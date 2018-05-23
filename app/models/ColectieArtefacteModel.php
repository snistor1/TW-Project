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
        $root = $doc->getElementById('Collection');

        $statement = oci_parse($this->db,"select * from tw.ARTEFACTS where upper(ARTEFACT_NAME) like upper('%'|| :key ||'%')");
        oci_bind_by_name($statement,"key",$key);
        oci_execute($statement,OCI_DEFAULT);

        while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS))
        {
            $line = "";
            foreach ($row as $item)
            {
                $line = $line . $item . " | ";
            }
            $first_div = new DOMElement('div');
            $root->appendChild($first_div);
            $first_div->setAttribute('class','responsive');
            $second_div = new DOMElement('div');
            $first_div->appendChild($second_div);
            $second_div->setAttribute('class','gallery');
            $alink = new DOMElement('a');
            $second_div->appendChild($alink);
            $alink->setAttribute('href','/public/paginaArtefact');
            $img = new DOMElement('img');
            $alink->appendChild($img);
            $img->setAttribute('src','/public/Images/img_artefact1.jpg');
            $img->setAttribute('alt','Imagine Artefact');
            $img->setAttribute('width','600');
            $img->setAttribute('height','400');
            $third_div = new DOMElement('div',$line);
            $second_div->appendChild($third_div);
            $third_div->setAttribute('class','desc');
        }



        echo $doc->saveHTML();


        /*
        $statement = oci_parse($this->db,"select count(*) from tw.ARTEFACTS where upper(ARTEFACT_NAME) like upper('%'|| :key ||'%')");
        oci_bind_by_name($statement,"key",$key);
        oci_execute($statement,OCI_DEFAULT);
        if(oci_fetch($statement))
        {
            $number = oci_result($statement,1);
        }*/
    }


}