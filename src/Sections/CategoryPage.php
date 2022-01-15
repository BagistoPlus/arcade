<?php

namespace EldoMagan\BagistoArcade\Sections;

use Webkul\Product\Helpers\Toolbar as ProductsListActionsHelper;
use Webkul\Product\Repositories\ProductFlatRepository;
use Webkul\Product\Repositories\ProductRepository;

class CategoryPage extends LivewireSection
{
    public $sort = '';
    public $order = '';
    public $perPage = 9;
    public $filters = [];

    public $sortOrder = '';

    protected $productRepository;
    protected $productFlatRepository;
    protected $productsListActionsHelper;

    protected $queryString = [
        'sort' ,
        'order',
        'perPage' => ['as' => 'limit'],
        'filters',
    ];

    public function mount()
    {
        $this->sort = request()->input('sort', 'name');
        $this->order = request()->input('order', 'asc');
        $this->perPage = request()->input('perPage', 9);
        $this->filters = request()->input('filters', []);

        $this->sortOrder = $this->sort . '-' . $this->order;
    }

    public function booted(ProductRepository $productRepository, ProductFlatRepository $productFlatRepository, ProductsListActionsHelper $productsListActionsHelper)
    {
        $this->productRepository = $productRepository;
        $this->productFlatRepository = $productFlatRepository;
        $this->productsListActionsHelper = $productsListActionsHelper;

        $this->getFilterAttributesProperty()->each(function ($attribute) {
            if (isset($this->filters[$attribute->code])) {
                return;
            }

            if (! empty(request()->query($attribute->code))) {
                $this->filters[$attribute->code] = explode(',', request()->query->get($attribute->code));
            } else {
                $this->filters[$attribute->code] = [];
            }
        });
    }

    public function updated($name, $value)
    {
        if ($name == 'sortOrder') {
            list($sort, $order) = explode('-', $this->sortOrder);
            $this->sort = $sort;
            $this->order = $order;
        }
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

    public function getFilterAttributesProperty()
    {
        return $this->productFlatRepository
            ->getProductsRelatedFilterableAttributes($this->context['category']);
    }

    public function render()
    {
        // This is necessary to forward query string updates to
        // other components like ProductRepository
        // as livewire don't send query params on subsequent requests
        request()->merge(array_merge(
            [
                'sort' => $this->sort,
                'order' => $this->order,
                'limit' => $this->perPage,
            ],
            collect($this->filters)->map(function ($value, $key) {
                return join(',', $value);
            })->toArray()
        ));

        return view('shop::sections.category-page');
    }
}
