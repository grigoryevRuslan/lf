module.exports = function(grunt) {

	grunt.initConfig({
		jshint: {
			files: ['Gruntfile.js'],
			options: {
				globals: {
					jQuery: true
				}
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

	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-sftp-deploy');

	grunt.registerTask('default', ['jshint', 'sftp-deploy']);

};
