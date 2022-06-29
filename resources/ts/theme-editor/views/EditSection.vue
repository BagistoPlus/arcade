<template>
  <div v-if="section" class="flex flex-col h-full overflow-hidden relative">
    <header class="flex-none p-2 border-b border-gray-300">
      <div class="flex items-center">
        <button class="p-1 rounded hover:bg-gray-200 focus:outline-none" @click="$router.back()">
          <mdicon name="arrow-left" class="text-gray-400" />
        </button>
        <span class="ml-2">{{ sectionData.settings.heading || section.label }}</span>
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
            @pickImage="(path) => openPicker('image', path)"
            @selectCategory="(path) => openPicker('category', path)"
            @selectProduct="(path) => openPicker('product', path)"
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
              @pickImage="(path) => openPicker('image', path)"
              @selectCategory="(path) => openPicker('category', path)"
              @selectProduct="(path) => openPicker('product', path)"
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
            :blocks="blocksData"
            :order="sectionData.blocks_order"
            :getBlockByType="getBlockByType"
            @reorder="onReorderBlocks"
            @editBlock="onEditBlock"
            @toggleBlock="onToggleBlock"
          />

          <div class="mt-2" v-if="blocksData.length < section.maxBlocks">
            <button
              v-if="remainingBlocks.length === 1"
              class="block w-full border bg-primary bg-opacity-75 text-white p-2 rounded hover:bg-opacity-90 focus:outline-none"
              @click="onAddBlock(remainingBlocks[0])"
            >
              Add {{ remainingBlocks[0].name }}
            </button>
            <div v-else>
              <popover
                content-class="w-[296px] ring-1 ring-black ring-opacity-5 rounded-md shadow-lg bg-white"
                offset="1"
              >
                <template #trigger="{ on }">
                  <button
                    v-on="on"
                    type="button"
                    class="block w-full rounded px-3 py-2 bg-primary text-white"
                  >
                    Add a block
                  </button>
                </template>
                <template v-slot="{ close }">
                  <ul class="py-1">
                    <li v-for="block in remainingBlocks" :key="block.type">
                      <a
                        href="#"
                        class="block w-full text-gray-700 px-4 py-2 text-sm cursor-pointer hover:bg-gray-100 hover:text-gray-900"
                        @click.prevent="
                          close();
                          onAddBlock(block);
                        "
                      >
                        {{ block.name }}
                      </a>
                    </li>
                  </ul>
                </template>
              </popover>
            </div>
          </div>
        </section>
      </template>
    </div>

    <footer v-if="isRemovable" class="flex-none border-t border-gray-300">
      <button class="flex w-full text-left py-3 px-4 hover:bg-gray-100" @click="onRemoveSection">
        <mdicon name="trash-can-outline" class="inline mr-2" />
        Remove section
      </button>
    </footer>
  </div>
</template>

<script lang="ts">
import { computed, defineComponent } from "@vue/composition-api";
import { useRoute, useRouter } from "vue2-helpers/vue-router";

import { groupSettings } from "../utils";
import { useStore } from "../store";

import SettingsGroup from "../components/SettingsGroup.vue";
import BlockList from "../components/BlockList.vue";
import Popover from "../components/Popover.vue";

import { Block, BlockData } from "../types";

export default defineComponent({
  components: { SettingsGroup, BlockList, Popover },

  setup() {
    const store = useStore();
    const router = useRouter();

    const sectionData = computed(() =>
      store.themeDataValue(`sections.${router.currentRoute.params.sectionId}`)
    );

    const section = computed(() =>
      sectionData.value ? store.sectionByType(sectionData.value.type) : null
    );

    const isRemovable = computed(() =>
      store.canRemoveSection(router.currentRoute.params.sectionId)
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

    const blocksData = computed(() =>
      sectionData.value
        ? sectionData.value.blocks_order.map((id: string) => sectionData.value.blocks[id])
        : []
    );

    const remainingBlocks = computed(() => {
      if (!section.value) {
        return [];
      }

      return section.value.blocks!.filter((block: Block) => {
        return (
          blocksData.value.filter((b: BlockData) => b.type === block.type).length < block.limit
        );
      });
    });

    const getBlockByType = (type: string) => {
      return section.value ? section.value.blocks?.find((block) => block.type === type) : {};
    };

    function getSettingValue(settingId: string) {
      return store.themeDataValue(`${valuePath.value}.${settingId}`);
    }

    function onUpdateSetting(value: any, settingId: string) {
      store.updateThemeDataValue(`${valuePath.value}.${settingId}`, value);
    }

    function onReorderBlocks(order: string[]) {
      store.updateThemeDataValue(`sections.${sectionData.value.id}.blocks_order`, order);
    }

    function onEditBlock(blockId: string) {
      router.push({ name: "edit_block", params: { blockId } });
    }

    function onToggleBlock(blockId: string) {
      store.toggleSectionBlock(router.currentRoute.params.sectionId, blockId);
    }

    function onRemoveSection() {
      store.removeSection(router.currentRoute.params.sectionId);
      router.back();
    }

    function onAddBlock(block: Block) {
      store.addSectionBlock(router.currentRoute.params.sectionId, block);
    }

    function openPicker(type: string, path: string) {
      console.log(type, path);
      store.openPicker(type as any, path);
    }

    return {
      section,
      sectionData,
      isRemovable,
      valuePath,
      groupedSettings,
      blocksData,
      remainingBlocks,

      getSettingValue,
      getBlockByType,
      onUpdateSetting,
      onReorderBlocks,
      onEditBlock,
      onRemoveSection,
      onToggleBlock,
      onAddBlock,
      openPicker,
    };
  },
});
</script>
