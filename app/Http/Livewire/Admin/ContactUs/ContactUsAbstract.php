<?php

namespace App\Http\Livewire\Admin\ContactUs;

use App\View\Components\Admin\Layouts\SubMasterLayout;
use Closure;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ContactUsAbstract extends Component
{
    /**
     * @param  view-string  $view
     */
    public function view(string $view, Closure $closure = null): View
    {
        return tap(view($view), $closure)
        ->layout(SubMasterLayout::class, [
            'menuName' => 'contact-us',
        ]);
    }
}
