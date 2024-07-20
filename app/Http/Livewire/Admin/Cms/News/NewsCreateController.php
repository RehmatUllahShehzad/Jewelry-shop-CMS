<?php

namespace App\Http\Livewire\Admin\Cms\News;

use App\Models\News;
use Illuminate\Contracts\View\View;

class NewsCreateController extends NewsAbstract
{
    /**
     * Mount the component
     *
     * @return void
     */
    public function mount(): void
    {
        $this->news = new News(['is_published' => true]);
    }

    public function render(): View
    {
        return $this->view('admin.cms.news.news-create-controller');
    }
}
