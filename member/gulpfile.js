var gulp = require('gulp'),
	path = require('path');


var	less = require('gulp-less');

var autoprefixer = require('gulp-autoprefixer');
	// LessPluginAutoPrefix = require('less-plugin-autoprefix'),
    // autoprefix = new LessPluginAutoPrefix({ browsers: ["last 2 versions"] });

	// browser-sync
var	browserSync = require('browser-sync').create(),
	reload = browserSync.reload;


gulp.task('default', function() {
	browserSync.init({
		server: {
			baseDir: 'src'
		}
	});
	gulp.watch('less/*.less', ["styles"]);
	gulp.watch("src/view/*.html").on("change", reload);
	gulp.watch("src/less/*.css").on("change", reload);
	gulp.watch("src/images/*.jpg").on("change", reload);
	gulp.watch("src/images/*.png").on("change", reload);
});


gulp.task('styles', function() {
	return gulp.src('./less/*.less')
		.pipe(less())
		.pipe(autoprefixer({
			browsers: ['last 2 versions'],
			cascade: false
		}))
		.pipe(gulp.dest('./src/less'));
});