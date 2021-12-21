<template>
  <div class="h-screen flex flex-col bg-gray-100">
    <Header
      :theme-name="themeName"
      :active-view-mode="activeViewMode"
      class="flex-none"
      @exit="onExit"
      @view-mode="onViewModeChanged"
    />

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
import { computed, defineComponent } from "@vue/composition-api";
import { useStore } from "./store";
import Header from "./components/Header.vue";

export default defineComponent({
  components: {
    Header,
  },

  setup() {
    const store = useStore();
    const url = window.origin + "?designMode";

    const iframeStyle = computed(() => {
      if (store.activeViewMode !== "mobile") {
        return "width: 100%; height: 100%";
      }

      return "width: 375px; height: 100%";
    });

    function onExit() {
      window.location.href = store.themesIndex;
    }

    function onViewModeChanged(mode: string) {
      store.setViewMode(mode);
    }

    return {
      url,
      iframeStyle,
      themeName: store.theme.name,
      activeViewMode: computed(() => store.activeViewMode),

      onExit,
      onViewModeChanged,
    };
  },
});
</script>
