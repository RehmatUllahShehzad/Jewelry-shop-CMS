<?php

namespace App\Services\Admin;

use MailchimpMarketing\ApiClient;

class NewsletterService
{
    public ApiClient $mailchimp;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->mailchimp = new ApiClient();

        $this->mailchimp->setConfig([
            'apiKey' => config('services.mailchimp.api_key'),
            'server' => config('services.mailchimp.server_prefix'),
        ]);
    }

    public function subscribe(string $email): mixed
    {
        /* @phpstan-ignore-next-line */
        return $this->mailchimp->lists->addListMember(config('services.mailchimp.list_id'), [
            'email_address' => $email,
            'status' => 'subscribed',
        ]);
    }
}
