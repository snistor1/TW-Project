<?php

class ColectieArtefacte extends Controller
{
    public function index()
    {
        $this->view('colectie_artefacte/colectie_artefacte');
    }

    public function submit()
    {
        $this->model('ColectieArtefacteModel');
        //echo "<script type='text/javascript'>alert(\"Location: /public/colectieArtefacte /"  . $_POST['key'] . "\");window.location.href='/public/login';</script>";
        //header("Location: /public/colectieArtefacte/" . $_POST['key']);
    }
}