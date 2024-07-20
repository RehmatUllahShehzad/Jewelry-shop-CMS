<x-slot name="pageTitle">
    {{ __('news.index.title') }}
</x-slot>

<div>

    <div class="text-right mb-4">
        <x-admin.components.button tag="a" href="{{ route('admin.cms.news.create') }}">
            {{ __('news.index.action.create') }}
        </x-admin.components.button>
    </div>


    <div
        class="shadow-gray-800 dark:shadow-gray-50 border border-gray-300 dark:border-gray-500 sm:rounded-lg">
        <div class="p-4 space-y-4">
            <div class="flex items-center space-x-4">
                <div class="grid grid-cols-12 w-full space-x-4">
                    <div class="col-span-8 md:col-span-8">
                        <x-admin.components.input.text wire:model.debounce.300ms="search"
                            placeholder="{{ __('news.index.search_placeholder') }}" />
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
                <x-admin.components.table.heading>{{ __('global.title') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.slug') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.date') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.image') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.published') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.deleted') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.actions') }}</x-admin.components.table.heading>
            </x-slot>
            <x-slot name="body">
                @forelse($this->news as $newsItem)
                    <x-admin.components.table.row wire:loading.class.delay="opacity-50">
                        <x-admin.components.table.cell>{{ $newsItem->title }}</x-admin.components.table.cell>
                        <x-admin.components.table.cell>{{ $newsItem->slug }}</x-admin.components.table.cell>
                        <x-admin.components.table.cell>{{ $newsItem->created_at->format('m/d/Y') }}
                        </x-admin.components.table.cell>
                        <x-admin.components.table.cell>
                            @if ($newsItem->thumbnail)
                                <img class="rounded shadow w-12" src="{{ $newsItem->getThumbnailUrl('small') }}"
                                    loading="lazy" />
                            @else
                                <x-icon ref="photograph" class="w-8 h-8 mx-auto text-gray-300" />
                            @endif
                        </x-admin.components.table.cell>

                        <x-admin.components.table.cell>
                            <x-icon :ref="$newsItem->is_published && !$newsItem->deleted_at ? 'check' : 'x'" :class="$newsItem->is_published && !$newsItem->deleted_at
                                ? 'text-green-500'
                                : 'text-red-500'" style="solid" />
                        </x-admin.components.table.cell>

                        <x-admin.components.table.cell>
                            <x-icon :ref="$newsItem->deleted_at ? 'check' : 'x'" :class="$newsItem->deleted_at ? 'text-green-500' : 'text-red-500'" style="solid" />
                        </x-admin.components.table.cell>

                        <x-admin.components.table.cell>
                            @if (!$newsItem->deleted_at)
                                <a href="{{ route('admin.cms.news.show', $newsItem->id) }}"
                                    class="text-indigo-500 hover:underline">
                                    {{ __('news.index.action.edit') }}
                                </a>
                                |
                                <a class="text-indigo-500 hover:underline"
                                    href="{{ route('admin.cms.news.editor.index', $newsItem) }}" target="_blank">
                                    {{ __('global.editor') }}
                                </a>
                            @endif
                        </x-admin.components.table.cell>
                    </x-admin.components.table.row>
                @empty
                    <x-admin.components.table.no-results />
                @endforelse
            </x-slot>
        </x-admin.components.table>

        @if($this->news->hasPages())
            <div class="p-4 space-y-4">
                {{ $this->news->links() }}
            </div>
        @endif
    </div>
</div>
