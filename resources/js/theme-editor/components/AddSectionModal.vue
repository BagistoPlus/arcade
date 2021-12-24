<template>
  <div
    v-show="opened"
    class="fixed z-10 inset-0 w-screen h-screen overflow-y-auto"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
  >
    <div class="flex items-center justify-center h-screen pt-4 px-4 pb-20">
      <transition
        enter-active-class="ease-out duration-300"
        enter-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="ease-in duration-200"
        leave-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div
          v-show="opened"
          class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
          aria-hidden="true"
          @click="opened = false"
        ></div>
      </transition>

      <transition
        enter-active-class="ease-out duration-300"
        enter-class="opacity-0 translate-y-4 scale-95"
        enter-to-class="opacity-100 translate-y-0 scale-100"
        leave-active-class="ease-in duration-200"
        leave-class="opacity-100 translate-y-0 scale-100"
        leave-to-class="opacity-0 translate-y-4 scale-95"
      >
        <div
          v-show="opened"
          class="flex flex-col bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all w-full max-w-2xl h-[90%]"
        >
          <div class="px-4 py-4 flex-none flex border-b rounded-t bg-gray-50">
            <h3 class="flex-1 text-xl">Add a new section</h3>
            <button
              class="flex-none w-7 h-7 ml-4 rounded-full flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-blue-500"
              @click="opened = false"
            >
              <mdicon name="close" />
            </button>
          </div>

          <div class="flex-1 flex flex-col overflow-hidden">
            <div class="border-b py-px">
              <text-input
                v-model="search"
                type="text"
                name="search"
                left-icon="magnify"
                input-class="w-full !border-transparent rounded-none"
              />
            </div>
            <div class="flex-1 p-6 overflow-y-auto">
              <div
                v-for="(sections, vendor) in groupedByVendor"
                :key="vendor"
                class="mb-4"
              >
                <h4 class="sticky capitalize mb-2 font-medium">
                  From {{ vendor }}
                </h4>
                <div class="grid grid-cols-2 gap-6">
                  <div
                    v-for="section in sections"
                    :key="section.slug"
                    class="rounded cursor-pointer shadow hover:shadow-lg"
                    @click="$emit('click-section', section)"
                  >
                    <div class="aspect-w-16 aspect-h-8 bg-gray-100"></div>
                    <div class="text-center p-3">
                      <h3 class="uppercase text-xs font-semibold">
                        {{ section.label }}
                      </h3>
                      <p class="text-xs line-clamp-1">
                        {{ section.previewDescription || "&nbsp;" }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>

<script lang="ts">
import { computed, defineComponent, ref, watch } from "@vue/composition-api";
import sortBy from "lodash/sortBy";
import { Section } from "../types";
import TextInput from "./Types/TextType.vue";

export default defineComponent({
  components: { TextInput },
  props: {
    active: {
      type: Boolean,
      default: false,
    },

    sections: {
      type: Array as () => Section[],
      default: () => [],
    },
  },

  setup(props, { emit }) {
    const opened = ref(props.active);
    const search = ref("");

    const allSections = computed(() =>
      sortBy(props.sections, ["label"], ["asc"])
    );

    const filteredSections = computed(() => {
      if (!search.value) {
        return allSections.value;
      }

      const regex = new RegExp(search.value, "gi");
      return allSections.value.filter((section: Section) => {
        return (
          regex.test(section.slug) ||
          regex.test(section.label) ||
          regex.test(section.description) ||
          regex.test(section.previewDescription)
        );
      });
    });

    const groupedByVendor = computed(() => {
      const grouped: Record<string, Section[]> = {};

      filteredSections.value.forEach((section) => {
        const vendor = section.slug.split("-")[0];

        if (!grouped[vendor]) {
          grouped[vendor] = [];
        }

        grouped[vendor].push(section);
      });

      return grouped;
    });

    watch(
      () => props.active,
      (newVal) => (opened.value = newVal)
    );

    watch(
      () => opened.value,
      (newValue) => {
        emit("update:active", newValue);
        if (newValue) {
          document.body.classList.add("overflow-hidden");
        } else {
          document.body.classList.remove("overflow-hidden");
        }
      }
    );

    return {
      opened,
      search,
      groupedByVendor,
    };
  },
});
</script>
