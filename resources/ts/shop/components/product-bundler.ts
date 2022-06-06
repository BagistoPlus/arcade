import { AlpineComponent } from "alpinejs";
interface ProductBundler {
  config: any;
  options: any[];
  selectedProducts: Record<string, any>;
  get formatedTotalPrice(): string | number;
}

interface ProductBundlerOptions {
  config: any;
}

export default function (options: ProductBundlerOptions): AlpineComponent<ProductBundler> {
  return {
    config: options.config,
    options: [],
    selectedProducts: [],

    get formatedTotalPrice() {
      let total = 0;

      for (const option of this.options) {
        for (const product of option.products) {
          if (product.is_default) {
            total += product.qty * product.price.final_price.price;
          }
        }
      }

      return total;
    },

    init() {
      this.options = this.config.options.slice();
      this.options.forEach((option) => {
        const defaultProduct = option.products.find((product: any) => product.is_default);

        if (["checkbox", "multiselect"].includes(option.type)) {
          this.selectedProducts[option.id] = [defaultProduct.id];
        } else {
          this.selectedProducts[option.id] = defaultProduct.id;
        }
      });

      this.$watch("selectedProducts", (selectedProducts) => {
        this.options.forEach((option) => {
          const selectedProductIds = Array.isArray(selectedProducts[option.id])
            ? selectedProducts[option.id]
            : [selectedProducts[option.id]];

          option.products.forEach((product: any) => {
            product.is_default = selectedProductIds.includes(product.id);
          });
        });
      });
    },
  };
}
