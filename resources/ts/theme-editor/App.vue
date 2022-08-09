<template>
  <div class="h-screen flex flex-col bg-gray-100">
    <Header
      :theme-name="themeName"
      :active-view-mode="activeViewMode"
      :can-publish-theme="canPublishTheme"
      :has-undo="hasUndo"
      :has-redo="hasRedo"
      :templates="templates"
      :current-template="currentTemplate"
      class="flex-none"
      @exit="onExit"
      @view-mode="onViewModeChanged"
      @publish="onPublishTheme"
      @undo="onUndoClick"
      @redo="onRedoClick"
      @changeTemplate="onChangeTemplate"
    />

    <div class="flex-1 flex overflow-hidden mt-px">
      <div
        v-if="activeViewMode !== 'fullscreen'"
        class="relative w-80 flex-none shadow bg-white h-full"
      >
        <router-view @add-section="sectionModalActive = true" />
        <div
          v-if="activePicker"
          class="absolute overflow-y-hidden top-0 left-0 h-full w-full border bg-white"
        >
          <image-picker v-if="activePicker === 'image'" />
          <category-picker v-if="activePicker === 'category'" />
          <product-picker v-if="activePicker === 'product'" />
        </div>
      </div>

      <div class="flex-1 h-full flex justify-center items-center p-4">
        <iframe
          ref="iframe"
          frameborder="0"
          class="transition-all shadow bg-white"
          :style="iframeStyle"
          :src="url"
        ></iframe>
      </div>
    </div>

    <add-section-modal
      :active.sync="sectionModalActive"
      :sections="sections"
      @click-section="onAddSection"
    />
  </div>
</template>

<script lang="ts">
import { computed, defineComponent, onMounted, ref } from "@vue/composition-api";
import { useStore } from "./store";
import NProgress from "nprogress";

import Header from "./components/Header.vue";
import AddSectionModal from "./components/AddSectionModal.vue";
import ImagePicker from "./views/ImagePicker.vue";
import CategoryPicker from "./views/CategoryPicker.vue";
import ProductPicker from "./views/ProductPicker.vue";

import { Section, ViewMode } from "./types";
import { useRouter } from "vue2-helpers/vue-router";
import { useLang } from "./lang";

export default defineComponent({
  components: {
    Header,
    AddSectionModal,

    ImagePicker,
    CategoryPicker,
    ProductPicker,
  },

  setup() {
    const store = useStore();
    const router = useRouter();
    const { t } = useLang();

    const url = store.theme.storefrontUrl;
    const iframe = ref<HTMLIFrameElement | null>(null);
    const sectionModalActive = ref(false);
    const iframeStyle = computed(() => {
      if (store.activeViewMode !== "mobile") {
        return "width: 100%; height: 100%";
      }

      return "width: 375px; height: 100%";
    });

    const messageHandlers: Record<string, Function> = {
      init(data: any) {
        store.setThemeData(data.themeData);
        store.setThemeSettings(data.themeSettings);
        store.setAvailableSections(data.availableSections);
        store.setTemplates(data.templates);
        store.setModels(data.models);
        NProgress.done();

        if (router.currentRoute.name !== "sections") {
          router.replace({ name: "sections" });
        }
      },

      editSection(sectionId: string) {
        if (router.currentRoute.name === "sections") {
          router.push({ name: "edit_section", params: { sectionId } });
        } else {
          router.replace({ name: "edit_section", params: { sectionId } });
        }
      },

      activateSection: store.activateSection,
      toggleSection: store.toggleSection,
      moveSectionUp: store.moveSectionUp,
      moveSectionDown: store.moveSectionDown,
      removeSection: store.removeSection,
    };

    window.addEventListener("message", (event) => {
      const { data } = event;

      if (data.type && messageHandlers[data.type]) {
        messageHandlers[data.type](data.data);
      }
    });

    onMounted(() => {
      store.setPreviewIframe(iframe.value as HTMLIFrameElement);
      NProgress.start();
    });

    function onExit() {
      window.location.href = store.themesIndex;
    }

    function onViewModeChanged(mode: ViewMode) {
      store.setViewMode(mode);
    }

    function onPublishTheme() {
      store.publishTheme();
    }

    function onAddSection(section: Section) {
      store.addNewSection(section);
      sectionModalActive.value = false;
    }

    function onUndoClick() {
      store.undo();
    }

    function onRedoClick() {
      store.redo();
    }

    function onChangeTemplate(url: string) {
      iframe.value!.src = url;
      NProgress.start();
    }

    return {
      t,
      url,
      iframe,
      iframeStyle,
      sectionModalActive,
      themeName: store.theme.name,
      activeViewMode: computed(() => store.activeViewMode),
      canPublishTheme: computed(() => store.canPublishTheme),
      hasUndo: computed(() => store.hasUndo),
      hasRedo: computed(() => store.hasRedo),
      sections: computed(() => Object.values(store.availableSections)),
      templates: computed(() => store.templates),
      currentTemplate: computed(() => store.themeData?.template),
      activePicker: computed(() => store.activePicker),

      onExit,
      onAddSection,
      onViewModeChanged,
      onPublishTheme,
      onUndoClick,
      onRedoClick,
      onChangeTemplate,
    };
  },
});
</script>
