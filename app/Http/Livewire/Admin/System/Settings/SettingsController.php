<?php

namespace App\Http\Livewire\Admin\System\Settings;

use App\Http\Livewire\Admin\System\SystemAbstract;
use App\Http\Livewire\Traits\Notifies;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class SettingsController extends SystemAbstract
{
    use Notifies;
    use WithFileUploads;

    /**
     * List of all the settings
     *
     * @var array<mixed>
     */
    public $settings = [];

    public function mount(): void
    {
        $this->settings = Setting::getKeyValues()->toArray();
    }

    /**
     * render
     *
     * @return View
     */
    public function render(): View
    {
        return $this->view('admin.system.settings.settings-controller');
    }

    /**
     * Custom attribute name's mapping
     *
     * @return array<mixed>
     */
    protected function validationAttributes()
    {
        return get_general_site_settings()
            ->mapWithKeys(fn ($value, $key) => ["settings.{$key}" => Str::replace('_', ' ', $key)])
            ->toArray();
    }

    /**
     * Define the validation rules.
     *
     * @return array<mixed>
     */
    protected function rules()
    {
        return get_general_site_settings()
            ->mapWithKeys(fn ($value, $key) => ["settings.{$key}" => $value['rules']])
            ->toArray();
    }

    public function update(): void
    {
        $this->validate();

        collect($this->settings)->each(function ($value, $key) {
            if (get_general_site_settings($key) == 'file') {
                if ($value instanceof TemporaryUploadedFile) {
                    /** @var Setting|null $setting */
                    $setting = Setting::where('key', $key)->first();

                    if ($setting) {
                        $setting->clearMediaCollection();
                        $this->settings[$key] = $setting->addMedia($value)->toMediaCollection()->getFullUrl();
                    }
                }

                $value = 'file';
            }

            Setting::updateOrCreate(
                compact('key'),
                compact('value')
            );
        });

        $this->notify(trans('notifications.settings.updated'));
    }
}
