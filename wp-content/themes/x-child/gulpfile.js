var gulp = require('gulp'),
    postcss = require('gulp-postcss'),
    cssimport = require('postcss-import'),
    postcss_mixins = require('postcss-mixins'),
    autoprefixer = require('autoprefixer'),
    nested = require('postcss-nested'),
    color_function = require('postcss-color-function'),
    custom_properties = require('postcss-custom-properties'),
    custom_media = require('postcss-custom-media'),
    csswring = require('csswring'),
    rename = require('gulp-rename'),
    watch = require('gulp-watch');

    var paths = {
      styles: './css/src/main.css'
    };

    gulp.task('styles', function () {
      var processors = [
        cssimport,
        postcss_mixins,
        autoprefixer,
        nested,
        color_function,
        custom_properties,
        custom_media
      ];
      return gulp.src(paths.styles)
        .pipe(postcss(processors))
        .pipe(rename('app.min.css'))
        .pipe(postcss([csswring]))
        .pipe(gulp.dest('./css/'));
    });

    // The default task (called when you run `gulp` from cli)
    gulp.task('default', ['styles']);
