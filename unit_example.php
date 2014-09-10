<?php
dl("example.so"); // Load it.

class StackTest extends PHPUnit_Framework_TestCase
{
    public function testLoaded()
    {
        $this->assertEquals(true, extension_loaded('example'));
    }
    
    public function testFact()
    {
    	$this->assertEquals(24, fact(4));
    }

    public function testMyMod()
    {
    	$this->assertEquals(2, my_mod(23, 7));
    }

    public function testMyVar()
    {
    	$this->assertEquals(3, My_variable_get());
    	My_variable_set(7);
    	$this->assertEquals(7, My_variable_get());
    	My_variable_set(7 + My_variable_get());
    	$this->assertEquals(14, My_variable_get());
    	$this->assertEquals(-1, My_variable_get()-15);
    }

}

?>