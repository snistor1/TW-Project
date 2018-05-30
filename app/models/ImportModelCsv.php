<?php

class ImportModelCsv extends Model
{
    public function __construct()
    {
        parent::__construct();
        $file = $_FILES['csv_file'];
        $fileName = $_FILES['csv_file']['name'];
        $fileError = $_FILES['csv_file']['error'];
        $fileType = $_FILES['csv_file']['type'];
        if(empty($fileName) || ($fileType!='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' && $fileType!='.csv' && $fileType!='application/vnd.ms-excel'))
        {
            echo "<script type='text/javascript'>alert(\"Please insert a valid csv file!\");window.location.href='/public/paginaUtilizator';</script>";
            exit();
        }
        $content = file_get_contents($_FILES['csv_file']['tmp_name']);
        echo $content;
    }
}