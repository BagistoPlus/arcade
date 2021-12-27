<template>
  <div class="relative">
    <span ref="triggerEl">
      <slot
        name="trigger"
        :on="{
          click: toggle,
        }"
      />
    </span>

    <transition
      enter-active-class="transition ease-out duration-100"
      enter-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-class="transform opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-95"
    >
      <div
        v-show="opened"
        ref="contentEl"
        :class="['fixed', contentClass]"
        v-bind="$attrs"
        role="popover"
        :style="{
          left: `${contentPosition.left}px`,
          top: `${contentPosition.top}px`,
        }"
      >
        <slot :close="close" />
      </div>
    </transition>
  </div>
</template>

<script lang="ts">
import {
  defineComponent,
  onMounted,
  reactive,
  ref,
  watch,
} from "@vue/composition-api";
import { computePosition, flip, offset } from "@floating-ui/dom";
import { onClickOutside } from "@vueuse/core";

export default defineComponent({
  inheritAttrs: false,

  props: {
    value: {
      type: Boolean,
      default: false,
    },

    position: {
      type: String,
      default: "bottom-start",
      validator: (value: string) =>
        /top|top-start|top-end|right|right-start|right-end|bottom|bottom-start|bottom-end|left|left-start|left-end/.test(
          value
        ),
    },

    offset: {
      type: [Number, String],
      default: 0,
    },

    contentClass: {
      type: [String, Array, Object],
      default: "",
    },
  },

  setup(props, { emit }) {
    const opened = ref(props.value);
    const triggerEl = ref<HTMLElement | null>(null);
    const contentEl = ref<HTMLElement | null>(null);
    const contentPosition = reactive({
      left: 0,
      top: 0,
    });

    watch(
      () => props.value,
      (value) => {
        if (value !== opened.value) {
          opened.value = value;
        }
      }
    );

    watch(
      () => opened.value,
      (value) => emit("input", value)
    );

    function updateContentPosition() {
      computePosition(
        triggerEl.value as HTMLElement,
        contentEl.value as HTMLElement,
        {
          placement: props.position as any,
          middleware: [offset(Number(props.offset)), flip()],
        }
      ).then(({ x, y }) => {
        contentPosition.left = x;
        contentPosition.top = y;
      });
    }

    function toggle() {
      if (!opened.value) {
        updateContentPosition();
      }

      opened.value = !opened.value;
    }

    function close() {
      opened.value = false;
    }

    onMounted(() => {
      onClickOutside(contentEl.value, () => (opened.value = false));
    });

    addEventListener("scroll", updateContentPosition);
    addEventListener("resize", updateContentPosition);

    return {
      opened,
      triggerEl,
      contentEl,
      contentPosition,
      toggle,
      close,
    };
  },
});
</script>
