<?php

namespace App\Http\Middleware\Web;

use Closure;

class AjaxFilterPostMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $formData = $request->all();
        $transformedData = [];
        foreach ($formData as $key => $value) {
            if (is_array($value)) {
                $transformedData[$key] = $this->transformArray($value);
            } else {
                $transformedData[$key] = $value;
            }
        }
        $request->replace($transformedData);
        return $next($request);
    }

    private function transformArray(array $data)
    {
        $result = [];
        foreach ($data as $item) {
            if (is_array($item) && isset($item['name']) && isset($item['value'])) {
                $keys = preg_split('/\[(.*?)\]/', $item['name'], -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
                if($item['value'] == 'true') $item['value'] = true;
                $this->setNestedArrayValue($result, $keys, $item['value']);
            }
        }
        return $result;
    }

    private function setNestedArrayValue(array &$array, array $keys, $value)
    {
        $current = &$array;
        foreach ($keys as $key) {
            if (!isset($current[$key])) {
                $current[$key] = [];
            }
            $current = &$current[$key];
        }
        $current = $value;
    }
}
