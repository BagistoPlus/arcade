<template>
  <div>
    <label v-if="label" class="block mb-1 font-medium">{{ label }}</label>
    <div>
      <div v-if="value">
        <div class="relative rounded-t bg-gray-100 p-2">
          <template v-if="model">
            <div v-if="modelName === 'categories'" class="flex items-center">
              <img
                v-if="model.image_url"
                :src="model.image_url"
                :alt="model.name"
                class="flex-none w-8 h-8 rounded object-cover"
              />
              <mdicon v-else name="tag-multiple" width="32" height="32" class="text-gray-500" />
              <span class="ml-2">{{ model.name }}</span>
            </div>
            <div v-else-if="modelName === 'products'" class="flex items-center">
              <img
                v-if="model.images.length > 0"
                :src="model.images[0].url"
                :alt="model.name"
                class="flex-none w-8 h-8 object-cover rounded"
              />
              <mdicon v-else name="tag" class="flex-none text-gray-500" />
              <div class="flex-1 ml-2 text-sm truncate">
                {{ model.name }}
              </div>
            </div>
          </template>
          <div class="absolute top-0 right-0 p-2">
            <button @click.prevent="$emit('input', null)" class="text-gray-600 hover:text-gray-800">
              <mdicon name="close" />
            </button>
          </div>
        </div>
        <button
          class="flex justify-center items-center w-full border rounded-b mt-1 py-2 bg-gray-50"
          @click="$emit('select')"
        >
          <mdicon width="16" height="16" name="pencil" class="inline mr-2" />
          {{ editButtonLabel }}
        </button>
      </div>
      <button
        v-else
        class="block w-full text-center bg-white hover:bg-gray-100 rounded border px-3 py-2"
        @click="$emit('select')"
      >
        {{ buttonLabel }}
      </button>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, computed } from "@vue/composition-api";
import { useStore } from "../../store";

export default defineComponent({
  props: {
    label: {
      type: String,
      required: false,
    },

    value: {
      type: [String, Number],
      required: false,
    },

    modelName: {
      type: String,
      default: "categories",
    },

    buttonLabel: {
      type: String,
      default: "Select category",
    },

    editButtonLabel: {
      type: String,
      default: "Update category",
    },
  },

  setup(props) {
    const store = useStore();

    const model = computed<Record<string, any> | null>(() => {
      return props.value ? store.getModel(props.modelName, props.value) : null;
    });

    return {
      model,
    };
  },
});
</script>
