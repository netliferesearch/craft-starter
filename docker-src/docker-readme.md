# Craft CMS Composer base docker image.

Not for use in production, only development. When starting up the user `www-data` is given heightened privileges (usermod uid set to 1000), this was done to help ease local development on Linux.

When building the container installs PHP support for a number of php extensions, including: gd, mcrypt, mysql, imagick, redis and enables mod_rewrite in Apache.

This image builds on the [official docker php image](https://hub.docker.com/_/php/).

## Testing locally built image

1.  Build image with `docker build -t craft-starter-test .`
    - Change the image name if you want projects on your computer to use this image instead of the image built by Docker Hub.
1.  Run `docker run -p 8080:80 --rm -it -v "$PWD/test":/var/www/html/public craft-starter-test`
    - You can use `docker exec -it $CONTAINER_ID bash` to start a shell within a container for easier debugging.
1.  Visit `localhost:8080` in your browser.
1.  Editing `test/index.php` will affect the output when refreshing the browser.

## Testing image built by Docker Hub

1.  Push changes to git repository. This should trigger an automated build if it is setup. Login with 1password if you need to see how it is setup.
1.  Run `docker run -p 8080:80 --rm -it -v "$PWD/test":/var/www/html/public netlifedesign/craft-starter`
    - You can use `docker exec -it $CONTAINER_ID bash` to start a shell within a container for easier debugging.
1.  Visit `localhost:8080` in your browser.
1.  Editing `test/index.php` will affect the output when refreshing the browser.

## Things to know about

- Building this Docker image locally on MacOS can lead to weird issues with compiling code written in C (PHP PECL + Composer). That's why we use hub.docker.com to build images for us.
