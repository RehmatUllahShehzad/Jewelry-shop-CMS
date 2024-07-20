@extends('frontend.layouts.master')

@section('meta_title', $news->title)
@section('meta_description', $news->name)

@push('page_css')
    <style>
        {!! $news->getCss() !!}
    </style>
@endpush

@section('page')
    {!! $news->getHtml() !!}
@endsection

@push('page_js')
    <script>
        $(document).ready(function(){ 

            if ($(".header-white").length){
                $('header').addClass('header-white'); 
            } 
    });
    </script>
@endpush

