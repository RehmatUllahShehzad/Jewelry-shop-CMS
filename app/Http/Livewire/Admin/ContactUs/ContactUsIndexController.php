<?php

namespace App\Http\Livewire\Admin\ContactUs;

use App\Http\Livewire\Traits\ResetsPagination;
use App\Models\ContactForm;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Livewire\WithPagination;

class ContactUsIndexController extends ContactUsAbstract
{
    use WithPagination;
    use ResetsPagination;

    public string $search = '';

    public bool $showTrashed = false;

    public function getContactUsProperty(): LengthAwarePaginator
    {
        return ContactForm::query()
            ->when($this->search, fn ($q) => $q->search($this->search))
            ->when($this->showTrashed, fn ($q) => $q->withTrashed())
            ->latest()
            ->paginate(10);
    }

    public function render(): View
    {
        return $this->view('admin.contact-us.contact-us-index-controller');
    }
}
