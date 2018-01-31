# Netlife Research: Craft Starter

_Read through the readme_, and if you are stuck, don't hesitate to ask in either #frontend or #craft in Slack. If you have made some smart improvement to the tooling or setup of in your Craft project, _please contribute to this starter by making a pull request_.

## Getting started

1. Clone, or download this repository
1. If you haven't already install Docker and Node, see guide below.
1. Run `npm install` to install NPM dependencies.
1. Run `docker-compose up` to start three containers (details found in docker-compose.yml):
   * Apache Server, to mirror production environment.
   * Redis, used for caching logins included so that we mirror production.
   * Mysql, the database.
1. It might/will take some time for the containers to finish building and there will be no complete message. So, just wait 2min until the text stops flowing and then go to `http://localhost:5000/admin` to install Craft.

### Start livereloading and asset building on localhost:3000

Then run `npm run dev` to start a process that will be building our frontend dependencies. Our build setup provides a localhost:3000 address that shows the same as localhost:5000 but also has livereloading.

Edit Sass and JavaScript in the `/resources/`-folder. Webpack will compile, transpile, minify it into the `public` folder, ready for production. If you put files in the assets-folder, Webpack will handle those too. The `style.scss` is built into `public/style.css` and it injects vendor prefixes and inlines smaller static resources (icon fonts for example). The file `resources/js/app.js` is built into `public/js/min/app.min.js`, and it uses Browserify + Babel, allowing you to both write ES6 as well as using a Node.js style if you prefer.

Both files are properly included in `craft/templates/_layout.twig`

## Changing the remote git repository

If you have cloned this project, the git remote `origin` is set to the craft-starter repository. Unless you're actually working on improving the craft-starter, you should set the remote `origin` to your project repository.

1. Remove the current `origin` with `git remote rm origin`
2. Add the new origin with `git remote add origin git@github.com:netliferesearch/repository-name`
3. Push to the new origin with `git push --set-upstream origin master`

## Setting up the project on Heroku for the first time

Push this button (remember to set the correct region)
[![Deploy](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy?template=https://github.com/netliferesearch/craft-starter/tree/master)

### Manually (like a pro)

Make sure you install global dependencies like Heroku toolbelt first.

1. `heroku create <name> --region eu`
2. `heroku buildpacks:add heroku/php`
3. `heroku buildpacks:add heroku/nodejs`
4. `heroku addons:create jawsdb`
5. `heroku addons:create heroku-redis`
6. `heroku config:add NPM_CONFIG_PRODUCTION=false`
7. `heroku config:add CRAFT_VALIDATION_KEY=anyuniquekey` <= generate this key yourself

## Up and running when somebody already set things up

1. `heroku git:remote <name>`
2. `heroku config -s | tr -d "'" > .env`
3. Get your local database up and running or connect to the remote database

## What about assets?!

We usually use S3 on Amazon Web Services. Ask [@kmelve](https://github.com/kmelve) about access to a bucket.

## Global dependencies for the starter-pack

Perform the following steps in a terminal:
You only need to do this once per system.

### Node Version Manager + tools

* Install Heroku toolbelt <https://toolbelt.heroku.com/>
* `brew install heroku`
* `brew install nvm`

### Troubleshooting

> Peow peow!

* Amazon S3: Craft CMS 2.x doesn't support bucket location Frankfurt because it uses a newer authentication method.
