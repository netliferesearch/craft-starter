var Promise = require('bluebird')
var inq = require('inquirer')

var fs = Promise.promisifiyAll(require('fs'))

var _ = require('lodash')
_.templateSettings.interpolate = /{{([\s\S]+?)}}/g;

var templatizedFiles = [
    'package.json',
    'craft/config/general.php',
    'craft/config/db.php'
]

/**
* Init craft project
* 1. Deduct name from path
* 2. Replace name into configuration
* 3. Install NPM components
*/

function answered (question) {
    return function (answers) {
        return !_.isEmpty(answers[question])
    }
}

var questions = [
    {
        type: 'input',
        name: 'name',
        message: 'Name this project',
        validate: function (val) {
            return !!val.match(/^[a-zA-Z0-9\-_]+$/) || 'Invalid name'
        }
    }, {
        type: 'input',
        name: 'dbUser',
        message: 'MySQL username',
        default: function(a) { return 'craft_' + a.name }
    }, {
        type: 'input',
        name: 'dbPass',
        message: 'MySQL password',
        when: answered('dbUser')
    }, {
        type: 'input',
        name: 'dbName',
        message: 'MySQL database',
        when: answered('dbUser')
    }, {
        type: 'input',
        name: 'ftpUser',
        message: 'FTP username'
    }, {
        type: 'input',
        name: 'ftpPass',
        message: 'FTP password',
        when: answered('ftpUser')
    }
]

function setPackageName (name) {
    var file = 'package.json'
    var write = _.partial(fs.writeFileAsync, file)
    return fs.readFileAsync(file)
        .then(JSON.parse)
        .then(function(obj) {
            obj.name = name
            return JSON.stringify(obj)
        })
        .then(write)
}

function replaceIntoFiles (context) {
    var files = templatizedFiles
        'package.json',
        'craft/config/general.php',
        'craft/config/db.php'
    ]
    return Promise.all(templatizedFiles.map(function(file) {
        return fs.readFileAsync(file)
            .then(function(tpl) {
                return _.template(tpl)(context)
            })
            .then(_.partial(fs.writeFileAsync, file))
    }))
}

// 1. update package.json with name
// 2. update craft/config/general
inq.prompt(questions, function (a, done) {

    setPackageName(a.name)
        .then(replaceIntoFiles(a))
        .then(function(res) {
            console.log(results);
            done(null)
        })
})
