module.exports = function(grunt) {

	grunt.initConfig({
		clean: {
			dist: ['public/**/*', 'assets/**/*']
		},
		sass: {
			options: {
				outputStyle: 'compressed'
			},
			dist: {
				files: [{
					src: ['src/sass/style.scss'],
					dest: 'public/css/style.css'
				}]
			}
		},
		jshint: {
			files: ['Gruntfile.js', 'src/js/**/*.js'],
			options: {
				globals: {
					jQuery: true
				}
			}
		},
		jscs: {
			src: ['<%= jshint.files %>'],
			options: {
				config: '.jscsrc'
			}
		},
		concat: {
			options: {
				separator: '\n\n'
			},
			dist: {
				src: ['bower_components/angular/angular.min.js', 'src/**/*.js'],
				dest: 'assets/js/app.js'
			}
		},
		uglify: {
			//jscs:disable requireCamelCaseOrUpperCaseIdentifiers
			my_target: {
			//jscs:enable requireCamelCaseOrUpperCaseIdentifiers
				files: {
					'public/js/app.min.js': ['assets/js/app.js']
				}
			}
		},
		sprite:{
			all: {
				cssFormat: 'scss',
				src: 'src/img/sprite/*.png',
				destImg: 'public/img/spritesheet.png',
				destCSS: 'src/sass/helpers/sprites.scss'
			}
		},
		watch: {
			files: ['<%= jshint.files %>'],
			tasks: ['jshint']
		},
		'sftp-deploy': {
			build: {
				auth: {
					host: '146.185.144.90',
					port: 22,
					authKey: 'dev'
				},
				cache: 'sftpCache.json',
				src: 'bower_components',
				dest: '/usr/games/test',
				serverSep: '/',
				localSep: '/',
				concurrency: 4,
				progress: true
			}
		}
	});

	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-jscs');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-sftp-deploy');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-spritesmith');

	grunt.registerTask('default', ['jshint', 'jscs', 'clean', 'concat', 'uglify', 'sprite', 'sass']);

};
