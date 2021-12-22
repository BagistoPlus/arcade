<template>
  <div
    :id="id"
    :data-section-id="id"
    class="flex items-center px-3 py-2 rounded cursor-pointer border"
    :class="{
      'border-gray-400': !active,
      'border-primary bg-gray-50': active,
    }"
    @mouseenter="$emit('activate')"
    @mouseleave="$emit('deactivate')"
  >
    <button
      v-if="!fixed"
      class="-ml-3 -my-2 mr-1 py-2 cursor-move rounded hover:bg-gray-200"
    >
      <mdicon name="drag-vertical" />
    </button>
    {{ section.label }}
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/composition-api";
import { Section } from "../types";

export default defineComponent({
  props: {
    id: {
      type: String,
      required: true,
    },

    section: {
      type: Object as () => Section,
      required: true,
    },

    fixed: {
      type: Boolean,
      default: false,
    },

    active: {
      type: Boolean,
      default: false,
    },
  },

  setup() {},
});
</script>
