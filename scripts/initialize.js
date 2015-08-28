var Promise = require('bluebird')
var inq = require('inquirer')

var fs = Promise.promisifyAll(require('fs'))

var _ = require('lodash')
_.templateSettings.interpolate = /{{([\s\S]+?)}}/g

var templatizedFiles = [
  '.git/config',
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
      return (!!val.match(/^[a-zA-Z0-9\-_]+$/) || 'Invalid name')
    }
  },
  {
    type: 'input',
    name: 'dbUser',
    message: 'MySQL username',
    default: function (a) { return 'craft_' + a.name }
  },
  {
    type: 'input',
    name: 'dbPass',
    message: 'MySQL password',
    when: answered('dbUser')
  },
  {
    type: 'input',
    name: 'dbName',
    message: 'MySQL database',
    when: answered('dbUser'),
    default: function (a) { return a.dbUser }
  },
  {
    type: 'input',
    name: 'ftpUser',
    message: 'FTP username',
    default: function (a) { return a.dbUser }
  },
  {
    type: 'input',
    name: 'ftpPass',
    message: 'FTP password',
    when: answered('ftpUser'),
    default: function (a) { return a.dbPass }
  },
  {
    type: 'input',
    name: 'repo',
    message: 'GitHub repo name (just the last part)',
    default: function (a) { return a.name }
  }
]

function setPackageName (name) {
  var file = 'package.json'
  return fs.readFileAsync(file)
    .then(JSON.parse)
    .then(function (obj) {
      obj.name = name
      return JSON.stringify(obj, null, '  ')
    })
    .then(function (content) {
      return fs.writeFileAsync(file, content, 'utf8')
    })
}

function replaceIntoFiles (context, files) {
  return Promise.all(files.map(function (file) {
    return fs.readFileAsync(file)
    .then(function (tpl) {
      return _.template(tpl)(context)
    })
    .then(function (content) {
      return fs.writeFileAsync(file, content, 'utf8')
    })
  }))
}

function copyFile (from, to) {
  return fs.readFileAsync(from)
    .then(function (content) { 
      return fs.writeFileAsync(to, content, 'utf-8')
    })
}

// 1. update package.json with name
// 2. update craft/config/general
// 3. inform user of changes
inq.prompt(questions, function (a, done) {

  setPackageName(a.name)
    .then(copyFile('./.templates/gitconfig', '.git/config'))
    .then(replaceIntoFiles(a, templatizedFiles))
    .then(function () {
      templatizedFiles.forEach(function (file) {
        console.log('Updated file:', file)
      })
    })
})
