<?php

class EditarePgUtilizator extends Controller
{
    public function index()
    {
        $this->view('editare_pg_utilizator/editare_pg_utilizator');
    }

    public function save()
    {
        $this->model('EditareUtilizatorModel');
    }
}