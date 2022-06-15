<template>
  <div class="absolute overflow-y-hidden top-0 left-0 h-full w-full flex flex-col border bg-white">
    <div class="flex-none flex justify-between border-b pl-4 pr-2 py-3">
      <h3 class="text-lg font-medium">Select Category</h3>
      <button
        class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100"
        @click="onCancel"
      >
        <mdicon name="close" width="20" class="text-gray-600" />
      </button>
    </div>

    <div class="flex-1 flex flex-col">
      <div class="flex-none px-4 py-3 border-b">
        <div class="relative">
          <mdicon name="magnify" class="absolute top-2 left-2 text-gray-400" />
          <input
            v-model="search"
            type="text"
            class="block w-full pl-10 rounded-lg border-gray-200"
          />
        </div>
      </div>

      <ul class="flex-1 overflow-y-auto divide-y">
        <li v-for="category in categories" :id="category.id">
          <a
            href="#"
            class="flex items-center w-full px-3 py-3 hover:bg-gray-100"
            @click="onCategoryClick(category.id)"
          >
            <img
              v-if="category.image_url"
              :src="category.image_url"
              :alt="category.name"
              class="flex-none w-8 h-8 object-cover rounded"
            />
            <mdicon v-else name="tag-multiple" class="flex-none text-gray-500" />
            <div class="flex-1 ml-2 truncate">
              {{ category.name }}
            </div>
            <mdicon
              name="check-circle"
              class="text-primary flex-none ml-2"
              :class="{ invisible: !selectedCategory || selectedCategory !== category.id }"
            />
          </a>
        </li>
      </ul>
    </div>

    <div class="flex-none px-3 py-2 border-t">
      <button
        class="px-4 py-2 rounded block w-full"
        :class="
          selectedCategory
            ? 'bg-primary text-white'
            : 'bg-gray-100 text-gray-500 pointer-events-none'
        "
        @click="onSelectCategory"
      >
        Select this category
      </button>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, computed } from "@vue/composition-api";
import { useFetchCategories } from "../api";
import { useStore } from "../store";

export default defineComponent({
  setup() {
    const store = useStore();
    const isImporting = ref(false);
    const selectedCategory = ref<number>(store.activePickerValue as number);
    const search = ref("");
    const { data } = useFetchCategories();

    function onCategoryClick(categoryId: number) {
      selectedCategory.value = categoryId;
      if (store.activePickerValuePath) {
        store.updateThemeDataValue(store.activePickerValuePath, categoryId);
      }
    }

    function onCancel() {
      if (selectedCategory.value !== store.activePickerValue) {
        store.updateThemeDataValue(store.activePickerValuePath as string, store.activePickerValue);
      }
      store.activePickerValue = null;
      store.closeActivePicker();
    }

    function onSelectCategory() {
      store.registerModel(
        "categories",
        data.value.data.find((category: any) => category.id === selectedCategory.value)
      );
      store.closeActivePicker();
    }

    return {
      search,
      selectedCategory,
      categories: computed(() => {
        if (!search.value) {
          return data.value?.data;
        }

        const regex = new RegExp(search.value, "i");
        return data.value?.data.filter((category: any) => regex.test(category.name));
      }),

      onCancel,
      onCategoryClick,
      onSelectCategory,
    };
  },
});
</script>
