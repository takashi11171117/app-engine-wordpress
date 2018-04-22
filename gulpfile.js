var gulp = require('gulp');
var gulpLoadPlugins = require('gulp-load-plugins');
var $ = gulpLoadPlugins();
var del = require('del');
var vinylPaths = require('vinyl-paths');
var sassLint = require('gulp-sass-lint');
var fs = require('fs');

var REPORT_DIR = './result/';
var HTMLHINT_FILE_NAME = 'htmlhint-checkstyle.xml';

process.env.HTMLHINT_CHECKSTYLE_FILE = REPORT_DIR + HTMLHINT_FILE_NAME;
gulp.task('htmlhint', function () {
  gulp.src(['./wp-content/themes/default_theme/**/*.php', '!./wp-content/themes/default_theme/tests/*.php', '!./wp-content/themes/default_theme/functions.php'])
    .pipe($.htmlhint('.htmlhintrc'))
    .pipe($.htmlhint.reporter('gulp-htmlhint-checkstyle-file-reporter'))
    .pipe(gulp.dest(REPORT_DIR + '.tmp'))
    .on('end', function () {
      gulp.src(REPORT_DIR + '*.tmp.*')
        .pipe(vinylPaths(del))
        .pipe($.concat(HTMLHINT_FILE_NAME))
        .pipe($.header('<?xml version="1.0" encoding="utf-8"?>\n<checkstyle version="4.3">\n'))
        .pipe($.footer('\n</checkstyle>'))
        .pipe(gulp.dest(REPORT_DIR))
        .on('end', function () {
          del([REPORT_DIR + '.tmp']);
        });
    });
});

gulp.task('sasslint', function () {
    var file = fs.createWriteStream('result/lint_sass.xml');
    var stream = gulp.src('./wp-content/themes/default_theme/assets/**/*.scss')
	.pipe(sassLint({
        options: {
            configFile: '.sass-lint.yml',
            formatter: 'checkstyle'
        }
    }))
	.pipe(sassLint.format(file));
    stream.on('finish', function() {
        file.end();
    });
    return stream;
});

gulp.task('lint', ['htmlhint', 'sasslint'], function () {
  gulp.src(REPORT_DIR + '*.xml')
    .pipe($.prettyData({ type: 'prettify' }))
    .pipe(gulp.dest(REPORT_DIR));
});

gulp.task('default', function () {
  gulp.start('lint');
});
