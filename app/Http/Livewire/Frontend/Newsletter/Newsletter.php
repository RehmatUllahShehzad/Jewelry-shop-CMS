<?php

namespace App\Http\Livewire\Frontend\Newsletter;

use App\Services\Admin\NewsletterService;
use Exception;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Newsletter extends Component
{
    public string $email;

    public function mount(): void
    {
        $this->resetFields();
    }

    public function render(): View
    {
        return view('frontend.newsletter.newsletter');
    }

    public function submit(NewsletterService $newsletterService): void
    {
        $this->validate([
            'email' => 'bail|required|email:filter,rfc,dns|max:191',
        ]);

        try {
            $newsletterService->subscribe($this->email);

            $this->resetFields();
            $this->emit('alert-success', __('frontend/newsletter.subscribed-successfully'));
        } catch (Exception $e) {
            $error_message = $e->getMessage();

            if ($e instanceof BadResponseException) {
                $response = $e->getResponse()->getBody()->getContents();

                if ($data = json_decode($response)) {
                    if (($detail = optional($data)->detail) && str_contains($detail, 'already')) {
                        $error_message = __('frontend/newsletter.already-subscribed');
                    }

                    $error_message = optional($data)->detail;
                }
            }

            $this->emit('alert-danger', $error_message);
        }
    }

    private function resetFields(): void
    {
        $this->email = '';
    }
}
