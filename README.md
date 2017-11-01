# Netlife Research: Craft Starter

*Read through the readme*, and if you are stuck, don't hesitate to ask in either #frontend or #craft in Slack. If you have made some smart improvement to the tooling or setup of in your Craft procject, _please contribute to this starter by making a pull request_.

## Get started

1. Clone, or download this repository
2. Install global dependencies if not installed already (see bottom of file)
3. Install dependencies
4. Make a repository on GitHub
5. Set up a Heroku app for the first time or get up and running when somebody already set things up

## Changing the remote git repository

If you have cloned this project, the git remote `origin` is set to the craft-starter repository. Unless you're actually working on improving the craft-starter, you should set the remote `origin` to your project repository.

1. Remove the current `origin` with `git remote rm origin`
2. Add the new origin with `git remote add origin git@github.com:netliferesearch/repository-name`
3. Push to the new origin with `git push --set-upstream origin master`

## Dependencies

1. `composer install` (for all the PHP stuff)
2. `npm i` ([alternately `yarn`](https://yarnpkg.com/)) (for all the JS and CSS stuff)

## Setting up the project on Heroku for the first time

Push this button (remember to set the correct region)
[![Deploy](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy?template=https://github.com/netliferesearch/craft-starter/tree/master)

### Manually (like a pro)

Make sure you install global dependencies like Heroku toolbelt first.

1. `heroku create <name> --region eu`
2. `heroku buildpacks:add heroku/php`
2. `heroku buildpacks:add heroku/nodejs`
3. `heroku addons:create jawsdb`
3. `heroku addons:create heroku-redis`
4. `heroku config -s | tr -d "'" > .env`
2. `heroku config:add NPM_CONFIG_PRODUCTION=false`
2. `heroku config:add CRAFT_VALIDATION_KEY=anyuniquekey` <= generate this key yourself
5. Update `general.php` with the heroku app {{name}}

## Up and running when somebody already set things up
1. `heroku git:remote <name>`
2. `heroku config -s | tr -d "'" > .env`
3. Get your local database up and running or connect to the remote database


## Heroku local configuration

`<name>` is the name of your app. E.g `https://<name>.herokuapp.com/`

1. Make sure that you've logged in, and have access to the project on Heroku: `heroku login`
2. Make sure that this folder has the correct Heroku app as an git remote `heroku git:remote <name>`
3. Run `heroku config --app <name> -s | tr -d "'" > .env` in terminal

`heroku config` lists out the configuration (a.k.a. environment variables) in your heroku app in the :cloud:. To save them locally in a file, we will first need the ouput in a shell format, thus we put the `-s` flag in. Heroku spits out database urls with `''`, which tend to create some trouble. Therefore we _pipe_ the output from `heroku config` by using this [`|`](https://en.wikipedia.org/wiki/Pipeline_(Unix)) and a [`tr -d "'"`](http://explainshell.com/explain?cmd=tr+-d+%22%27%22) that deletes these. With this output we can _write_ it to a `.env` file with `>`.

If you e.g. have installed a new add-on and just want to _append_ this to the .env-configuration file, you can do so with this command

`heroku config:get REDIS_URL -s |tr -d "'" >> .env` (`>>` appends the output to a new line in the file, while a single `>` would overwrite the whole file).

## Developing on a local database

Download [Craft Starter DB](https://github.com/netliferesearch/craft-starter-db) as a zip, either in a separate folder or in your craft-project (remember to ignore it in git). Read its README. It's pretty handy!

TIPS:
- Set fields and sections and other setup on the heroku Craft, and download the changes locally. You will thank us later.
- Also work mainly with content on the remote database.
- Treat your local database as something that can disappear at any moment.

Run the oneliner `docker-compose down && ./download-prop && docker-compose-up` in your craft-starter-db-docker-folder to do a quick down sync of the remote database. Note: You'll loose any changes you have done locally in the database.


## Install craft
Go to [http://localhost:5000/admin](http://localhost:5000/admin) and follow the wizard to install craft.

If you want to change this URL, you'll have to change it in `start.sh`. If you want to use browser-sync, you'll have to change it in `webpack.config.js` (line 58) as well.

## Start working

`npm run dev` starts the web server + webpack. Webpack processes Sass + JS. This craft-starter comes ready with [Browser-Sync](http://www.browsersync.io/) – that means that you don't *need* CodeKit.

Edit Sass and JavaScript in the `/resources/`-folder. Webpack will compile, transpile, minify it into the `public` folder, ready for production. If you put files in the assets-folder, Webpack will handle those too. The `style.scss` is built into `public/style.css` and it injects vendor prefixes and inlines smaller static resources (icon fonts for example). The file `resources/js/app.js` is built into `public/js/min/app.min.js`, and it uses Browserify + Babel, allowing you to both write ES6 as well as using a Node.js style if you prefer.

Both files are properly included in `craft/templates/_layout.twig`

## What about assets?!

We usually use S3 on Amazone Web Services. Ask [@kmelve](https://github.com/kmelve) about access to a bucket.

## Global dependencies for the starter-pack

Perform the following steps in a terminal:
You only need to do this once per system.

### PHP
* Install homebrew: `ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"`
* `brew tap homebrew/dupes`
* `brew tap homebrew/versions`
* `brew tap homebrew/homebrew-php`
* `brew install php70 php70-mcrypt php70-imagick php70-redis composer`
* `brew link php70`

If you have problems with php70-magick, you can fix it with this command:

```bash
brew uninstall imagemagick && brew install imagemagick@6 && brew link imagemagick@6 --force
```

And if you still have problems, try this:
`brew reinstall -s php70-imagick`

### Node Version Manager + tools

* Install Heroku toolbelt <https://toolbelt.heroku.com/>
  * `brew install heroku`
* `brew install nvm`

### Troubleshooting

>Peow peow!

- Amazon S3: Craft CMS 2.x doesn't support bucket location Frankfurt because it uses a newer authentication method.

- Redis: Remember to uncomment Redis-settings in `general.php`. If not Heroku will fail miserably. 
