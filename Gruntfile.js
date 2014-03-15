/*global module:false*/
module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    // Metadata.
    pkg: grunt.file.readJSON('package.json'),
    banner: '/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' +
      '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
      '<%= pkg.homepage ? "* " + pkg.homepage + "\\n" : "" %>' +
      '* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %>;' +
      ' Licensed <%= _.pluck(pkg.licenses, "type").join(", ") %> */\n',
    // Task configuration.
    bower: {
      all: {
        rjsConfig: 'js/main.js'
      }
    },
    concat: {
      options: {
        banner: '<%= banner %>',
        stripBanners: true
      },
      dist: {
        files: {
          'dist/js/startpage.js' : ['lib/js/events.js', 'lib/js/promises.js', 'lib/js/startpage.js']
        }
      }
    },
    uglify: {
      options: {
        banner: '<%= banner %>'
      },
      dist: {
        src: 'dist/js/startpage.js',
        dest: 'dist/js/startpage.min.js'
      }
    },
    jshint: {
      options: {
        devel: true,
        curly: true,
        eqeqeq: true,
        immed: true,
        latedef: true,
        newcap: true,
        noarg: true,
        sub: true,
        undef: true,
        unused: true,
        boss: true,
        eqnull: true,
        browser: true,
        jquery: true,
        globals: {
          jQuery: true,
          require: true
        }
      },
      gruntfile: {
        src: 'Gruntfile.js'
      },
      libTest: {
        src: 'dist/js/startpage.js'
      }
    },
    sass: {
      dev: {
        options: {
          lineNumbers: true,
          debugInfo: true,
          spawn: false
        },
        files: [{
          expand: true,
          cwd: 'lib/scss',
          src: ['**/*.scss'],
          dest: 'dist/css',
          ext: '.css'
        }]
      },
      dist: {
        options: {
          banner: '<%= banner %>',
          style: 'compressed'
        },
        files: [{
          expand: true,
          cwd: 'lib/scss',
          src: ['**/*.scss'],
          dest: 'dist/css',
          ext: '.min.css'
        }]
      }
    },
    autoprefixer: {
      all: {
        files: [{
          expand: true,
          cwd: 'dist/css',
          src: ['**/*.css'],
          dest: 'dist/css'
        }]
      }
    },
    imagemin: {
      options: {
        pngquant: true
      },
      dist: {
        files: [{
          expand: true,
          cwd: 'lib/',
          src: ['**/*.{jpg,gif,png}'],
          dest: 'dist/'
        }]
      }
    },
    image_resize: {
      thumbnailify: {
        options: {
          width: 150,
          height: 150,
          upscale: true
        },
        files: [{
          expand: true,
          cwd: 'dist/images',
          src: ['**/*.{png,jpg,gif}'],
          dest: 'dist/images'
        }]
      }
    },
    copy: {
      viewsNscripts: {
        src: ['views/*','scripts/*'],
        dest: 'dist/',
        options: {
          process: function(content) {
            return content.replace(/dist\//g, '' );
          }
        }
      },
      index: {
        src: 'index.php',
        dest: 'dist/'
      }
    },
    watch: {
      gruntfile: {
        files: '<%= jshint.gruntfile.src %>',
        tasks: ['jshint:gruntfile']
      },
      js: {
        files: ['lib/**/*.js'],
        tasks: ['concat', 'jshint:libTest', 'uglify']
      },
      php: {
        files: ['**/*.php'],
        tasks: []
      },
      sass: {
        files: ['lib/**/*.scss'],
        tasks: ['sass', 'autoprefixer']
      },
      options: {
        livereload: true
      }
    }
  });

  // Autoload devDependencies
  require('load-grunt-tasks')(grunt);

  // Default task.
  grunt.registerTask('default', ['sass', 'autoprefixer', 'jshint', 'concat', 'uglify', 'copy']);

};
