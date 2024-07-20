<x-slot name="pageTitle">
    {{ __('frontend/contact-us.index.title') }}
</x-slot>

<div>
    <div class="shadow-gray-800 dark:shadow-gray-50 border border-gray-300 dark:border-gray-500 sm:rounded-lg">

        <div class="p-4 space-y-4">
            <div class="flex items-center space-x-4">
                <div class="grid grid-cols-12 w-full space-x-4">
                    <div class="col-span-8 md:col-span-8">
                        <x-admin.components.input.text wire:model.debounce.300ms="search"
                            placeholder="{{ __('frontend/contact-us.search_placeholder') }}" />
                    </div>
                    <div class="col-span-4 text-right md:col-span-4">
                        <x-admin.components.input.checkbox-button wire:model="showTrashed" autocomplete="off">
                            {{ __('global.show_deleted') }}
                        </x-admin.components.input.checkbox-button>
                    </div>
                </div>
            </div>
        </div>

        <x-admin.components.table class="w-full whitespace-no-wrap p-2">
            <x-slot name="head">
                <x-admin.components.table.heading>{{ __('global.firstname') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.lastname') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.email') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.phone') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.date') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading></x-admin.components.table.heading>
            </x-slot>
            <x-slot name="body">
                @forelse($this->contactUs as $contact)
                    <x-admin.components.table.row wire:loading.class.delay="opacity-50">
                        <x-admin.components.table.cell>{{ $contact->first_name }}</x-admin.components.table.cell>
                        <x-admin.components.table.cell>{{ $contact->last_name }}</x-admin.components.table.cell>
                        <x-admin.components.table.cell>{{ $contact->email }}</x-admin.components.table.cell>
                        <x-admin.components.table.cell>{{ $contact->phone }}</x-admin.components.table.cell>
                        <x-admin.components.table.cell>{{ $contact->created_at->format('m/d/Y') }}
                        </x-admin.components.table.cell>
                        <x-admin.components.table.cell>
                            @if (!$contact->deleted_at)
                                <div class="flex flex-row justify-between">
                                    <a class="text-indigo-500 hover:underline"
                                        href="{{ route('admin.contact-us.show', $contact->id) }}">
                                        {{ __('Show') }}
                                    </a>
                                </div>
                            @endif
                        </x-admin.components.table.cell>
                    </x-admin.components.table.row>
                @empty
                    <x-admin.components.table.no-results />
                @endforelse
            </x-slot>
        </x-admin.components.table>

        @if ($this->contactUs->hasPages())
            <div class="p-4 space-y-4">
                {{ $this->contactUs->links() }}
            </div>
        @endif
    </div>
</div>
