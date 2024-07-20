<!-- product listing  -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-listing-main">
                    <div class="row">

                        @if ($item->publishedChildren)
                            @foreach ($item->publishedChildren->load('thumbnail') as $subCategory)
                                <div class="col-sm-6 col-md-4">
                                    <a href="{{ route('category', [$item->slug, $subCategory->slug]) }}"
                                        class="product-card">
                                        <div class="product-img">
                                            <img src="{{ $subCategory->getThumbnailUrl() }}" loading="lazy" alt="{{ $subCategory->title }}" />
                                        </div>
                                        <div class="product-text">
                                            <h3>{{ $subCategory->name }}</h3>
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
