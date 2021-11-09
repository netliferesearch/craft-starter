# Using Docker

Running PHP inside a docker container gives
[speed penalties on Windows and MacOS](https://engageinteractive.co.uk/blog/making-docker-faster-on-mac).
The solution to that is to fire up [Valet](https://laravel.com/docs/7.x/valet),
for full native development locally.

## Setup

1. Run docker-compose up to start three containers (details found in
   [`docker-compose.yml`](../docker-compose.yml)):
1. Apache Server, to mirror production environment.
1. Mysql, the database.
1. It might/will take some time for the containers to finish building and there
   will be no complete message. So, just wait a bit until the text stops flowing
   and then go to [`localhost:5000/admin`](http://localhost:5000/admin) to install
   Craft.
