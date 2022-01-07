<template>
  <div ref="sortable" class="space-y-2">
    <block-list-item
      v-for="blockData in blocks"
      :key="blockData.id"
      :id="blockData.id"
      :name="blockName(blockData)"
      :disabled="blockData.disabled"
      @toggle="$emit('toggleBlock', blockData.id)"
      @click.native="$emit('editBlock', blockData.id)"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, ref } from "@vue/composition-api";
import Sortable from "sortablejs/modular/sortable.core.esm.js";
import BlockListItem from "./BlockListItem.vue";

import { BlockData } from "../types";

export default defineComponent({
  components: { BlockListItem },
  props: {
    blocks: {
      type: Array as () => BlockData[],
      default: () => [],
    },

    order: {
      type: Array as () => string[],
      default: () => [],
    },

    getBlockByType: {
      type: Function,
      default: () => () => ({}),
    },
  },

  setup(props, { emit }) {
    const sortable = ref<HTMLElement>();

    function blockName(blockData: BlockData) {
      const block = (props.getBlockByType as Function)(blockData.type);

      return (
        blockData.settings.title || blockData.settings.heading || block.name
      );
    }

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

    return { sortable, blockName };
  },
});
</script>
