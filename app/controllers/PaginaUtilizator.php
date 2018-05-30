<?php

class PaginaUtilizator extends Controller
{
    public function __construct()
    {
        if(Session::get('email')==null)
        {
            echo "<script type='text/javascript'>alert(\"You need to login first!\");window.location.href='/public/login';</script>";
        }
    }

    public function index()
    {
        $this->view('pagina_utilizator/pagina_utilizator');
    }

    public function logout()
    {
        Session::destroy();
        header('Location: /public/login');
    }

    public function show()
    {
        $this->model('UtilizatorModel');
    }

    public function importJson()
    {
        $this->model('ImportModelJson');
    }

    public function importCsv()
    {
        $this->model('ImportModelCsv');
    }

    public function importXml()
    {
        $this->model('ImportModelXml');
    }
}