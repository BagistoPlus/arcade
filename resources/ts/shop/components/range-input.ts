import { AlpineComponent } from "alpinejs";
import noUiSlider from "nouislider";

interface RangeInput {
  rangeSlider: any;
  min: number;
  max: number;

  initializeRangeSlider: () => void;
}

export default function (options: any): AlpineComponent<RangeInput> {
  return {
    rangeSlider: null,

    min: Number(options.minValue || options.min),
    max: Number(options.maxValue || options.max),

    init() {
      this.initializeRangeSlider();
      // @ts-ignore
      Livewire.hook("message.processed", (message, component) => {
        this.rangeSlider.destroy();
        this.initializeRangeSlider();
      });
    },

    initializeRangeSlider() {
      this.rangeSlider = noUiSlider.create(this.$el, {
        start: [this.min, this.max],
        connect: true,
        step: Number(options.step || 1),
        range: {
          min: Number(options.min),
          max: Number(options.max),
        },
        cssClasses: {
          target: "atarget relative bg-gray-200 rounded h-2 select-none",
          base: "abase z-1 w-full h-full relative",
          origin:
            "aorigin absolute top-0 right-0 w-full h-0 will-change-transform origin-top-left",
          handle:
            "ahandle absolute w-4 h-4 rounded-full bg-gray-300 shadow -right-3 -top-1",
          handleLower: "handleLower",
          handleUpper: "handleUpper",
          touchArea: "touchArea",
          horizontal: "horizontal",
          vertical: "vertical",
          background: "background",
          connect:
            "connect absolute bg-primary z-1 top-0 right-0 w-full h-full origin-top-left will-change-transform",
          connects:
            "aconnects rounded z-0 overflow-hidden w-full h-full relative",
          ltr: "ltr",
          rtl: "rtl",
          textDirectionLtr: "textDirectionLtr",
          textDirectionRtl: "textDirectionRtl",
          draggable: "draggable",
          drag: "drag",
          tap: "tap",
          active: "active",
          tooltip: "tooltip",
          pips: "pips",
          pipsHorizontal: "pipsHorizontal",
          pipsVertical: "pipsVertical",
          marker: "marker",
          markerHorizontal: "markerHorizontal",
          markerVertical: "markerVertical",
          markerNormal: "markerNormal",
          markerLarge: "markerLarge",
          markerSub: "markerSub",
          value: "value",
          valueHorizontal: "valueHorizontal",
          valueVertical: "valueVertical",
          valueNormal: "valueNormal",
          valueLarge: "valueLarge",
          valueSub: "valueSub",
        },
      });

      this.rangeSlider.on("change", (values: any) => {
        const [min, max] = values.map(Number);
        this.min = min;
        this.max = max;
        this.$dispatch("update", [min, max]);
      });
    },
  };
}
