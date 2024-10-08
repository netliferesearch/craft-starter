This readme.md file is a template that you must fill out as you embark on a new project, or upgrade an old Craft CMS setup.

See also the [docs/](docs) folder for useful guides including:

- [Getting started](docs/getting-started.md).
- [Activating livereload in development](docs/livereload.md).
- [Handling assets across environments](docs/assets.md).
- [Testing email locally](https://ryangjchandler.co.uk/posts/setup-mailhog-with-laravel-valet).
- [Upgrading legacy stuff](docs/upgrading-legacy-rig.md).

# Your project title

## Usage

1.  Explain
2.  In
3.  Simple terms how to get started developing.

## Deployment

1.  How and where
2.  is
3.  this project deployed?

## Things to know

- What should future developers be aware about when developing on this rig?
- Where are the assets hosted? AWS S3, local filesystem, somwhere else?

### Included plugins

We've included some plugins that we use in a lot of projects. Most of them are free. Ask Torgeir or Anna if some is unclear.

- [Redactor](https://plugins.craftcms.com/redactor) - Adds Redactor WYSIWIG editor field, see config files in config/redactor
- [Seomatic](https://plugins.craftcms.com/seomatic) - Paid plugin, but really worth it.
- [Linkfield](https://plugins.craftcms.com/typedlinkfield) - Adds link field type to Craft.

# Environment variables
We are using the .env-file to store license keys and other variables that Craft uses. You'll find examples in [here](.env.example). Most of these are used in [the config file](config/general.php).

## Plugin license keys
When installing a new plugin add the license key to the .env-file (and update the .env.example-file), and follow the naming convention (PLUGIN_<PLUGIN_HANDLE>_LICENSE)
