<section>
    <div class="press-card-main">
        <div class="container">

            @foreach ($news->load('thumbnail') as $item)
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="press-card-text">
                            <span>{{ $item->created_at->format('M d, Y') }}</span>
                            <h3>
                                {{ $item->short_title }}
                            </h3>
                            @if ($item->gjs_data)
                                <a href="{{ route('news.show', $item->slug) }}" class="general-btn">Read more</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="press-card-img">
                            <img src="{{ $item->getThumbnailUrl() }}" alt="Press" class="img-fluid" />
                        </div>
                    </div>
                </div>
            @endforeach

            @if ($hasMorePage)
                <div class="text-center press-card-img">
                    <a type="button" class="general-btn" wire:click.prevent="loadMore">Load more</a>
                </div>
            @endif
        </div>
    </div>
</section>
