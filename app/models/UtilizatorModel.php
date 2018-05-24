<?php

class UtilizatorModel extends Model
{
    public $name='';
    public $email='';
    public $class_names='';
    public $id_artefacte=array();
    public $name_artefacte=array("ceva","initial");
    public function __construct()
    {
        parent::__construct();
        $statement = oci_parse($this->db,  "select  name, email ,class_name from tw.USERS u join tw.USERS_CLASSES u_c
                                     on u.ID = u_c.ID_USER join tw.CLASSES c on u_c.ID_CLASS = c.ID where u.id=:v_id");
        $myid = Session::get('id_user');
        oci_bind_by_name($statement, ":V_ID", $myid);
        oci_execute($statement);
        $flag=0;
        while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS+OCI_ASSOC)) {
            if($flag==0) {
                $this->name = $row['NAME'];
                $this->email = $row['EMAIL'];
                $this->class_names=$row['CLASS_NAME'];
                $flag=1;
            }
            else {
                $this->class_names = $this->class_names . ', ' . $row['CLASS_NAME'];
            }
        }

        $statement= oci_parse($this->db, "select  ID, ARTEFACT_NAME FROM tw.ARTEFACTS where ID_USER=:v_id");
        $myid = Session::get('id_user');
        oci_bind_by_name($statement, ":V_ID", $myid);
        oci_execute($statement);
        $contor=0;
        while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS+OCI_ASSOC)){
            $this->id_artefacte[$contor]=$row['ID'];
            $this->name_artefacte[$contor]=$row['ARTEFACT_NAME'];
            $contor=$contor+1;
        }
    }
}