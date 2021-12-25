<template>
  <div v-if="section" class="flex flex-col h-full overflow-hidden relative">
    <header class="flex-none p-2 border-b border-gray-300">
      <div class="flex items-center">
        <button
          class="p-1 rounded hover:bg-gray-200 focus:outline-none"
          @click="$router.back()"
        >
          <mdicon name="arrow-left" class="text-gray-400" />
        </button>
        <span class="ml-2">{{
          sectionData.settings.heading || section.label
        }}</span>
      </div>
      <p v-if="section.description" class="mt-2 text-sm">
        {{ section.description }}
      </p>
    </header>

    <div class="flex-1 p-3 overflow-y-auto">
      <section v-if="Object.keys(groupedSettings).length > 0" class="space-y-3">
        <h3 class="font-medium">Settings</h3>
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
      <p v-else>This section has no configuration</p>

      <template v-if="section.blocks.length > 0">
        <hr class="-mx-3 my-4 border-gray-300" />
        <section class="">
          <h3 class="font-semibold">Blocks</h3>

          <block-list
            class="mt-2"
            :blocks="blocks"
            :order="sectionData.blocks_order"
            :getBlockByType="getBlockByType"
            @reorder="onReorderBlocks"
            @editBlock="onEditBlock"
          />

          <div class="mt-2" v-if="blocks.length < section.maxBlocks">
            <button
              v-if="section.blocks.length === 1"
              class="block w-full border bg-primary bg-opacity-75 text-white p-2 rounded hover:bg-opacity-90 focus:outline-none"
            >
              Add {{ section.blocks[0].name }} ({{ blocks.length }}/{{
                section.maxBlocks
              }})
            </button>
            <div v-else>drop down</div>
          </div>
        </section>
      </template>
    </div>

    <footer v-if="isRemovable" class="flex-none border-t border-gray-300">
      <button
        class="flex w-full text-left py-3 px-4 hover:bg-gray-100"
        @click="onRemoveSection"
      >
        <mdicon name="trash-can-outline" class="inline mr-2" />
        Remove section
      </button>
    </footer>
  </div>
</template>

<script lang="ts">
import { computed, defineComponent } from "@vue/composition-api";
import { groupSettings } from "../utils";
import { useStore } from "../store";

import SettingsGroup from "../components/SettingsGroup.vue";
import BlockList from "../components/BlockList.vue";

export default defineComponent({
  components: { SettingsGroup, BlockList },

  setup(_, { root }) {
    const store = useStore();

    const sectionData = computed(() =>
      store.themeDataValue(`sections.${root.$route.params.sectionId}`)
    );

    const section = computed(() =>
      sectionData.value ? store.sectionByType(sectionData.value.type) : null
    );

    const isRemovable = computed(() =>
      store.canRemoveSection(root.$route.params.sectionId)
    );

    const valuePath = computed(() =>
      sectionData.value ? `sections.${sectionData.value.id}.settings` : ""
    );

    const groupedSettings = computed(() => {
      if (!section.value) {
        return {};
      }

      return groupSettings(section.value.settings);
    });

    const blocks = computed(() =>
      sectionData.value
        ? sectionData.value.blocks_order.map(
            (id: string) => sectionData.value.blocks[id]
          )
        : []
    );

    const getBlockByType = (type: string) => {
      return section.value
        ? section.value.blocks?.find((block) => block.type === type)
        : {};
    };

    function getSettingValue(settingId: string) {
      return store.themeDataValue(`${valuePath.value}.${settingId}`);
    }

    function onUpdateSetting(value: any, settingId: string) {
      store.updateThemeDataValue(`${valuePath.value}.${settingId}`, value);
    }

    function onReorderBlocks(order: string[]) {
      store.updateThemeDataValue(
        `sections.${sectionData.value.id}.blocks_order`,
        order
      );
    }

    function onEditBlock(blockId: string) {
      root.$router.push({ name: "edit_block", params: { blockId } });
    }

    function onRemoveSection() {
      store.removeSection(root.$route.params.sectionId);
      root.$router.back();
    }

    return {
      section,
      sectionData,
      isRemovable,
      valuePath,
      groupedSettings,
      blocks,

      getSettingValue,
      getBlockByType,
      onUpdateSetting,
      onReorderBlocks,
      onEditBlock,
      onRemoveSection,
    };
  },
});
</script>
