
// Config for theme
var themePath = '';

// Gulp Nodes
var gulp = require( 'gulp' ),
	watch = require( 'gulp-watch' ),
	cleanCSS = require('gulp-clean-css'),
	uglify = require( 'gulp-uglify' ),
	rename = require( 'gulp-rename' ),
	notify = require( 'gulp-notify' ),
	sass = require( 'gulp-ruby-sass' ),
	autoprefixer = require('gulp-autoprefixer'),
	concat = require('gulp-concat'),
	imagemin = require('gulp-imagemin'),
	sourcemaps = require('gulp-sourcemaps'),
	newer = require('gulp-newer');

// Error Handling
var onError = function( err ) {
	console.log( 'An error occurred:', err.message );
	this.emit( 'end' );
};

// A helper function for the tasks to use.
// It processes .scss files to create a sourcemap, add browser prefixes, and minify the SASS into CSS.
// The parameter args should be an object with two properties: path and messageComplete.
// path (string) is the path to the .scss file.
// messageComplete (string) is the message you want to display in the terminal when the task is complete.
function jpProcessCSS(args){
	return sass( args.path )
		.on( 'error', sass.logError )
		.pipe( sourcemaps.init() )
		.pipe( autoprefixer(['last 4 versions', 'iOS 7']) )
		.pipe( cleanCSS() )
		.pipe( rename({suffix: '.min' }) )
		.pipe( sourcemaps.write() )
		.pipe( gulp.dest( themePath + 'styles/css/' ) )
		.pipe( notify({ message: args.messageComplete }) );
}

// Bundle the critical CSS files.
gulp.task('scss-critical', function () {
	var args = {
		path: themePath + 'styles/style-critical.scss',
		messageComplete: 'Critical SCSS task complete.'
	};
	return jpProcessCSS(args);
});

// Bundle the noncritical CSS files.
gulp.task('scss-noncritical', function () {
	var args = {
		path: themePath + 'styles/style-noncritical.scss',
		messageComplete: 'Noncritical SCSS task complete.'
	};
	return jpProcessCSS(args);
});

// Bundle styles to be used on the Dashboard.
gulp.task('scss-admin', function () {
	var args = {
		path: themePath + 'styles/scss/admin/style-admin.scss',
		messageComplete: 'Scss-admin task complete.'
	};
	return jpProcessCSS(args);
});

// Bundle styles for the login page.
gulp.task('scss-login', function () {
	var args = {
		path: themePath + 'styles/scss/admin/style-login.scss',
		messageComplete: 'Scss-login task complete.'
	};
	return jpProcessCSS(args);
});

// Bundle styles for the TinyMCE WYSIWYG editor.
gulp.task('scss-tinymce', function () {
	var args = {
		path: themePath + 'styles/scss/admin/style-tinymce.scss',
		messageComplete: 'Scss-tinymce task complete.'
	};
	return jpProcessCSS(args);
});


// The order in which the JS files are concatenated is as follows:
//     1. Every JS file within the js/development/before-libs/ folder.
//     2. Every JS file within the js/development/libs/ folder.
//     3. Every JS file within the js/development/after-libs/ folder.
//     4. Every JS file within the modules/ folder (searches through sub-folders).
//
// In this way, you can set up any JS that needs to happen before libraries are loaded (like configs). Then it after it loads the libraries, you can set up JS that is dependent on those libraries.
gulp.task('scripts', function() {
	return gulp.src([
			themePath + 'js/development/before-libs/*.js',
			themePath + 'js/development/libs/**/*.js',
			themePath + 'js/development/after-libs/*.js',
			themePath + 'modules/*/js/*.js'
		])
		.pipe(concat('js/scripts.js'))
		.pipe(gulp.dest(themePath))
		.pipe(rename({suffix: '.min'}))
		.pipe(uglify())
		.pipe(gulp.dest(themePath))
		.pipe(notify({ message: 'Scripts task complete' }));
});

// Compress all images in the uncompressed folder.
gulp.task('images', function() {
	return gulp.src(themePath + 'images/uncompressed/*')
		.pipe(newer(themePath + 'images'))
		.pipe(imagemin({ optimizationLevel: 3, progressive: true, interlaced: true }))
		.pipe(gulp.dest(themePath + 'images'))
		.pipe(notify({ message: 'Images task complete' }));
});

// Watch task -- this runs on every file save.
gulp.task( 'watch', function() {

	gulp.watch(
		[
			themePath + 'styles/*.scss',
			themePath + 'styles/scss/*.scss',
			themePath + 'modules/*/scss/*.scss'
		],
		[
			'scss-critical',
			'scss-noncritical'
		]
	);

	gulp.watch( themePath + 'styles/scss/admin/style-admin.scss', ['scss-admin'] );

	gulp.watch( themePath + 'styles/scss/admin/style-login.scss', ['scss-login'] );

	gulp.watch( themePath + 'styles/scss/admin/style-tinymce.scss', ['scss-tinymce'] );

	// Watch all .scss files
	// gulp.watch( themePath + '**/**/*.scss', [ 'scss-critical', 'scss-noncritical', 'scss-admin', 'scss-login', 'scss-tinymce' ] );

	// Watch js files
	gulp.watch( [themePath + 'js/development/**/*.js', themePath + 'modules/*/js/*.js'], [ 'scripts' ] );

	// Watch img Files
	gulp.watch( themePath + 'images/uncompressed/**', [ 'images' ] );

});


// Default task -- runs scss and watch functions
gulp.task( 'default', ['images', 'scripts', 'scss-critical', 'scss-noncritical', 'scss-admin', 'scss-login', 'scss-tinymce', 'watch'], function() {
});
