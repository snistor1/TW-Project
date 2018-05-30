<?php

class ImportModelJson extends Model
{
    public function __construct()
    {
        parent::__construct();
        $file = $_FILES['json_file'];
        $fileName = $_FILES['json_file']['name'];
        $fileError = $_FILES['json_file']['error'];
        $fileType = $_FILES['json_file']['type'];
        if(empty($fileName) || ($fileType!='application/json' && $fileType!='.json'))
        {
            echo "<script type='text/javascript'>alert(\"Please insert a valid json file!\");window.location.href='/public/paginaUtilizator';</script>";
            exit();
        }
        $content = file_get_contents($_FILES['json_file']['tmp_name']);
        $decoded = json_decode($content);

    }
}