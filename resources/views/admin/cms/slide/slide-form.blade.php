<form action="submit" method="POST" wire:submit.prevent="save">
    <div class="grid grid-cols-12">
        <div class="col-span-12 space-y-4">
            <x-admin.components.card heading="">
                <header class="flex justify-between">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        @lang($pageTitle)
                    </h3>
                    <a href="{{ route('admin.cms.slides.show', [$type, $slideable->id]) }}"
                        class="py-2 px-4 text-sm bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500 disabled:cursor-not-allowed disabled:opacity-50 border border-transparent rounded-lg shadow-sm inline-flex justify-center font-medium focus:outline-none focus:ring-offset-2 focus:ring-2">
                        {{ __('global.back') }}
                    </a>
                </header>
                <div class="grid grid-cols-2 gap-4">
                    <x-admin.components.input.group label="{{ __('inputs.title') }}" for="title" :error="$errors->first('slide.title')">
                        <x-admin.components.input.text wire:model.defer="slide.title" name="title" id="title"
                            :error="$errors->first('slide.title')" />
                    </x-admin.components.input.group>

                    <x-admin.components.input.group label="{{ __('slide.form.inputs.sub_title') }}" for="sub_title"
                        :error="$errors->first('slide.sub_title')">
                        <x-admin.components.input.text wire:model.defer="slide.sub_title" name="sub_title"
                            id="sub_title" :error="$errors->first('slide.sub_title')" />
                    </x-admin.components.input.group>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <x-admin.components.input.group label="{{ __('slide.form.inputs.cta_link') }}" for="cta_link"
                        :error="$errors->first('slide.cta_link')">
                        <x-admin.components.input.text wire:model.defer="slide.cta_link" name="cta_link" id="cta_link"
                            :error="$errors->first('slide.cta_link')" />
                    </x-admin.components.input.group>
                    <x-admin.components.input.group label="{{ __('slide.form.inputs.cta_title') }}" for="cta_title"
                        :error="$errors->first('slide.cta_title')">
                        <x-admin.components.input.text wire:model.defer="slide.cta_title" name="cta_title"
                            id="cta_title" :error="$errors->first('slide.cta_title')" />
                    </x-admin.components.input.group>
                </div>

                <x-admin.components.input.group label="{{ __('slide.form.inputs.description') }}" for="description"
                    :error="$errors->first('slide.description')">
                    <x-admin.components.input.textarea wire:model.defer="slide.description" name="description"
                        id="description" :error="$errors->first('slide.description')" />
                </x-admin.components.input.group>

            </x-admin.components.card>

            <div id="images">
                <x-admin.components.image-manager :existing="$images" :maxFiles="2" :multiple="false"
                    model="imageUploadQueue"  subtitle="{{ $type == 'page' ? '(1400 x 858)' : '(685 x 729)' }}" />
                @error('images')
                    <div class="space-y-1">
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    </div>
                @enderror
                @error('images.*')
                    <div class="space-y-1">
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    </div>
                @enderror
            </div>

            <div class="px-4 py-3 text-right rounded shadow bg-gray-50 sm:px-6">
                <div class="flex flex-row justify-end gap-x-2">
                    <x-admin.components.publish-dropdown wire:model.defer="slide.is_published" type="category" />
                    <button type="submit"
                        class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span wire:loading.remove>
                            {{ __('global.save') }}
                        </span>
                        @include('admin.layouts.livewire.button-loading')
                    </button>
                </div>
            </div>

            @if ($slide->id)
                <div class="bg-white border border-red-300 rounded shadow">
                    <header class="px-6 py-4 text-red-700 bg-white border-b border-red-300 rounded-t">
                        {{ __('inputs.danger_zone.title') }}
                    </header>
                    <div class="p-6 space-y-4 text-sm">
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 md:col-span-6">
                                <strong>{{ __('slide.form.danger_zone.label') }}</strong>
                                <p class="text-xs text-gray-600">{{ __('slide.form.danger_zone.instructions') }}</p>
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
    </div>
</form>
