module.exports = {
  mode: "jit",
  purge: {
    content: [
      "./resources/views/theme/**/*.blade.php",
      "./resources/views/components/**/*.blade.php",
      "./resources/js/shop/**/*.{js,ts}",
      "./theme-safelist.txt",
    ],
  },
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [
    require("@tailwindcss/forms"),
    require("tailwind-safelist-generator")({
      path: "./theme-safelist.txt",
      patterns: [
        "text-{colors}",
        "border-{colors}",
        "bg-{colors}",
        "from-{colors}",
        "to-{colors}",
        "via-{colors}",
      ],
    }),
  ],
};
