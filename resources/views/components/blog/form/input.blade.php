@props(['type' => 'text' , 'name', 'placeholder','required' => 'true','value'])

<input
       type="{{ $type }}"
       id="{{ $name }}"
       name="{{ $name }}"
       value="{{ $value }}"
       placeholder="{{ $placeholder }}"
       class=" form-control"
       {{ $required=='true' ? 'required' : '' }}>

@error($name)
<small class=" text-danger">{{ $message }}</small>
@enderror