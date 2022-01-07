import { AlpineComponent } from "alpinejs";

export interface Dropdown {
  opened: boolean;
  open(): void;
  close(): void;
  toggle(): void;
}

export default function (options: any): AlpineComponent<Dropdown> {
  return {
    opened: false,

    open() {
      this.opened = true;
    },

    close() {
      this.opened = false;
    },

    toggle() {
      this.opened = !this.opened;
    },
  };
}
