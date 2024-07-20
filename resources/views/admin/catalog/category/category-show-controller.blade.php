<x-slot name="pageTitle">
    {{ $category->parent_id ? __('catalog.categories.subcategory.edit.title') :  __('catalog.categories.edit.title') }}
</x-slot>
<form action="submit" method="POST" wire:submit.prevent="update">
    <div class="flex flex-col w-full">
        @include('admin.catalog.category.form')
    </div>
</form>
