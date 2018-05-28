<?php

class ColectieArtefacteModel extends Model
{
    public $id_artefacte=array();
    public $name_artefacte=array();
    public $imagini_artefacte = array();
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

        if($this->cat == 'Category' or $this->cat == 'All')
            $this->cat = "";

        $statement= oci_parse($this->db, "select  t.ID, t.ARTEFACT_NAME, t.ARTEFACT_IMAGE 
                                                  FROM tw.ARTEFACTS t left outer join tw.ARTEFACTS_SUB_CATEGORIES a_s on t.id = a_s.id_artefact 
                                                    left outer join tw.SUB_CATEGORIES s on s.id = a_s.id_sub_category 
                                                    left outer join tw.CATEGORIES c on s.parent_id = c.id
                                                  where upper(t.ARTEFACT_NAME) like upper('%'||:key||'%') and c.category_name like '%' || :category
                                                  order by t.ID desc");

        oci_bind_by_name($statement, ":key", $this->key);
        oci_bind_by_name($statement, ":category", $this->cat);
        oci_execute($statement);
        $i=0;
        while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS+OCI_ASSOC)){
            $this->id_artefacte[$i]=$row['ID'];
            $this->name_artefacte[$i]=$row['ARTEFACT_NAME'];
            $this->imagini_artefacte[$i] = $row['ARTEFACT_IMAGE'];
            $i=$i+1;
        }
    }


}