import setValue from "lodash/set";
import getValue from "lodash/get";
import debounce from "lodash/debounce";
import NProgress from "nprogress";

import { Section } from "./types.d";
import { defineStore } from "pinia";
import { ThemeData } from "./types";

interface State {
  theme: { code: string; name: string; storefrontUrl: string };
  themesIndex: string;
  activeViewMode: "desktop" | "mobile" | "fullscreen";
  themeData: ThemeData | null;
  activeSectionId: string | null;
  availableSections: Record<string, Section>;
}

let previewIframe: HTMLIFrameElement | null = null;

function notifyPreviewIframe(type: string, data?: any) {
  previewIframe?.contentWindow?.postMessage({ type, data }, window.origin);
}

function refreshPreviewer(html: string) {
  notifyPreviewIframe("refresh", html);
}

const persistThemeData = debounce((themeCode, themeData) => {
  const headers = new Headers();
  headers.append("Content-Type", "application/json");
  headers.append(
    "X-CSRF-Token",
    (document.querySelector('meta[name="csrf-token"]') as Element).getAttribute(
      "content"
    ) as string
  );

  NProgress.start();

  fetch(`/admin/arcade/themes/editor/${themeCode}/persist`, {
    headers,
    method: "POST",
    body: JSON.stringify(themeData),
  })
    .then((res) => res.text())
    .then((html) => {
      refreshPreviewer(html);
      NProgress.done();
    })
    .catch((e) => {
      NProgress.done();
    });
}, 500);

export const useStore = defineStore("main", {
  state: (): State => ({
    theme: {
      code: Arcade.theme.code,
      name: Arcade.theme.name,
      storefrontUrl: Arcade.theme.storefrontUrl,
    },
    themesIndex: Arcade.themesIndex,
    activeViewMode: "desktop",
    themeData: null,
    activeSectionId: null,
    availableSections: {},
  }),

  getters: {
    sectionByType: (state: State) => (type: string) => {
      return state.availableSections[type];
    },

    themeDataValue: (state: State) => (path: string) => {
      return getValue(state.themeData, path);
    },

    beforeContentSections: (state) => {
      return state.themeData?.beforeContentSectionsOrder.map((slug) => {
        return state.themeData?.sections[slug];
      });
    },

    afterContentSections: (state) => {
      return state.themeData?.afterContentSectionsOrder.map((slug) => {
        return state.themeData?.sections[slug];
      });
    },

    contentSections: (state) => {
      return state.themeData?.sectionsOrder.map((slug) => {
        return state.themeData?.sections[slug];
      });
    },
  },

  actions: {
    setPreviewIframe(iframe: HTMLIFrameElement) {
      previewIframe = iframe;
    },

    setViewMode(mode: "desktop" | "mobile" | "fullscreen") {
      this.activeViewMode = mode;
    },

    setThemeData(themeData: any) {
      this.themeData = themeData;
    },

    activateSection(sectionId: string, notify = false) {
      this.activeSectionId = sectionId;
      if (notify) {
        notifyPreviewIframe("activateSection", sectionId);
      }
    },

    deactivateSection(notify = false) {
      this.activeSectionId = null;
      if (notify) {
        notifyPreviewIframe("clearActiveSection");
      }
    },

    setAvailableSections(availableSections: any) {
      this.availableSections = availableSections;
    },

    persistThemeData() {
      persistThemeData(this.theme.code, this.themeData);
    },

    updateThemeDataValue(path: string, value: any) {
      setValue(this.themeData as object, path, value);
      this.persistThemeData();
    },
  },
});
