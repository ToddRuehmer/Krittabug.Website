/*jslint node: true */

/*******************************************************************************
    DEPENDENCIES
*******************************************************************************/

/*global -$ */
'use strict';

var $           = require( 'gulp-load-plugins' )(),
    gulp        = require( 'gulp' ),
    serve        = require( 'gulp-serve' ),
    neat        = require( 'node-neat' ).includePaths,
    notify      = require( 'gulp-notify' ),
    order     = require( 'gulp-order' ),
    babel     = require( 'gulp-babel' ),
    plumber     = require( 'gulp-plumber' ),
    usemin      = require( 'gulp-usemin' ),
    htmlmin      = require( 'gulp-htmlmin' ),
    uglify      = require( 'gulp-uglify' ),
    wiredep     = require( 'wiredep' ),
    connect     = require( 'gulp-connect' ),
    connectSSI  = require( 'connect-ssi' ),
    cleanCSS    = require( 'gulp-clean-css' ),
    extname     = require( 'gulp-extname' ),
    open        = require( 'gulp-open' ),
    sassGlob    = require( 'gulp-sass-glob' ),
    inject      = require( 'gulp-inject' ),
    browserSync = require( 'browser-sync' ).create(),
    reload      = browserSync.reload,
    concat      = require( 'gulp-concat' ),
    bowerFiles  = require( 'gulp-main-bower-files' ),
    rename      = require( 'gulp-rename' ),
    utils       = require( 'gulp-util' ),
    filter      = require( 'gulp-filter' ),
    addsrc      = require( 'gulp-add-src' );


/*******************************************************************************
    STYLES: process main.scss, auto-vendor-prefix, update dist & reload browsers
*******************************************************************************/

gulp.task( 'styles', function() {
  return gulp.src( [ 'src/components/**/*.scss', 'src/scss/styles.scss' ] )
	.pipe( filter( '**/*.scss' ))
    .pipe( plumber() )
    .pipe( sassGlob() )
    .pipe( $.sass({
      outputStyle: 'compact',
      precision: 10,
      sourceComments: 'normal',
      includePaths: [ 'styles' ].concat( neat ),
      onError: function( error ) {
        console.error.bind( console, 'Sass error:' );
        return notify({ sound: 'Glass' }).write( error );
      }
    }))
    .pipe( $.postcss([
      require( 'autoprefixer' )({
        browsers: [
          'last 2 version',
          '> 1%',
          'ie 8',
          'ie 9',
          'ios 6',
          'android 4'
        ]
      })
	]))
	.pipe( concat( 'main.css' ))
    .pipe( gulp.dest( 'css/' ))
    .pipe( reload({
      stream: true
    }))
    .pipe( notify({ sound: false, message: 'File Processed: main.scss' }));

});



/*******************************************************************************
    SERVE: fire up browser sync & reload when changes are made
*******************************************************************************/

gulp.task( 'serve', function() {
	browserSync.init({
		  proxy: 'https://krittabug:82/'
	  });

});



/*******************************************************************************
    WATCH: Check for changes and update accordingly
*******************************************************************************/

gulp.task( 'watch', function() {

//gulp.watch([
//  'src/**/*'
//]).on( 'change', reload );

  gulp.watch( 'src/js/**/*.js', function( event ) {
    gulp.start( 'concat-scripts' );
    //gulp.start( 'concat-plugins' );
  });

  gulp.watch( 'src/scss/**/*.scss', [ 'styles' ]);

  gulp.watch( 'bower.json', [ 'concat-plugins', 'styles' ]);

});


/*******************************************************************************
    JAVASCRIPT
*******************************************************************************/

gulp.task( 'concat-plugins', function() {
  gulp.src( 'bower.json' )
    .pipe( bowerFiles() )
    .pipe( filter( '**/*.js' ))
    .pipe( addsrc( 'src/js/CustomEase.min.js' ))
    .pipe( concat( 'plugins.js' ))
    .pipe( gulp.dest( 'js/' ))
    .pipe( rename( 'plugins.min.js' ))
    .pipe( uglify() )
    .on('error', function (err) { utils.log(utils.colors.red('[Error]'), err.toString()); })
    .pipe( gulp.dest( 'js/' ))
    .pipe( notify({ sound: false, message: 'plugins processed' }));
});


gulp.task( 'concat-scripts', function() {
  gulp.src([ 'src/js/**/*.js' ])
    .pipe(order([
      'src/js/**/*.js',
      'src/js/main.js'
    ]))
    .pipe(babel())
    .pipe( concat( 'main.min.js' ))
    .pipe( gulp.dest( 'js/' ))
    .pipe( reload({ stream: true }))
    .pipe( notify({ sound: false, message: 'js file processed' }));
});



/*******************************************************************************
    BUILD
*******************************************************************************/

gulp.task( 'build', [ 'styles', 'concat-plugins', 'concat-scripts' ], function() {

  return gulp.src( '../assets/**/*' ).pipe( $.size({
    title: 'build',
    gzip: true
  }));

});



/*******************************************************************************
    DEFAULT ==== CLEAN && BUILD
*******************************************************************************/

gulp.task( 'default', [ 'serve', 'watch' ] );
