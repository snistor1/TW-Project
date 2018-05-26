<?php

class ColectieArtefacteModel extends Model
{
    public $id_artefacte=array();
    public $name_artefacte=array();
    public $key = "";
    public $cat = "";
    public $mat = "";
    public $pur = "";
    public $dat = "";
    public function __construct()
    {
        parent::__construct();
        if(isset($_GET['search']))
        {
            $this->key = $_GET['search'];
        }
        else
            $this->key = "";

        if(isset($_GET['cat']))
        {
            $this->cat = $_GET['cat'];
        }
        else
            $this->cat = "";

        if(isset($_GET['mat']))
        {
            $this->mat = $_GET['mat'];
        }
        else
            $this->mat = "";

        if(isset($_GET['pur']))
        {
            $this->pur = $_GET['pur'];
        }
        else
            $this->pur = "";

        if(isset($_GET['dat']))
        {
            $this->dat = $_GET['dat'];
        }
        else
            $this->dat = "";

        //echo "<script>alert(" . $this->key . $this->cat . $this->dat . $this->pur . $this->mat . ");</script>";

        $statement= oci_parse($this->db, "select  ID, ARTEFACT_NAME FROM tw.ARTEFACTS where upper(ARTEFACT_NAME) like upper('%' || :key || '%') order by ID desc");
        oci_bind_by_name($statement, ":key", $this->key);
        oci_execute($statement);
        $i=0;
        while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS+OCI_ASSOC)){
            $this->id_artefacte[$i]=$row['ID'];
            $this->name_artefacte[$i]=$row['ARTEFACT_NAME'];
            $i=$i+1;
        }
    }


}