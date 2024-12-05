<?php

class Customer extends User{
    public function canAddProduct(){
        return false;
    }
}