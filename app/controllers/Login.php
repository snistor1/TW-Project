<?php

class Login extends Controller
{
    public function __construct()
    {
        if(Session::get('email')!=null)
        {
            echo "<script type='text/javascript'>alert(\"You are already logged in!\");window.location.href='/public/paginaUtilizator';</script>";
        }
    }

    public function index()
    {
        $this->view('login/login');
    }

    public function submit()
    {
        $this->model('LoginModel');
    }
}