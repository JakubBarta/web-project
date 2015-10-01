<?php

namespace App\Model\Exception;

use App\Exception\BaseException;

/**
 * Author: Jakub Barta <jakub.barta@gmail.com>
 * Date: 19.09.15
 * Time: 19:48
 */

class ModelException extends BaseException {}

class EntityNotFoundException extends ModelException {}