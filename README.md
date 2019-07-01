<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Skeleton</h1>
    <br>
</p>

Yii 2 Skeleton is a new approach to a design skeleton using [Yii 2](http://www.yiiframework.com/) as a basis.

The motivation to make this new template was to try to organize the packages inside a `src` directory, keeping all the class there, ie a place where the main application code will be.

REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 7+.

INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project template using the following command:

```
php composer.phar create-project dersonsena/yii2-skeleton skeleton
```

### Your Enviroments Variables

Make a copy of the `.env.sample` file, you can use `cp .env.sample .env` in your terminal to do that.

You can place your environment settings in `.env` file, as below (note the sample file is ready to basic usage):

```yml
# ---------
# Docker
# ---------
DOCKER_APP_PORT=8000
DOCKER_APP_SERVICE_NAME=yii2-skeleton-app
DOCKER_DB_SERVICE_NAME=yii2-skeleton-db
DOCKER_MYSQL_PORT=4500
XDEBUG_REMOTE_HOST=
XDEBUG_REMOTE_PORT=9000

# ---------
# Yii Framework
# ---------
YII_DEBUG=true
YII_ENV=dev
REQUEST_COOKIE_VALIDATION_KEY=mL3QmMN-xV-uyY3VyqE9P-M5YzxMTrSn

# ---------
# Database
# ---------
DB_DSN=mysql:host=yii2-skeleton-db;dbname=yii2-skeleton
DB_USERNAME=root
DB_PASSWORD=secret
DB_DATABASE=yii2-skeleton
DB_TABLE_PREFIX=
DB_CHARSET=utf8

DB_ENABLE_SCHEMA_CACHE=false
DB_SCHEMA_CACHE_DURATION=60
DB_SCHEMA_CACHE_NAME=cache

# ---------
# Mailer
# ---------
SMTP_HOST=your.smtp.dns
SMTP_PORT=437
SMTP_USERNAME=your_smtp_username
SMTP_PASSWORD=your_smtp_password
SMTP_ENCRYPTION=
```

### Run your Application

To start your application using Docker container, just run the follow command:

```
docker-compose up -d
```

If you have set a `DOCKER_APP_PORT` environment variable to `8000`, you will can then access the yout application through the following URL:

```
http://localhost:8000
```

### The useful Make file

The makefile file has several commands to help with day-to-day work. In it you can execute commands inside the container by typing a few letters in your terminal.

If you wanted to install or update the dependencies of your application, you should do something like:

```
docker exec -it YOUR_CONTAINER_NAME composer install -o
```

For you not to have to write all this, use `make`:

```
make install
```

Thanks [@wilcorrea](https://github.com/wilcorrea) for showing me this simple yet useful approach.

The [makefile](https://github.com/dersonsena/yii2-skeleton/blob/master/makefile) of skeleton comes with the following commands:

- #### **install**<br>
	Perform composer install with optimize autoloaders parameter<br>
    ex.: `make install`

- #### **require**<br>
	Perform composer require with the PACKAGE parameter<br>
    ex.: `make PACKAGE="vendor/package" require`

- #### **dump**<br>
	Run composer command `dump-autoload`<br>
    ex.: `make dump`

- #### **migrate**<br>
	Alias to execute `yii migrate` in app container and run all migrations that are not applied<br>
    ex.: `make migrate`

- #### **migrate-create**<br>
	Create a new migration in the project<br>
    ex.: `make NAME="my-cute-migration" migrate-create`

- #### **migrate-down**<br>
	Rollback the last migration<br>
    ex.: `make migrate-down`

- #### **cache-clear**<br>
	Just run the `yii cache/flush-all` into app container<br>
    ex.: `make cache-clear`

- #### **db-backup**<br>
	Generate a `backup.sql` in the project root dir with a hot backup<br>
    e.: `make db-backup`

- #### **db-restore**<br>
	Import a `backup.sql` that are in the project root dir to database container<br>
    e.: `make db-restore`
 
 
