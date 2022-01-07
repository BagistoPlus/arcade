<template>
  <div class="block">
    <label class="block">
      <span
        v-if="label"
        class="block mb-1 text-sm font-medium"
        :class="labelClass"
      >
        {{ label }}
      </span>

      <div class="relative">
        <slot name="prepend">
          <div
            v-if="leftIcon"
            class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 pointer-events-none"
          >
            <mdicon :name="leftIcon" />
          </div>
        </slot>

        <input
          v-model="model"
          :type="type"
          class="w-full"
          :class="[
            'text-base rounded border-gray-400',
            inputClass,
            {
              'pl-10': leftIcon,
              'pr-10': rightIcon,
            },
          ]"
          :placeholder="placeholder"
        />

        <slot name="append">
          <div
            v-if="rightIcon"
            class="absolute inset-y-0 right-0 z-10 flex items-center pr-3 text-gray-500"
            :class="{ 'pointer-events-none': rightIcon }"
          >
            <mdicon v-if="rightIcon" :name="rightIcon" />
          </div>
        </slot>
      </div>
    </label>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, watch } from "@vue/composition-api";

export default defineComponent({
  name: "TextType",

  props: {
    value: {
      type: [String, Number],
      required: false,
    },

    name: {
      type: String,
      required: true,
    },

    label: {
      type: String,
      required: false,
    },

    placeholder: {
      type: String,
      required: false,
    },

    labelClass: {
      type: String,
      default: "",
    },

    type: {
      type: String,
      default: "text",
    },

    leftIcon: {
      type: String,
      required: false,
    },

    rightIcon: {
      type: String,
      required: false,
    },

    inputClass: {
      type: String,
      default: "",
    },
  },

  emits: ["update:modelValue"],

  setup(props, { emit }) {
    const model = ref(props.value);

    watch(
      () => props.value,
      (value) => {
        if (value !== model.value) {
          model.value = value;
        }
      }
    );

    watch(
      () => model.value,
      (value) => {
        emit("input", value);
      }
    );

    return {
      model,
    };
  },
});
</script>
