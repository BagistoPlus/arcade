module.exports = {
  mode: "jit",
  content: ["./resources/ts/theme-editor/**/*.{js,ts,vue}"],
  theme: {
    extend: {
      colors: {
        primary: "#0041ff",
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
    require("@tailwindcss/forms"),
    require("@tailwindcss/line-clamp"),
    require("@tailwindcss/aspect-ratio"),
  ],
};
