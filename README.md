Configure Google Cloud SDK with your account and the appropriate project ID:

```
$ gcloud init
```

Create an App Engine application within your new project:

```
$ gcloud app create
```

Then configure the App Engine default GCS bucket for later use. The default App
Engine bucket is named YOUR_PROJECT_ID.appspot.com. Change the default Access
Control List (ACL) of that bucket as follows:

```
$ gsutil defacl ch -u AllUsers:R gs://YOUR_PROJECT_ID.appspot.com
```

### Create and configure a Cloud SQL for MySQL 2nd generation instance

Note: In this guide, we use `wp` for various resource names; the instance
name, the database name, and the user name.

Create a new Cloud SQL for MySQL Second Generation instance with the following
command:

```
$ gcloud sql instances create wp \
  --activation-policy=ALWAYS \
    --tier=db-n1-standard-1
```

Note: you can choose `db-f1-micro` or `db-g1-small` instead of
`db-n1-standard-1` for the Cloud SQL machine type, especially for the
development or testing purpose. However, those machine types are not
recommended for production use and are not eligible for Cloud SQL SLA
coverage. See our [Cloud SQL SLA](https://cloud.google.com/sql/sla)
for more details.

Then change the root password for your instance:

```
$ gcloud sql users set-password root % \
  --instance wp --password=YOUR_INSTANCE_ROOT_PASSWORD # Don't use this password!
```

Now you can access the Cloud SQL instance with the MySQL client in a separate
command line tab. Create a new database and a user as follows:

```
`gcloud sql users create dbuser % --instance webdb --password mimi8na46kuro@Ezweb`
```

## How to use

First install the dependencies in this directory as follows:

```
$ composer install
```

If it complains about extensions, please install `phar` and `zip` PHP
extensions and retry.

Then run the helper command.

```
$ php wordpress-helper.php setup
```

The command asks you several questions, please answer them. Then you'll have a
new WordPress project. By default it will create `my-wordpress-project` in the
current directory.

## Deployment

CD into your WordPress project directory and run the following command to
deploy:

```
$ cd my-wordpress-project
$ gcloud app deploy \
    --promote --stop-previous-version app.yaml cron.yaml
```

Then access your site, and continue the installation step. The URL is:
https://PROJECT_ID.appspot.com/

Go to the Dashboard at https://PROJECT_ID.appspot.com/wp-admin. On the Plugins page, activate the following
plugins:


- For the standard environment
  - Batcache Manager
  - Google App Engine for WordPress (also set the e-mail address in its
    settings page)
- For the flexible environment
  - Batcache Manager
  - GCS media plugin

After activating the plugins, try uploading a media object in a new post
and confirm the image is uploaded to the GCS bucket by visiting the
[Google Cloud console's Storage page][cloud-storage-console].

## Check if the Batcache plugin is working

On the plugin page in the WordPress dashboard, click on the Drop-ins tab near
the top. You should see 2 drop-ins are activated: `advanced-cache.php` and
`object-cache.php`.

To make sure it’s really working, you can open an incognito window and
visit the site because the cache plugin only serves from cache to
anonymous users. Then go to
[the memcache dashboard in the Cloud Console][memcache-dashboard] and
check the hit ratio and number of items in cache.

## Various workflows

### Install/Update Wordpress, plugins, and themes

Because the wp-content directory on the server is read-only, you have
to do this locally. Run WordPress locally and update plugins/themes in
the local Dashboard, then deploy, then activate them in the production
Dashboard. You can also use the `wp-cli` utility as follows (be sure to keep
the cloud SQL proxy running):

```
# To update Wordpress itself
$ vendor/bin/wp core update --path=wordpress
# To update all the plugins
$ vendor/bin/wp plugin update --all --path=wordpress
# To update all the themes
$ vendor/bin/wp theme update --all --path=wordpress
```

If you're using App Engine Standard, You may get the following error:

```
Failed opening required 'google/appengine/api/urlfetch_service_pb.php'
```

You can set a `WP_CLI_PHP_ARGS` environment variable to add
`include_path` PHP configuration for wp-cli.

```
$ export WP_CLI_PHP_ARGS='-d include_path=vendor/google/appengine-php-sdk'
```
