<?php

namespace Tests\Feature\Admin\Cms;

use App\Http\Livewire\Admin\Cms\Blog\BlogCreateController;
use App\Http\Livewire\Admin\Cms\Blog\BlogIndexController;
use App\Http\Livewire\Admin\Cms\Blog\BlogShowController;
use App\Models\Admin\Staff;
use App\Models\Blog;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class BlogTest extends TestCase
{
    use WithLogin;

    public function test_guest_users_cannot_see_blogs_listing_page()
    {
        $response = $this->get(
            route('admin.cms.blogs.index')
        );

        $response->assertRedirect(
            route('admin.login')
        );
    }

    public function test_authorized_user_can_see_blogs_listing_page()
    {
        $user = $this->loginStaff(true);

        $response = $this->get(
            route('admin.cms.blogs.index')
        );

        $response = Livewire::actingAs($user)
            ->test(BlogIndexController::class)
            ->call('render');

        $response->assertOk();
    }

    public function test_authorized_user_cannot_create_blog_with_invalid_data()
    {
        $this->loginStaff(true);

        $response = Livewire::test(BlogCreateController::class)
            ->set('blog.title', '')
            ->call('save');

        $response->assertOk();
        $response->assertHasErrors([
            'blog.title',
        ]);
    }

    public function test_authorized_user_can_create_blog_with_valid_data()
    {
        $user = $this->loginStaff(true);

        $response = Livewire::actingAs($user)
            ->test(BlogCreateController::class)
            ->set('blog.title', 'test')
            ->set('blog.is_published', true)
            ->set('blog.published_at', '2022-01-01')
            ->uploadFile('imageUploadQueue', UploadedFile::fake()->image('avatar.jpg', 445, 255))
            ->call('save');

        $response->assertOk();

        $this->assertCount(1, Blog::query()->whereTitle('test')->published()->get());
    }

    public function test_authorized_user_cannot_update_blog_with_invalid_data()
    {
        $user = $this->loginStaff(true);

        $blog = Blog::factory()
            ->for(Staff::factory(), 'staff')
            ->count(1)
            ->create()
            ->first();

        $response = Livewire::actingAs($user)
            ->test(BlogShowController::class, [
                'blog' => $blog,
            ])
            ->set('blog.title', '')
            ->call('save');

        $response->assertOk();
        $response->assertHasErrors([
            'blog.title',
        ]);
    }

    public function test_authorized_user_can_update_blog_with_valid_data()
    {
        $user = $this->loginStaff(true);

        $blog = Blog::factory()
            ->for(Staff::factory(), 'staff')
            ->count(1)
            ->create()
            ->first();

        $response = Livewire::actingAs($user)->test(BlogShowController::class, [
            'blog' => $blog,
        ])
            ->set('blog.title', 'test title')
            ->set('blog.is_published', false)
            ->set('blog.published_at', '2022-01-01')
            ->uploadFile('imageUploadQueue', UploadedFile::fake()->image('avatar.jpg', 445, 255))
            ->call('save');

        $response->assertOk();

        $this->assertCount(1, Blog::query()->whereTitle('test title')->notPublished()->get());
    }

    public function test_authorized_user_delete_blog()
    {
        $user = $this->loginStaff(true);

        $blog = Blog::factory()
            ->for(Staff::factory(), 'staff')
            ->count(1)
            ->create()
            ->first();

        Livewire::actingAs($user)
            ->test(BlogShowController::class, [
                'blog' => $blog,
            ])
            ->call('delete');

        $this->assertSoftDeleted($blog);
    }
}
