<?php

namespace App\Http\Livewire\Admin\Cms\Slide;

use App\Http\Livewire\Admin\Cms\CmsAbstract;
use App\Http\Livewire\Traits\HasImages;
use App\Http\Livewire\Traits\Notifies;
use App\Models\Category;
use App\Models\Page;
use App\Models\Slide;
use App\Rules\ImageDimensionsValidation;
use App\View\Components\Admin\Layouts\SubMasterLayout;
use Illuminate\Contracts\View\View;
use Livewire\WithFileUploads;

abstract class SlideAbstract extends CmsAbstract
{
    use Notifies;
    use HasImages;
    use WithFileUploads;

    public Page|Category $slideable;

    public string $type;

    public int $slideableId;

    /**
     * The slide model
     *
     * @var Slide
     */
    public Slide $slide;

    /**
     * @return array<mixed>
     */
    protected function getListeners(): array
    {
        return array_merge(
            [],
            $this->getHasImagesListeners()
        );
    }

    public function getMediaModel(): Slide
    {
        return $this->slide;
    }

    /**
     * Validation rules for slides
     *
     * @return array<mixed>
     */
    protected function rules(): array
    {
        return [
            'slide.title' => 'bail|required|max:30',
            'slide.sub_title' => 'bail|nullable',
            'slide.description' => 'bail|required',
            'slide.cta_title' => 'bail|nullable',
            'slide.cta_link' => 'bail|nullable',
            'slide.is_published' => 'bail|boolean',
            'images' => [
                'required',
                $this->type == 'category' ? 'min:2' : '',
            ],
            'images.*' => (new ImageDimensionsValidation())->height($this->type == 'page' ? 858 : 729)->width($this->type == 'page' ? 1400 : 685),
        ];
    }

    /**
     * Define the validation messagess.
     *
     * @var array<mixed>
     */
    protected array $messages = [
        'images.min' => 'Please add atleast :min images.',
    ];

    /**
     * Custom attribute name's mapping
     *
     * @return array<mixed>
     */
    protected function validationAttributes()
    {
        return collect($this->images)
            ->mapWithKeys(fn ($value, $key) => ["images.{$key}" => 'image #'.++$key])
            ->toArray();
    }

    /**
     * Save the page in database
     *
     * @return void
     */
    public function save(): void
    {
        $this->validate();

        $this->slideable->slides()->save($this->slide);

        $this->updateImages();

        $type = $this->slide->wasRecentlyCreated ? 'created' : 'updated';

        $this->notify(
            "Slide {$type} successfully.",
            'admin.cms.slides.show',
            [$this->type, $this->slideable->id]
        );
    }

    public function render(): View
    {
        $menuName = $this->type == 'page' ? 'cms' : 'catalog';

        $title = $this->slide->id ? 'edit' : 'create';

        return view('admin.cms.slide.slide-form')
            ->with('pageTitle', "slide.{$title}.title")
            ->layout(SubMasterLayout::class, [
                'menuName' => $menuName,
            ]);
    }
}
