# {{name}}

## Start working

`npm start` starts the web server + Gulp. Gulp processes SASS + JS

The `styles.scss` is built into `public/style.css` and it injects vendor prefixes and inlines smaller static resources (icon fonts for example).

The file `public/js/main.js` is built into `public/js/dist.js`, and it uses Browserify + Babelify, allowing you to both write ES6 as well as using a Node.js style if you prefer.

Both files are properly included in `craft/templates/_layout.twig`

## Dependencies

1. `npm i`
2. `bower install`

## Global dependencies for the starter-pack

Perform the following steps in a terminal:
You only need to do this once per system.

### PHP

* Install homebrew: `ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"`
* `brew tap homebrew/dupes`
* `brew tap homebrew/versions`
* `brew tap homebrew/homebrew-php`
* `brew install php56 php56-mcrypt`
* `brew link php56`

### Node.js + tools

* `brew install nodejs`
* `npm i -g bower gulp-cli`
