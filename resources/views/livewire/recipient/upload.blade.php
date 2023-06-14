<form wire:submit.prevent="save">
    <div
        class="flex flex-col justify-between mt-3"
        x-data="{ isUploading: false, progress: 0 }"
        x-on:livewire-upload-start="isUploading = true"
        x-on:livewire-upload-finish="isUploading = false"
        x-on:livewire-upload-error="isUploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress"
    >
        <!-- File Input -->
        <input type="file" wire:model="file">

        <!-- Progress Bar -->
        <div x-show="isUploading">
            <progress max="100" x-bind:value="progress"></progress>
        </div>
    </div>

    @error('file') <span class="error">{{ $message }}</span> @enderror

    <x-primary-button type="submit" class="mt-3">{{ __('Upload Recipients') }}</x-primary-button>
</form>