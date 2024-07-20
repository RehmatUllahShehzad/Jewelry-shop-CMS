<x-slot name="pageTitle">
    {{ $parent ? __('catalog.categories.subcategory.create.title') :  __('catalog.categories.create.title') }}
</x-slot>
<form action="submit" method="POST" wire:submit.prevent="store">
    <div class="flex flex-col w-full">
        @include('admin.catalog.category.form')
    </div>
</form>
