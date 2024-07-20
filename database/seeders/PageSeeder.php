<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'id' => Page::HOME_PAGE_ID,
                'title' => 'Home',
                'template' => 'home',
            ],
            [
                'id' => 2,
                'title' => 'About Us',
                'template' => 'about-us',
            ],
            [
                'id' => 3,
                'title' => 'Contact Us',
                'template' => 'contact-us',
            ],
            [
                'id' => 4,
                'title' => 'Privacy Policy',
                'template' => 'privacy-policy',
            ],
            [
                'id' => 5,
                'title' => 'Terms & conditions',
                'template' => 'terms-conditions',
            ],
            [
                'id' => 6,
                'title' => 'Blogs',
                'template' => 'blogs',
            ],
            [
                'id' => 7,
                'title' => 'In The Press',
                'template' => 'in-the-press',
            ],

        ];
        foreach ($pages as $page) {
            $content = view("frontend/theme/templates/pages.{$page['template']}")->render();

            Page::firstOrCreate(
                [
                    'id' => $page['id'],
                ],
                [
                    'id' => $page['id'],
                    'title' => $page['title'],
                    'slug' => Str::slug($page['title']),
                    'gjs_data' => [
                        'html' => $content,
                        'page' => [
                            'component' => $content,
                        ],
                        'styles' => [],
                        'css' => '',
                    ],
                ]
            );
        }
    }
}
