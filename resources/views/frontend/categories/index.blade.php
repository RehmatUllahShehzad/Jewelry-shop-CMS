@extends('frontend.layouts.master')

@section('meta_title', $category->name)
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($category->getHtml()), 200))

@push('page_css')
    <style>
        {!! $category->getCss() !!}
    </style>
@endpush

@section('page')
    {!! $category->getHtml() !!}
@endsection

@push('page_js')
    <script>
        $(document).ready(function(){ 
            if ($(".header-white").length){
                $('header').addClass('header-white'); 
            } 

            $('.integer-value-main').slick({
                arrows: false,
                dots: true,
                slidesToShow: 1,
                slidesToScroll: 1,
            }); 


            // For Zoom 
            $('.zoom-images').each(function() {
                $(this).imageZoom();
            });
            // For Zoom 
        });
    </script>
@endpush

