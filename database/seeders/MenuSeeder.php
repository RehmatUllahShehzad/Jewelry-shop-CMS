<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = collect([
            'header', 'navigation', 'jewelry', 'footer',
        ])
            ->map(
                fn ($name) => Menu::query()
                    ->firstOrCreate(compact('name'))
            )
            ->pluck('id', 'name');

        collect([
            1 => [
                'menu' => 'header',
                'title' => 'Fine Jewelry',
                'link' => '/category/fine-jewelry',
            ],
            2 => [
                'menu' => 'header',
                'title' => 'High Jewelry',
                'link' => '/category/high-jewelry',
            ],
            3 => [
                'menu' => 'header',
                'title' => 'I Do by Rafka',
                'link' => '/category/i-do-by-rafka',
            ],
            4 => [
                'menu' => 'header',
                'title' => 'Objets',
                'link' => '/category/objets',
            ],
            5 => [
                'menu' => 'header',
                'title' => 'Bespoke Creations',
                'link' => '/category/bespoke-creations',
            ],
            6 => [
                'menu' => 'header',
                'title' => 'About Us',
                'link' => '/about-us',
            ],
            7 => [
                'menu' => 'navigation',
                'title' => 'Fine Jewelry',
                'link' => '/category/fine-jewelry',
            ],
            8 => [
                'menu' => 'navigation',
                'title' => 'High Jewelry',
                'link' => '/category/high-jewelry',
            ],
            9 => [
                'menu' => 'navigation',
                'title' => 'I Do by Rafka',
                'link' => '/category/i-do-by-rafka',
            ],
            10 => [
                'menu' => 'navigation',
                'title' => 'Objets',
                'link' => '/category/objets',
            ],
            11 => [
                'menu' => 'navigation',
                'title' => 'Bespoke Creations',
                'link' => '/category/bespoke-creations',
            ],
            12 => [
                'menu' => 'navigation',
                'title' => 'About Us',
                'link' => '/about-us',
            ],
            13 => [
                'menu' => 'navigation',
                'title' => 'In The Press',
                'link' => '/in-the-press',
            ],
            14 => [
                'menu' => 'navigation',
                'title' => 'Blogs',
                'link' => '/blogs',
            ],
            15 => [
                'menu' => 'jewelry',
                'title' => 'Bracelets',
                'link' => '/category/fine-jewelry/bracelets',
            ],
            16 => [
                'menu' => 'jewelry',
                'title' => 'Brooches',
                'link' => '/category/fine-jewelry/brooches',
            ],
            17 => [
                'menu' => 'jewelry',
                'title' => 'Earrings',
                'link' => '/category/fine-jewelry/earrings',
            ],
            18 => [
                'menu' => 'jewelry',
                'title' => 'Pendants',
                'link' => '/category/fine-jewelry/pendants',
            ],
            19 => [
                'menu' => 'jewelry',
                'title' => 'Rings',
                'link' => '/category/fine-jewelry/rings',
            ],
            20 => [
                'menu' => 'footer',
                'title' => 'Terms & Conditions',
                'link' => '/terms-conditions',
            ],
            21 => [
                'menu' => 'footer',
                'title' => 'Privacy Policy',
                'link' => '/privacy-policy',
            ],
        ])
            ->map(fn ($item, $key) => MenuItem::firstOrCreate(['id' => $key], [
                'menu_id' => $menus[$item['menu']],
                'title' => $item['title'],
                'link' => $item['link'],
            ]));
    }
}
