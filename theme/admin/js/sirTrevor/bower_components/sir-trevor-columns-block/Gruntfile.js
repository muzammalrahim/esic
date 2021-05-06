module.exports = function(grunt) {

  var banner = '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n';

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    concat: {
      options: {
        separator: ';',
        banner: banner
      },
      scripts: {
        src: 'src/*.js',
        dest: 'build/<%= pkg.name %>.js'
      }
    },

    copy: {
      dist: {
        files: [
          {expand: true, cwd: 'build/', src: '*', dest: 'dist/'},
          {expand: true, cwd: 'fonts/', src: 'ST-Columns-Icons.woff', dest: 'dist/fonts/'} // the only one font used for now
        ]
      }
    },

    rebase: {
      dist: {
        files: [{
          src: 'dist/<%= pkg.name %>.css',
          dest: 'dist/<%= pkg.name %>.css',
          scopes: {
            url: {
              "\\.\\.\/fonts": "fonts"
            }
          }
        }]
      }
    },

    uglify: {
      options: {
        banner: banner
      },
      scripts: {
        src: 'build/<%= pkg.name %>.js',
        dest: 'build/<%= pkg.name %>.min.js'
      }
    },
    clean: {
      build: {
        src: 'build'
      },
      dist: {
        src: 'dist'
      }
    },
    sass: {
      styles: {
        files: {
          'build/<%= pkg.name %>.css': 'scss/styles.scss'
        }
      }
    },

    imageEmbed: {
      icons: {
        src: [ "build/<%= pkg.name %>.css" ],
        dest: "build/<%= pkg.name %>.all.css",
        options: {
          deleteAfterEncoding : false
        }
      }
    },

    watch: {
      scripts: {
        files: ['src/*.js'],
        tasks: ['concat', 'uglify']
      },
      styles: {
        files: ['scss/*.scss'],
        tasks: ['sass']
      },
      icons: {
        files: ['icons/**/*'],
        tasks: ['imageEmbed']
      }
    },

    'http-server': {
      'example': {
        root: __dirname,
        port: 8012,
        autoIndex: true,
        // server default file extension
        ext: "html",
        runInBackground: true
      }
    },

    open : {
      example: {
        path: 'http://127.0.0.1:8012/example/'
      }
    }
  });

  // Load plugins
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-image-embed');
  grunt.loadNpmTasks('grunt-open');
  grunt.loadNpmTasks('grunt-rebase');
  grunt.loadNpmTasks('grunt-wait-forever');

  grunt.loadNpmTasks('grunt-http-server');

  grunt.registerTask('build', ['clean', 'concat', 'uglify', 'sass', 'imageEmbed']);
  grunt.registerTask('dist', ['build', 'copy', 'rebase', 'clean:build']);

  grunt.registerTask('example', ['build', 'http-server:example', 'open:example', 'wait-forever']);

  // Default task(s).
  grunt.registerTask('default', ['build']);

};