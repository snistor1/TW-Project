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
    }


}