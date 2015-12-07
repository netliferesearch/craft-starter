var gulp = require('gulp')
var sass = require('gulp-sass')
var plumber = require('gulp-plumber')
var watchify = require('watchify')
var babelify = require('babelify')
var browserify = require('browserify')
var source = require('vinyl-source-stream')
var gutil = require('gulp-util')
var _ = require('lodash')
var purge = require('gulp-css-purge')
var minify = require('gulp-minify-css')
var sourcemaps = require('gulp-sourcemaps')
var autoprefixer = require('gulp-autoprefixer')
var inlineAssets = require('gulp-inline-base64')
var browserSync = require('browser-sync').create()

var dir = {
  dist: 'public'
}

var browserifyOpts = _.assign({}, watchify.args, {
  entries: dir.dist + '/js/main.js',
  debug: true
})

var b = watchify(browserify(browserifyOpts))
b.on('update', buildJs).on('log', gutil.log)

function buildJs () {
  return b.transform(babelify).bundle()
    .on('error', gutil.log.bind(gutil, 'Browserify Error'))
    .pipe(source('dist.js'))
    .pipe(gulp.dest(dir.dist + '/js'))
}

gulp.task('js', buildJs)

gulp.task('sass', function () {
  return gulp.src('style.scss')
    .pipe(plumber())
    .pipe(sass().on('error', sass.logError))
    .pipe(plumber.stop())
    .pipe(inlineAssets({
      baseDir: dir.dist,
      debug: true
    }))
    .pipe(autoprefixer({
      browsers: ['last 2 versions'],
      cascade: true
    }))
    .pipe(gulp.dest(dir.dist))
})

gulp.task('prod-sass', function () {
  return gulp.src(dir.dist + '/style.css')
    .pipe(purge())
    .pipe(sourcemaps.init())
    .pipe(minify())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(dir.dist))
})

gulp.task('browser-sync', function() {
    browserSync.init({
        proxy: "craft.dev:8080"
    })
})

gulp.task('watch', function () {
  gulp.watch(['style.scss', 'scss/*.scss'], ['sass'])
})

gulp.task('default', ['sass', 'js', 'watch'])
