<?php

namespace App\Http\Livewire\Frontend\ContactUs;

use App\Http\Livewire\Traits\Notifies;
use App\Mail\ContactUsMail;
use App\Mail\ContactUsThankYouMail;
use App\Models\ContactForm;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactUs extends Component
{
    use Notifies;

    public string $first_name = '';

    public string $last_name = '';

    public string $email = '';

    public string $phone = '';

    public string $message = '';

    public function mount(): void
    {
        $this->initializeInputs();
    }

    public function render(): View
    {
        return view('frontend.contact-us.contact-us');
    }

    public function submit(): void
    {
        $this->phone = preg_replace('/[^0-9]/', '', $this->phone);

        $data = $this->validate([
            'email' => 'required|email:filter,rfc,dns',
            'first_name' => 'required|alpha|max:30',
            'last_name' => 'required|alpha|max:30',
            'message' => 'required|max:700',
            'phone' => 'required|min:11|regex:/^1(?!0{10})[0-9]{10}$/',
        ]);

        try {
            ContactForm::create($data);
            Mail::send(new ContactUsThankYouMail($data));
            Mail::send(new ContactUsMail($data));
            $this->emit('alert-success', __('frontend/contact-us.success.message'));
            $this->initializeInputs();
        } catch (Exception $exception) {
            $this->emit('alert-danger', 'Error: '.$exception->getMessage());
        }
    }

    public function initializeInputs(): void
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->phone = '';
        $this->message = '';
    }
}
