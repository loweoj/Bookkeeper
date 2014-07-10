module.exports = function(grunt) {

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

    less: {
        development: {
            options: {
              compress: true,  //minifying the result
            },
            files: {
              //compiling global.less into global.css
              "./public/assets/css/global.css":"./app/assets/css/global.less",
            }
        }
    },

    concat: {
      options: {
        separator: ';',
      },
      js_global: {
        src: [
          './bower_components/jquery/dist/jquery.js',
          './bower_components/bootstrap/dist/js/bootstrap.js',
          './app/assets/js/vendor/*.js',
          './app/assets/js/global.js'
        ],
        dest: './public/assets/js/global.js',
      }
    },

    uglify: {
      options: {
        mangle: false  // Use if you want the names of your functions and variables unchanged
      },
      global: {
        files: {
          './public/assets/js/global.js': './public/assets/js/global.js',
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
            './bower_components/jquery/jquery.js',
            './bower_components/bootstrap/dist/js/bootstrap.js',
            './app/assets/js/global.js'
            ],
          tasks: ['concat:js_global','uglify:global'],     //tasks to run
          options: {
            livereload: true                        //reloads the browser
          }
        },
        less: {
          files: ['./app/assets/css/*.less'],  //watched files
          tasks: ['less'],                          //tasks to run
          options: {
            livereload: true                        //reloads the browser
          }
        }
        //,
        // tests: {
        //   files: ['app/controllers/*.php','app/models/*.php'],  //the task will run only when you save files in this location
        //   tasks: ['phpunit']
        // }
      }
    });

  // Plugin loading
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-phpunit');
  grunt.loadNpmTasks('grunt-contrib-copy');

  // Task definition
  grunt.registerTask('init', ['copy', 'less', 'concat', 'uglify']);
  grunt.registerTask('default', ['watch']);

};
