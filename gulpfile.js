'use strict';

const G = require('gulp-load-plugins')(),
    gulp = require('gulp'),
    argv = require('yargs').argv;

const minify = !!(argv.production);

const plumberr = function (err) {
    console.error(err);
    this.emit('end');
};

gulp.task('clean', () => {
    return gulp.src('/public_html/{cs,font,image,j}s/**/*')
        .pipe(G.rimraf());
});

gulp.task('css', ['css:app', 'css:portal']);

gulp.task('css:app', () => {
    return gulp.src('app/assets/less/app.less')
        .pipe(G.plumber({errorHandler: plumberr}))
        .pipe(G.less())
        .pipe(G.autoprefixer({
            browsers: ['last 2 versions', 'ie 10'],
            cascade: false
        }))
        .pipe(G.if(minify, G.cssmin()))
        .pipe(G.addSrc.append('bower_components/font-awesome/css/font-awesome.min.css'))
        .pipe(G.concat('app.css'))
        .pipe(gulp.dest('public_html/css'));
});

gulp.task('css:portal', () => {
    return gulp.src('app/assets/less/portal.less')
        .pipe(G.plumber({errorHandler: plumberr}))
        .pipe(G.less())
        .pipe(G.autoprefixer({
            browsers: ['last 2 versions', 'ie 10'],
            cascade: false
        }))
        .pipe(G.if(minify, G.cssmin()))
        .pipe(G.addSrc.append('bower_components/font-awesome/css/font-awesome.min.css'))
        .pipe(G.concat('portal.css'))
        .pipe(gulp.dest('public_html/css'));
});

gulp.task('default', ['rebuild'], () => gulp.start('watch'));

gulp.task('build', ['css', 'fonts', 'images', 'js']);

gulp.task('fonts', () => {
    var paths = [
        'bower_components/bootstrap/fonts/*',
        'bower_components/font-awesome/fonts/*',
    ];
    return gulp.src(paths)
        .pipe(gulp.dest('public_html/fonts'));
});

gulp.task('images', () => {
    return gulp.src('app/assets/images/*')
        .pipe(gulp.dest('public_html/images'));
});

gulp.task('js', ['js:app', 'js:portal']);

gulp.task('js:app', () => {
    return gulp.src('app/assets/js/app.js')
        .pipe(G.plumber({errorHandler: plumberr}))
        .pipe(G.babel())
        .pipe(G.if(minify, G.uglify()))
        .pipe(G.addSrc.prepend([
            'bower_components/jquery/dist/jquery.min.js',
            'bower_components/bootstrap/dist/js/bootstrap.min.js',
        ]))
        .pipe(G.concat('app.js'))
        .pipe(gulp.dest('public_html/js'));
});

gulp.task('js:portal', () => {
    return gulp.src('app/assets/js/portal.js')
        .pipe(G.plumber({errorHandler: plumberr}))
        .pipe(G.babel())
        .pipe(G.if(minify, G.uglify()))
        .pipe(G.addSrc.prepend([
            'bower_components/jquery/dist/jquery.min.js',
            'bower_components/bootstrap/dist/js/bootstrap.min.js',
        ]))
        .pipe(G.concat('portal.js'))
        .pipe(gulp.dest('public_html/js'));
});

gulp.task('rebuild', ['clean'], () => gulp.start('build'));

gulp.task('watch', () => {
    G.watch(
        ['app/assets/less/app.less', 'app/assets/less/imports/*.less'],
        G.batch((e, done) => gulp.start('css:app', done))
    );
    G.watch(
        ['app/assets/less/portal.less', 'app/assets/less/imports/*.less'],
        G.batch((e, done) => gulp.start('css:portal', done))
    );
    G.watch('app/assets/js/app.js', G.batch((e, done) => gulp.start('js:app', done)));
    G.watch('app/assets/js/portal.js', G.batch((e, done) => gulp.start('js:portal', done)));
});
