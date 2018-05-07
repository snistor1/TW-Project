<?php
/**
 * Created by PhpStorm.
 * User: Serban
 * Date: 07-May-18
 * Time: 11:14 PM
 */

class Register extends Controller
{
    public function index()
    {
        $this->view('register/register');
    }
}