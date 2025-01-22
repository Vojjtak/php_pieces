<?php

class Calculator{
    
    public $first_digit;
    public $second_digit;
    
    public function __construct(){
    }
    
    public function sum($first_digit, $second_digit){
        echo $first_digit + $second_digit;
    }
    
    public function deleno($first_digit, $second_digit){
        echo $first_digit / $second_digit;
    }
    
    public function krat($first_digit, $second_digit){
        echo $first_digit * $second_digit;
    }
    
    public function minus($first_digit, $second_digit){
        echo $first_digit - $second_digit;
    }
}

?>