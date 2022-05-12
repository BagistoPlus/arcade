<?php

namespace EldoMagan\BagistoArcade\Sections;

use Webkul\Category\Repositories\CategoryRepository;

class Header extends BladeSection
{
    protected static string $view = 'shop::sections.header';

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
}
