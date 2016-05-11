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
					dest: 'public/css/style.css'
				}]
			}
		},
		jshint: {
			files: ['Gruntfile.js', 'src/client/js/**/*.js', '!src/client/js/libs/**/*.js'],
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
				src: [
					'bower_components/jquery/dist/jquery.min.js',
					'bower_components/angular/angular.min.js',
					'bower_components/angular-recaptcha/release/angular-recaptcha.min.js',
					'src/client/js/app/**/*.js',
					'src/client/js/global/**/*.js'
				],
				dest: 'assets/js/app.js'
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

	grunt.registerTask('default', ['jshint', 'jscs', 'clean', 'concat', 'uglify', 'sprite', 'sass', 'copy']);
	grunt.registerTask('deploy', ['default', 'sftp-deploy']);

};
