<?php

class ColectieArtefacteModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        if(isset($_POST['key']))
        {
            $key = $_POST['key'];
        }
        else
            $key = "";
        $file = file_get_contents('http://localhost/public/colectieArtefacte');
        $doc = new DOMDocument();
        @$doc->loadHTML($file);
        $element = new DOMElement('p', 'Search: ' . $key);
        $here = $doc->getElementById('Collection');
        $here->appendChild($element);
        echo $doc->saveHTML();


        /*
        echo "<script type='text/javascript'>alert(\"$key\")</script>";
        $statement = oci_parse($this->db,"select count(*) from tw.ARTEFACTS where upper(ARTEFACT_NAME) like upper('%'|| :key ||'%')");
        oci_bind_by_name($statement,"key",$key);
        oci_execute($statement,OCI_DEFAULT);
        if(oci_fetch($statement))
        {
            $number = oci_result($statement,1);
        }*/
    }


}