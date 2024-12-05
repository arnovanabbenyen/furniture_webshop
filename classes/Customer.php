<?php

class Customer extends User{
    public function canAddProduct(){
        return false;
    }

    public function canDeleteProduct(){
        return false;
    }
}