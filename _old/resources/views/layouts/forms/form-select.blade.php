@php
  $name = $name ?? '';
  $id = isset($multiple) ? str_replace('[]', '', $name) : $name;
@endphp

<div class="form-group {{ $cols ?? null }} {{ $groupClasses ?? null }} @error($name) is-invalid @enderror">
  <label for="{{ $name }}" class="control-label {{ $labelClasses ?? null }}">
    {{ $label }}:
  </label>

  <select name="{{ $name }}"
          id="{{ $id }}"
          class="form-control @error($name) is-invalid @enderror {{ $controlClasses ?? null }}"
          {{ $actions ?? null }}
          {{ isset($multiple) ? 'multiple' : null }}>
    @forelse($options as $option)
      @if($loop->first)
        <option @if(is_null($option['selected'] ?? null)) selected @endif disabled>
          [Selecionar {{ $label }}]
        </option>
      @endif

      @if($option != null)
        <option value="{{ $option['value'] }}"
          @if(old($name) == $option['value'] ||
              (isset($value) && $value == $option['value']) ||
              (isset($option['selected']) && $option['selected'] == true) ||
              (isset($multiple) && !is_null(old($id)) && in_array($option['value'], old($id))) ||
              (isset($multiple) && isset($value) && in_array($option['value'], $value)))
            selected
          @endif>
          {{ $option['content'] }}
        </option>
      @else
        @continue
      @endif
    @empty
      @inject('str', 'Illuminate\Support\Str')
      <option selected disabled>Nenhum {{ $str->lower($label) }} encontrado</option>
    @endforelse
  </select>

  @include('layouts.forms.form-error', ['nomeCampo' => $name, 'tamanho' => $validationCols ?? null])
</div>