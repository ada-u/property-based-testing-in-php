<?php

use QCheck\Generator as Gen;
use QCheck\Quick;

class QuickCheckReverseTest extends PHPUnit_Framework_TestCase
{


    /**
     * @test
     */
    public function success()
    {
        $prop = Gen::forAll(
            [Gen::posInts()->intoArrays()],
            function ($array) {
                return $array === array_reverse(array_reverse($array));
            }
        );

        var_dump(Quick::check(300, $prop));
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

        $prop = Gen::forAll(
            [Gen::posInts()->intoArrays()],
            function ($array) {
                return $array === reverse(reverse($array));
            }
        );

        var_dump(Quick::check(30, $prop));
    }


    public function complicatedGen()
    {
        return Gen::posInts()
            ->bind(function ($n) {
                return Gen::strings()->fmap(function ($str) use ($n) {
                    return [$n, substr($str, $n)];
                });
            })
            ->bind(function ($n_str) {
                return Gen::posInts()->fmap(function ($m) use ($n_str) {
                    return [$n_str[0], $n_str[1], $n_str[0] + $m];
                });
            })
            ->bind(function ($n_s_m) {
                return Gen::choose(0, $n_s_m[2])->fmap(function ($l) use ($n_s_m) {
                    return [$n_s_m[0], $n_s_m[1], $n_s_m[2], $l];
                });
            }); // 力尽きた


    }

}