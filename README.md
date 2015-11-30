# My awesome Craft project

## Get started

Clone this repo and get a move on

## Start working

`npm start` starts the web server + Gulp. Gulp processes SASS + JS

The `styles.scss` is built into `public/style.css` and it injects vendor prefixes and inlines smaller static resources (icon fonts for example).

The file `public/js/main.js` is built into `public/js/dist.js`, and it uses Browserify + Babelify, allowing you to both write ES6 as well as using a Node.js style if you prefer.

Both files are properly included in `craft/templates/_layout.twig`

## Install craft
Go to [http://localhost:5000/admin](http://localhost:5000/admin) and follow the wizard to install craft.

## Dependencies

1. `composer install`
2. `npm i`
3. `bower install`

## Setting up Heroku

Make sure you install global dependencies first

1. `heroku create <name>`
2. `heroku addons:create cleardb`
3. `heroku config | sed 1d | sed  -e "s/: /=/" > .env`

## Heroku local configuration

Create a file `.env` with the two variables

```bash
BUILDPACK_URL=https://github.com/heroku/heroku-buildpack-php
CLEARDB_DATABASE_URL=<same as in heroku>|<local mysql connectino string>
```

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

* `gem install heroku`
* `brew install nodejs`
* `npm i -g bower gulp-cli`
