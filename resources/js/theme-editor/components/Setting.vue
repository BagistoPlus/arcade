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
      <label v-if="setting.label" class="block font-medium mb-1">{{
        setting.label
      }}</label>
      <textarea
        class="block w-full rounded border-gray-300"
        :rows="setting.rows"
        :model-value="value"
        @input="$emit('input', $event)"
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
          v-for="option in setting.options"
          :value="option.value"
          :key="option.value"
          :selected="value === option.value"
        >
          {{ option.label }}
        </option>
      </select>

      <p
        v-if="setting.info"
        v-html="setting.info"
        class="text-xs text-gray-600"
        :class="{ 'ml-6': setting.type === 'checkbox' }"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/composition-api";
import TextType from "./Types/TextType.vue";
import CheckboxType from "./Types/CheckboxType.vue";
import RadioGroupType from "./Types/RadioGroupType.vue";

import { Setting as SettingType } from "../types";

export default defineComponent({
  components: {
    TextType,
    CheckboxType,
    RadioGroupType,
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
