@props(['label', 'name', 'value' => '', 'dataAttr' => ''])

<div class="row mb-7 fv-row">
    <div class="col-md-3 text-md-end">
        <label class="fs-6 fw-semibold form-label mt-3">{{ $label }}</label>
    </div>
    <div class="col-md-9">
        <input type="text" class="form-control form-control-solid" name="{{ $name }}"
               value="{{ $value }}" {!! $dataAttr !!}>
    </div>
</div>
