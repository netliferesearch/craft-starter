# Upgrading a legacy rig

**Heads up:** This guide was written back when we still recommended using Docker for local development. This document is old, yet potentially useful. See [getting-started.md](getting-started.md) for our current best practise recommendations.

You are reading this because you have a legacy Craft 2 project on your hands. And you would like to upgrade it a little bit into the future so that you get nice things like containerisation and better build setup. Read on dear reader, read on:

## Adding docker

_Why:_ We use docker so that we do not have to install and re-install all sorts of php dependencies on our machine. We need to be able to quickly jump between Craft projects and get up and running.

How: Essentially we need to copy code from [the current craft-starter](https://github.com/netliferesearch/craft-starter), and adjust as we go along.

1. Copy the `docker-compose.yml` from the craft-starter into the legacy project.
2. Copy the `docker-src/` folder from the craft-starter into the legacy project.
3. Place a copy of the production data (an .sql file) into the `docker-src/db-dump`. You can grab a copy of the data by logging into the dashboard of the service you are upgrading, and finding the option for backing up the database.
4. Run `docker-compose up`. This will start up a number of services such as a database and a php-enabled apache server.
5. GOTO `localhost:5000` and see if your site is running. Most likely php will have trouble finding the database. The solution is to compare configuration between the new and the old rig, namely have a look at the files `db.php` and `general.php`.
6. Once you get things working be sure to update the project readme based on the craft-starter readme template.
7. Delete files that are no longer needed. Tidy things up. :sparkles:

## Do a security audit.

1. Run `npm audit` to evaluate if you have any vulnerable npm packages.
1. Run `npm audit fix` to attempt a non-breaking upgrade.
1. Evaluate if asset building still works properly after the upgrade. If so, commit the changes.

## Bonus points: Upgrading webpack/bower/gulp

Again, it's about comparing the build setups between the old and the new craft-starter.
