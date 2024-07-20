@extends('frontend.layouts.master', ['title' => $product->title])

@section('page')
<div>
    <!-- banner -->
    <section>
        <div class="banner-main">
            <img src="{{ $product->bannerImageUrl }}" alt="{{ $product->title }}" />
            <div class="container">  
                <div class="banner-text banner-text-right text-white-50">
                    <h1>{{ $product->title }}</h1>
                    <p>{!! $product->description !!}</p>
                </div>  
            </div>
        </div>
    </section>
    <!-- banner -->

    <!-- left right section  -->
    <section>
        <div class="rafka-left-right-main rafka-right-left-main">
            <div class="container">
                <div class="row"> 
                    <div class="col-md-6">
                        <div class="rafka-right-main mt-4">
                            <div class="accordion" id="accordionExample">
                                @if ($product->description)                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                description
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                {!! $product->description !!}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                @if ($product->specifications)                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                            specifications
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                {!! $product->specifications !!}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($product->materials)                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                                materials/metals
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                {!! $product->materials !!}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="inquire">
                                <a href="/contact-us">Inquire</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="rafka-left-main text-end">
                            <div class="product-plugin-upper">
                                @foreach($product->galleryImages as $url)
                                    <div class="product-plugin-upper-img"> 
                                        <img src="{{ $url }}" class="img-fluid zoom-images" alt="{{ $product->title }}" /> 
                                    </div>
                                @endforeach
                            </div>
                            <div class="product-plugin-lower">
                                @foreach($product->galleryImageThumbnails as $url)
                                    <div class="product-plugin-lower-img"> 
                                        <img src="{{ $url }}" class="img-fluid" alt="{{ $product->title }}" />
                                    </div>
                                @endforeach
                            </div> 
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </section>
    <!-- left right section  -->
    
</div>
@endsection

@push('page_js')
    <script>
        $('header').addClass('header-white');

        // For Zoom 
        $(document).ready(function(){ 
            $('.zoom-images').each(function() {
                $(this).imageZoom();
            });
        });
        // For Zoom 

        $('.product-plugin-upper').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.product-plugin-lower'
        });
        $('.product-plugin-lower').slick({
            slidesToShow: 3,
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
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
            ]
        }); 
    </script>
@endpush