'use strict';

/***********************************************************************************************************************
 * Path and file naming settings
 **********************************************************************************************************************/
require('events').EventEmitter.prototype._maxListeners = 400;

var build_dir = '../../../public';
var src_dir = './';

var scss_base_style_file_name = 'base-style.scss';
var scss_main_file_name = 'style.scss';
var css_main_file_name = ['style.css', 'base-style.css'];
var sprite_img_file_name = '../img/sprites/sprite.png';
var sprite_scss_file_name = '_sprite.scss';
var zip_file_name = 'build.zip';
var changeFile = require('./fileModification');

function replaceFile(action) {
    let changingScripts =  new changeFile(action);
    changingScripts.init();
    return changingScripts;
}
function replaceAllFileInBlade(done) {
    replaceFile(['styles']);
    done();
}
function replaceBaseStylesInBlade(done) {
    // replaceFile('baseStyles');
    done();
}

var path = {
    build: {
        css: build_dir + '/css/',
        js: build_dir + '/js/',
        img: build_dir + '/img/',
        fonts: build_dir + '/fonts/',
        sprite_scss: src_dir + '/sass/4_common',
        zip: build_dir + '/',
    },
    src: {
        css: [src_dir + 'sass/' + scss_main_file_name,  src_dir + 'sass/' + scss_base_style_file_name],
        img: build_dir + '/img/**/*.*',
        js: [src_dir + 'js/libs.js', src_dir + 'js/script.js'],
        fonts: src_dir + 'fonts/*.ttf',
        sprites: src_dir + 'img/sprites/*.*',
        zip: [build_dir + '/**', '!' + build_dir + '/_gulp-builder/node_modules/**'],
    },
    watch: {
        css: src_dir + '/sass/**/*.*',
        img: src_dir + '/img/**/*.*',
        fonts: src_dir + '/fonts/**/*.*',
        sprite: src_dir + '/img/sprites/*.*'
    },
    clean: build_dir + '/'
};


/***********************************************************************************************************************
 * Plugins
 **********************************************************************************************************************/

var gulp = require('gulp');
var gulpIf = require('gulp-if');
const debug = require('gulp-debug');
const { series, parallel } = require('gulp');
var webpack = require('webpack-stream');
var plugins = {
    'sass': require('gulp-sass'),
    'prefixer': require('gulp-autoprefixer'),
    'rename': require('gulp-rename'),
    'cssmin': require('gulp-clean-css'),
    'sourcemaps': require('gulp-sourcemaps'),
    'spritesmith': require('gulp.spritesmith'),
    'buffer': require('vinyl-buffer'),
    'imagemin': import('gulp-imagemin'),
    'mergeStream': require('merge-stream'),
    'ttf2woff': require('gulp-ttf2woff'),
    'ttf2eot': require('gulp-ttf2eot'),
    'plumber': require('gulp-plumber'),
    'pngquant': require('imagemin-pngquant'),
    'watch': require('gulp-watch'),

    'uglify': require('gulp-uglify'),
    'rimraf': require('rimraf'),

    'zip': require('gulp-zip'),
    // 'inlinesource': require('gulp-inline-source'),
};

/***********************************************************************************************************************
 * Tasks registration
 **********************************************************************************************************************/

/***********************************************************************************************************************
 * Task: Sprite
 ***********************************************************************************************************************
 *
 * Concatenates images in one sprite image and generate .scss file sprite mixins
 *
 **********************************************************************************************************************/

gulp.task('sprite', function() {
    return gulp.src(path.src.sprites)
        .pipe(plugins.spritesmith({
            imgName: sprite_img_file_name, // Image file
            cssName: sprite_scss_file_name, // CSS file
            cssVarMap: function(sprite) {
                sprite.name = 's-' + sprite.name;
            }
        }))
        .pipe(gulpIf('*.png', gulp.dest(path.build.img)))
        .pipe(gulpIf('*.scss', gulp.dest(path.build.sprite_scss)));
});


/***********************************************************************************************************************
 * Task: CSS
 ***********************************************************************************************************************
 *
 * Compiles .scss files to css. Adds vendor prefixes and minimizes
 *
 **********************************************************************************************************************/

gulp.task('css:build', function(cb) {
    parallel(
        'cssBase:build',
        'cssStyle:build',
        replaceAllFileInBlade
    )(cb)
});

gulp.task('cssBase:build', function() {
    return gulp.src(path.src.css[1])
        .pipe(plugins.sass().on('error', plugins.sass.logError))
        .pipe(plugins.prefixer())
        .pipe(plugins.rename('dist.' + css_main_file_name[1]))
        .pipe(gulp.dest(path.build.css))
        .pipe(plugins.cssmin())
        .pipe(plugins.rename(css_main_file_name[1]))
        .pipe(gulp.dest(path.build.css));
});

gulp.task('cssStyle:build', function() {
    return gulp.src(path.src.css[0])
        .pipe(plugins.sass().on('error', plugins.sass.logError))
        .pipe(plugins.prefixer())
        .pipe(plugins.rename('dist.' + css_main_file_name[0]))
        .pipe(gulp.dest(path.build.css))
        .pipe(plugins.cssmin())
        .pipe(plugins.rename(css_main_file_name[0]))
        .pipe(gulp.dest(path.build.css));
});

gulp.task('css:dev', function(cb) {
    parallel(
        'cssBase:dev',
        'cssStyle:dev',
        replaceBaseStylesInBlade
    )(cb)
});

