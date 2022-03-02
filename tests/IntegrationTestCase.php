<?php

namespace Tests;

use App\Auth\Infra\ActiveRecord\User;
use DersonSena\Yii2Tactician\Yii2TacticianCommandBus;
use Faker\Factory as Faker;
use Faker\Generator;
use PDO;
use PHPUnit\Framework\TestCase as PHPUnitTestCast;
use Yii;
use yii\helpers\ArrayHelper;

class IntegrationTestCase extends PHPUnitTestCast
{
    use Asserts;

    protected static Generator $faker;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        self::$faker = Faker::create('pt_BR');
    }

    public static function setUpBeforeClass(): void
    {
        self::mockApplication([], '\yii\console\Application');
        self::performMigrations();
    }

    protected function setUp(): void
    {
        self::mockApplication();
    }

    protected function tearDown(): void
    {
        self::destroyApplication();
    }

    /**
     * Populates Yii::$app with a new application
     * The application will be destroyed on tearDown() automatically.
     * @param array $config The application configuration, if needed
     * @param string $appClass name of the application class to create
     */
    protected static function mockApplication(array $config = [], string $appClass = '\yii\web\Application')
    {
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_ENV') or define('YII_ENV', 'test');

        $routes = require __DIR__ . '/../routes/index.php';

        $_SERVER['SCRIPT_FILENAME'] = '/app/web/index.php';
        $_SERVER['SCRIPT_NAME'] = '/index.php';

        new $appClass(ArrayHelper::merge([
            'id' => 'test-acceptance-app',
            'language' => 'pt_BR',
            'basePath' => __DIR__,
            'vendorPath' => dirname(__DIR__, 2) . '/vendor',
            'timeZone' => $_ENV['APP_TIMEZONE'],
            'params' => require __DIR__ . '/../config/params.php',
            'controllerMap' => $routes['controllerMap'],
            'components' => [
                'user' => [
                    'class' => \yii\web\User::class,
                    'identityClass' => User::class,
                    'enableAutoLogin' => false,
                    'enableSession' => false,
                    'loginUrl' => null
                ],
                'urlManager' => [
                    'enablePrettyUrl' => true,
                    'showScriptName' => false,
                    'rules' => $routes['routes']
                ],
                'commandBus' => [
                    'class' => Yii2TacticianCommandBus::class
                ],
                'db' => require __DIR__ . '/../config/db.php',
                'log' => require __DIR__ . '/../config/log.php'
            ],
        ], $config));

        require_once __DIR__ . '/../config/di.php';
    }

    protected static function destroyApplication(): void
    {
        if (Yii::$app && Yii::$app->has('session', true)) {
            Yii::$app->session->close();
        }

        Yii::$app = null;
    }

    protected static function performMigrations(): void
    {
        $dbh = new PDO("mysql:host={$_ENV['DB_HOST']}", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

        if (!isset($_ENV['DB_DROP_TEST_DATABASE'])) {
            $dbh->exec("DROP DATABASE IF EXISTS `{$_ENV['DB_DATABASE_TEST']}`");
        }

        $dbh->exec("
            CREATE DATABASE IF NOT EXISTS `{$_ENV['DB_DATABASE_TEST']}` CHARACTER SET utf8 COLLATE utf8_general_ci
        ");

        Yii::$app->runAction('migrate', [
            'migrationPath' => '@root/database/migrations/',
            'interactive' => false
        ]);
    }
}
