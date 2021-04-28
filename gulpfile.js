var syntax        = 'scss', // выберете используемый синтаксис sass или scss, и перенастройте нужные пути в файле gulp.js и папки в вашего шаблоне wp
		gulpversion   = '4'; // Выберете обязателньо свою версию Gulp: 3 или 4

var gulp          = require('gulp'),
	proxy         = 'learn.wp.loc',
	themename     = 'hitmark-theme',
    autoprefixer  = require('gulp-autoprefixer'),
    browsersync   = require('browser-sync'),
    concat        = require('gulp-concat'),
    cache         = require('gulp-cache'),
    cleancss      = require('gulp-clean-css'),
	pngquant      = require('imagemin-pngquant'),
	mozjpeg       = require('imagemin-mozjpeg'),
	imagemin      = require('gulp-imagemin'),
	notify        = require('gulp-notify'),
	gutil         = require('gulp-util' ),
	rename        = require('gulp-rename'),
	sass          = require('gulp-sass'),
	sourcemaps    = require('gulp-sourcemaps'),
	uglify        = require('gulp-uglify-es').default;

	
// Незабываем менять 'wp-gulp.loc' на свой локальный домен
gulp.task('browser-sync', function() {
	browsersync({
		proxy: proxy,
		notify: false,
		// open: false,
		// tunnel: true,
		// tunnel: "gulp-wp-fast-start", //Demonstration page: http://gulp-wp-fast-start.localtunnel.me
	})
});


// Обьединяем файлы sass, сжимаем и переменовываем
gulp.task('styles', function() {
	return gulp.src('./wp-content/themes/'+ themename +'/dev/sass/**/*.scss')
	.pipe(sourcemaps.init())
	.pipe(sass({ outputStyle: 'expand' }).on("error", notify.onError()))
	.pipe(rename({ suffix: '.min', prefix : '' }))
	.pipe(concat('custom-style.css'))
	.pipe(autoprefixer(['last 15 versions']))
	.pipe(cleancss( {level: { 1: { specialComments: 0 } } })) // Opt., comment out when debugging
	.pipe(sourcemaps.write())
	.pipe(gulp.dest('./wp-content/themes/'+ themename +'/css'))
	.pipe(browsersync.stream())
});


// Обьединяем файлы скриптов, сжимаем и переменовываем
gulp.task('scripts', function() {
	return gulp.src([
		'./wp-content/themes/'+ themename +'/dev/js/index.js',
		'./wp-content/themes/'+ themename +'/dev/js/libs/jquery.formstyler.min.js', // Connecting my scripts
		'./wp-content/themes/'+ themename +'/dev/js/libs/jquery.fancybox.min.js', // Connecting my scripts
		'./wp-content/themes/'+ themename +'/dev/js/common.js', // Always at the end
		])
	.pipe(concat('scripts.min.js'))
	.pipe(uglify()) // Mifify js (opt.)
	.pipe(gulp.dest('./wp-content/themes/'+ themename +'/js'))
	.pipe(browsersync.reload({ stream: true }))
});


// сжимаем картинки в папке images в шаблоне, и туда же возвращаем в готовом виде gulp imgmin-theme
gulp.task('imgmin-theme', function() {
	return gulp.src('./wp-content/themes/'+ themename +'/img/**/*')
	.pipe(cache(imagemin())) // Cache Images
	.pipe(gulp.dest('./wp-content/themes/'+ themename +'/img'));
});


// сжимаем картинки в папке uploads, и туда же возвращаем в готовом виде gulp imgmin-uploads
gulp.task('imgmin-uploads', function() {
	return gulp.src('./wp-content/uploads/**/*')
	.pipe(imagemin([
		mozjpeg({quality: 80}),
		// pngquant({quality: [0.5, 0.5]}),
	],
		{
			interlaced: true,
			progressive: true,
			svgoPlugins: [{removeViewBox: false}],
			verbose: true
		}
	)) // Cache Images
	.pipe(gulp.dest('./wp-content/uploads'));
});

if (gulpversion == 3) {
  gulp.task('watch', ['styles', 'scripts', 'browser-sync'], function() {
	  gulp.watch(['./wp-content/themes/'+ themename +'/dev/sass/**/*.scss'], ['styles']); // Наблюдение за sass файлами в папке sass в теме
	  gulp.watch(['./wp-content/themes/'+ themename +'/dev/js/**/*.js', './wp-content/themes/'+ themename +'/dev-js/common.js'], ['scripts']); // Наблюдение за JS файлами js в теме
    gulp.watch('src/wp-content/themes/'+  themename +'/**/*.php', browsersync.reload) // Наблюдение за sass файлами php в теме
  });
  gulp.task('default', ['watch']);
}


if (gulpversion == 4) {
	gulp.task('watch', function() {
		gulp.watch(['./wp-content/themes/'+ themename +'/dev/sass/**/*.scss'], gulp.parallel('styles')); // Наблюдение за sass файлами в папке sass в теме
		gulp.watch(['src/wp-content/themes/'+ themename +'/dev/js/**/*.js', './wp-content/themes/'+ themename +'/dev/js/common.js'], gulp.parallel('scripts')); // Наблюдение за JS файлами в папке js
    gulp.watch('src/wp-content/themes/'+ themename +'/**/*.php', browsersync.reload) // Наблюдение за sass файлами php в теме
	});
	gulp.task('default', gulp.parallel('styles', 'scripts', 'watch'));
}
