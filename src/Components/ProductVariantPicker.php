<?php

namespace EldoMagan\BagistoArcade\Components;

use Illuminate\View\Component;
use Webkul\Product\Helpers\ConfigurableOption;

class ProductVariantPicker extends Component
{
    public $product;

    public $defaultVariant;

    public $productOptions;

    protected $variantHelper;

    protected $livewire;

    public function __construct($product, $livewire)
    {
        $this->product = $product;
        $this->livewire = $livewire;
        $this->variantHelper = resolve(ConfigurableOption::class);

        $this->defaultVariant = $product->getTypeInstance()->getDefaultVariant();
        $this->productOptions = $this->variantHelper->getConfigurationConfig($product);

        $this->livewire->setData('selected_configurable_option', null);
        $this->livewire->setData('super_attribute', []);
    }

    public function isAttributeDropdown($attribute)
    {
        return ! isset($attribute['swatch_type'])
            || $attribute['swatch_type'] === ''
            || $attribute['swatch_type'] === 'dropdown';
    }

    public function render()
    {
        return view('shop::components.product-variant-picker');
    }
}
