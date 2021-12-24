<template>
  <div
    :id="id"
    :data-section-id="id"
    class="flex items-center px-3 py-2 rounded cursor-pointer border border-gray-400 hover:border-primary hover:bg-gray-50"
  >
    <button class="-ml-3 -my-2 mr-1 py-2 cursor-move rounded hover:bg-gray-200">
      <mdicon name="drag-vertical" />
    </button>

    {{ name }}
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

    name: {
      type: String,
      required: true,
    },
  },

  setup(props) {},
});
</script>
