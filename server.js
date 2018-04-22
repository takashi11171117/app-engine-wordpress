var browserSync = require("browser-sync");
browserSync({
  proxy: 'http://localhost:30010/',
  files: [
	"./wp-content/themes/default_theme/build/**/*.css",
	"./wp-content/themes/default_theme/build/**/*.js",
	"./wp-content/themes/default_theme/build/**/*.img",
	"./wp-content/themes/default_theme/*.php",
	"./wp-content/themes/default_theme/classes/**/*.php"
  ]
});
