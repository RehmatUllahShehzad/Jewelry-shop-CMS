@extends('frontend.layouts.master')

@section('meta_title', $page->title)
@section('meta_description', $page->short_description)

@push('page_css')
    <style>
        {!! $page->getCss() !!}
    </style>
@endpush

@section('page')
    {!! $page->getHtml() !!}
@endsection

@push('page_js')
    <script>
        $(document).ready(function(){ 

            if ($(".header-white").length){
                $('header').addClass('header-white'); 
            } 

            $('.home-hero-slider').slick({
                arrows: false,
                dots: true,
                slidesToShow: 1,
                slidesToScroll: 1,
            });
            $('.latest-news-slider').slick({ 
                dots: false,
                slidesToShow: 2,
                slidesToScroll: 1,
                responsive: [
                    {
                    breakpoint: 576,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1, 
                        }
                    }, 
                ]
            });

            // For Zoom 
            $('.zoom-images').each(function() {
                $(this).imageZoom();
            });
            // For Zoom 

            $('.video-play').click(function(){
                $('.video-wrap').show();
                $('.bl-video').show();
                $('.bl-video').click();
                $('.bl-video')[0].contentWindow.postMessage('{"event":"command","func":"' + 'playVideo' + '","args":""}', '*');
                return false;
            });
        });

        $('.product-plugin-upper').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.product-plugin-lower'
        });
        $('.product-plugin-lower').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: '.product-plugin-upper',
            dots: false,
            arrows: true,
            centerMode: true,
            focusOnSelect: true,
            responsive: [ 
                {
                breakpoint: 390,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
            ]
        }); 


        //i do by rafka
        $('select').each(function(){
        var $this = $(this), numberOfOptions = $(this).children('option').length;
    
        $this.addClass('select-hidden'); 
        $this.wrap('<div class="select"></div>');
        $this.after('<div class="select-styled"></div>');

        var $styledSelect = $this.next('div.select-styled');
        $styledSelect.text($this.children('option').eq(0).text());
    
        var $list = $('<ul />', {
            'class': 'select-options'
        }).insertAfter($styledSelect);
    
        for (var i = 0; i < numberOfOptions; i++) {
            $('<li />', {
                text: $this.children('option').eq(i).text(),
                rel: $this.children('option').eq(i).val()
            }).appendTo($list);
        }
    
        var $listItems = $list.children('li');
    
        $styledSelect.click(function(e) {
            e.stopPropagation();
            $('div.select-styled.active').not(this).each(function(){
                $(this).removeClass('active').next('ul.select-options').hide();
            });
            $(this).toggleClass('active').next('ul.select-options').toggle();
        });
    
        $listItems.click(function(e) {
            e.stopPropagation();
            $styledSelect.text($(this).text()).removeClass('active');
            $this.val($(this).attr('rel'));
            $list.hide();
        });
    
        $(document).click(function() {
            $styledSelect.removeClass('active');
            $list.hide();
        });
    });
    </script>
@endpush

