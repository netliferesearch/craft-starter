# My awesome Craft project

## Get started

1. Clone this repo
2. Install global dependencies if not installed already (see bottom of file)
3. Install dependencies
4. Set up Heroku

## Start working

`npm start` starts the web server + Gulp. Gulp processes SASS + JS. This craft-starter comes ready with [Browser-Sync](http://www.browsersync.io/) – that means that you don't *need* CodeKit.

The `styles.scss` is built into `public/style.css` and it injects vendor prefixes and inlines smaller static resources (icon fonts for example).

The file `public/js/main.js` is built into `public/js/dist.js`, and it uses Browserify + Babelify, allowing you to both write ES6 as well as using a Node.js style if you prefer.

Both files are properly included in `craft/templates/_layout.twig`

## Install craft
Go to [http://localhost:5000/admin](http://localhost:5000/admin) and follow the wizard to install craft.

If you want to change this URL, you'll have to change it in `start.sh`. If you want to use browser-sync, you'll have to change it in `Gulpfile.js` (line 65) as well.

## Dependencies

1. `composer install`
2. `npm i`
3. `bower install`

## Setting up Heroku

Make sure you install global dependencies first (this probably happens automagically)

1. `heroku create <name>`
2. `heroku buildpacks:set heroku/php`
3. `heroku addons:create cleardb`
4. `heroku config -s > .env`

## Heroku local configuration

`heroku config -s > .env`

## Global dependencies for the starter-pack

Perform the following steps in a terminal:
You only need to do this once per system.

### PHP
* Install homebrew: `ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"`
* `brew tap homebrew/dupes`
* `brew tap homebrew/versions`
* `brew tap homebrew/homebrew-php`
* `brew install php56 php56-mcrypt php56-imagick composer`
* `brew link php56`

### Node.js + tools

* Install Heroku toolbelt <https://toolbelt.heroku.com/>
  * `brew install heroku-toolbelt`
* `brew install nodejs`
* `npm i -g bower gulp-cli`
