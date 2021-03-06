module.exports = function(grunt) {

	grunt.initConfig({
		clean: {
			dist: ['public/**/*', 'assets/**/*']
		},
		sass: {
			options: {
				outputStyle: 'nested'
			},
			dist: {
				files: [{
					src: ['src/client/sass/style.scss'],
					dest: 'assets/css/style.css'
				}]
			}
		},
		jshint: {
			files: [
				'Gruntfile.js',
				'src/client/js/**/*.js',
				'server/admin/js/**/*.js',
				'!src/client/js/libs/**/*.js'
			],
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

			//jscs:disable requireCamelCaseOrUpperCaseIdentifiers
			basic_and_extras: {
				//jscs:enable requireCamelCaseOrUpperCaseIdentifiers
				files: {
					'assets/js/app.js': [
					'bower_components/jquery/dist/jquery.min.js',
					'bower_components/jquery-ui/jquery-ui.min.js',
					'bower_components/angular/angular.min.js',
					'bower_components/angular-recaptcha/release/angular-recaptcha.min.js',
					'bower_components/ng-tags-input/ng-tags-input.min.js',
					'bower_components/angular-ui-mask/dist/mask.min.js',
					'bower_components/angular-rangeslider/angular.rangeSlider.js',
					'src/client/js/app/**/*.js',
					'src/client/js/global/**/*.js'
					],
					'assets/css/main.css': [
					'assets/css/style.css',
					'bower_components/jquery-ui/themes/south-street/jquery-ui.css'
					]
				}
			}
		},
		uglify: {
			//jscs:disable requireCamelCaseOrUpperCaseIdentifiers
			my_target: {
				//jscs:enable requireCamelCaseOrUpperCaseIdentifiers
				files: {
					'public/js/global/app.min.js': ['assets/js/app.js']
				}
			}
		},
		sprite:{
			all: {
				cssFormat: 'scss',
				src: 'src/client/img/sprite/*.png',
				imgPath: '../img/spritesheet.png',
				destImg: 'public/img/spritesheet.png',
				destCSS: 'src/client/sass/helpers/sprites.scss'
			}
		},
		copy: {
			main: {
				files: [{
					expand: true,
					cwd: 'src/server/',
					src: ['**'],
					dest: 'public/'
				}, {
					expand: true,
					cwd: 'src/client/img/pics',
					src: ['**'],
					dest: 'public/img'
				}, {
					expand: true,
					cwd: 'src/client/js/modules',
					src: ['**'],
					dest: 'public/js/modules'
				}, {
					expand: true,
					cwd: 'src/client/js/libs',
					src: ['**'],
					dest: 'public/js/libs'
				}, {
					expand: true,
					cwd: 'assets/css/',
					src: ['**'],
					dest: 'public/css'
				}]
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
				src: 'public/',
				dest: '/var/www/html',
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
	grunt.loadNpmTasks('grunt-contrib-copy');

	grunt.registerTask('default', ['jshint', 'jscs', 'clean', 'sprite', 'sass', 'concat', 'uglify', 'copy']);
	grunt.registerTask('deploy', ['default', 'sftp-deploy']);

};
