import setValue from "lodash/set";
import getValue from "lodash/get";
import debounce from "lodash/debounce";
import NProgress from "nprogress";
import { v4 as uuidv4 } from "uuid";

import { defineStore } from "pinia";
import { ThemeData, Setting, Section } from "./types";

interface State {
  theme: { code: string; name: string; storefrontUrl: string };
  themesIndex: string;
  activeViewMode: "desktop" | "mobile" | "fullscreen";
  themeData: ThemeData | null;
  activeSectionId: string | null;
  availableSections: Record<string, Section>;
  canPublishTheme: boolean;
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
    canPublishTheme: false,
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

    canRemoveSection: (state) => (sectionId: string) => {
      return state.themeData?.sectionsOrder.includes(sectionId);
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
      this.canPublishTheme = true;
      this.persistThemeData();
    },

    addNewSection(section: Section) {
      const settings: Record<string, unknown> = {};
      const id = uuidv4();

      section.settings.forEach((setting: Setting) => {
        settings[setting.id] = setting.default;
      });

      this.themeData!.sections[id] = {
        id,
        settings,
        type: section.slug,
        blocks: {},
        blocks_order: [],
      };

      this.themeData!.sectionsOrder.push(id);

      this.persistThemeData();
    },

    removeSection(sectionId: string) {
      delete this.themeData!.sections[sectionId];
      this.themeData!.sectionsOrder = this.themeData!.sectionsOrder.filter(
        (id) => id !== sectionId
      );

      this.persistThemeData();
    },

    removeSectionBlock(sectionId: string, blockId: string) {
      const section = this.themeData!.sections[sectionId];

      delete section.blocks[blockId];
      section.blocks_order = section.blocks_order.filter(
        (id) => id !== blockId
      );

      this.persistThemeData();
    },

    publishTheme() {
      const headers = new Headers();
      headers.append("Content-Type", "application/json");
      headers.append(
        "X-CSRF-Token",
        (
          document.querySelector('meta[name="csrf-token"]') as Element
        ).getAttribute("content") as string
      );

      NProgress.start();

      fetch(`/admin/arcade/themes/editor/${this.theme.code}/publish`, {
        headers,
        method: "POST",
      })
        .then((res) => {
          this.canPublishTheme = false;
          NProgress.done();
        })
        .catch((e) => {
          NProgress.done();
        });
    },
  },
});
