<?php


namespace App\Tests;

use Nette\Caching\Storages\MemoryStorage;
use Nette\DI\Container;
use Nette\Loaders\RobotLoader;

/**
 * Author: Jakub Barta <jakub.barta@gmail.com>
 * Date: 01.07.15
 * Time: 12:48
 */

class Environment
{
    /** @var Container */
    private static $container = null;

    private static $initialized = false;

    public static function getContainer()
    {
        return self::$container;
    }

    public static function getByType($type)
    {
        return self::$container->getByType($type);
    }

    public static function initialize()
    {
        if (self::$initialized) {
            throw new \Exception("Already initialized");
        }

        $loader = new RobotLoader();
        $loader
            ->addDirectory(__DIR__ . "/../../app")
            ->addDirectory(__DIR__);
        $loader->setCacheStorage(new MemoryStorage());

        $loader->register();

        $container = require __DIR__ . "/../../app/bootstrap.php";
        $container->removeService("nette.userStorage");
        $container->addService("nette.userStorage", new \DummyUserStorage());

        self::$container = $container;
    }
}