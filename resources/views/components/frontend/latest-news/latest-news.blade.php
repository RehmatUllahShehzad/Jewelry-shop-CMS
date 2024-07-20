@if (!$news->isEmpty())
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="latest-news-main">
                        <h3 class="sub-head text-center">latest news</h3>
                        <div class="latest-news-slider row">
                            @foreach ($news as $item)
                                <div class="latest-news-slide m-0 col-md-4 p-4">
                                    <div class="latest-news-image">
                                        <img loading="lazy" src="{{ $item->getThumbnailUrl() }}" alt="{{ $item->title }}"
                                            class="img-fluid" />
                                    </div>
                                    <div class="latest-news-text">
                                        <span>{{ $item->created_at->format('M d, Y') }}</span>
                                        <h4>{{ $item->short_title }}</h4>
                                        @if ($item->gjs_data)
                                            <a href="{{ route('news.show', $item->slug) }}" class="general-btn">Read
                                                More</a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
