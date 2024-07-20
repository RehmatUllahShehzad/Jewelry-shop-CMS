<div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-12">
        <div class="sm:px-12 lg:px-0 lg:col-span-12">
            <div class="space-y-6">
                <div id="identifiers">
                    <div class="overflow-hidden shadow sm:rounded-md">
                        <div class="flex-col px-4 py-5 space-y-4 bg-white sm:p-6">
                            <header>
                                <h3 class="text-lg font-medium leading-6 text-gray-900">
                                    Basic Information
                                </h3>
                            </header>

                            <div class="space-y-4">
                                <div>
                                    <x-admin.components.input.group for="title" label="{{ __('inputs.title') }}"
                                        :error="$errors->first('product.title')">
                                        <x-admin.components.input.text id="title" name="title"
                                            wire:model.defer="product.title" :error="$errors->first('product.title')" />
                                    </x-admin.components.input.group>
                                </div>
                                <div>
                                    <label class="flex items-center text-sm font-medium text-gray-700"
                                        for="description">
                                        <span class="block"></span>
                                        <span class="block">Description</span>
                                    </label>
                                    <div class="relative mt-1">
                                        <x-admin.components.input.richtext wire:model.defer="product.description"
                                            :initialValue="$product->description" />
                                    </div>
                                    @error('product.description')
                                        <div class="space-y-1 text-center">
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                                <div>
                                    <label class="flex items-center text-sm font-medium text-gray-700"
                                        for="specifications">
                                        <span class="block"></span>
                                        <span class="block">Specifications</span>
                                    </label>
                                    <div class="relative mt-1">
                                        <x-admin.components.input.richtext wire:model.defer="product.specifications"
                                            :initialValue="$product->specifications" />
                                    </div>
                                    @error('product.specifications')
                                        <div class="space-y-1 text-center">
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                                <div>
                                    <label class="flex items-center text-sm font-medium text-gray-700" for="materials">
                                        <span class="block"></span>
                                        <span class="block">Materials</span>
                                    </label>
                                    <div class="relative mt-1">
                                        <x-admin.components.input.richtext wire:model.defer="product.materials"
                                            :initialValue="$product->materials" />
                                    </div>
                                    @error('product.materials')
                                        <div class="space-y-1 text-center">
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="bannerImage">
                    <div class="overflow-hidden shadow sm:rounded-md">
                        <div class="flex-col px-4 py-5 space-y-4 bg-white sm:p-6">
                            <h4 class="mb-2">Banner Image</h4>

                            <label for="feature-file" id="root-feature"
                                class="feature-upload position-relative flex-wrap d-flex flex-row rounded relative">
                                <div class="item-snap">
                                    <div x-data="{
                                        bannerImage: @entangle('bannerImage')
                                    }" x-show="!bannerImage">
                                        <x-admin.components.input.fileupload
                                            label="<span class='plus text-gray-400'>+</span>" :imagesHolder="null"
                                            wire:model="bannerImage"  :multiple="false" />
                                    </div>
                                    @if ($bannerImage)
                                        <div class="feature-upload position-relative flex-wrap d-flex flex-row rounded">
                                            <div class="preview-img"><img class="img-fluid d-block mx-auto h-100"
                                                    src="{{ $this->bannerImagePreview }}" alt=""></div>
                                            <button
                                                class="inline-flex absolute top-5 right-5 justify-center items-center w-6 h-6 text-xs opacity-60 font-bold text-white bg-gray-700 rounded-full cursor-pointer"
                                                wire:loading.attr="disabled" wire:target="removeImage"
                                                wire:click.prevent="removeBannerImage()">x</button>
                                        </div>
                                    @endif
                                </div>
                                @error('bannerImage')
                                    <div class="error">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </label>
                        </div>
                    </div>
                </div>

                <div id="images">
                    <x-admin.components.image-manager :existing="$images" :maxFileSize="$maxFileSize" :maxFiles="$maxFiles"
                        :multiple="false" model="imageUploadQueue"  />
                    @error('images')
                        <div class="space-y-1">
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
                
                <div id="collections">
                    <x-admin.components.category-manager :existing="$categories" />
                    @error('categories')
                        <div class="space-y-1">
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="px-4 py-3 text-right rounded shadow bg-gray-50 sm:px-6">
                    <div class="flex flex-row justify-end gap-x-2">
                        <x-admin.components.publish-dropdown wire:model.defer="product.is_published" type="product" />
                        <button
                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            type="submit">
                            <span wire:loading.remove>
                                {{ __($product->id ? 'catalog.product.form.update.btn' : 'catalog.product.form.create.btn') }}
                            </span>
                            @include('admin.layouts.livewire.button-loading')
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @if ($product->id)
        <div class="bg-white border border-red-300 rounded shadow">
            <header class="px-6 py-4 text-red-700 bg-white border-b border-red-300 rounded-t">
                {{ __('inputs.danger_zone.title') }}
            </header>
            <div class="p-6 space-y-4 text-sm">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 md:col-span-6">
                        <strong>{{ __('catalog.product.form.danger.zone.label') }}</strong>
                        <p class="text-xs text-gray-600">{{ __('catalog.product.form.danger.zone.instructions') }}</p>
                    </div>
                    <div class="col-span-9 lg:col-span-4">
                        <x-admin.components.input.text wire:model="deleteConfirm" />
                    </div>
                    <div class="col-span-3 text-right lg:col-span-2">
                        <x-admin.components.button theme="danger" :disabled="!$this->canDelete" wire:click="delete"
                            type="button">{{ __('global.delete') }}</x-admin.components.button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
