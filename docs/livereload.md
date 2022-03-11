# Start livereloading and asset building on localhost:3000

1. Run `npm run dev` to start a [Vite](https://vitejs.dev/) Server on localhost:3000 that will serve script and style resources.
1. On the initial `npm run dev` you might be prompted for you password to authorize the creation of a SSL certificat for you localhost so that the resources can be served from https://localhost:3000.

> **NB!** Note that the root of https://localhost:3000 is not serving anything, only the path to your resources (e.g. https://localhost:3000/resources/js/main.js').

With `npm run dev` running, when you edit CSS and JavaScript in the `/resources/`-folder, Vite will provide a Hot Module Replacement (HMR) experience to your browser running [`<name-of-project>.test`](http://<name-of-project>.test) - refreshing changes on save.

> **NB!** The frontend code will throw an `Calling unknown method` error if the Vite plugin hasn't been enabled yet in the Craft dashboard under settings -> plugins.

To achieve HMR, the CSS is imported into the main JS-file and added to the DOM via the [Craft Vite plugin](https://plugins.craftcms.com/vite) (when in `dev` mode):

```
{{ craft.vite.script('resources/js/main.js', false) }}
```

Vite will also be listening to changes in yor `template`-files and refresh the browser window when files change.

## Build for production

To build for production, run `npm run build` (this will typically be automated as part of the deploy pipelines).

When `npm run build` is run, Vite vil use Rollup to transpile, minify etc resources and generate production ready files in the `public/dist` folder. It will generate ESM files for modern browsers and legacy-versions for older browsers, as well provide automatic cache busting through hashes in the filenames.

When not in dev mode the `{{ craft.vite.script(...) }}` tag will inject the correct paths to the DOM. This means that when testing build configuration locally, you need to switch your `CRAFT_ENVIRONMENT` to `production` or `staging` in your .env.

Vite is mostly zero-config, but can be customized in the `/vite.config.js`-file.

The Craft Vite Plugin can be configured in the `/config/vite.php`-file.

For more details and guides on cofiguration, see:

- https://nystudio107.com/blog/using-vite-js-next-generation-frontend-tooling-with-craft-cms
- https://vitejs.dev/guide/#scaffolding-your-first-vite-project
- https://nystudio107.com/docs/vite/

## With Docker

Remember to read the [using Docker guide](using-docker.md).

If you are running in Docker, you need to make a couple of adjustments:

1.  In `/config/vite.php`, set `devServerPublic` variable to `http://localhost:3000/` (not `https`).
1.  Update the `server`object of the vite config file (`/vite.config.js`) to the following:

````
  server: {
    origin: 'https://localhost:3000',
    host: '0.0.0.0',  // <- for docker
    hmr: {
      host: 'localhost',
    },
  },
```
````
