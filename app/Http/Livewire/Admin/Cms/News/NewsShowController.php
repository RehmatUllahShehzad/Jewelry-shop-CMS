<?php

namespace App\Http\Livewire\Admin\Cms\News;

use App\Http\Livewire\Traits\CanDeleteRecord;
use Illuminate\Contracts\View\View;

class NewsShowController extends NewsAbstract
{
    use CanDeleteRecord;

    public function render(): View
    {
        return $this->view('admin.cms.news.news-show-controller');
    }

    public function delete(): void
    {
        $this->news->delete();

        $this->notify(trans('notifications.news.deleted'), 'admin.cms.news.index');
    }

    /**
     * return field to verify for delete
     */
    public function getCanDeleteConfirmationField(): string
    {
        return $this->news->slug;
    }
}
