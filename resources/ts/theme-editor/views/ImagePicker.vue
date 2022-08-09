<template>
  <div class="h-full flex flex-col bg-white">
    <div class="flex-none flex justify-between border-b pl-4 pr-2 py-3">
      <h3 class="text-lg font-medium">{{ t("images") }}</h3>
      <button
        class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100"
        @click="onCancel"
      >
        <mdicon name="close" width="20" class="text-gray-600" />
      </button>
    </div>

    <div class="flex-1 overflow-y-auto">
      <input type="file" class="hidden" ref="fileInput" accept="image/*" @change="onFileChange" />

      <div class="grid grid-cols-2 gap-4 p-4">
        <button
          class="relative block w-full aspect-w-1 aspect-h-1 rounded border border-dashed hover:border-primary"
          @click="$refs.fileInput.click()"
        >
          <div class="absolute w-full h-full flex flex-col items-center justify-center">
            <mdicon name="upload" class="text-gray-600" />
            {{ t("import") }}
          </div>
        </button>

        <div v-if="isImporting" class="w-full rounded border flex items-center justify-center">
          <mdicon name="loading" width="48" height="48" class="animate-spin text-primary" />
        </div>

        <button
          v-for="image in images"
          :key="image.path"
          class="relative w-full rounded aspect-w-1 aspect-h-1 border"
          :class="{
            'ring-2 ring-primary': image.path === selectedImage,
          }"
          @click="onImageClick(image.path)"
        >
          <img :src="image.url" class="rounded object-cover" />
          <mdicon
            v-if="image.path === selectedImage"
            class="flex justify-end text-primary"
            width="20"
            height="20"
            name="check-circle"
          />
        </button>
      </div>
    </div>

    <div class="flex-none px-3 py-2 border-t">
      <button
        class="px-4 py-2 rounded block w-full"
        :class="
          selectedImage ? 'bg-primary text-white' : 'bg-gray-100 text-gray-500 pointer-events-none'
        "
        @click="onSelectImage"
      >
        {{ t("Select this image") }}
      </button>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from "@vue/composition-api";
import { useFetchImages, useImportImage } from "../api";
import { useStore } from "../store";
import { useLang } from "../lang";

export default defineComponent({
  setup() {
    const store = useStore();
    const { t } = useLang();
    const isImporting = ref(false);
    const selectedImage = ref("");
    const { data: images } = useFetchImages();

    function onFileChange(event: Event) {
      if ((event.target as HTMLInputElement).files!.length > 0) {
        const file = (event.target as HTMLInputElement).files![0];
        const formData = new FormData();

        formData.append("image", file);
        const { onFetchResponse, data } = useImportImage(formData);

        isImporting.value = true;

        onFetchResponse(() => {
          isImporting.value = false;
          images.value.unshift(data.value);
        });
      }
    }

    function onImageClick(path: string) {
      selectedImage.value = path;
      if (store.activePickerValuePath) {
        store.updateThemeDataValue(store.activePickerValuePath, path);
      }
    }

    function onCancel() {
      store.updateThemeDataValue(store.activePickerValuePath as string, store.activePickerValue);
      store.activePickerValue = null;
      store.closeActivePicker();
    }

    function onSelectImage() {
      store.closeActivePicker();
    }

    return {
      t,
      images,
      isImporting,
      selectedImage,

      onFileChange,
      onImageClick,
      onCancel,
      onSelectImage,
    };
  },
});
</script>
