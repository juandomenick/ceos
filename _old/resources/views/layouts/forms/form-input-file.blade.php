@php
  if (preg_match('/\[(.*?)\]/', $name)) {
    $nameValidation = str_replace('[', '.', $name);
    $nameValidation = str_replace(']', '', $nameValidation);
    $id = str_replace('[', '_', $name);
    $id = str_replace(']', '', $id);
  }
@endphp

<div class="form-group {{ $cols ?? null }} {{ $classes ?? null }}">
  <label class="control-label {{ $labelClasses ?? null }}">
    {{ $label }}:
  </label>

  <div class="input-group">
    <div class="custom-file">
      <input accept="{{ $accept ?? 'image/*' }}"
             autofocus
             class="custom-file-input @error($nameValidation ?? $name) is-invalid @enderror"
             id="{{ $id ?? $name }}"
             name="{{ $name }}"
             type="file"
             {{ $actions ?? null }}>

      <label class="custom-file-label" for="{{ $id ?? $name }}">
        Selecione a Imagem
      </label>
    </div>
  </div>

  @include('layouts.forms.form-error', ['nomeCampo' => $nameValidation ?? $name, 'tamanho' => $colsValidation ?? null])
</div>