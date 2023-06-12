<label for="{{ $modelId }}" class="flex items-center cursor-pointer relative mb-4">
    <input type="checkbox" id="{{ $modelId }}" wire:model="{{ $modelId }}" class="sr-only">
    <div class="toggle-bg bg-gray-200 border-2 border-gray-200 h-6 w-11 shrink-0 rounded-full"></div>
    <span class="ml-3 text-gray-900 text-sm leading-3 font-medium">{{ $slot }}</span>
</label>