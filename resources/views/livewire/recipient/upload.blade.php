<form wire:submit.prevent="save">
    <input type="file" wire:model="file">

    @error('file') <span class="error">{{ $message }}</span> @enderror

    <button type="submit">{{ __('Upload Recipients') }}</button>
</form>