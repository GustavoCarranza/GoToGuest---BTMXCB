<?php
class Logout
{
    public function __construct()
    {
        session_start();
        session_unset();   
        session_destroy();
        header('location: ' . Base_URL() . '/Login');
    }
}
