<?php
class HomeModel extends Model{

    public $name_colectii=array();

    public function __construct(){
        parent::__construct();
        $statement=oci_parse($this->db,"select  category_name from tw.categories");
        oci_execute($statement);
        $contor=0;
        while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS + OCI_ASSOC))
        {
            $this->name_colectii[$contor]=$row['CATEGORY_NAME'];
            $contor++;
        }
    }
}