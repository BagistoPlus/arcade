<template>
  <div class="h-screen flex flex-col bg-gray-100">
    <Header
      :theme-name="themeName"
      :active-view-mode="activeViewMode"
      class="flex-none"
      @exit="onExit"
      @view-mode="onViewModeChanged"
    />
    <div id="nprogress-container" class="flex-none" />
    <div class="flex-1 flex overflow-hidden mt-px">
      <div
        v-if="activeViewMode !== 'fullscreen'"
        class="w-80 flex-none shadow bg-white h-full"
      >
        <router-view />
      </div>

      <div class="flex-1 h-full flex justify-center items-center p-4">
        <iframe
          ref="iframe"
          frameborder="0"
          class="transition-all shadow bg-white"
          :style="iframeStyle"
          :src="url"
        />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {
  computed,
  defineComponent,
  onMounted,
  ref,
} from "@vue/composition-api";
import { useStore } from "./store";
import NProgress from "nprogress";

import Header from "./components/Header.vue";
import { ViewMode } from "./types";

export default defineComponent({
  components: {
    Header,
  },

  setup() {
    const store = useStore();
    const url = store.theme.storefrontUrl;
    const iframe = ref<HTMLIFrameElement | null>(null);
    const iframeStyle = computed(() => {
      if (store.activeViewMode !== "mobile") {
        return "width: 100%; height: 100%";
      }

      return "width: 375px; height: 100%";
    });

    const messageHandlers: Record<string, Function> = {
      init(data: any) {
        store.setThemeData(data.themeData);
        store.setAvailableSections(data.availableSections);
        NProgress.done();
      },

      activateSection: store.activateSection,
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

    return {
      url,
      iframe,
      iframeStyle,
      themeName: store.theme.name,
      activeViewMode: computed(() => store.activeViewMode),

      onExit,
      onViewModeChanged,
    };
  },
});
</script>
