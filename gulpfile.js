const { parallel, src, dest } = require('gulp');
const concat = require('gulp-concat');
var sass = require('gulp-sass')(require('sass'));

/**
 * Stylesheet
 */

exports.default = parallel(cssLibs, cssGlobal, jsLibs, jsGlobal, allImages, allFonts);

function cssLibs() {
  return src([
    'resources/assets/css/bootswatch.min.css',
    'resources/assets/css/font-awesome.min.css',
  ])
    .pipe(concat('libs.css'))
    .pipe(dest('public/css'));
};

function cssGlobal() {
  return src('resources/assets/sass/global.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(dest('public/css'));
};


/**
 * Scripts
 */

function jsLibs() {
  return src([
    'resources/assets/js/libs/jquery-2.1.4.min.js',
    'resources/assets/js/libs/bootstrap.min.js',
	'resources/assets/js/libs/jquery.bxslider.min.js',
	'resources/assets/js/libs/sweetalert.min.js',
  ])
    .pipe(concat('libs.js'))
    .pipe(dest('public/js'));
}

function jsGlobal() {
  return src([
    'resources/assets/js/script.js',
    'resources/assets/js/script_admin.js',
  ])
    .pipe(concat('global.js'))
    .pipe(dest('public/js'));
}

/**
 * Images
 */

function allImages() {
  return src('resources/assets/images/*')
	.pipe(dest('public/images'));
}

/**
 * Fonts
 */

function allFonts() {
  return src('resources/assets/fonts/*')
	.pipe(dest('public/fonts'));
}
