<div>
    <!-- Blogs -->
    <div class="blogs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="inner-wrapper">
                        <div class="row">

                            @foreach ($blogs->load('thumbnail') as $blog)
                                <div class="col-sm-6">
                                    <div class="latest-news-slide">
                                        <img src="{{ $blog->getThumbnailUrl() }}" alt="Latest News" class="img-fluid" />
                                        <div class="latest-news-text">
                                            <span>{{ $blog->created_at->format('M d, Y') }}</span>

                                            <h4 title="{{ $blog->title }}">{{ $blog->short_title }}</h4>
                                            @if ($blog->gjs_data)
                                                <a href="{{ route('blog.show', $blog->slug) }}" class="general-btn">
                                                    Read more
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if ($hasMorePage)
                                <div class="col-12">
                                    <div class="load-more-wrap">
                                        <a type="button" class="general-btn" wire:click="loadMore">Load more</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blogs -->
</div>
