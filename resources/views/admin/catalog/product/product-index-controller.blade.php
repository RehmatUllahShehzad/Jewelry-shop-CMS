<x-slot name="pageTitle">
    {{ __('catalog.product.index.title') }}
</x-slot>

<div>
    <div class="text-right mb-4">
        <x-admin.components.button tag="a" href="{{ route('admin.catalog.product.create') }}">
            {{ __('catalog.product.index.action.create') }}
        </x-admin.components.button>
    </div>

    <div class="shadow-gray-800 dark:shadow-gray-50 border border-gray-300 dark:border-gray-500 sm:rounded-lg">
        <div class="p-4 space-y-4">
            <div class="flex items-center space-x-4">
                <div class="grid grid-cols-12 w-full space-x-4">
                    <div class="col-span-8 md:col-span-8">
                        <x-admin.components.input.text wire:model.debounce.300ms="search"
                            placeholder="{{ __('catalog.product.index.search.placeholder') }}" />
                    </div>
                    <div class="col-span-4 text-right md:col-span-4">
                        <x-admin.components.input.checkbox-button wire:model="showTrashed" autocomplete="off">
                            {{ __('catalog.product.show_deleted') }}
                        </x-admin.components.input.checkbox-button>
                    </div>
                </div>
            </div>
        </div>
        <x-admin.components.table class="w-full whitespace-no-wrap p-2">
            <x-slot name="head">
                <x-admin.components.table.heading>{{ __('catalog.product.name') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading></x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('catalog.product.slug') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('catalog.product.created_at') }}
                </x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.published') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.active') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading></x-admin.components.table.heading>
            </x-slot>
            <x-slot name="body">
                @forelse($products as $product)
                    <x-admin.components.table.row wire:loading.class.delay="opacity-50">
                        <x-admin.components.table.cell>{{ $product->title }}</x-admin.components.table.cell>

                        <x-admin.components.table.cell>
                            @if ($product->thumbnail)
                                <img class="rounded shadow w-12" src="{{ $product->getThumbnailUrl('small') }}"
                                    loading="lazy" />
                            @else
                                <x-icon ref="photograph" class="w-8 h-8 mx-auto text-gray-300" />
                            @endif
                        </x-admin.components.table.cell>
                        <x-admin.components.table.cell>{{ $product->slug }}</x-admin.components.table.cell>
                        <x-admin.components.table.cell>{{ $product->created_at->format('m/d/Y') }}
                        </x-admin.components.table.cell>
                        <x-admin.components.table.cell>
                            <x-icon :ref="$product->is_published && !$product->deleted_at ? 'check' : 'x'" :class="$product->is_published && !$product->deleted_at
                                ? 'text-green-500'
                                : 'text-red-500'" style="solid" />
                        </x-admin.components.table.cell>
                        <x-admin.components.table.cell>
                            <x-icon :ref="!$product->deleted_at ? 'check' : 'x'" :class="!$product->deleted_at
                                ? 'text-green-500'
                                : 'text-red-500'" style="solid" />
                        </x-admin.components.table.cell>
                        <x-admin.components.table.cell>
                            @if (!$product->deleted_at)
                                <a href="{{ route('admin.catalog.product.show', $product->id) }}"
                                    class="text-indigo-500 hover:underline">
                                    {{ __('catalog.product.index.action.edit') }}
                                </a>
                            @endif
                        </x-admin.components.table.cell>
                    </x-admin.components.table.row>
                @empty
                    <x-admin.components.table.no-results />
                @endforelse
            </x-slot>
        </x-admin.components.table>
        <div class="p-4 space-y-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
