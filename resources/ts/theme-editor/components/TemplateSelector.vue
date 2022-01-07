<template>
  <popover
    offset="14"
    content-class="w-80 max-h-[300px] rounded-md shadow-lg ring-1 ring-black ring-opacity-5 bg-white"
  >
    <template #trigger="{ on, opened }">
      <button
        v-on="on"
        class="relative w-80 rounded-md h-10 px-3 py-2 text-left border"
      >
        {{ activeTemplate && activeTemplate.label }}
        <mdicon
          :name="opened ? 'chevron-up' : 'chevron-down'"
          width="20"
          height="20"
          class="absolute right-2 top-2"
        />
      </button>
    </template>
    <template v-slot="{ close }">
      <ul>
        <li v-for="template in templates" :key="template.template">
          <a
            href="#"
            class="flex w-full rounded-md text-gray-700 px-4 py-2 text-base hover:bg-gray-100 hover:text-gray-900"
            @click.prevent="
              close();
              $emit('changeTemplate', template.url);
            "
          >
            <mdicon :name="template.icon || 'web'" class="inline mr-2" />
            {{ template.label }}
          </a>
        </li>
      </ul>
    </template>
  </popover>
</template>

<script lang="ts">
import { computed, defineComponent } from "@vue/composition-api";
import { Template } from "../types";
import Popover from "./Popover.vue";

export default defineComponent({
  components: { Popover },
  props: {
    templates: {
      type: Array as () => Template[],
      default: () => [],
    },

    currentTemplate: {
      type: String,
      required: true,
    },
  },

  setup(props) {
    const activeTemplate = computed(() =>
      props.templates.find((t) => t.template === props.currentTemplate)
    );

    return {
      activeTemplate,
    };
  },
});
</script>
