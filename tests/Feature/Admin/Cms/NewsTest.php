<?php

namespace Tests\Feature\Admin\Cms;

use App\Http\Livewire\Admin\Cms\News\NewsCreateController;
use App\Http\Livewire\Admin\Cms\News\NewsIndexController;
use App\Http\Livewire\Admin\Cms\News\NewsShowController;
use App\Models\Admin\Staff;
use App\Models\News;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class NewsTest extends TestCase
{
    use WithLogin;

    public function test_guest_user_cannot_see_news_listing_page()
    {
        $response = $this->get(
            route('admin.cms.news.index')
        );

        $response->assertRedirect(
            route('admin.login')
        );
    }

    public function test_authorized_user_can_see_news_listing_page()
    {
        $user = $this->loginStaff(true);

        $response = $this->get(
            route('admin.cms.news.index')
        );

        $response = Livewire::actingAs($user)
            ->test(NewsIndexController::class)
            ->call('render');

        $response->assertOk();
    }

    public function test_authorized_user_cannot_create_news_with_invalid_data()
    {
        $this->loginStaff(true);

        $response = Livewire::test(NewsCreateController::class)
            ->set('news.title', '')
            ->call('save');

        $response->assertOk();
        $response->assertHasErrors([
            'news.title',
        ]);
    }

    public function test_authorized_user_can_create_news_with_valid_data()
    {
        $user = $this->loginStaff(true);

        $response = Livewire::actingAs($user)
            ->test(NewsCreateController::class)
            ->set('news.title', 'test')
            ->set('news.is_published', true)
            ->uploadFile('imageUploadQueue', UploadedFile::fake()->image('avatar.jpg', 500, 500))
            ->call('save');

        $response->assertOk();

        $this->assertCount(1, News::query()->whereTitle('test')->published()->get());
    }

    public function test_authorized_user_cannot_update_news_with_invalid_data()
    {
        $user = $this->loginStaff(true);

        $news = News::factory()
            ->for(Staff::factory(), 'staff')
            ->count(1)
            ->create()
            ->first();

        $response = Livewire::actingAs($user)
            ->test(NewsShowController::class, [
                'news' => $news,
            ])
            ->set('news.title', '')
            ->call('save');

        $response->assertOk();
        $response->assertHasErrors([
            'news.title',
        ]);
    }

    public function test_authorized_user_can_update_news_with_valid_data()
    {
        $user = $this->loginStaff(true);

        $news = News::factory()
            ->for(Staff::factory(), 'staff')
            ->count(1)
            ->create()
            ->first();

        $response = Livewire::actingAs($user)->test(NewsShowController::class, [
            'news' => $news,
        ])
            ->set('news.title', 'test title')
            ->set('news.is_published', false)
            ->uploadFile('imageUploadQueue', UploadedFile::fake()->image('avatar.jpg', 500, 500))
            ->call('save');

        $response->assertOk();

        $this->assertCount(1, News::query()->whereTitle('test title')->notPublished()->get());
    }

    public function test_authorized_user_delete_news()
    {
        $user = $this->loginStaff(true);

        $news = News::factory()
            ->for(Staff::factory(), 'staff')
            ->count(1)
            ->create()
            ->first();

        Livewire::actingAs($user)
            ->test(NewsShowController::class, [
                'news' => $news,
            ])
            ->call('delete');

        $this->assertSoftDeleted($news);
    }
}
