import { AlpineComponent } from "alpinejs";

interface ProductBuyButtons {
  disableButtons: boolean;
}

interface ProductBuyButtonsOptions {
  productHasVariants: boolean;
}

export default function (options: ProductBuyButtonsOptions): AlpineComponent<ProductBuyButtons> {
  return {
    disableButtons: options.productHasVariants,

    init() {
      window.addEventListener("product-variant-change", ((event: CustomEvent) => {
        this.disableButtons = !event.detail.variant;
      }) as EventListener);
    },
  };
}
