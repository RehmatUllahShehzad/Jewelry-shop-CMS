<?php

namespace App\Http\Livewire\Admin\Cms\Menu;

use App\Http\Livewire\Traits\Notifies;
use App\Models\Menu;
use Illuminate\Contracts\View\View;

class MenuForm extends MenuAbstract
{
    use Notifies;

    public ?Menu $menu = null;

    public string $name = '';

    /**
     * @var array<mixed>
     */
    public $listeners = [
        'edit-item' => 'editItem',
    ];

    /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        $this->initializeFields();
    }

    public function render(): View
    {
        return $this->view('admin.cms.menu.menu-form');
    }

    /**
     * save
     *
     * @return void
     */
    public function save()
    {
        $this->validate([
            'name' => 'required|max:191|unique:menus,name'.($this->menu ? ','.$this->menu->id : ''),
        ]);

        if ($this->menu) {
            $this->menu->update([
                'name' => $this->name,
            ]);
        } else {
            Menu::create([
                'name' => $this->name,
            ]);
        }

        $this->notify(__('menu.item.form.menu.saved'));
        $this->emit('records-updated');
        $this->initializeFields();
    }

    /**
     * editItem
     *
     * @return void
     */
    public function editItem(Menu $menu)
    {
        $this->menu = $menu;
        $this->name = $menu->name;
    }

    /**
     * initializeFields
     *
     * @return void
     */
    public function initializeFields()
    {
        $this->name = '';
        $this->menu = null;
    }
}
