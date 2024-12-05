<?php

    //namespace php\Webshop;
    include_once("User.php");

    class Admin extends User{
        public function canAddProduct(){
            return true;
        }

        public function canDeleteProduct(){
            return true;
        }
    }