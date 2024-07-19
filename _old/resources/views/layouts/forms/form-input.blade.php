@php
  if (preg_match('/\[(.*?)\]/', $name)) {
    $validationName = str_replace('[', '.', $name);
    $validationName = str_replace(']', '', $validationName);
    $id = str_replace('[', '_', $name);
    $id = str_replace(']', '', $id);
  }

  $isPassword = $name === 'password' || $name === 'password_confirmation' || isset($notRemember);
@endphp

<div class="form-group {{ $cols ?? null }} {{ $groupClasses ?? null }}">
  @if (isset($label))
    <label for="{{ $id ?? $name }}" class="control-label {{ $labelClasses ?? null }}">
      {{ $label }}:
    </label>
  @endif

  <input autofocus
         class="form-control @error($validationName ?? $name) is-invalid @enderror {{ $controlClasses ?? null }}"
         id="{{ $id ?? $name }}"
         name="{{ $name }}"
         placeholder="{{ $placeholder ?? $label ?? null }}"
         type="{{ $type ?? 'text' }}"
         value="{{ $isPassword ? null : old($validationName ?? $name) ?? $value ?? null }}"
         {{ $actions ?? null }}
         {{ isset($readonly) ? 'readonly' : null }}>

  @include('layouts.forms.form-error', ['nomeCampo' => $validationName ?? $name, 'tamanho' => $validationCols ?? null])
</div>