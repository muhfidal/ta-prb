@props(['title'])

<div class="bg-white rounded-lg shadow-sm">
    @if(isset($title))
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-900">{{ $title }}</h3>
        </div>
    @endif

    <div class="p-6">
        {{ $slot }}
    </div>
</div>
