<?php

use Eris\Generator;

class ErisReverseTest extends PHPUnit_Framework_TestCase
{

    use Eris\TestTrait;

    /**
     * @test
     */
    public function success()
    {
        $prop = function($array) {
            $this->assertSame($array, array_reverse(array_reverse($array)));
        };

        $this->forAll(Generator\seq(Generator\nat()))->then($prop);
        $this->forAll(Generator\seq(Generator\string()))->then($prop);
    }

    /**
     * @test
     */
    public function failure()
    {
        function reverse($array)
        {
            return $array === [] ? [1, 2, 3] : [3, 2, 1];
        }

        $prop = function($array) {
            $this->assertSame($array, reverse(reverse($array)));
        };

        $this->forAll(Generator\seq(Generator\nat()))->then($prop);
    }

}