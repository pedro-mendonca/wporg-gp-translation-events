# wporg-gp-translation-events

## Development environment
First follow [instructions to install `wp-env`](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/#prerequisites).

Then you can run a local WordPress instance with the plugin installed:

```shell
composer dev:start
```

Once the environment is running, you must create the database tables needed by this plugin:

```shell
composer dev:db:schema
```

WordPress is now running at http://localhost:8888, user: `admin`, password: `password`.