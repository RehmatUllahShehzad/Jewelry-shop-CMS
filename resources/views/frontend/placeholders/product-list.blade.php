<!-- product listing  -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">  
                <div class="product-listing-main">
                    <div class="row">
                        @if($item)
                            @foreach ($item->publishedProducts->load('thumbnail') as $product)
                                <div class="col-sm-6 col-md-4">
                                    <a href="{{ route('product.show', [$item->parent->slug, $item->slug, $product->slug]) }}" class="product-card">
                                        <div class="product-img">
                                            <img src="{{ $product->getThumbnailUrl() }}" alt="{{ $product->title }}" />
                                        </div>
                                        <div class="product-text">
                                            <h3>{{ $product->title }}</h3>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- product listing  -->