<x-slot name="pageTitle">
    {{ __('catalog.product.create.title') }}
</x-slot>
<form action="submit" method="POST" wire:submit.prevent="store">
    @include('admin.catalog.product.form')
</form>
