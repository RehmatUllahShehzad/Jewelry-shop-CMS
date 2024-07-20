<?php

namespace Tests\Feature\Admin\Product;

use App\Http\Livewire\Admin\Catalog\Product\ProductCreateController;
use App\Http\Livewire\Admin\Catalog\Product\ProductIndexController;
use App\Http\Livewire\Admin\Catalog\Product\ProductShowController;
use App\Models\Admin\Staff;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class ProductTest extends TestCase
{
    use WithLogin;

    public function test_guest_users_cannot_see_product_listing_page()
    {
        $response = $this->get(
            route('admin.catalog.product.index')
        );

        $response->assertRedirect(
            route('admin.login')
        );
    }

    public function test_authorized_users_can_see_product_listing_page()
    {
        $this->loginStaff(true);

        $response = $this->get(
            route('admin.catalog.product.index')
        );

        $response->assertOk();
    }

    public function test_authorized_users_cannot_create_product_with_invalid_data()
    {
        $this->loginStaff(true);

        $response = Livewire::test(ProductCreateController::class)
            ->set('product.title', '')
            ->set('product.description', '')
            ->set('product.specifications', '')
            ->set('product.materials', '')
            ->call('store');

        $response->assertOk();
        $response->assertHasErrors([
            'product.title',
            'product.description',
            'product.specifications',
            'product.materials',
            'categories',
        ]);
    }

    public function test_authorized_users_can_create_product_with_valid_data()
    {
        $this->loginStaff(true);
        $categories = Category::factory()->create();
        $categories = Category::all();

        $response = Livewire::test(ProductCreateController::class)
            ->set('product.title', 'test product')
            ->set('product.description', 'sada sadsad d sada')
            ->set('product.specifications', 'sada sadsad d sada')
            ->set('product.materials', 'sada sadsad d sada')
            ->set('categories', $categories)
            ->uploadFile('imageUploadQueue', UploadedFile::fake()->image('avatar.jpg'))
            ->call('store');

        $response->assertOk();
        $this->assertCount(1, Product::query()->get());
    }

    public function test_authorized_users_cannot_update_product_with_invalid_data()
    {
        $this->loginStaff(true);
        $product = Product::factory()->count(1)->has(Category::factory(1))->has(Staff::factory(1))->create()->first();

        $response = Livewire::test(ProductShowController::class, [
            'product' => $product,
        ])
            ->set('product.title', '')
            ->set('product.description', '')
            ->set('product.specifications', '')
            ->set('product.materials', '')
            ->call('update');

        $response->assertOk();
        $response->assertHasErrors([
            'product.title',
            'product.description',
            'product.specifications',
            'product.materials',

        ]);
    }

    public function test_authorized_users_can_update_product_with_valid_data()
    {
        $this->loginStaff(true);
        $product = Product::factory()->count(1)->has(Category::factory(1))->has(Staff::factory(1))->create()->first();

        $response = Livewire::test(ProductShowController::class, [
            'product' => $product,
        ])
            ->set('product.title', 'test product updated')

            ->call('update');

        $response->assertOk();
        $this->assertCount(1, Product::query()->where('title', 'test product updated')->get());
    }

    public function test_authorized_users_can_see_deleted_product()
    {
        $this->loginStaff(true);
        $product = Product::factory()->count(1)->has(Category::factory(1))->has(Staff::factory(1))->create()->first();

        $response = Livewire::test(ProductShowController::class, [
            'product' => $product,
        ])
        ->call('delete');

        $response = Livewire::test(ProductIndexController::class)
            ->set('showTrashed', false);

        $response->assertDontSee($product->title);

        $response = Livewire::test(ProductIndexController::class)
            ->set('showTrashed', true);

        $response->assertSee($product->title);
    }
}
