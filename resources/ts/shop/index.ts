import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";
import Dropdown from "./components/dropdown";
import RangeInput from "./components/range-input";

declare global {
  interface Window {
    Alpine: typeof Alpine;
  }
}

window.Alpine = Alpine;

Alpine.plugin(collapse);
Alpine.data("ArcadeDropdown", Dropdown);
Alpine.data("ArcadeRangeInput", RangeInput);

Alpine.start();
