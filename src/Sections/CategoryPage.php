<?php

namespace EldoMagan\BagistoArcade\Sections;

use Webkul\Product\Helpers\Toolbar as ProductsListActionsHelper;
use Webkul\Product\Repositories\ProductRepository;

class CategoryPage extends LivewireSection
{
    public $sort = '';
    public $order = '';
    public $perPage = 9;

    public $sortOrder = '';

    protected $productRepository;
    protected $productsListActionsHelper;

    protected $queryString = [
        'sort' ,
        'order',
        'perPage' => ['as' => 'limit'],
    ];

    public function mount()
    {
        $this->sort = request()->input('sort', 'name');
        $this->order = request()->input('order', 'asc');

        $this->sortOrder = $this->sort . '-' . $this->order;
    }

    public function booted(ProductRepository $productRepository, ProductsListActionsHelper $productsListActionsHelper)
    {
        $this->productRepository = $productRepository;
        $this->productsListActionsHelper = $productsListActionsHelper;
    }

    public function updated($name, $value)
    {
        if ($name == 'sortOrder') {
            list($sort, $order) = explode('-', $this->sortOrder);
            $this->sort = $sort;
            $this->order = $order;
        }

        // This is necessary to forward query string updates to
        // other components like ProductRepository
        // as livewire don't send query params on subsequent requests
        request()->query->add([
            'sort' => $this->sort,
            'order' => $this->order,
            'limit' => $this->perPage,
        ]);
    }

    public function getProductsPaginator()
    {
        return $this->productRepository->getAll($this->context['category']->id);
    }

    public function getProductsProperty()
    {
        return $this->getProductsPaginator();
    }

    public function getSortOptionsProperty()
    {
        return $this->productsListActionsHelper->getAvailableOrders();
    }

    public function getItemsPerPageOptionsProperty()
    {
        return $this->productsListActionsHelper->getAvailableLimits();
    }

    public function render()
    {
        return view('shop::sections.category-page');
    }
}
