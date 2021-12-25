<template>
  <div class="h-full flex flex-col overflow-hidden">
    <div class="flex border-b flex-none">
      <button
        v-for="tab in tabs"
        :key="tab"
        class="flex-1 text-center px-4 py-2 border-b-2 border-transparent hover:border-primary hover:border-opacity-60 hover:text-primary hover:text-opacity-60"
        :class="{ 'border-primary text-primary': tab === activeTab }"
        @click="activeTab = tab"
      >
        {{ tab }}
      </button>
    </div>

    <div class="flex-1 p-3 overflow-y-auto">
      <template v-if="activeTab === 'Page'">
        <section-list
          fixed
          title="Layout sections"
          :sections="beforeContentSections"
          :activeSectionId="activeSectionId"
          :getSectionByType="getSectionByType"
          @activateSection="activateSection"
          @deactivateSection="deactivateSection"
          @editSection="onEditSection"
        />

        <section-list
          title="Content"
          class="mt-4"
          :sections="contentSections"
          :order="contentSectionsOrder"
          :activeSectionId="activeSectionId"
          :getSectionByType="getSectionByType"
          @reorder="onSectionReorder"
          @activateSection="activateSection"
          @deactivateSection="deactivateSection"
          @editSection="onEditSection"
          @toggleSection="onToggleSection"
          @add-section="$emit('add-section')"
        />

        <section-list
          fixed
          title="Layout sections"
          class="mt-4"
          :sections="afterContentSections"
          :getSectionByType="getSectionByType"
          @activateSection="activateSection"
          @deactivateSection="deactivateSection"
          @editSection="onEditSection"
        />
      </template>
    </div>
  </div>
</template>

<script lang="ts">
import { computed, defineComponent, ref } from "@vue/composition-api";
import SectionList from "../components/SectionList.vue";
import { useStore } from "../store";
import { useRouter } from "vue2-helpers/vue-router";

export default defineComponent({
  components: {
    SectionList,
  },

  setup() {
    const tabs = ["Page", "Theme Settings"];
    const activeTab = ref(tabs[0]);
    const store = useStore();
    const router = useRouter();

    function activateSection(id: string) {
      store.activateSection(id, true);
    }

    function deactivateSection() {
      store.deactivateSection(true);
    }

    function onSectionReorder(sectionIds: string[]) {
      store.updateThemeDataValue("sectionsOrder", sectionIds);
    }

    function onEditSection(sectionId: string) {
      router.push({ name: "edit_section", params: { sectionId } });
    }

    function onToggleSection(sectionId: string) {
      store.toggleSection(sectionId);
    }

    return {
      tabs,
      activeTab,
      beforeContentSections: computed(() => store.beforeContentSections),
      afterContentSections: computed(() => store.afterContentSections),
      contentSections: computed(() => store.contentSections),
      activeSectionId: computed(() => store.activeSectionId),
      contentSectionsOrder: computed(() =>
        store.themeDataValue("sectionsOrder")
      ),

      activateSection,
      deactivateSection,
      onSectionReorder,
      onEditSection,
      onToggleSection,

      getSectionByType(type: string) {
        return store.sectionByType(type);
      },
    };
  },
});
</script>
