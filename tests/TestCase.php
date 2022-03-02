<?php

namespace Tests;

use Faker\Factory as Faker;
use Faker\Generator;
use Yii;
use Dotenv\Dotenv;
use yii\helpers\ArrayHelper;
use PHPUnit\Framework\TestCase as PHPUnitTestCast;

/**
 * This is the base class for all yii framework unit tests.
 */
abstract class TestCase extends PHPUnitTestCast
{
    use Asserts;

    protected static Generator $faker;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        self::$faker = Faker::create('pt_BR');
    }

    /**
     * Clean up after test case.
     */
    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        $logger = Yii::getLogger();
        $logger->flush();
    }

    /**
     * Clean up after test.
     * By default the application created with [[mockApplication]] will be destroyed.
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        $this->destroyApplication();
    }

    /**
     * Populates Yii::$app with a new application
     * The application will be destroyed on tearDown() automatically.
     * @param array $config The application configuration, if needed
     * @param string $appClass name of the application class to create
     */
    protected function mockApplication(array $config = [], string $appClass = '\yii\console\Application')
    {
        new $appClass(ArrayHelper::merge([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => $this->getVendorPath(),
            'params' => require __DIR__ . '/../config/params.php'
        ], $config));

        require_once __DIR__ . '/di.php';
    }

    protected function mockApplicationWithRedis($config = [])
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $this->mockApplication(ArrayHelper::merge([
            'components' => [
                'redisTests' => require __DIR__ . '/../config/redis-tests.php',
            ],
        ], $config));
    }

    protected function mockApplicationWithDB($config = [])
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $this->mockApplication(ArrayHelper::merge([
            'components' => [
                'db' => require __DIR__ . '/../config/db.php',
            ],
        ], $config));
    }

    protected function getVendorPath(): string
    {
        $vendor = dirname(__DIR__, 2) . '/vendor';

        if (!is_dir($vendor)) {
            $vendor = dirname(__DIR__, 4);
        }

        return $vendor;
    }

    /**
     * Destroys application in Yii::$app by setting it to null.
     */
    protected function destroyApplication()
    {
        if (Yii::$app && Yii::$app->has('session', true)) {
            Yii::$app->session->close();
        }

        Yii::$app = null;
    }
}
