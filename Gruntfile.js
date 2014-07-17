module.exports = function (grunt) {

    //Initializing the configuration object
    grunt.initConfig({

        // Task configuration
        copy: {
            main: {
                expand: true,
                cwd: 'bower_components/bootstrap/fonts/',
                src: '**',
                dest: 'public/assets/fonts/',
                flatten: true,
                filter: 'isFile',
            },
        },

//        jasmine : {
//            // Your project's source files
//            src : 'app/assets/js/src/*.js',
//            options: {
//                // Your Jasmine spec files
//                specs : 'app/assets/spec/**/*spec.js',
//                // Your spec helper files
//                helpers : 'app/assets/spec/helpers/*.js'
//            }
//        },

        less: {
            development: {
                options: {
                    compress: true,  //minifying the result
                    optimization: 2,
                    sourceMap: true,
                    sourceMapFilename: "public/assets/css/global.css.map",
                    sourceMapBasepath: "public/assets/css/"
                },
                files: {
                    //compiling global.less into global.css
                    "public/assets/css/global.css": "app/assets/css/global.less",
                }
            }
        },

        concat: {
            options: {
                separator: ';',
            },
            js_global: {
                src: [
                    'bower_components/jquery/dist/jquery.js',
                    'bower_components/bootstrap/dist/js/bootstrap.js',
                    'app/assets/js/vendor/*.js',
                    'app/assets/js/src/*.js',
                    'app/assets/js/global.js'
                ],
                dest: 'public/assets/js/global.js',
            }
        },

        uglify: {
            options: {
                mangle: false  // Use if you want the names of your functions and variables unchanged
            },
            global: {
                files: {
                    'public/assets/js/global.js': 'public/assets/js/global.js',
                }
            }
        },

        phpunit: {
            classes: {
            },
            options: {
            }
        },

        watch: {
            js_global: {
                files: [
                    //watched files
                    'bower_components/jquery/jquery.js',
                    'bower_components/bootstrap/dist/js/bootstrap.js',
                    'app/assets/js/**/*.js'
                ],
                tasks: ['concat:js_global'],
                options: {
                    livereload: true
                }
            },
            less: {
                files: ['app/assets/css/**/*.less'],
                tasks: ['less'],
                options: {
                    livereload: true
                }
            }
        }
    });

    // Plugin loading
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-phpunit');
    grunt.loadNpmTasks('grunt-contrib-copy');
    // grunt.loadNpmTasks('grunt-contrib-jasmine');
    // grunt.loadNpmTasks('grunt-hogan');

    // Task definition
    grunt.registerTask('init', ['copy', 'less', 'concat', 'uglify']);
    grunt.registerTask('build', ['less', 'concat', 'uglify'])
    grunt.registerTask('default', ['watch']);

};
