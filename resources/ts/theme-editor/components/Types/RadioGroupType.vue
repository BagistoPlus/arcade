<template>
  <div>
    <label v-if="label" class="block mb-1 text-sm font-medium">
      {{ label }}
    </label>
    <label
      v-for="option in options"
      :key="option.value"
      class="flex items-center"
    >
      <input v-model="model" type="radio" :name="name" :value="option.value" />
      <span class="ml-2">{{ option.label }}</span>
    </label>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, watch } from "@vue/composition-api";

export default defineComponent({
  props: {
    value: {
      type: String,
      default: null,
    },

    name: {
      type: String,
      required: true,
    },

    label: {
      type: String,
      required: false,
    },

    options: {
      type: Array as () => Array<{ value: string; label: string }>,
      default: [],
    },
  },

  setup(props, { emit }) {
    const model = ref(props.value);

    watch(
      () => props.value,
      (newValue) => {
        if (newValue !== model.value) {
          model.value = newValue;
        }
      },
      { immediate: true }
    );

    watch(
      () => model.value,
      (newValue) => {
        emit("input", newValue);
      }
    );

    return {
      model,
    };
  },
});
</script>
