<?php

class ColectieArtefacte extends Controller
{
    public function index()
    {
        $this->model('ColectieArtefacteModel');
        //modificare view cu informatii din query
        $this->view('colectie_artefacte/colectie_artefacte');
    }

    public function submit()
    {
        if(isset($_POST['key'])) {
            $key = $_POST['key'];
            header('Location: /public/colectieArtefacte?search=' .$key);
        }

    }


}