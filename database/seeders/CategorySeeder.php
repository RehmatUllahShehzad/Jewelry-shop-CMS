<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'id' => Category::FINE_JEWELRY_ID,
                'name' => 'Fine Jewelry',
                'parent_id' => null,
                'template' => 'jewelry',
            ],
            [
                'id' => Category::HIGH_JEWELRY_ID,
                'name' => 'High Jewelry',
                'parent_id' => null,
                'template' => 'jewelry',
            ],
            [
                'id' => Category::I_DO_BY_RAFKA_ID,
                'name' => 'I Do by Rafka',
                'parent_id' => null,
                'template' => 'i-do-by-rafka',
            ],
            [
                'id' => Category::OBJETS_ID,
                'name' => 'Objets',
                'parent_id' => null,
                'template' => 'objets',
            ],
            [
                'id' => 5,
                'name' => 'Bespoke Creations',
                'parent_id' => null,
                'template' => 'bespoke-creations',
            ],
            [
                'id' => 6,
                'name' => 'Groom',
                'parent_id' => null,
                'template' => 'category',
            ],
            [
                'id' => 7,
                'name' => 'Bride',
                'parent_id' => null,
                'template' => 'category',
            ],
            [
                'id' => Category::FINE_JEWELRY_RINGS_ID,
                'name' => 'RINGS',
                'parent_id' => Category::FINE_JEWELRY_ID,
                'template' => 'sub-category',
                'image' => '/fine_jewelry/rings.jpg',
            ],
            [
                'id' => Category::FINE_JEWELRY_EARRINGS_ID,
                'name' => 'EARRINGS',
                'parent_id' => Category::FINE_JEWELRY_ID,
                'template' => 'sub-category',
                'image' => '/fine_jewelry/earrings.jpg',
            ],
            [
                'id' => Category::FINE_JEWELRY_BRACELET_ID,
                'name' => 'BRACELETS',
                'parent_id' => Category::FINE_JEWELRY_ID,
                'template' => 'sub-category',
                'image' => '/fine_jewelry/bracelets.jpg',
            ],
            [
                'id' => Category::FINE_JEWELRY_NECKLACE_ID,
                'name' => 'NECKLACES',
                'parent_id' => Category::FINE_JEWELRY_ID,
                'template' => 'sub-category',
                'image' => '/fine_jewelry/necklaces.jpg',
            ],
            [
                'id' => Category::FINE_JEWELRY_BROOCHES_ID,
                'name' => 'BROOCHES',
                'parent_id' => Category::FINE_JEWELRY_ID,
                'template' => 'sub-category',
                'image' => '/fine_jewelry/brooches.jpg',
            ],
            [
                'id' => Category::FINE_JEWELRY_PENDANTS_ID,
                'name' => 'PENDANTS',
                'parent_id' => Category::FINE_JEWELRY_ID,
                'template' => 'sub-category',
                'image' => '/fine_jewelry/pendants.jpg',
            ],
            [
                'id' => Category::HIGH_JEWELRY_RINGS_ID,
                'name' => 'RINGS',
                'parent_id' => Category::HIGH_JEWELRY_ID,
                'template' => 'sub-category',
                'image' => '/high_jewelry/rings.jpg',
            ],
            [
                'id' => Category::HIGH_JEWELRY_EARRINGS_ID,
                'name' => 'EARRINGS',
                'parent_id' => Category::HIGH_JEWELRY_ID,
                'template' => 'sub-category',
                'image' => '/high_jewelry/earings.jpg',
            ],
            [
                'id' => Category::HIGH_JEWELRY_BRACELET_ID,
                'name' => 'BRACELETS',
                'parent_id' => Category::HIGH_JEWELRY_ID,
                'template' => 'sub-category',
                'image' => '/high_jewelry/bracelets.jpg',
            ],
            [
                'id' => Category::HIGH_JEWELRY_NECKLACE_ID,
                'name' => 'NECKLACES',
                'parent_id' => Category::HIGH_JEWELRY_ID,
                'template' => 'sub-category',
                'image' => '/high_jewelry/necklaces.jpg',
            ],
            [
                'id' => Category::HIGH_JEWELRY_BROOCHES_ID,
                'name' => 'BROOCHES',
                'parent_id' => Category::HIGH_JEWELRY_ID,
                'template' => 'sub-category',
                'image' => '/high_jewelry/brooches.jpg',
            ],
            [
                'id' => Category::I_DO_BY_RAFKA_ENGAGEMENT_RINGS_ID,
                'name' => 'ENGAGEMENT RINGS',
                'parent_id' => Category::I_DO_BY_RAFKA_ID,
                'template' => 'sub-category',
                'image' => '/i_do_by_rafka/engagement_rings.png',
            ],
            [
                'id' => Category::I_DO_BY_RAFKA_ETERNITY_BANDS_ID,
                'name' => 'ETERNITY BANDS',
                'parent_id' => Category::I_DO_BY_RAFKA_ID,
                'template' => 'sub-category',
                'image' => '/i_do_by_rafka/eternity_bands.png',
            ],
            [
                'id' => Category::I_DO_BY_RAFKA_STUD_EARRINGS_ID,
                'name' => 'STUD EARRINGS',
                'parent_id' => Category::I_DO_BY_RAFKA_ID,
                'template' => 'sub-category',
                'image' => '/i_do_by_rafka/stud_earrings.jpg',
            ],
            [
                'id' => Category::I_DO_BY_RAFKA_RIVIERA_NECKLACES_ID,
                'name' => 'RIVIERA NECKLACES',
                'parent_id' => Category::I_DO_BY_RAFKA_ID,
                'template' => 'sub-category',
                'image' => '/i_do_by_rafka/riviera_necklaces.jpg',
            ],
            [
                'id' => Category::I_DO_BY_RAFKA_RIVIERA_BRACELETS_ID,
                'name' => 'RIVIERA BRACELETS',
                'parent_id' => Category::I_DO_BY_RAFKA_ID,
                'template' => 'sub-category',
                'image' => '/i_do_by_rafka/riviera _bracelets.jpg',
            ],
        ];

        foreach ($categories as $item) {
            $content = view('frontend/theme/templates/'.($item['parent_id'] ? 'sub-category' : 'category').".{$item['template']}")->render();

            $category = Category::firstOrCreate(
                [
                    'id' => $item['id'],
                ],
                [
                    'name' => $item['name'],
                    'parent_id' => $item['parent_id'],
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

            if (isset($item['image']) && ! $category->hasMedia(get_class($category))) {
                $folderPath = database_path('seeders/data/images/categories/');

                $category
                    ->addMedia($folderPath.$item['image'])
                    ->preservingOriginal()
                    ->withCustomProperties(['primary' => true])
                    ->toMediaCollection(get_class($category));
            }
        }
    }
}
