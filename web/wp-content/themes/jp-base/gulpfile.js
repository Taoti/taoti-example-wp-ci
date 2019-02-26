// Just run `gulp` - it will compile everything and start the watch module.

// Config for theme
var themePath = './';

// Gulp Nodes
var gulp = require( 'gulp' ),
	watch = require( 'gulp-watch' ),
	cleanCSS = require('gulp-clean-css'),
	uglify = require( 'gulp-uglify' ),
	rename = require( 'gulp-rename' ),
	notify = require( 'gulp-notify' ),
	autoprefixer = require('gulp-autoprefixer'),
	concat = require('gulp-concat'),
	image = require('gulp-image'),
	sourcemaps = require('gulp-sourcemaps'),
	newer = require('gulp-newer'),
	sass = require('gulp-sass');

sass.compiler = require('node-sass');

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

	return gulp.src( args.path )
	    .pipe( sass().on('error', sass.logError) )
		// 	.pipe( sourcemaps.init() )
		.pipe( autoprefixer(['last 4 versions', 'iOS 7']) )
		.pipe( cleanCSS({rebase:false}) )
		.pipe( rename({suffix: '.min' }) )
		// .pipe( sourcemaps.write() )
	    .pipe( gulp.dest( args.destination ) )
		.pipe( notify({ message: args.messageComplete + ' <%= file.relative %>' }) );

}

// All the main SCSS files that will be compiled into styles/css/
gulp.task('scss', function () {
	var args = {
		path: [
			themePath + 'styles/scss/admin/style-tinymce.scss', // TinyMCE WYSIWYG editor.
			themePath + 'styles/scss/admin/style-login.scss', // the login page
			themePath + 'styles/scss/admin/style-admin.scss', // the WP Dashboard
			themePath + 'styles/style-noncritical.scss', // noncritical CSS files
			themePath + 'styles/style-critical.scss', // critical CSS files
		],
		messageComplete: 'Scss task complete for',
		destination: themePath + 'styles/css/'
	};
	return jpProcessCSS(args);
});

// Further SASS files that need to be loaded as critical CSS, but they only get loaded on specific templates.
gulp.task('scss-other-criticals', function () {
	var args = {
		path: [
			themePath + 'styles/scss/critical/*.scss',
		],
		messageComplete: 'Scss task complete.',
		destination: themePath + 'styles/css/critical/'
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
		.pipe(image({
			pngquant: true,
			optipng: false,
			zopflipng: true,
			jpegRecompress: false,
			mozjpeg: true,
			guetzli: false,
			gifsicle: true,
			svgo: true,
			concurrent: 10,
			quiet: true // defaults to false
	    }))
		.pipe(gulp.dest(themePath + 'images'))
		.pipe(notify({ message: 'Images task complete' }));
});

// Watch task -- this runs on every file save.
gulp.task( 'watch', function() {

	gulp.watch(
		[
			themePath + 'styles/*.scss',
			themePath + 'styles/scss/*.scss',
			themePath + 'modules/*/scss/**/*.scss',
			themePath + 'styles/scss/admin/*.scss',
		],
		gulp.series([ 'scss', 'scss-other-criticals' ]) // Sometimes there are critical scss files in the modules directory, so they will trigger this watch block. Hence, run the 'scss-other-criticals' here as well.
	);

	gulp.watch(
		[ themePath + 'styles/scss/critical/*.scss' ],
		gulp.series([ 'scss-other-criticals' ])
	);

	// Watch all .scss files
	// gulp.watch( themePath + '**/**/*.scss', [ 'scss' ] );

	// Watch js files
	gulp.watch(
		[
			themePath + 'js/development/**/*.js',
			themePath + 'modules/*/js/*.js'
		],
		gulp.series([ 'scripts' ])
	);

	// Watch img Files
	gulp.watch(
		[ themePath + 'images/uncompressed/**' ],
		gulp.series([ 'images' ])
	);

});


// Default task -- runs scss and watch functions
gulp.task( 'default', gulp.series(['images', 'scripts', 'scss', 'scss-other-criticals', 'watch']), function() {
});
