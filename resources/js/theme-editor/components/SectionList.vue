<template>
  <div>
    <h3 v-if="title" class="mb-1 text-sm text-gray-600">{{ title }}</h3>

    <div ref="sortable" class="space-y-2">
      <section-list-item
        v-for="sectionData in sections"
        :key="sectionData.id"
        :id="sectionData.id"
        :fixed="fixed"
        :active="activeSectionId === sectionData.id"
        :label="sectionLabel(sectionData)"
        @activate="$emit('activateSection', sectionData.id)"
        @deactivate="$emit('deactivateSection', sectionData.id)"
        @click="onSectionClick(section)"
      />
    </div>

    <button
      v-if="!fixed"
      class="mt-2 py-2 flex w-full justify-center rounded text-white bg-primary hover:bg-opacity-90"
      @click="$emit('add-section')"
    >
      <mdicon name="plus" class="" />
      Ajouter une section
    </button>
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, ref } from "@vue/composition-api";
import { SectionData } from "../types";
import SectionListItem from "./SectionListItem.vue";

import Sortable from "sortablejs/modular/sortable.core.esm.js";

export default defineComponent({
  components: { SectionListItem },

  props: {
    title: {
      type: String,
      required: false,
    },

    fixed: {
      type: Boolean,
      default: false,
    },

    sections: {
      type: Array as () => SectionData[],
      default: () => [],
    },

    order: {
      type: Array as () => string[],
      default: () => [],
    },

    activeSectionId: {
      type: String,
      required: false,
    },

    getSectionByType: {
      type: Function,
      required: true,
    },
  },

  setup(props, { emit }) {
    const sortable = ref<HTMLElement>();

    onMounted(() => {
      new Sortable(sortable.value, {
        onEnd({ newIndex, oldIndex }: { newIndex: number; oldIndex: number }) {
          const order = [...props.order];
          const moved = order.splice(oldIndex, 1)[0];

          order.splice(newIndex, 0, moved);
          emit("reorder", order);
        },
      });
    });

    function sectionLabel(sectionData) {
      const section = (props.getSectionByType as Function)(sectionData.type);
      return sectionData.settings.heading || section.label;
    }

    return {
      sortable,
      sectionLabel,
    };
  },
});
</script>
