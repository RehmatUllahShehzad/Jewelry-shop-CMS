<section>
    <div class="banner-main home-hero-slider">
        @foreach ($item->publishedSlides->load('thumbnail') as $slide)
            <div class="home-banner">
                <img src="{{ $slide->getThumbnailUrl('') }}" class="img img-fluid" alt="{{ $slide->title }}">
                <div class="container"> 
                    <div class="banner-text">
                        <h4>{{ $slide->description }}</h4>
                        <h1 class="mb-0">{{ $slide->title }}</h1>
                        <a href="{{ $slide->cta_link }}" class="general-btn">{{ $slide->cta_title }}</a>    
                    </div> 
                </div>
            </div>
        @endforeach
    </div>
</section> 