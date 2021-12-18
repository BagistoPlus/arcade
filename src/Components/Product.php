<?php

namespace EldoMagan\BagistoArcade\Components;

use Illuminate\View\Component;
use Webkul\Product\Contracts\Product as ProductModel;

class Product extends Component
{
    /**
     * @var ProductModel
     */
    public $product;

    /**
     * @var string
     */
    public $layout;

    public $previewImageUrl;

    public $url;

    public function __construct(ProductModel $product, $layout = 'vertical')
    {
        $this->product = $product;
        $this->layout = $layout;

        $this->url = $this->getUrl();
        $this->previewImageUrl = $this->getPreviewImageUrl();
    }

    public function getPreviewImageUrl()
    {
        return productimage()->getProductBaseImage($this->product)['medium_image_url'];
    }

    public function getUrl()
    {
        return route('shop.productOrCategory.index', $this->product->url_key);
    }

    public function render()
    {
        return view('shop::components.product');
    }
}
