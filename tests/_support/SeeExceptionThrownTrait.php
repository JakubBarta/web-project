<?php
/**
 * Author: Jakub Barta <jakub.barta@gmail.com>
 * Date: 01.07.15
 * Time: 13:07
 */

namespace Achigami\Tests;


trait SeeExceptionThrownTrait
{
    /**
     * @param $exception
     * @param $function
     */
    public function seeExceptionThrown($exception, $function)
    {
        $ret = false;

        try {
            $function();
        } catch (\Exception $e) {
            if (get_class($e) == $exception) {
                $ret = true;

            }
        }

        $this->assertTrue($ret);

    }
}