<div>
    <form action="" method="post" wire:submit.prevent="submit">
        <div class="row">
            <div class="col-md-6">
                <label for="firstName" class="form-label">First name</label>
                <input type="text" autocomplete="off" wire:model.defer="first_name" class="form-control" id="firstName"
                    aria-describedby="First name" placeholder="First name">
                @error('first_name')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="lastName" class="form-label">Last name</label>
                <input type="text" autocomplete="off" class="form-control" wire:model.defer="last_name"
                    id="lastName" aria-describedby="Last name" placeholder="Last name">
                @error('last_name')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" autocomplete="off" class="form-control" wire:model.defer="email" id="email"
                    aria-describedby="Email Address" placeholder="Email Address">
                @error('email')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" class="form-control mask_us_phone" id="phone"
                    wire:model.defer="phone" placeholder="Phone Number">
                @error('phone')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-12">
                <label for="Message" class="form-label">Message</label>
                <textarea class="form-control" id="Message" wire:model.defer="message" rows="5"></textarea>
                @error('message')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>
            <div class="col-md-12 mt-lg-5 mt-4">
                <button type="submit" class="btn-default">
                    <div class="text" wire:loading.remove wire:target="submit">
                        {{ __('global.submit') }}
                    </div>
                    @include('admin.layouts.livewire.button-loading')
                </button>
            </div>
        </div>
    </form>
</div>
