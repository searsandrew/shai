<div class="py-12">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Import Recipients from :file', ['file' => $file->name]) }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <table class="table border-collapse table-fixed w-full text-sm">
            <thead>
                <form method="POST" action="{{ route('recipient.create', $file->campaign->slug) }}">
                    @csrf
                    <input type="hidden" name="file" value="{{ $file->id }}" />
                    <span class="flex flex-row-reverse">
                        <x-primary-button type="submit" class="self-start ml-3">{{ __('Assign Headers') }}</x-primary-button>
                        <small class="text-right pl-12">{{ __('Assign the uploaded headers to their appropriate fields. Every recipient requires a name and a grouping, external ID\'s are optional. Any fields that are unnecessary, please select Omit. Everything marked as a Detail will be saved and available for tag and email customization.') }}<br/><strong class="text-black">{{ __('Only the first six rows are displayed') }}</strong></small>
                    </span>
                    <tr>
                        @foreach($csv->getHeaders() as $key => $header)
                            <th class="border-b dark:border-slate-600 pt-2 pb-1 font-medium text-slate-400 dark:text-slate-200 text-left">
                                {{ ucwords(strtolower($header)) }}
                                <select name="{{ Str::snake(strtolower($header)) }}" class="flex w-full shrink text-xs border-slate-300 rounded-lg px-2 py-1">
                                    <option value="skip">{{ __('Omit') }}</option>
                                    <option value="name">{{ __('Name') }}</option>
                                    <option value="group_id">{{ __('Grouping') }}</option>
                                    <option value="external_id">{{ __('External ID') }}</option>
                                    <option value="meta">{{ __('Details') }}</option>
                                </select>
                            </th>
                        @endforeach
                    </tr>
                </form>
            </thead>
            <tbody class="bg-white dark:bg-slate-800">
                @foreach($csv->take(6)->getRows() as $row)
                    <tr>
                        @foreach($row as $line)
                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ ucwords(strtolower($line)) }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
