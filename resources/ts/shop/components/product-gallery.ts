import { AlpineComponent } from "alpinejs";

interface Image {
  original_image_url: string;
  small_image_url: string;
  medium_image_url: string;
  large_image_url: string;
}

interface ProductGallery {
  activeImage: number;
  images: Image[];
  defaultImages: Image[];
}

export default function (options: any): AlpineComponent<ProductGallery> {
  return {
    images: options.images,
    defaultImages: options.images,
    activeImage: 0,

    init() {
      window.addEventListener("product-variant-change", ((event: CustomEvent) => {
        console.log(event.detail.variant && event.detail.variant.id, event.detail.variantImages);
        if (event.detail.variantImages) {
          this.images = event.detail.variantImages;
        } else {
          this.images = this.defaultImages;
        }
      }) as EventListener);
    },
  };
}
