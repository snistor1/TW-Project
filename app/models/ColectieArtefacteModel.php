<?php
/**
 * Created by PhpStorm.
 * User: Cosmin
 * Date: 21-May-18
 * Time: 7:42 PM
 */


class ColectieArtefacteModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        if(isset($_GET['search']))
        {
            $key = $_GET['search'];
        }
        else
            $key = "";


        $doc = new DomDocument();
        $doc->loadHtml('/public/app/views/colectie_artefacte/colectie_artefacte.php');
        $element = new DOMElement('p', 'Search: ' . $key);
        $col = $doc->getElementById("Collection");



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