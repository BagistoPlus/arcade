import { AlpineComponent } from "alpinejs";

interface ProductAttribute {
  id: number;
  code: string;
  label: string;
  swatch_type: string;
  options: ProductAttributeValue[];
}

interface ProductAttributeValue {
  id: number;
  label: string;
  products: number[];
}

interface Price {
  price: number;
  formated_price: string;
}

interface Options {
  attributes: ProductAttribute[];
  index: {
    [key: number]: { [key: number]: number };
  };
  variant_prices: {
    [key: number]: { regular_price: Price; final_price: Price };
  };
  variant_images: { [key: number]: any };
  [key: string]: any;
}

interface Product {
  id: number;
  variants: Array<{ id: number }>;
}

export interface ProductVariantPicker {
  product: Product;
  options: Options;
  attributeValues: { [key: number]: string };
  selectedVariant: any;
  availableVariantIds: number[];
  getAttribute(attributeId: number): ProductAttribute | undefined;
  attributePosition(attribute: ProductAttribute): number;
  isAttributeOptionAvailable(attributeId: number, optionId: number): boolean;
  onOptionSelected(attributeId: number, value: string): Promise<void>;
  findMatchingVariant(): any;
}

export default function (options: any): AlpineComponent<ProductVariantPicker> {
  return {
    product: options.product,
    options: options.options,
    attributeValues: {},
    selectedVariant: null,
    availableVariantIds: [],

    init() {
      this.options.attributes.forEach((attribute) => {
        this.attributeValues[attribute.id] = "";
      });
    },

    getAttribute(attributeId: number) {
      return this.options.attributes.find((attribute) => attribute.id === attributeId);
    },

    attributePosition(attribute: ProductAttribute) {
      return this.options.attributes.findIndex((attr) => attr.id === attribute.id);
    },

    isAttributeOptionAvailable(attributeId, optionId) {
      const attribute = this.getAttribute(attributeId) as ProductAttribute;

      if (this.attributePosition(attribute) === 0) {
        return true;
      }

      const option = attribute.options.find((opt) => opt.id === optionId) as ProductAttributeValue;

      return this.availableVariantIds.some((id) => option.products.includes(id));
    },

    async onOptionSelected(attributeId: number, value: string) {
      const attribute = this.getAttribute(attributeId) as ProductAttribute;
      const selectedOption = attribute.options.find((opt) => opt.id === Number(value)) as ProductAttributeValue;

      if (this.attributePosition(attribute) === 0) {
        this.availableVariantIds = selectedOption.products;
      }

      // unset invalid previous selected options
      this.options.attributes.forEach((attr) => {
        const activeOption = attr.options.find((opt) => String(opt.id) === this.attributeValues[attr.id]);

        if (!activeOption || !this.isAttributeOptionAvailable(attr.id, activeOption.id)) {
          this.attributeValues[attr.id] = "";
        }
      });

      this.selectedVariant = this.findMatchingVariant();
      (this as any).$wire.set(`data.super_attribute.${attribute.id}`, Number(value), true);

      if (this.selectedVariant) {
        (this as any).$wire.set("data.selected_configurable_option", Number(this.selectedVariant.id), true);
      }

      window.dispatchEvent(
        new CustomEvent("product-variant-change", {
          detail: {
            variant: this.selectedVariant,
            ...(this.selectedVariant && {
              variantImages: this.options.variant_images[this.selectedVariant.id],
              variantPrice: this.options.variant_prices[this.selectedVariant.id],
            }),
          },
        })
      );
    },

    findMatchingVariant() {
      if (Object.values(this.attributeValues).some((value) => !value)) {
        return null;
      }

      for (const variantId in this.options.index) {
        const attributeValues = this.options.index[variantId];
        const variantMatch = Object.keys(this.attributeValues)
          .map((key) => Number(key))
          .every((attrId) => attributeValues[attrId] == Number(this.attributeValues[attrId]));

        if (variantMatch) {
          return this.product.variants.find((variant) => variant.id === Number(variantId));
        }
      }
    },
  };
}
