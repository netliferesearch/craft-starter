# Start livereloading and asset building on localhost:3000

1. Run `npm run dev` to start a Browsersync instance listening on localhost:3000 that is a proxy in front of the `PRIMARY_SITE_URL` as defined in the `.env` file.
1. You will get an insecure https error from BrowserSync, so you'll need to explicitly trust the connection for the proxy request to go trough.

Edit CSS and JavaScript in the `/resources/`-folder. Webpack will compile, transpile, minify it into the `public` folder, ready for production. If you put files in the assets-folder, Webpack will handle those too (see file-loader).

The `main.css` is built into `public/dist/main.dist.css` and it injects vendor prefixes and inlines smaller static resources (icon fonts for example).

The file `resources/js/main.js` is built into `public/dist/main.dist.js`, and it uses Babel, allowing you to both write ES6 as well as using a Node.js style if you prefer.

Both files are included in `./templates/_layout.twig`

When you want to login into Craft you'll need to go to [`<name-of-project>.test/admin`](http://<name-of-project>.test/admin), because [`localhost:3000`](https://localhost:3000) is just a livereloading proxy that can't handle logins.

## With Docker

Remember to read the [using Docker guide](using-docker.md)

When you have `docker-compose` running in one terminal window please open a second window where you run `npm run dev`. This will start a process that will be building our frontend dependencies. Our build setup provides a [`localhost:3000`](http://localhost:3000) address that shows the same as localhost:5000 but also has livereloading.

When you want to login into Craft you'll need to go to [`localhost:5000/admin`](http://localhost:5000/admin), because [`localhost:3000`](http://localhost:3000) is just a livereloading proxy that can't handle logins.
