@props([
    'name',
    'label',
    'value' => '',
    'required' => false,
    'rows' => 4,
    'placeholder' => ''
])

<div class="form-group">
    <label for="{{ $name }}" class="block text-base font-semibold text-gray-700 mb-1">{{ $label }}</label>
    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="{{ $rows }}"
        @if($required) required @endif
        placeholder="{{ $placeholder }}"
        class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-base px-4 py-2 @error($name) border-red-500 @enderror"
    >{{ old($name, $value) }}</textarea>
    @error($name)
        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
