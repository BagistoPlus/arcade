<template>
  <div class="absolute overflow-y-hidden top-0 left-0 h-full w-full flex flex-col border bg-white">
    <div class="flex-none flex justify-between border-b pl-4 pr-2 py-3">
      <h3 class="text-lg font-medium">{{ t("Select product") }}</h3>
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
            @input="onSearchQueryChange"
          />
        </div>
      </div>

      <div v-if="isFetching" class="w-full py-5 flex items-center justify-center">
        <mdicon name="loading" width="48" height="48" class="animate-spin text-primary" />
      </div>

      <ul v-else class="flex-1 overflow-y-auto divide-y">
        <li v-for="product in products" :id="product.id">
          <a
            href="#"
            class="flex items-center w-full px-3 py-3 hover:bg-gray-100"
            @click="onProductClick(product.id)"
          >
            <img
              v-if="product.base_image"
              :src="product.base_image.small_image_url"
              :alt="product.name"
              class="flex-none w-8 h-8 object-cover rounded"
            />
            <mdicon v-else name="tag" class="flex-none text-gray-500" />
            <div class="flex-1 ml-2 text-sm truncate">
              {{ product.name }}
            </div>
            <mdicon
              name="check-circle"
              class="text-primary flex-none ml-2"
              :class="{ invisible: !selectedProduct || selectedProduct !== product.id }"
            />
          </a>
        </li>
      </ul>
    </div>

    <div class="flex-none px-3 py-2 border-t">
      <button
        class="px-4 py-2 rounded block w-full"
        :class="
          selectedProduct
            ? 'bg-primary text-white'
            : 'bg-gray-100 text-gray-500 pointer-events-none'
        "
        @click="onSelectProduct"
      >
        {{ t("Select this product") }}
      </button>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, computed } from "@vue/composition-api";
import debounce from "lodash/debounce";
import { useFetchProducts } from "../api";
import { useStore } from "../store";
import { useLang } from "../lang";

export default defineComponent({
  setup() {
    const store = useStore();
    const { t } = useLang();
    const selectedProduct = ref<any>(store.activePickerValue);
    const search = ref("");
    const { data, isFetching, execute } = useFetchProducts();

    const onSearchQueryChange = debounce(() => {
      console.log("searching...", search.value);
      search.value ? execute({ search: search.value }) : execute();
    }, 300);

    function onProductClick(productId: number) {
      selectedProduct.value = productId;
      if (store.activePickerValuePath) {
        store.updateThemeDataValue(store.activePickerValuePath, productId);
      }
    }

    function onCancel() {
      if (selectedProduct.value !== store.activePickerValue) {
        store.updateThemeDataValue(store.activePickerValuePath as string, store.activePickerValue);
      }

      store.activePickerValue = null;
      store.closeActivePicker();
    }

    function onSelectProduct() {
      store.registerModel(
        "products",
        data.value.data.find((p: any) => p.id === selectedProduct.value)
      );
      store.closeActivePicker();
    }

    return {
      t,
      search,
      selectedProduct,
      isFetching,
      products: computed(() => data.value?.data),

      onCancel,
      onProductClick,
      onSelectProduct,
      onSearchQueryChange,
    };
  },
});
</script>
