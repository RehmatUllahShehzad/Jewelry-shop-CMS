<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" >
                <div class="integer-parent" >
                    <div class="integer-value-main">
                        @foreach ($item->publishedSlides as $slide)
                            <div class="integer-value" style="background-color: #f7f7f7">
                                <div class="row" >
                                    <div class="col-md-6">
                                        <div class="integer-value-img position-relative">
                                            <img src="/frontend/images/zoom-icon.png" alt="Zoom Image" class="zoom-img" />
                                            <img src="{{ $slide->getThumbnailUrl('') }}" alt="{{ $slide->title }}" class="zoom-images" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 align-self-center">
                                        <div class="integer-value-text-main">
                                            <div class="integer-value-text text-center">
                                                <h3>{{ $slide->title }}</h3>
                                                <img src="{{ $slide->getSecondaryImageUrl('') }}" alt="{{ $slide->title }}" class="img-fluid" />
                                                <h4>{{ $slide->sub_title }}</h4>
                                                <p>{{ $slide->description }}</p>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>