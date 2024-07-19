@php
    if (preg_match('/\[(.*?)\]/', $name)) {
      $validationName = str_replace('[', '.', $name);
      $validationName = str_replace(']', '', $validationName);
      $id = str_replace('[', '_', $name);
      $id = str_replace(']', '', $id);
    }
@endphp

<div class="animated-checkbox">
    <label for="{{ $id ?? $name }}" class="form-check-label {{ $cols ?? null }} {{ $labelClasses ?? null }}">
        <input class="form-check-input @error($validationName ?? $name) is-invalid @enderror {{ $classes ?? null }}"
               id="{{ $id ?? $name }}"
               name="{{ $name }}"
               type="checkbox"
               {{ old('remember') ? 'checked' : '' }}>

        <span class="label-text">
            {{ $label }}
        </span>
    </label>
</div>