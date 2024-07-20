<x-slot name="pageTitle">
    {{ __('news.create.title') }}
</x-slot>

<form action="submit" method="POST" wire:submit.prevent="save">
        @include('admin.cms.news.news-form')
</form>
