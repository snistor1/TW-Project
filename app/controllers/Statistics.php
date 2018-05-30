<?php

class Statistics extends Controller
{
    public function index()
    {
        $this->view('statistics/statistics');
    }

    public function date()
    {
        $this->model('StatisticsModel');
    }

}