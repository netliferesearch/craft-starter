# Netlife Research: Craft Starter

Read through the readme, and if you are stuck, don't hesitate to ask in either #frontend or #craft in Slack.

## Get started

1. Clone, or download this repository
2. Install global dependencies if not installed already (see bottom of file)
3. Install dependencies
4. Make a repository on GitHub
5. Run `npm run init`
6. Set up a Heroku app

## Changing the remote git repository

If you have cloned this project, the git remote `origin` is set to the craft-starter repository. Unless you're actually working on improving the craft-starter, you should set the remote `origin` to your project repository.

1. Remove the current `origin` with `git remote rm origin`
2. Add the new origin with `git remote add origin git@github.com:netliferesearch/repository-name`
3. Push to the new origin with `git push --set-upstream origin master`

## Install craft
Go to [http://localhost:5000/admin](http://localhost:5000/admin) and follow the wizard to install craft.

If you want to change this URL, you'll have to change it in `start.sh`. If you want to use browser-sync, you'll have to change it in `webpack.config.js` (line 58) as well.

## Dependencies

1. `composer install`
2. `npm i` ([alternately `yarn`](https://yarnpkg.com/))

## Setting up the project on Heroku for the first time

Push this button (remember to set the correct region)
[![Deploy](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy?template=https://github.com/netliferesearch/craft-starter/tree/master)


### Manually

Make sure you install global dependencies like Heroku toolbelt first.

1. `heroku create <name> --region eu`
2. `heroku buildpacks:set heroku/php`
3. `heroku addons:create jawsdb`
4. `heroku config -s | tr -d "'" > .env`
5. `npm run init`

## Heroku local configuration

1. Make sure that you've logged in, and have access to the project on Heroku: `heroku login`
2. Run `heroku config --app <name> -s | tr -d "'" > .env` in terminal

`<name>` is the name of your app. E.g `https://<name>.herokuapp.com/`

## Developing on a local database

This project is set up to use the JAWSDB as the mysql addon on Heroku. Provided that is used, you can run this command in bash from your project folder to download a dump of the database:

```bash
heroku config:get JAWSDB_URL|sed -E 's%mysql:\/\/(.+):(.+)@(.+)(:3306| )\/(.+)(\?reconnect=true)%mysqldump --host=\3 --user=\1 --password=\2 \5%'|sh > dump.sql
```

This command first gets the mysql-url for JAWSDB in the Heroku config. Then it pipes it to `sed`, which [parses it through regex](https://regex101.com/r/EeO9HR/1) and outputs the `mysqldump` command with proper credentials. This text string is piped into `sh` which runs it. With `> dump.sql` we make sure that the output (which is a bunch of sql insert commands) is saved to a file with the name dump.sql.

This file can then be imported into any mysql database, including your local. 

1. If typing `mysql` in the terminal does nothing, install it with `brew install mysql`
2. Make sure it runs by typing `mysql.server start`
3. Set `LOCAL_DATABASE_URL=mysql://user:password@127.0.0.1/databasename` in your .env-file. The username is usually `root`. If your database has no password, just omit colon and password-string (`user@127…`)
4. Run this command from the folder with the dump.sql file to import the database dump, assuming that both username and password is `root`: 

```bash
mysql --host=127.0.0.1 --user=root --password=root databasename < dump.sql
```

Done!

If all these steps were successfull you can run `npm run sync` to download the mysql dump and import it in one turn.

## Start working

`npm run dev` starts the web server + webpack. Webpack processes Sass + JS. This craft-starter comes ready with [Browser-Sync](http://www.browsersync.io/) – that means that you don't *need* CodeKit.

Edit Sass and JavaScript in the `/resources/`-folder. Webpack will compile, transpile, minify it into the `public` folder, ready for production. If you put files in the assets-folder, Webpack will handle those too. The `style.scss` is built into `public/style.css` and it injects vendor prefixes and inlines smaller static resources (icon fonts for example). The file `resources/js/app.js` is built into `public/js/min/app.min.js`, and it uses Browserify + Babel, allowing you to both write ES6 as well as using a Node.js style if you prefer.

Both files are properly included in `craft/templates/_layout.twig`

## Global dependencies for the starter-pack

Perform the following steps in a terminal:
You only need to do this once per system.

### PHP
* Install homebrew: `ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"`
* `brew tap homebrew/dupes`
* `brew tap homebrew/versions`
* `brew tap homebrew/homebrew-php`
* `brew install php70 php70-mcrypt php70-imagick composer`
* `brew link php70`

### Node Version Manager + tools

* Install Heroku toolbelt <https://toolbelt.heroku.com/>
  * `brew install heroku`
* `brew install nvm`
