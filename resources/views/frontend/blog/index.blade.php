@extends('frontend.layouts.master')

@section('meta_title', $blog->title)
@section('meta_description', $blog->name)

@push('page_css')
    <style>
        {!! $blog->getCss() !!}
    </style>
@endpush

@section('page')
    {!! $blog->getHtml() !!}
@endsection


