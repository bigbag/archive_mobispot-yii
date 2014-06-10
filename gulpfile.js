var gulp = require('gulp'), // Сообственно Gulp JS
    minifyCSS = require('gulp-minify-css'), // Минификация CSS
    uglify = require('gulp-uglify'), // Минификация JS
    notify = require('gulp-notify'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    clean = require('gulp-clean'),
    cssPath = 'themes/mobispot/css/',
    jsPath = 'themes/mobispot/js/',
    tmpPath = 'tmp';

gulp.task('css', function() {
    gulp.src([
        'themes/mobispot/css/style.css',
        'themes/mobispot/css/a-slider.css'
    ])
    .pipe(rename('style.min.css'))
    .pipe(minifyCSS())
    .pipe(gulp.dest(tmpPath));

    gulp.src([
        'themes/mobispot/css/add.css',
    ])
    .pipe(rename('add.min.css'))
    .pipe(minifyCSS())
    .pipe(gulp.dest(tmpPath));

    gulp.src([
        'themes/mobispot/css/foundation3/foundation.min.css', 
        'themes/mobispot/css/foundation_actual/foundation.min.css', 
        'tmp/style.min.css',
        'tmp/add.min.css'
    ])
    .pipe(concat('all.min.css'))
    .pipe(gulp.dest(cssPath));

});

gulp.task('js', function() {
    gulp.src([
        'themes/mobispot/js/script.js', 
        'themes/mobispot/js/script-add.js', 
    ])
    .pipe(concat('script.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest(jsPath));

});

gulp.task('default', ['css', 'js']);