<?php

namespace App\Http\Livewire\Admin\Catalog\Product;

use App\Http\Livewire\Admin\Catalog\CatalogAbstract;
use App\Http\Livewire\Traits\ResetsPagination;
use App\Models\Product;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\WithPagination;

class ProductIndexController extends CatalogAbstract
{
    use WithPagination,
        ResetsPagination;

    public string $showTrashed = '';

    public string $search = '';

    public string $sortBy = 'id';

    public string $sortOrder = 'id';

    /**
     * @var array<string>
     */
    protected $queryString = ['sortBy'];

    public function mount(): void
    {
        $this->search = '';
    }

    public function render(): View
    {
        return $this->view('admin.catalog.product.product-index-controller', function (View $view) {
            $view->with('products', $this->getProducts());
        });
    }

    public function getProducts(): Paginator
    {
        $query = Product::query()
            ->with('thumbnail')
            ->when($this->search, fn ($query) => $query->search($this->search));

        if ($this->showTrashed) {
            $query = $query->withTrashed();
        }

        return $query
            ->orderBy('id', 'ASC')
            ->paginate(10);
    }
}
