<template>
  <div>
    <text-type
      v-if="setting.type === 'text'"
      :name="setting.id"
      :label="setting.label"
      :placeholder="setting.placeholder"
      :value="value"
      @input="$emit('input', $event)"
    />

    <text-type
      v-else-if="setting.type === 'number'"
      type="number"
      :name="setting.id"
      :label="setting.label"
      :placeholder="setting.placeholder"
      :value="value"
      @input="$emit('input', $event)"
    />

    <div v-else-if="setting.type === 'textarea'">
      <label v-if="setting.label" class="block font-medium mb-1">{{ setting.label }}</label>
      <textarea
        class="block w-full rounded border-gray-300"
        :rows="setting.rows"
        :value="value"
        @input="$emit('input', $event.target.value)"
      ></textarea>
    </div>

    <checkbox-type
      v-else-if="setting.type === 'checkbox'"
      :name="setting.id"
      :label="setting.label"
      :value="value"
      @input="$emit('input', $event)"
    />

    <radio-group-type
      v-else-if="setting.type === 'radio'"
      :label="setting.label"
      :name="setting.id"
      :options="setting.options"
      :value="value"
      @input="$emit('input', $event)"
    />

    <div v-else-if="setting.type === 'select'">
      <label v-if="setting.label" class="block font-medium mb-1">
        {{ setting.label }}
      </label>
      <select
        :name="setting.id"
        class="block w-full rounded border-gray-300"
        @change="$emit('input', $event.target.value)"
      >
        <option v-if="setting.placeholder">{{ setting.placeholder }}</option>
        <option
          v-for="(label, value) in setting.options"
          :value="value"
          :key="value"
          :selected="value === value"
        >
          {{ label }}
        </option>
      </select>
    </div>

    <image-type
      v-else-if="setting.type === 'image'"
      :label="setting.label"
      :value="value"
      @input="$emit('input', $event)"
      @pickImage="$emit('pickImage')"
    />

    <model-type
      v-else-if="setting.type === 'category'"
      :label="setting.label"
      :value="value"
      model-name="categories"
      button-label="Select category"
      edit-button-label="Update category"
      @input="$emit('input', $event)"
      @select="$emit('selectCategory')"
    />

    <model-type
      v-else-if="setting.type === 'product'"
      :label="setting.label"
      :value="value"
      model-name="products"
      button-label="Select product"
      edit-button-label="Update product"
      @input="$emit('input', $event)"
      @select="$emit('selectProduct')"
    />

    <div v-else-if="setting.type === 'range'">
      <label class="block font-medium mb-1">{{ setting.label }}</label>
      <div class="flex items-center">
        <slider
          class="flex-1 slider-primary"
          :label="setting.label"
          :value="value"
          :model-value="value"
          :min="setting.min"
          :max="setting.max"
          :step="setting.step"
          :show-tooltip="'drag'"
          @input="$emit('input', $event)"
        />
        <span class="flex-none ml-2">{{ value }} {{ setting.unit }}</span>
      </div>
    </div>

    <div v-else-if="setting.type === 'color'" class="flex items-start">
      <color-picker class="flex-none rounded" :value="value" @input="$emit('input', $event)" />
      <div class="flex-1 ml-3 -mt-1">
        <label class="block text-base font-medium">{{ setting.label }}</label>
        <p class="text-xs">{{ value }}</p>
      </div>
    </div>

    <p
      v-if="setting.info"
      v-html="setting.info"
      class="text-xs text-gray-600"
      :class="{ 'ml-6': setting.type === 'checkbox' }"
    ></p>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/composition-api";
import Slider from "@vueform/slider/dist/slider.vue2.js";
import TextType from "./Types/TextType.vue";
import CheckboxType from "./Types/CheckboxType.vue";
import RadioGroupType from "./Types/RadioGroupType.vue";
import ImageType from "./Types/ImageType.vue";
import ModelType from "./Types/ModelType.vue";

import { Setting as SettingType } from "../types";

export default defineComponent({
  components: {
    TextType,
    CheckboxType,
    RadioGroupType,
    ImageType,
    ModelType,
    Slider,
  },

  props: {
    value: {
      type: [Number, String, Boolean],
      default: null,
    },

    setting: {
      type: Object as () => SettingType,
      default: () => ({}),
    },
  },

  emits: ["input"],

  setup() {},
});
</script>

<style src="@vueform/slider/themes/default.css"></style>
<style scoped>
.slider-primary {
  --slider-connect-bg: #3b82f6;
  --slider-tooltip-bg: #3b82f6;
  --slider-handle-ring-color: #3b82f630;
}
</style>
