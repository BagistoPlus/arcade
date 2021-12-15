<?php

namespace EldoMagan\BagistoArcade\Sections;

use Webkul\Category\Repositories\CategoryRepository;

class Header extends BladeSection
{
    protected static $settings = [];

    public $categories = [];

    public function __construct(CategoryRepository $categoryRepository, $arcadeId)
    {
        parent::__construct($arcadeId);

        // @phpstan-ignore-next-line
        $rootCategoryId = core()->getCurrentChannel()->root_category_id;

        foreach ($categoryRepository->getVisibleCategoryTree($rootCategoryId) as $category) {
            if ($category->slug) {
                array_push($this->categories, $category);
            }
        }
    }

    public function render()
    {
        return view('shop::sections.header');
    }
}
