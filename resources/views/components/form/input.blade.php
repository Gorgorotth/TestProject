@props(['name', 'type' => 'text', 'class' => 'border border-gray-300', 'required' =>'required', 'accept' => '*'])
<div class="mb-6">
    <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
           for="{{ $name }}"
    >
        {{ ucwords($name) }}
    </label>

    <input class="{{$class}} p-2 w-full rounded"
           name="{{ $name }}"
           type="{{$type}}"
           id="{{ $name }}"
           {{$required}}
           {{$attributes}}
           value="{{old($name)}}"
           accept="{{ $accept }}"

    >

    @error( $name )
    <p class="text-red-500 text-xs mt-2"> {{$message}} </p>
    @enderror
</div>
