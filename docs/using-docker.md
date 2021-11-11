# Using Docker

Running PHP inside a docker container gives
[speed penalties on Windows and MacOS](https://engageinteractive.co.uk/blog/making-docker-faster-on-mac). This penalty also applies to Craft's Nitro2 which uses Docker under the hood.

This is why we recommend using [Valet](https://laravel.com/docs/7.x/valet) in our [getting-started.md](getting-started.md) guide.

Nevertheless, if you still want to use Docker feel free to read on.

## Setting up Docker

1. Move `docker-compose.yml` from `docker-src/` into the project root folder.
1. Run `docker-compose` in the project root to start containers for the PHP server and the database:
   - Apache Server, to mirror production environment.
   - Mysql, the database.
1. It ~might~ will take some time for the containers to finish building and there
   will be no completion message. So, just wait a bit until the text stops flowing
   and then go to [`localhost:5000/admin`](http://localhost:5000/admin) to install
   Craft.

## More details about the Dockerfile

The Dockerfile is not meant to be used in production, only development. When starting up the user `www-data` is given heightened privileges (usermod uid set to 1000), this was done to help ease local development on Linux.

When building the container installs PHP support for a number of php extensions, including: gd, mcrypt, mysql, imagick, redis and enables mod_rewrite in Apache.

This image builds on the [official docker php image](https://hub.docker.com/_/php/).

**Headsup!** Building this Docker image locally on MacOS can lead to weird issues with compiling code written in C (PHP PECL + Composer). That's why we use hub.docker.com to build images for us.

You can use `docker exec -it $CONTAINER_ID bash` to start a shell within a container for easier debugging.
