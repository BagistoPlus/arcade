<template>
  <div>
    <label v-if="label" class="block mb-1 font-medium">{{ label }}</label>
    <div>
      <div v-if="value">
        <div class="relative rounded-t bg-gray-100 p-2">
          <img :src="imageUrl(value)" />
          <div class="absolute top-0 right-0 p-2">
            <button
              @click="removeImage"
              class="text-gray-600 hover:text-gray-800"
            >
              <mdicon name="close" />
            </button>
          </div>
        </div>
        <button
          class="block flex justify-center items-center w-full border rounded-b mt-1 py-2 bg-gray-50"
          @click="$emit('pickImage')"
        >
          <mdicon width="16" height="16" name="pencil" class="inline mr-2" />
          Update Image
        </button>
      </div>
      <div v-else class="p-4 rounded bg-gray-100 text-center">
        <button
          class="bg-white rounded border px-3 py-2"
          @click="$emit('pickImage')"
        >
          Select Image
        </button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/composition-api";

export default defineComponent({
  props: {
    value: {
      type: String,
      required: false,
    },

    label: {
      type: String,
      required: false,
    },
  },

  setup(props, { emit }) {
    function imageUrl(path: string) {
      return Arcade.imagesBaseUrl + path;
    }

    function removeImage() {
      emit("input", null);
    }

    return {
      imageUrl,
      removeImage,
    };
  },
});
</script>
