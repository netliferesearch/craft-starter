# Going native

Running PHP inside a docker container gives [speed penalties on Windows and MacOS](https://engageinteractive.co.uk/blog/making-docker-faster-on-mac). The solution to that is to fire up [Valet](https://laravel.com/docs/7.x/valet), for full native development locally.

## Usage

1. Install [Valet](https://laravel.com/docs/7.x/valet).
1. cd into `public/` folder and call `valet link my-site`.

- Call `valet links` to see where this site is hosted.

1. Copy `.env-example` into `.env`

- Be sure to configure `PROXY_SITE_URL` to point to the site configured in `valet links`.

1. Start local database with `./startOnlyDatabase.sh`.

- Within `.env` Make sure to add `DATABASE_URL=mysql://root:somegloriouspassword@127.0.0.1:3306/craft_cms`

1. Run `npm run dev`.
1. Goto `PROXY_SITE_URL/admin` to install Craft.
1. When editing .twig, .css and .js be sure to use `localhost:3000` to get livereloading functionality.
