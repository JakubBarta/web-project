<?php
namespace Helper;

use App\Tests\Environment;
use Nette\DI\Container;

class Unit extends \Codeception\Module
{

    /**
     * @return Container
     */
    public function getContainer()
    {
        return Environment::getContainer();
    }
}
