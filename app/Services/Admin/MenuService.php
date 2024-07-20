<?php

namespace App\Services\Admin;

use App\Menu\Menu;
use App\Menu\MenuItem;
use Illuminate\Support\Collection;

class MenuService
{
    public static function menu(string $name): Menu
    {
        return (new self)->get($name);
    }

    public function get(string $name): Menu
    {
        /** @var \App\Menu\Menu */
        $menu = $this->getMenuList()->where('name', $name)->first();

        return $menu;
    }

    private function getMenuList(): Collection
    {
        return collect([
            /**
             * Main Sidebar Menu
             */
            Menu::make('main')
                ->addItem(function (MenuItem $item) {
                    $item->name('Dashboard')
                        ->handle('admin.dashboard')
                        // ->permission('admin:dashboard')
                        ->icon('chart-square-bar')
                        ->route('admin.dashboard');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Cms')
                        ->handle('admin.cms')
                        ->permission('cms')
                        ->icon('document')
                        ->route('admin.cms.blogs.index');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Catalog')
                        ->handle('admin.catalog')
                        ->permission('catalog')
                        ->icon('collection')
                        ->route('admin.catalog.category.index');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Contact Us')
                        ->handle('admin.contact-us')
                        ->permission('contact-us')
                        ->icon('table')
                        ->route('admin.contact-us.index');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('System')
                        ->handle('admin.system')
                        ->permission('system')
                        ->icon('cog')
                        ->route('admin.system.staff.index');
                }),

            /**
             * System Menu
             */
            Menu::make('system')
                ->addItem(function (MenuItem $item) {
                    $item->name('Staff')
                        ->handle('admin.system.staff')
                        ->route('admin.system.staff.index')
                        ->permission('system:manage-staff')
                        ->icon('identification');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Settings')
                        ->handle('admin.system.settings')
                        ->route('admin.system.settings')
                        ->permission('system:settings')
                        ->icon('cog');
                }),

            /**
             * Catalog Menu
             */
            Menu::make('catalog')
                ->addItem(function (MenuItem $item) {
                    $item->name('Categories')
                        ->handle('admin.catalog.category')
                        ->route('admin.catalog.category.index')
                        ->permission('catalog:manage-category')
                        ->icon('collection');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Products')
                        ->handle('admin.catalog.product')
                        ->route('admin.catalog.product.index')
                        ->permission('catalog:manage-products')
                        ->icon('cube');
                }),
            /**
             * CMS Menu
             */
            Menu::make('cms')
                ->addItem(function (MenuItem $item) {
                    $item->name('Blogs')
                        ->handle('admin.cms.blogs')
                        ->route('admin.cms.blogs.index')
                        ->permission('cms:manage-blogs')
                        ->icon('document');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('News')
                        ->handle('admin.cms.news')
                        ->permission('cms:manage-news')
                        ->icon('newspaper')
                        ->route('admin.cms.news.index');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Menu')
                        ->handle('admin.cms.menu')
                        ->route('admin.cms.menu.index')
                        ->permission('cms:manage-menus')
                        ->icon('menu');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Pages')
                        ->handle('admin.cms.pages')
                        ->route('admin.cms.pages.index')
                        ->permission('cms:manage-pages')
                        ->icon('collection');
                }),

            /**
             * Contact us Menu
             */
            Menu::make('contact-us')
            ->addItem(function (MenuItem $item) {
                $item->name('Contact us')
                    ->handle('admin.contact-us')
                    ->route('admin.contact-us.index')
                    ->permission('contact-us')
                    ->icon('table');
            }),
        ]);
    }
}
