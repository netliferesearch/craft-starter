# Netlife Design: Craft Starter

_Read through the readme_, and if you are stuck, don't hesitate to ask in either #frontend or #craft in Slack. If you have made some smart improvement to the tooling or setup of in your Craft project, _please contribute to this starter by making a pull request_.

Looking to get started with Docker instead? See [using-docker.md](using-docker.md).

## Getting started

1.  Clone, or download this repository
1.  If you haven't already install [global dependencies for the craft-starter](#global-deps).
1.  Run `npm install` to install NPM dependencies.
1.  Run `valet link <name-of-project>` to link the repository.
1.  Run `valet secure <name-of-project>` to add a SSL-certificate.
1.  Check if the project is running with `valet links`. You should be able to
    see your project; `https://<name-of-project>.test`
1.  Run `mysql` to log into the locally running mariadb database.
    - Inside the MySQL prompt create a new database by calling `CREATE DATABASE <name-of-project> CHARACTER SET UTF8mb4 COLLATE utf8mb4_danish_ci;` Trivia: We use `utf8mb4_danish_ci` to ensure proper ordering of ÆØÅ.
    - To learn your mysql username run `SELECT USER(),CURRENT_USER();` inside the mysql prompt.
1.  Run `cp .env.example .env` to create a `.env` configuration file based on the example file and complete its configuration.
    - DATABASE_URL=mysql://username@localhost/<name-of-project>
1.  Go to `https://<name-of-project>.test/admin` to install Craft.

### Troubleshooting getting started

Running PHP, Nginx and MySQL natively on the host machine can definitely be tricky.

### Start livereloading and asset building on localhost:3000

When you have docker-compose running in one terminal window please open a second window where you run `npm run dev`. This will start a process that will be building our frontend dependencies. Our build setup provides a [`localhost:3000`](http://localhost:3000) address that shows the same as localhost:5000 but also has livereloading.

Edit CSS and JavaScript in the `/resources/`-folder. Webpack will compile, transpile, minify it into the `public` folder, ready for production. If you put files in the assets-folder, Webpack will handle those too (see file-loader).

The `main.css` is built into `public/dist/main.dist.css` and it injects vendor prefixes and inlines smaller static resources (icon fonts for example).

The file `resources/js/main.js` is built into `public/dist/main.dist.js`, and it uses Babel, allowing you to both write ES6 as well as using a Node.js style if you prefer.

Both files are included in `./templates/_layout.twig`

When you want to login into Craft you'll need to go to [`localhost:5000/admin`](http://localhost:5000/admin), because [`localhost:3000`](http://localhost:3000) is just a livereloading proxy that can't handle logins.

## Changing the remote git repository

If you have cloned this project, the git remote `origin` is set to the craft-starter repository. Unless you're actually working on improving the craft-starter, you should set the remote `origin` to your project repository.

1.  Update the current `origin` with `git remote set-url origin git@github.com:netliferesearch/repository-name.git`
2.  Push to the new origin with `git push --set-upstream origin master`

## What about assets?!

We usually use S3 on Amazon Web Services. By storing assets in S3 we have an easier time switching between various server environments without manually copying assets around.

S3 is a bit complicated to configure so we have created [AWS helper scripts here](https://github.com/netliferesearch/aws-helper-scripts). Be sure to use Netlife's AWS account.

**Gotcha:** Craft CMS doesn't support bucket location Frankfurt because it uses a newer authentication method.

## <a name="global-deps"></a> Global dependencies for the craft-starter

Perform the following steps in a terminal: You only need to do this once per laptop.

- Start by [installing Homebrew (`brew`)](https://brew.sh/)
- Run `brew install nvm` for [Node Version Manager](https://github.com/nvm-sh/nvm). This is a nice to have for administrating Node versions.
- Run `brew install php` for the latest version of PHP.
- Run `brew install mariadb` for the MySQL command line tools with MariaDB.
- Run `brew install composer` for [Composer](https://getcomposer.org/).
  - Run `composer self-update` to update Composer to latest version.
- Run `composer global require laravel/valet` for [Valet](https://laravel.com/docs/8.x/valet)
  - To update valet run `composer global update`.
