<?php

namespace App\Http\Livewire\Admin\ContactUs;

use App\Http\Livewire\Traits\CanDeleteRecord;
use App\Http\Livewire\Traits\Notifies;
use App\Models\ContactForm;
use Illuminate\Contracts\View\View;

class ContactUsShowController extends ContactUsAbstract
{
    use Notifies;
    use CanDeleteRecord;

    public ContactForm $contactUs;

    public function render(): View
    {
        return $this->view('admin.contact-us.contact-us-show-controller');
    }

    public function delete(): void
    {
        $this->contactUs->delete();
        $this->notify('frontend/contact-us.delete', 'admin.contact-us.index');
    }

    /**
     * return field to verify for delete
     */
    public function getCanDeleteConfirmationField(): string
    {
        return $this->contactUs->email;
    }
}
