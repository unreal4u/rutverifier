/*global module:false*/
module.exports = function (grunt) {
    'use strict';

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        uglify: {
            dist: {
                files: {
                    'js/<%= pkg.name %>.min.js': ['js/src/<%= pkg.name %>.js']
                }
            }
        },
        qunit: {
            files: ['js/test/*.html']
        },
        jshint: {
            options : {
                bitwise : true,
                camelcase : true,
                curly : true,
                eqeqeq : true,
                forin : true,
                immed : true,
                indent : 4,
                latedef : true,
                newcap : true,
                noarg : true,
                noempty : true,
                nonew : true,
                plusplus : true,
                quotmark : true,
                regexp : true,
                undef : true,
                unused : false,
                strict : true,
                trailing : true,
                maxparams : 3,
                maxdepth : 4,
                maxstatements : 50
            },
            all : [ 'Gruntfile.js', 'js/src/*.js' ]
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-qunit');
    grunt.loadNpmTasks('grunt-contrib-jshint');

    grunt.registerTask('default', ['jshint', 'uglify']);
};
