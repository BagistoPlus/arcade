<template>
  <div class="h-16 flex items-center shadow bg-white">
    <div class="w-80 h-full items-center flex-none flex">
      <button
        class="hover:bg-gray-100 px-6 focus:outline-none h-full"
        @click="$emit('exit')"
      >
        <mdicon name="exit-to-app" class="transform rotate-180 block" />
      </button>

      <div class="flex-1 px-4 border-l border-r">
        <h1 class="font-medium">Theme Editor</h1>
        <h2 class="text-gray-700">{{ themeName }}</h2>
      </div>
    </div>

    <div class="flex flex-1 items-center">
      <div class="flex-1 justify-start pl-4">Page Selector</div>
      <div class="flex-none flex space-x-4">
        <button
          v-for="{ mode, icon, text } in viewModes"
          :key="mode"
          class="h-16 flex items-center justify-center flex-col text-xs text-center border-b-2 border-transparent hover:border-primary"
          :class="{ 'border-primary': activeViewMode === mode }"
          @click="$emit('view-mode', mode)"
        >
          <mdicon :name="icon" />
          {{ text }}
        </button>
      </div>

      <div class="flex-1 items-center justify-end flex px-4">
        <div
          class="border-l border-r h-16 flex items-center mx-4 px-4 space-x-2"
        >
          <button
            title="Undo"
            class="p-2 rounded hover:bg-gray-100"
            :class="{ 'pointer-events-none text-gray-300': !hasUndo }"
            :disabled="!hasUndo"
            @click="$emit('undo')"
          >
            <mdicon name="undo" />
          </button>
          <button
            title="Redo"
            class="p-2 rounded hover:bg-gray-100"
            :class="{ 'pointer-events-none text-gray-300': !hasRedo }"
            :disabled="!hasRedo"
            @click="$emit('redo')"
          >
            <mdicon name="redo" />
          </button>
        </div>
        <button
          class="px-4 py-2 rounded cursor-pointer hover:bg-opacity-90"
          :class="
            canPublishTheme
              ? 'bg-primary text-white'
              : 'bg-gray-200 text-gray-700 cursor-not-allowed'
          "
          @click="$emit('publish')"
        >
          Publish
        </button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/composition-api";

export default defineComponent({
  props: {
    themeName: {
      type: String,
      required: true,
    },

    activeViewMode: {
      type: String,
      default: "desktop",
    },

    hasUndo: {
      type: Boolean,
      default: false,
    },

    hasRedo: {
      type: Boolean,
      default: false,
    },

    canPublishTheme: {
      type: Boolean,
      default: false,
    },
  },

  setup() {
    const viewModes = [
      { mode: "desktop", icon: "desktop-mac", text: "Desktop" },
      { mode: "mobile", icon: "cellphone", text: "Mobile" },
      { mode: "fullscreen", icon: "arrow-expand", text: "Fullscreen" },
    ];

    return { viewModes };
  },
});
</script>
