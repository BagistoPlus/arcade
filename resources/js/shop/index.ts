import Alpine from "alpinejs";
import Dropdown from "./components/dropdown";
import Carousel from "./components/carousel";

declare global {
  interface Window {
    Alpine: typeof Alpine;
  }
}

window.Alpine = Alpine;

Alpine.data("ArcadeDropdown", Dropdown);
Alpine.data("ArcadeCarousel", Carousel);

Alpine.start();
