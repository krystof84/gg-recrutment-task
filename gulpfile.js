var gulp = require('gulp'),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    autoprefixer = require('gulp-autoprefixer'),
    livereload = require('gulp-livereload');


gulp.task('sass', function() {
  return gulp.src('./src/scss/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({
      browsers: ['last 3 versions']
    }))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./src/css'))
    .pipe(livereload());
});

gulp.task('watch', function () {
  livereload.listen(35729);
  gulp.watch('./src/scss/**/*.scss', ['sass']);

  gulp.watch('./**/*.php').on('change', function(file) {
    livereload.changed(file.path);
  });
});

gulp.task('default', ['watch']);