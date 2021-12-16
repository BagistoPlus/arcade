import Glide from "@glidejs/glide";
import { AlpineComponent } from "alpinejs";

export interface Carousel {
  glide: any;
  activeIndex: number;

  goto(index: number): void;
  nextSlide(): void;
  previousSlide(): void;
}

export default function (
  options: Record<string, unknown>
): AlpineComponent<Carousel> {
  return {
    glide: null,
    activeIndex: 0,

    init() {
      const container = this.$el.querySelector(".glide") as HTMLElement;

      if (container.hasAttribute("data-glide-carousel-initialized")) {
        return;
      }

      container.setAttribute("data-glide-carousel-initialized", "");

      this.glide = new Glide(container, {
        ...options,
      }).mount();

      console.log(this.glide.on);
      this.glide.on("run", () => {
        console.log("--> on run");
        this.activeIndex = this.glide.index;
      });
    },

    goto(index) {
      this.glide.go(`=${index}`);
    },

    nextSlide() {
      this.glide.go(">");
    },

    previousSlide(): void {
      this.glide.go("<");
    },
  };
}
