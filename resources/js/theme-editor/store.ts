import { defineStore } from "pinia";

export const useStore = defineStore("main", {
  state: () => ({
    theme: {
      code: Arcade.theme.code,
      name: Arcade.theme.name,
    },
    themesIndex: Arcade.themesIndex,
    activeViewMode: "desktop",
  }),

  actions: {
    setViewMode(mode: string) {
      this.activeViewMode = mode;
    },
  },
});
