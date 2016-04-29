module.exports = function(grunt) {

	grunt.initConfig({
		clean: {
			dist: 'public/**/*'
		},
		sass: {
			options: {
				outputStyle: 'compressed'
			},
			dist: {
				files: [{
					src: ['src/sass/**/*.scss'],
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
//				exclusions: ['/path/to/source/folder/**/.DS_Store', '/path/to/source/folder/**/Thumbs.db', 'dist/tmp'],
			}
		}
	});

	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-jscs');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-sftp-deploy');

	grunt.registerTask('default', ['jshint', 'jscs', 'clean', 'sass']);

};
