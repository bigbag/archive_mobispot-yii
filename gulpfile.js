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
    gulp.src('app/tmp', {read: false})
    .pipe(clean());

    gulp.src([
        'themes/mobispot/css/reset.css',
        'themes/mobispot/css/style.css',
        'themes/mobispot/css/front-page-slider.css',
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

    gulp.src([
        'themes/mobile/css/style.css'
    ])
    .pipe(rename('style_mobile_view.min.css'))
    .pipe(minifyCSS())
    .pipe(gulp.dest('themes/mobile/css/'));

    gulp.src([
        'themes/mobispot/css/mobile-style.css',
        'themes/mobispot/css/mobile-add.css'
    ])
    .pipe(rename('style_mobile.min.css'))
    .pipe(minifyCSS())
    .pipe(gulp.dest('themes/mobispot/css/'));

});

gulp.task('js', function() {
    gulp.src([
        'themes/mobispot/js/script.js',
        'themes/mobispot/js/script-add.js',
        'themes/mobispot/js/scrollIt.min.js'
    ])
    .pipe(concat('script.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest(jsPath));

});

gulp.task('default', ['css', 'js']);