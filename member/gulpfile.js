var gulp = require('gulp'),
	less = require('gulp-less'),
	autoprefixer = require('gulp-autoprefixer'),
	browserSync = require('browser-sync').create(),

	reload = browserSync.reload;


gulp.task('default', function() {
	browserSync.init({
		server: {
			baseDir: './'
		}
	});
	gulp.watch('public/css/*.less', ["styles"]);
	gulp.watch("view/*.html").on("change", reload);
	gulp.watch("public/css/*.css").on("change", reload);
	gulp.watch("public/img/*.jpg").on("change", reload);
	gulp.watch("public/img/*.png").on("change", reload);
});


gulp.task('styles', function() {
	return gulp.src('./public/css/*.less')
		.pipe(less())
		.pipe(autoprefixer({
			cascade: false
		}))
		.pipe(gulp.dest('./public/css'));
});