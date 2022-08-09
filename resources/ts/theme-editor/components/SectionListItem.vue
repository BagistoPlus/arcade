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
    <button v-if="!fixed" class="-ml-3 -my-2 mr-1 py-2 cursor-move rounded hover:bg-gray-200">
      <mdicon name="drag-vertical" />
    </button>
    <div class="flex-1">
      {{ label }}
    </div>
    <button
      v-if="!fixed"
      class="-mr-1 py-1 px-1 rounded text-gray-600 hover:bg-gray-200"
      :title="disabled ? 'Enable' : 'Disable'"
      @click.stop="$emit('toggle')"
    >
      <mdicon :name="disabled ? 'eye-outline' : 'eye-off-outline'" width="20" height="20" />
    </button>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/composition-api";

export default defineComponent({
  props: {
    id: {
      type: String,
      required: true,
    },

    label: {
      type: String,
      required: true,
    },

    fixed: {
      type: Boolean,
      default: false,
    },

    /** is this is the current section focused ? */
    active: {
      type: Boolean,
      default: false,
    },

    disabled: {
      type: Boolean,
      default: false,
    },
  },

  setup() {},
});
</script>
