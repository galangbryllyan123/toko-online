module.exports = function(grunt) {

  // Import dependencies.
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');

  var jsSrc = [
    'vendor/bower_components/bootstrap/dist/js/bootstrap.min.js',
    'assets/js/admin.js'
  ];
  var jsDist = 'assets/js/dist/admin.js';
  var jsDistMin = 'assets/js/dist/admin.min.js';

  // Configuration de Grunt
  grunt.initConfig({
    less: {
      dev: {
        options: {
          paths: ['assets/css'],
          relativeUrls: true
        },
        files: {
          'assets/css/admin.css': 'assets/css/admin.less'
        }
      }
    },
    cssmin: {
      options: {
        rebase: true
      },
      target: {
        files: [
          {
            expand: true,
            cwd: 'assets/css',
            src: ['admin.css', '!*.min.css'],
            dest: 'assets/css',
            ext: '.min.css'
          },
          {
            'assets/css/dist/web.css' : [
              'vendor/bower_components/fancybox/source/jquery.fancybox.css',
              'assets/css/web.css',
            ]
          }
        ]
      }
    },
    concat: {
      options: {
        separator: ';'
      },
      compile_admin: { // On renomme vu qu'on n'a pas de mode dev/dist. Dist étant une autre tâche : uglify
        src: jsSrc, // Vu qu'on doit l'utiliser deux fois, autant en faire une variable.
        dest: jsDist // Il existe des hacks plus intéressants mais ce n'est pas le sujet du post.
      },
      compile_web: {
        src: [
          'vendor/bower_components/Autolinker.js/dist/Autolinker.js',
          'vendor/bower_components/fancybox/source/jquery.fancybox.js',
          'vendor/bower_components/twig.js/twig.js',
          'assets/js/web.js',
        ],
        dest: 'assets/js/dist/web.js'
      }
    },
    uglify: {
      options: {
          compress: true,
          mangle: true
      },
      compile_admin: {
        src: '<%= concat.compile_admin.dest %>',
        dest: jsDistMin
      },
      compile_web: {
        src: '<%= concat.compile_web.dest %>',
        dest: 'assets/js/dist/web.min.js'
      }
    },
    watch: {
      scripts: {
        files: 'assets/js/*.js',
        tasks: ['scripts:dev']
      }
    }
  });

  grunt.registerTask('default', ['dev', 'watch']);
  grunt.registerTask('dev', ['styles:dev', 'scripts:dev']);
  grunt.registerTask('styles:dev', ['less:dev', 'cssmin']);
  grunt.registerTask('scripts:dev', ['concat:compile_admin', 'concat:compile_web', 'uglify:compile_admin', 'uglify:compile_web']);
};
