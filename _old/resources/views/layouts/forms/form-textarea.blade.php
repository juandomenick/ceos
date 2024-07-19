@php
  if (preg_match('/\[(.*?)\]/', $name)) {
    $validationName = str_replace('[', '.', $name);
    $validationName = str_replace(']', '', $validationName);
    $id = str_replace('[', '_', $name);
    $id = str_replace(']', '', $id);
  }
@endphp

<div class="form-group {{ $cols ?? null }} {{ $classes ?? null }}">
  <label for="{{ $id ?? $name }}" class="control-label {{ $labelClasses ?? null }}">
    {{ $label }}:
  </label>

  <textarea autofocus
         class="form-control @error($validationName ?? $name) is-invalid @enderror"
         id="{{ $id ?? $name }}"
         name="{{ $name }}"
         placeholder="{{ $placeholder ?? $label }}"
         type="{{ $type ?? 'text' }}"
         {{ $actions ?? null }}
         {{ isset($readonly) ? 'readonly' : null }}>
    {{ old($validationName ?? $name) ?? $value ?? null }}
  </textarea>

  @include('layouts.forms.form-error', ['nomeCampo' => $validationName ?? $name, 'tamanho' => $validationCols ?? null])
</div>