// Подключаем Gulp и все необходимые библиотеки
var gulp           = require('gulp'),
		gutil          = require('gulp-util' ),
		sass           = require('gulp-sass'),
		browserSync    = require('browser-sync'),
		cleanCSS       = require('gulp-clean-css'),
		autoprefixer   = require('gulp-autoprefixer'),
		bourbon        = require('node-bourbon'),
		ftp            = require('vinyl-ftp'),
		rename         = require('gulp-rename'),
		svgstore       = require('gulp-svgstore'),
		cache          = require('gulp-cache');

// Обновление страниц сайта на локальном сервере
gulp.task('browser-sync', function() {
	browserSync({
		proxy: "toko.loc",
		notify: false
	});
});

// Компиляция stylesheet.css
gulp.task('sass', function() {
	return gulp.src('catalog/view/theme/tokostyle/stylesheet/stylesheet.sass')
		.pipe(sass({
			includePaths: bourbon.includePaths
		}).on('error', sass.logError))
		.pipe(autoprefixer(['last 20 versions']))
		.pipe(cleanCSS())
		.pipe(gulp.dest('catalog/view/theme/tokostyle/stylesheet/'))
		.pipe(browserSync.reload({stream: true}))
});

gulp.task('sprite', function() {
	return gulp.src('catalog/view/theme/tokostyle/image/icon-*.svg')
	.pipe(svgstore({
		inlineSvg: true
		}))
	.pipe(rename('sprite.svg'))
	.pipe(gulp.dest('catalog/view/theme/tokostyle/image'));
	});

// Наблюдение за файлами
gulp.task('watch', ['sass', 'browser-sync'], function() {
	gulp.watch('catalog/view/theme/tokostyle/stylesheet/stylesheet.sass', ['sass']);
	gulp.watch('catalog/view/theme/tokostyle/template/**/*.twig', browserSync.reload);
	gulp.watch('catalog/view/theme/tokostyle/js/**/*.js', browserSync.reload);
	gulp.watch('catalog/view/theme/tokostyle/libs/**/*', browserSync.reload);
});

// Выгрузка изменений на хостинг
gulp.task('deploy', function() {
	var conn = ftp.create({
		host:      'ftp46.hostia.name',
		user:      'job.zerrocull@zerrocull.ru',
		password:  'mGCX9ss9',
		parallel:  10,
		log: gutil.log
	});
	var globs = [
	'catalog/view/theme/tokostyle/**'
	];
	return gulp.src(globs, {buffer: false})
	.pipe(conn.dest('/path/to/folder/on/server'));
});


gulp.task('default', ['watch']);
