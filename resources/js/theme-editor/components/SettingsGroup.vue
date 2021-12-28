<template>
  <div class="rounded border border-gray-300">
    <button
      v-if="name"
      class="relative block w-full px-3 py-2 text-left capitalize hover:bg-gray-100 rounded-t"
      @click="opened = !opened"
    >
      {{ name }}
      <mdicon
        :name="opened ? 'chevron-up' : 'chevron-down'"
        class="absolute right-2 top-2"
      />
    </button>
    <div v-show="opened" class="p-2 space-y-3">
      <setting
        v-for="setting in settings"
        :key="setting.id"
        :setting="setting"
        :value="getSettingValue(setting.id)"
        @input="(value) => $emit('update-setting', value, setting.id)"
        @pickImage="$emit('pickImage', `${valuePath}.${setting.id}`)"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from "@vue/composition-api";
import { Setting as SettingType } from "../types";
import Setting from "./Setting.vue";

export default defineComponent({
  components: { Setting },

  props: {
    name: {
      type: String,
      required: false,
    },

    valuePath: {
      type: String,
      required: true,
    },

    settings: {
      type: Array as () => SettingType[],
      default: [],
    },

    getSettingValue: {
      type: Function,
      default: () => () => null,
    },
  },

  setup(props) {
    const opened = ref<boolean>(!props.name);

    return {
      opened,
    };
  },
});
</script>
