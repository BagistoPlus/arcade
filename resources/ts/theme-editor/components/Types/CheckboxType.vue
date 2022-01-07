<template>
  <label>
    <input v-model="model" v-bind="attrs" type="checkbox" />
    <span v-if="label" class="ml-2">{{ label }}</span>
  </label>
</template>

<script lang="ts">
import { defineComponent, ref, watch } from "@vue/composition-api";

export default defineComponent({
  inheritAttrs: false,

  props: {
    value: {
      type: [Boolean, Array],
      required: false,
    },

    label: {
      type: String,
      required: false,
    },
  },

  setup(props, { emit, attrs }) {
    const model = ref(attrs.checked || props.value);

    watch(
      () => props.value,
      (newValue) => {
        model.value = newValue;
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
      attrs,
      model,
    };
  },
});
</script>
