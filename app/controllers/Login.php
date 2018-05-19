<?php

class Login extends Controller
{
    public function index()
    {
        $this->view('login/login');
    }

    public function test()
    {
        $this->model('User')->show();
    }
}