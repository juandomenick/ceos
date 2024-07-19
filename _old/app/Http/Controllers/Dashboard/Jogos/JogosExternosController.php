<?php

namespace App\Http\Controllers\Dashboard\Jogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

/**
 * Class JogosExternosController
 * @package App\Http\Controllers\Dashboard\Jogos
 */
class JogosExternosController extends Controller
{
    /**
     * JogosExternosController constructor.
     */
    public function __construct()
    {
        $this->middleware('role:professor|aluno');
    }

    /**
     * @return RedirectResponse
     */
    public function mainWorld()
    {
        return Redirect::away(config('jogos.main_world'));
    }
}
