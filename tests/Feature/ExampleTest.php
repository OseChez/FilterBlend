<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
   public function solution($number){
    $tres = 3;
    $cinco =5;
    $a = array();
    for($i = 1; $i < $number ; $i++){
        if($i % $tres == 0 || $i % $cinco == 0){
            array_push($a, $i);
        }
    }

    $suma=0;
    for($i = 0; $i <= count($a)-1; $i++){
     $suma += $a[$i];
    }
    return $suma;
}
    public function testBasicTest()
    {
       $this->assertEquals(23,$this->solution(10));
    }
}
