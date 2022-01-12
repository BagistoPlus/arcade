import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";
import Dropdown from "./components/dropdown";

declare global {
  interface Window {
    Alpine: typeof Alpine;
  }
}

window.Alpine = Alpine;

Alpine.plugin(collapse);
Alpine.data("ArcadeDropdown", Dropdown);

Alpine.start();
