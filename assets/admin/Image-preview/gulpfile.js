'use strict';

// -----------------------------------------------------------------------------
// Modules
// -----------------------------------------------------------------------------

var autoprefixer = require('gulp-autoprefixer');
var browserSync = require('browser-sync').create();
var cleanCss = require('gulp-clean-css');
var del = require('del');
var gulp = require('gulp');
var header = require('gulp-header');
var jshint = require('gulp-jshint');
var less = require('gulp-less');
var pkg = require('./package.json');
var plumber = require('gulp-plumber');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');

// -----------------------------------------------------------------------------
// Configuration
// -----------------------------------------------------------------------------

var headerText = [
    '/**',
    ' * <%= pkg.name %> v<%= pkg.version %>',
    ' * <%= pkg.homepage %>',
    ' * Copyright 2016 <%= pkg.author %>',
    ' * Released under the <%= pkg.license %> license',
    ' */',
    '\n'
].join('\n');

var errorHandler = function(error) {
    console.log(error.message);
    this.emit('end');
};

// -----------------------------------------------------------------------------
// Tasks
// -----------------------------------------------------------------------------

gulp.task('browser-sync:init', function() {
    browserSync.init({
        server: {
            baseDir: './'
        }
    });
});

gulp.task('jshint', function() {
    return gulp.src('src/js/**/*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'))
        .pipe(jshint.reporter('fail'));
});

gulp.task('browser-sync:reload', function() {
    browserSync.reload();
});

gulp.task('build:css', function() {
    return gulp.src('src/less/main.less')
        .pipe(plumber({ errorHandler: errorHandler }))
        .pipe(less())
        .pipe(autoprefixer('last 3 versions'))
        .pipe(header(headerText, { pkg: pkg }))
        .pipe(rename({
            basename: 'bootstrap-imageupload',
            extname: '.css',
        }))
        .pipe(gulp.dest('dist/css'))
        .pipe(cleanCss())
        .pipe(header(headerText, { pkg: pkg }))
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('dist/css'));
});

gulp.task('build:js', ['jshint'], function() {
    return gulp.src('src/js/main.js')
        .pipe(plumber({ errorHandler: errorHandler }))
        .pipe(header(headerText, { pkg: pkg }))
        .pipe(rename({
            basename: 'bootstrap-imageupload',
            extname: '.js',
        }))
        .pipe(gulp.dest('dist/js'))
        .pipe(uglify())
        .pipe(header(headerText, { pkg: pkg }))
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('dist/js'));
});

gulp.task('build', ['build:css', 'build:js']);

gulp.task('clean:css', function() {
    return del(['dist/css/**/*.css']);
});

gulp.task('clean:js', function() {
    return del(['dist/js/**/*.js']);
});

gulp.task('clean', ['clean:css', 'clean:js']);

gulp.task('watch', ['browser-sync:init'], function() {
    gulp.watch('index.html', ['browser-sync:reload']);
    gulp.watch('src/less/**/*.less', ['build:css', 'browser-sync:reload']);
    gulp.watch('src/js/**/*.js', ['build:js', 'browser-sync:reload']);
});

gulp.task('default', ['build', 'watch']);
