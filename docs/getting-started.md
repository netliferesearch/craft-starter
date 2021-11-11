# Getting started

_Read through the readme_, and if you are stuck, don't hesitate to ask in #craft in Slack. If you have made some smart improvement to the tooling or setup of in your Craft project, _please contribute to this starter by making a pull request_.

Looking to get started with Docker instead? See [using-docker.md](using-docker.md).

## Part one: Installing global dependencies

**Headsup:** To be able to effectively work and debug in the terminal you need to be comfortable with [managing your shell environment](https://fedoramagazine.org/manage-your-shell-environment/).

When installing these dependencies keep in mind that they should try to match the target server environment as close as possible so that you avoid having bugs that only show up in production.

- Start by [installing Homebrew](https://brew.sh/).
- Run `brew install nvm` for [Node Version Manager](https://github.com/nvm-sh/nvm). This is a nice to have for administrating Node versions.
- Run `brew install php` for the latest version of PHP.
- Run `brew install mariadb` for the MySQL command line tools with MariaDB.
  1. **Watch the terminal** output for any potential errors.
  1. Run `brew info mariadb` to re-visit Homebrew's instructions on the package.
  1. Run `brew services mariadb start` to permanently run the database in the background across computer restarts.
  1. **Alternatively** run `mysql.server start` to only run the server until next computer restart.
  1. Finally, after the mysql server process has started. Run `mysql` on the terminal to verify that you're able to log into the database.
- Run `brew install composer` for [Composer](https://getcomposer.org/).
  - Run `composer self-update` to update Composer to latest version.
- Install `valet` which is a command-line tool that helps setup a local PHP development environment. [See Valet installation guide](https://laravel.com/docs/8.x/valet).
  - **Tip:** Valet will always ask you to fill in password for it make changes, but you can run `valet trust` to avoid that.

## Part two: Getting started with a new project

1.  Did you finish installing the global dependencies from the previous step?
1.  Clone, or download this repository.
    - Remember to update the current origin to avoid accidentally pushing project-specific changes to the craft-starter. Example:
    - Update the current `origin` with `git remote set-url origin git@github.com:netliferesearch/repository-name.git`
    - Push to the new origin with `git push --set-upstream origin master`
1.  Run `npm install` to install NPM dependencies.
    - use `nvm use <node-version>` to change Node version.
1.  Run `composer install` to install PHP dependencies.
1.  Run `valet link <name-of-project>` to link the repository.
1.  Run `valet secure <name-of-project>` to add a SSL-certificate.
1.  Check if the project is running with `valet links`. You should be able to
    see your project; `https://<name-of-project>.test`
1.  Run `mysql` to log into the locally running mariadb database.
    - Inside the MySQL prompt create a new database by calling `CREATE DATABASE <name-of-project> CHARACTER SET UTF8mb4 COLLATE utf8mb4_danish_ci;`. Trivia: We use `utf8mb4_danish_ci` to ensure proper ordering of ÆØÅ.
    - To learn your mysql username run `SELECT USER(),CURRENT_USER();` inside the mysql prompt.
1.  Run `cp .env.example .env` to create a `.env` configuration file;
    1.  Within `.env` update `PRIMARY_SITE_URL` and `DATABASE_URL` (remember to replace `<name-of-project>`, `db_user` & `db_password`).
1.  Go to `https://<name-of-project>.test/admin` to install Craft.
    - **Tip:** There's also a `craft` command line tool that has a lot of useful commands, including a command for running the installation from the terminal. [Learn more about the Craft CLI](https://nystudio107.com/blog/exploring-the-craft-cms-3-console-command-line-interface-cli).
1.  After the installation of Craft check out [livereloading guide](livereload.md).

## Troubleshooting

_It is tricky_ to run PHP, Nginx and MySQL natively on the host machine. While this starter tries to create a smooth startup you will need to get comfortable with the terminal and debugging your host environment.

Here's an incomplete list with everything that can go wrong with setting up this starter and suggestions on how to debug and fix it.

Did you deal with an issue not covered here? Please update this list with a pull request so that you can save time for others!

### Database

Things to try if you're having trouble installing and running [MariaDB](https://mariadb.org/):

- Do you have [MAMP](https://www.mamp.info) installed? Uninstall it.
- Do you have [MySQL](https://www.mysql.com/) installed (not MariaDB)? Uninstall it.

MariaDB can have trouble starting up due to old config files laying around. Guide to fully purging the machine before installing MariaDB.

1. Run `brew uninstall mysql`
1. Run `brew uninstall mariadb`
1. Run `find / -name 'mysql'` to find remaining mysql files. Delete these files.
1. Run `find / -name 'my.cnf' -not -path "/Library/*"` to find remaining mysql configuration files. Delete these files.
1. Then reboot your computer to ensure to remove any running mysql processes and free occupied ports.
1. Finally you're ready to run `brew install mariadb` be sure to keep an eye on the terminal messages during the installation.

### Valet (Nginx, PHP)

- Run `valet` to see what commands it offers.
- Run `valet log` to see log options.
- If you're getting Nginx "Gateway 502 error" you can inspect its logs using `valet log nginx`.
  - This might be an error from PHP not running. To fix this you can call `valet use php --force`.

### PHP dependencies

If you recently updated PHP you might have old packages.

1. Delete the `vendor/` folder to remove PHP packages.
1. Run `composer install` to re-download PHP packages.
