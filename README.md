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

The minimum requirement by this project template that your Web server supports PHP 8+.

RESOURCES
------------

- Nginx + PHP 8.1 with Docker using [Webdevops Images](https://github.com/webdevops/Dockerfile) 
- PHP Unit 9.5
- Yii2 Bootstrap 5 Extension
- PHP Codesniffer 3.5
- PHP Codesniffer Fixer 3

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

```bash
# ---------
# Docker
# ---------
PROJECT_NAME=yii2-skeleton
DOCKER_APP_PORT=8080
DOCKER_APP_SSL_PORT=443
DOCKER_MYSQL_PORT=3306
XDEBUG_REMOTE_PORT=9000

# ---------
# Application
# ---------
YII_ENV=dev
YII_DEBUG=true
REQUEST_COOKIE_VALIDATION_KEY=YOUR_VALIDATION_KEY
ADMIN_PASSWORD=
# APP_TIMEZONE=America/Sao_Paulo
# APP_LANGUAGE=pt_BR
APP_BASE_URL=http://localhost:8088

# ---------
# Database
# ---------
DB_HOST=your-db-host
DB_USERNAME=root
DB_PASSWORD=secret
DB_DATABASE=your-db-name
DB_DATABASE_TEST=your-test-db-name
DB_SCHEMA_CACHE_DURATION=60

# ---------
# Mailer
# ---------
SMTP_HOST=
SMTP_PORT=465
SMTP_USERNAME=
SMTP_PASSWORD=
SMTP_ENCRYPTION=ssl
```

**NOTE:** the commented environment variables are optional and your values set here is its default value.

### Run your Application

Before anything change `PROJECT_NAME` env variable to your project name/alias. This one it will be used to prefixed the application containers and other stuff.

To start your application and start up your containers just run the follow command:

```
make run
```

The command above will start 2 docker containers: `yii2-skeleton-app` (Nginx + PHP 8.1) and `yii2-skeleton-db` (MySQL)

If you have set a `DOCKER_APP_PORT` environment variable to `8000`, you will can then access the yout application through the following URL:

```
http://localhost:8000
```

COHESIVE CONTROLLER
------------
Trying to follow the best programming practices, this boilerplate has a controller type called [CohesiveController](src/Shared/Controller/CohesiveController.php) to help you a create a controller class with a single action (aka `handle()` method) and a single responsibility.

To create a cohesive controller got to [config/routes.php](./config/routes.php) and add your route such as:

```php
<?php

return [
    // other routes...

    'specific/route/to/cohesive/a/controller' => 'cohesive-xpto-routine'
];
```

The next step is create your `CohesiveXptoRoutineController` class extending from `App\Core\Controller\CohesiveController` and implement the `handle()` method, as below:

```php
<?php

namespace App\Controllers;

use App\Core\Controller\CohesiveController;

class CohesiveXptoRoutineController extends CohesiveController
{
    public function handle()
    {
        // your cohesive and specific implementation here =)
    }
}
```

Finally, access your Cohesive action: http://localhost:8080/specific/route/to/cohesive/a/controller

THE USEFUL MAKEFILE
------------

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
 
 
