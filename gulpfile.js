var gulp = require('gulp'),
    sequence = require('gulp-sequence'),
    zip = require('gulp-zip'),
    del = require('del');

gulp.task('copy', function() {
  return gulp.src(['./src/**/*'])
    .pipe(gulp.dest('build/sqweb-sdk-php'));
});

gulp.task('zip', function() {
  return gulp.src(['./build/sqweb-sdk-php/**/*'], {base : "./build"})
    .pipe(zip('sqweb-sdk-php.zip'))
    .pipe(gulp.dest('dist'));
});

gulp.task('clean', function() {
  return del(['build/']);
});

gulp.task('keep-build', sequence('copy', 'zip'));

gulp.task('default', sequence('copy', 'zip', 'clean'));