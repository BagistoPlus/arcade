const mix = require("laravel-mix");

mix.disableNotifications();

/** Default Theme */
mix
  .ts("resources/js/shop/index.ts", "dist/shop/shop.js")
  .postCss("resources/css/theme.css", "dist/shop/theme.css", [
    require("tailwindcss")("./tailwind.shop.js"),
  ]);

/** Admin */
mix.postCss("resources/css/admin.css", "dist/admin/style.css", [
  require("tailwindcss")("./tailwind.admin.js"),
]);

mix.copyDirectory("resources/img/admin", "dist/admin/images");

/** Theme Editor */

mix
  .ts("resources/js/theme-editor/app.ts", "dist/theme-editor")
  .ts("resources/js/theme-editor/injected.ts", "dist/theme-editor")
  .postCss("resources/css/theme-editor.css", "dist/theme-editor/style.css", [
    require("tailwindcss")("./tailwind.editor.js"),
  ])
  .vue({ version: 2 });
