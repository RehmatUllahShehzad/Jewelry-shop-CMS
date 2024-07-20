<div class="coverletter-wrap">
    <div class="row align-items-center">
        
        <div class="col-md-5">
            <h2>{{ __('frontend/contact-us.signup-for-rafka-updates') }}</h2>
        </div>

        <div class="col-md-7">
            <form wire:submit.prevent="submit">

                <div class="input-group">
                    <input type="email" class="form-control" wire:model.defer="email"
                        placeholder="Enter your email Address" aria-labelledby="newsletter" id="newsletter">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">
                            <img src="/frontend/images/arrow-right-white.svg" class="img-fluid" alt="newsletter">
                            <x-button-loading wire:loading wire:target="submit" />
                        </button>
                    </div>
                </div>
                @error('email')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </form>
        </div>
    </div>
</div>
