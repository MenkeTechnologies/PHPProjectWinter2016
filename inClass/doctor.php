<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

interface Nameable {

    public function getName();
}

interface Ageable {

    public function age();
}

abstract class Person implements Nameable, Ageable {

    protected $name;
    protected $lastName;

    public function __construct($name, $lastName) {
        $this->name = $name;
        $this->lastName = $lastName;
    }

    public function getName() {
        return $this->name . " " . $this->lastName;
    }

    public function __get($name) {


        if ($name == "firstname") {
            echo "balls";
        } else {
            echo "no function";
        }
    }

    public function __set($name, $value) {
        $this->name = ucfirst($value);
        echo "you are setting $name to " . ucfirst($value);
    }

    public function __call($name, $arguments) {
        return "ok";
    }

    public function __toString() {
        return $this->getName();
    }

}

class Doctor extends Person {

    public function getName() {
        $name = parent::getName();
        $name.= " MD";
        return $name;
    }

    public function age() {
        
    }

}

class Place implements Nameable {

    public function getName() {
        ;
    }

}

class Container {

    public function addThing(Nameable $thing) {
        $str = $thing->getName();
    }

}

$me = new Doctor("Fred", "Rabbit");

echo $me;

