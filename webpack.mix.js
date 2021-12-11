const mix = require("laravel-mix");

mix.disableNotifications();

mix
  .ts("resources/js/shop/index.ts", "dist/theme/shop.js")
  .postCss("resources/css/theme.css", "dist/theme/theme.css", [
    require("tailwindcss")("./tailwind.shop.js"),
  ]);
