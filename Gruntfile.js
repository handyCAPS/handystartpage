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
        src: ['lib/js/**.js'],
        dest: 'dist/js/startpage.js'
      }
    },
    uglify: {
      options: {
        banner: '<%= banner %>'
      },
      dist: {
        src: '<%= concat.dist.dest %>',
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
      lib_test: {
        src: ['lib/js/**/*.js']
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
    watch: {
      gruntfile: {
        files: '<%= jshint.gruntfile.src %>',
        tasks: ['jshint:gruntfile']
      },
      lib_test: {
        files: '<%= jshint.lib_test.src %>',
        tasks: ['jshint:lib_test']
      },
      js: {
        files: ['lib/**/*.js'],
        tasks: ['jshint', 'concat', 'uglify']
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
  grunt.registerTask('default', ['jshint', 'concat', 'uglify']);

};
