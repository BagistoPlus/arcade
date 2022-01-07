import Alpine from "alpinejs";
import Dropdown from "./components/dropdown";

declare global {
  interface Window {
    Alpine: typeof Alpine;
  }
}

window.Alpine = Alpine;

Alpine.data("ArcadeDropdown", Dropdown);

Alpine.start();
