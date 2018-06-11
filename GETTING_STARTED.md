# Netlife Design: Craft Starter

_Read through the readme_, and if you are stuck, don't hesitate to ask in either #frontend or #craft in Slack. If you have made some smart improvement to the tooling or setup of in your Craft project, _please contribute to this starter by making a pull request_.

## Getting started

1.  Clone, or download this repository
1.  If you haven't already install [global dependencies for the craft-starter](#global-deps).
1.  Run `npm install` to install NPM dependencies.
1.  Run `docker-compose up` to start three containers (details found in docker-compose.yml):
    - Apache Server, to mirror production environment.
    - Redis, used for caching logins included so that we mirror production.
    - Mysql, the database.
1.  It might/will take some time for the containers to finish building and there will be no complete message. So, just wait a bit until the text stops flowing and then go to `http://localhost:5000/admin` to install Craft.

### Start livereloading and asset building on localhost:3000

When you have docker-compose running in one terminal window please open a second window where you run `npm run dev`. This will start a process that will be building our frontend dependencies. Our build setup provides a localhost:3000 address that shows the same as localhost:5000 but also has livereloading.

Edit CSS and JavaScript in the `/web/`-folder. Webpack will compile, transpile, minify it into the `web` folder, ready for production. If you put files in the assets-folder, Webpack will handle those too (see file-loader).

The `main.css` is built into `web/dist/styles.css` and it injects vendor prefixes and inlines smaller static resources (icon fonts for example).

The file `web/js/main.js` is built into `web/dist/bundle.js`, and it uses Babel, allowing you to both write ES6 as well as using a Node.js style if you prefer.

Both files are included in `./templates/_layout.twig`

When you want to login into Craft you'll need to go to localhost:5000/admin, because localhost:3000 is just a livereloading proxy that can't handle logins.

## Changing the remote git repository

If you have cloned this project, the git remote `origin` is set to the craft-starter repository. Unless you're actually working on improving the craft-starter, you should set the remote `origin` to your project repository.

1.  Remove the current `origin` with `git remote rm origin`
2.  Add the new origin with `git remote add origin git@github.com:netliferesearch/repository-name`
3.  Push to the new origin with `git push --set-upstream origin master`

## Setting up the project on Heroku for the first time

Make sure you install global dependencies first. Then you can run these commands in order:

1.  `heroku create <name> --region eu`
2.  `heroku buildpacks:add heroku/php`
3.  `heroku buildpacks:add heroku/nodejs`
4.  `heroku addons:create jawsdb`
5.  `heroku addons:create heroku-redis`
6.  `heroku config:add NPM_CONFIG_PRODUCTION=false`
7.  `heroku config:add CRAFT_VALIDATION_KEY=anyuniquekey` <= generate this key yourself

## Buying a license

1.  Before buying a license. Uncomment license.key in the file .gitignore. This will allow you to commit the license file to the repository.
2.  Buy the license.
3.  Commit the file to the repository.

## Up and running when somebody already set things up

1.  `heroku git:remote -a <heroku-app-name>`
2.  `heroku config -s | tr -d "'" > .env`
3.  Get your local database up and running or connect to the remote database

## What about assets?!

We usually use S3 on Amazon Web Services. Ask [@kodepoeten](https://github.com/nilsnh) about access to a bucket.

## <a name="global-deps"></a> Global dependencies for the craft-starter

Perform the following steps in a terminal: You only need to do this once per laptop.

- Start by [installing brew](https://brew.sh/)
- Run `brew install heroku` for Heroku command line
- Run `brew install nvm` for Node version manager.
- Run `brew install mysql` for the MySQL command line tools.
- Run `brew cask install docker` for Docker.

### Troubleshooting

> Peow peow!

- Amazon S3: Craft CMS doesn't support bucket location Frankfurt because it uses a newer authentication method.

## Updating from an old Craft starter setup

1.  Get to know this project's `webpack.config.js` and `docker-compose.yml`.
2.  Inside your old project start a new git branch for upgrading. And then try to copy over the build setup for asset building and docker container setup. You should also compare general.php and .htaccess setups to see if there are lessons to learn from the more up to date craft-starter.
3.  Try, try, try until you get it right. Be methodical and commit your progress steadily within the upgrade branch. After some thorough testing you can merge your "upgrade" branch back into master.
