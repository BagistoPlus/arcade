import Alpine from "alpinejs";

import collapse from "@alpinejs/collapse";
import Dropdown from "./components/dropdown";
import RangeInput from "./components/range-input";

import ProductVariantPicker from "./components/product-variant-picker";
import ProductBuyButtons from "./components/product-buy-buttons";
import ProductGallery from "./components/product-gallery";

declare global {
  interface Window {
    Alpine: typeof Alpine;
  }
}

window.Alpine = Alpine;

Alpine.plugin(collapse);

Alpine.data("ArcadeDropdown", Dropdown);
Alpine.data("ArcadeRangeInput", RangeInput);
Alpine.data("ArcadeProductVariantPicker", ProductVariantPicker);
Alpine.data("ArcadeProductBuyButtons", ProductBuyButtons);
Alpine.data("ArcadeProductGallery", ProductGallery);

Alpine.start();
