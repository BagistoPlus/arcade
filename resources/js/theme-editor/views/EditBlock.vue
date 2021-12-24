<template>
  <div v-if="block" class="flex flex-col h-full overflow-hidden relative">
    <header class="flex-none p-2 border-b border-gray-300">
      <div class="flex items-center">
        <button
          class="p-1 rounded hover:bg-gray-200 focus:outline-none"
          @click="$router.back()"
        >
          <mdicon name="arrow-left" class="text-gray-400" />
        </button>
        <span class="ml-2">
          {{
            blockData.settings.title || blockData.settings.heading || block.name
          }}
        </span>
      </div>
      <p v-if="block.description" class="mt-2 text-sm">
        {{ block.description }}
      </p>
    </header>

    <div class="flex-1 p-3 overflow-y-auto">
      <section class="space-y-3">
        <h3 class="font-semibold">Settings</h3>

        <template v-if="groupedSettings.default">
          <settings-group
            :settings="groupedSettings.default"
            :value-path="valuePath"
            :getSettingValue="getSettingValue"
            @update-setting="onUpdateSetting"
          />
        </template>

        <template v-for="(settings, group) in groupedSettings">
          <template v-if="group !== 'default'">
            <settings-group
              :key="group"
              :name="group"
              :settings="settings"
              :value-path="valuePath"
              :getSettingValue="getSettingValue"
              @update-setting="onUpdateSetting"
            />
          </template>
        </template>
      </section>
    </div>

    <footer class="flex-none border-t border-gray-300">
      <button class="flex w-full text-left py-3 px-4 hover:bg-gray-100">
        <mdicon name="trash-can-outline" class="inline mr-2" />
        Remove block
      </button>
    </footer>
  </div>
</template>

<script lang="ts">
import { computed, defineComponent } from "@vue/composition-api";
import { useStore } from "../store";
import { groupSettings } from "../utils";

import SettingsGroup from "../components/SettingsGroup.vue";

export default defineComponent({
  components: { SettingsGroup },

  setup(_, { root }) {
    const store = useStore();
    const sectionData = computed(() => {
      return store.themeDataValue(`sections.${root.$route.params.sectionId}`);
    });

    const blockData = computed(() => {
      return store.themeDataValue(
        `sections.${root.$route.params.sectionId}.blocks.${root.$route.params.blockId}`
      );
    });

    const block = computed(() => {
      if (!sectionData.value) {
        return null;
      }

      const section = store.sectionByType(sectionData.value.type);

      return section && blockData.value
        ? section.blocks?.find((block) => block.type === blockData.value.type)
        : null;
    });

    const groupedSettings = computed(() => {
      if (!block.value) {
        return {};
      }

      return groupSettings(block.value.settings);
    });

    const valuePath = computed(
      () =>
        `sections.${root.$route.params.sectionId}.blocks.${root.$route.params.blockId}.settings`
    );

    function getSettingValue(settingId: string) {
      return store.themeDataValue(`${valuePath.value}.${settingId}`);
    }

    function onUpdateSetting(value: any, settingId: string) {
      store.updateThemeDataValue(`${valuePath.value}.${settingId}`, value);
    }

    return {
      block,
      blockData,
      groupedSettings,
      valuePath,

      getSettingValue,
      onUpdateSetting,
    };
  },
});
</script>