gulp.task('cssBase:dev', function() {
    return gulp.src(path.src.css[1])
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.sass().on('error', plugins.sass.logError))
        .pipe(plugins.prefixer())
        .pipe(plugins.cssmin())
        .pipe(plugins.rename(css_main_file_name[1]))
        .pipe(plugins.sourcemaps.write())
        .pipe(gulp.dest(path.build.css));
});
gulp.task('cssStyle:dev', function() {
    return gulp.src(path.src.css[0])
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.sass().on('error', plugins.sass.logError))
        .pipe(plugins.prefixer())
        .pipe(plugins.cssmin())
        .pipe(plugins.rename(css_main_file_name[0]))
        .pipe(plugins.sourcemaps.write())
        .pipe(gulp.dest(path.build.css));
});

/***********************************************************************************************************************
 * Task: Webpack
 ***********************************************************************************************************************
 *
 * Run webpack
 *
 **********************************************************************************************************************/

gulp.task('js:build', function() {
    process.env.NODE_ENV = 'prod';

    // Replacing hash for build
    replaceFile('scripts');

    return gulp.src(path.src.js)
        .pipe(webpack( require('./webpack.config.js') ))
        .pipe(gulp.dest(path.build.js));
});

gulp.task('js', function() {
    process.env.NODE_ENV = 'dev';
    return gulp.src(path.src.js)
        .pipe(webpack( require('./webpack.config.js') ))
        .pipe(gulp.dest(path.build.js));
});

/***********************************************************************************************************************
 * Task: Test by karma
 ***********************************************************************************************************************
 *
 * Run test files
 *
 **********************************************************************************************************************/
/**
 * Run test once and exit
 */
// gulp.task('test', function (done) {
//     new Server({
//         configFile: __dirname + '/karma.config.js',
//         singleRun: true
//     }, done).start();
// });


/***********************************************************************************************************************
 * Task: Img
 ***********************************************************************************************************************
 *
 * Compress .png and .jpg files
 *
 **********************************************************************************************************************/

gulp.task('img:build', function() {
    return gulp.src([path.src.img, '!' + path.src.sprites])
        .pipe(plugins.plumber())
        .pipe(plugins.imagemin(
            {
                interlaced: true,
                progressive: true,
                optimizationLevel: 3,
                svgoPlugins: [{
                    removeViewBox: false
                }],
                use: [plugins.pngquant()]
            }))
        .pipe(gulp.dest(path.build.img));
});
//
// gulp.task('img:dev', function() {
//     gulp.src([path.src.img, '!' + path.src.sprites])
//         .pipe(gulp.dest(path.build.img))
// });

/***********************************************************************************************************************
 * Task: Fonts
 ***********************************************************************************************************************
 *
 * Generate .eot and .woff files frome one .ttf file.
 * Reacts on .ttf only
 *
 **********************************************************************************************************************/
gulp.task('fonts', function() {
    return plugins.mergeStream(
        gulp.src(path.src.fonts)
            .pipe(gulp.dest(path.build.fonts))
            .pipe(plugins.ttf2eot())
            .pipe(gulp.dest(path.build.fonts)),
        gulp.src(path.src.fonts)
            .pipe(plugins.ttf2woff())
            .pipe(gulp.dest(path.build.fonts))
        )
});

/***********************************************************************************************************************
 * Task: Jshint
 ***********************************************************************************************************************
 *
 * Сhecks js code for correctness
 *
 *
 **********************************************************************************************************************/


// gulp.task('lint', function() {
//   return gulp.src(path.src.lint)
//     .pipe(plugins.jshint())
//     .pipe(plugins.jshint.reporter(plugins.stylish));
// });



/***********************************************************************************************************************
 * Task: ZIP
 ***********************************************************************************************************************
 *
 * Compress build path in .zip file.
 * Use for deploying preparing
 *
 **********************************************************************************************************************/
//
// gulp.task('zip', function() {
//     return gulp.src(path.src.zip)
//         .pipe(plugins.plumber())
//         .pipe(plugins.zip(zip_file_name))
//         .pipe(gulp.dest(path.build.zip));
// });

/***********************************************************************************************************************
 * Task: Clean
 ***********************************************************************************************************************
 *
 * Cleans build directory
 *
 **********************************************************************************************************************/
//
// gulp.task('clean', function(cb) {
//     plugins.rimraf(path.clean, cb);
// });

/***********************************************************************************************************************
 * Task: Build
 ***********************************************************************************************************************
 *
 * Run all task in build mode. Prepare all for production
 *
 **********************************************************************************************************************/

gulp.task('build', series(
    'sprite', parallel(
    'css:build',
    'fonts',
    'img:build',
    'js:build'
    )
));


/***********************************************************************************************************************
 * Task: Build
 ***********************************************************************************************************************
 *
 * Run all task in development mode. Quick use for developing process
 *
 **********************************************************************************************************************/

gulp.task('dev', series(
    'sprite', parallel(
    'js',
    'css:dev',
    'fonts'
    )
));
/***********************************************************************************************************************
 * Task: Watch
 ***********************************************************************************************************************
 *
 * Watch all files and start needed tasks when changes happen
 *
 **********************************************************************************************************************/

gulp.task('watch', parallel(
    'js',
    watchGulpFile
));

function watchGulpFile() {
    plugins.watch([path.watch.css], parallel('css:dev'));
    plugins.watch([path.watch.sprite], parallel('sprite'));
    plugins.watch([path.watch.fonts], parallel('fonts'));
}


/***********************************************************************************************************************
 * Task: Watch
 ***********************************************************************************************************************
 *
 * Run all tasks in dev mode and than run watch task
 *
 **********************************************************************************************************************/
//
gulp.task('default', series('dev', watchGulpFile));
