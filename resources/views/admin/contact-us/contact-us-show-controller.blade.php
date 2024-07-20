<x-slot name="pageTitle">
    {{ __('contact-us.title') }}
</x-slot>

<div>
    <header class="flex items-center">
        <h1 class="text-lg font-bold text-gray-900 md:text-2xl">
            <span class="">{{ __('contact-us.details') }}</span>
        </h1>
    </header>
    <div class="mt-4">
        <ul class="space-y-4">
            <li class="text-sm bg-white borderborder-green-300 rounded-lg shadow-sm ">
                <div class="grid grid-cols-2 gap-4 p-3">
                    <div>
                        <strong class="text-xs">
                            <strong>{{ __('contact-us.first_name') }}</strong>
                        </strong>
                        <p>{{ $contactUs->first_name }}</p>
                    </div>
                    <div>
                        <strong class="text-xs">
                            <strong>{{ __('contact-us.last_name') }}</strong>
                        </strong>
                        <p>{{ $contactUs->last_name }}</p>
                    </div>
                    <div>
                        <strong class="text-xs">
                            <strong>{{ __('contact-us.email') }}</strong>
                        </strong>
                        <p>{{ $contactUs->email }}</p>
                    </div>
                    <div>
                        <strong class="text-xs">
                            <strong>{{ __('contact-us.phone') }}</strong>
                        </strong>
                        <p>+{{ $contactUs->phone }}</p>
                    </div>
                </div>
                <div class="p-3 w-100">
                    <div>
                        <strong class="text-xs">
                            <strong>{{ __('contact-us.message') }}</strong>
                        </strong>
                        <p class="overflow-x-auto overflow-hidden">
                            {{ $contactUs->message }}
                        </p>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <div class="mt-4">
        @if ($contactUs->id)
            <div class="bg-white border border-red-300 rounded shadow">
                <header class="px-6 py-4 text-red-700 bg-white border-b border-red-300 rounded-t">
                    {{ __('inputs.danger_zone.title') }}
                </header>
                <div class="p-6 space-y-4 text-sm">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 md:col-span-6">
                            <strong>{{ __('frontend/contact-us.form.danger_zone.label') }}</strong>
                            <p class="text-xs text-gray-600">
                                {{ __('frontend/contact-us.form.danger_zone.instructions') }}</p>
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
