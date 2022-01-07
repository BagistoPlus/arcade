import { Template } from "./types";
import { ref } from "@vue/composition-api";
import setValue from "lodash/set";
import getValue from "lodash/get";
import debounce from "lodash/debounce";
import NProgress from "nprogress";
import { v4 as uuidv4 } from "uuid";
import { History } from "stateshot";
import { defineStore } from "pinia";
import { ThemeData, Setting, Section, Block } from "./types";

interface State {
  theme: { code: string; name: string; storefrontUrl: string };
  themesIndex: string;
  activeViewMode: "desktop" | "mobile" | "fullscreen";
  themeData: ThemeData | null;
  activeSectionId: string | null;
  availableSections: Record<string, Section>;
  canPublishTheme: boolean;
  templates: Template[];
  imagePickerActive: boolean;
  imagePickerValuePath: string;
  imagePickerDefaultValue: any;
}

let previewIframe: HTMLIFrameElement | null = null;

function notifyPreviewIframe(type: string, data?: any) {
  previewIframe?.contentWindow?.postMessage({ type, data }, window.origin);
}

function refreshPreviewer(html: string) {
  notifyPreviewIframe("refresh", html);
}

const persistThemeData = debounce(
  (themeCode, themeData, skipHistory = false) => {
    const headers = new Headers();
    headers.append("Content-Type", "application/json");
    headers.append(
      "X-CSRF-Token",
      (
        document.querySelector('meta[name="csrf-token"]') as Element
      ).getAttribute("content") as string
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
        if (!skipHistory) {
          themeDataStack.value.pushSync(JSON.parse(JSON.stringify(themeData)));
        }
      })
      .catch((e) => {
        NProgress.done();
      });
  },
  500
);

const themeDataStack = ref(new History());

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
    templates: [],
    imagePickerActive: false,
    imagePickerValuePath: "",
    imagePickerDefaultValue: null,
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

    hasUndo: (state) => {
      return state.themeData && themeDataStack.value.hasUndo;
    },

    hasRedo: (state) => {
      return state.themeData && themeDataStack.value.hasRedo;
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
      themeDataStack.value.pushSync(JSON.parse(JSON.stringify(themeData)));
    },

    setTemplates(templates: Template[]) {
      this.templates = templates;
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

    openImagePicker(valuePath: string) {
      this.imagePickerActive = true;
      this.imagePickerValuePath = valuePath;
      this.imagePickerDefaultValue = this.themeDataValue(valuePath);
    },

    closeImagePicker() {
      this.imagePickerActive = false;
      this.imagePickerValuePath = "";
    },

    persistThemeData(skipHistory = false) {
      persistThemeData(this.theme.code, this.themeData, skipHistory);
      this.canPublishTheme = true;
    },

    updateThemeDataValue(path: string, value: any) {
      setValue(this.themeData as object, path, value);
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
        disabled: false,
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

    toggleSection(sectionId: string) {
      this.themeData!.sections[sectionId].disabled =
        !this.themeData!.sections[sectionId].disabled;

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

    toggleSectionBlock(sectionId: string, blockId: string) {
      const currentState = this.themeDataValue(
        `sections.${sectionId}.blocks.${blockId}.disabled`
      );

      this.updateThemeDataValue(
        `sections.${sectionId}.blocks.${blockId}.disabled`,
        !currentState
      );

      this.persistThemeData();
    },

    undo() {
      this.themeData = themeDataStack.value.undo().get();
      this.persistThemeData(true); // true to skip history
    },

    redo() {
      this.themeData = themeDataStack.value.redo().get();
      this.persistThemeData(true); // true to skip history
    },

    addSectionBlock(sectionId: string, block: Block) {
      const section = this.themeData!.sections[sectionId];
      const settings: Record<string, unknown> = {};
      const id = uuidv4();

      block.settings.forEach((setting: Setting) => {
        settings[setting.id] = setting.default;
      });

      section.blocks[id] = {
        id,
        type: block.type,
        disabled: false,
        settings,
      };
      section.blocks_order.push(id);

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
          themeDataStack.value.reset();
          themeDataStack.value.pushSync(
            JSON.parse(JSON.stringify(this.themeData))
          );
        })
        .catch((e) => {
          NProgress.done();
        });
    },
  },
});
