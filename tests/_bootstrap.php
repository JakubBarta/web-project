<?php
// This is global bootstrap for autoloading

use App\Tests\Environment;

require_once __DIR__ . "/_support/Environment.php";

Environment::initialize();