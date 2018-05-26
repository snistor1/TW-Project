<?php

class ArtefactModel  extends Model
{
    public $artefact_name='';
    public $user_name='';
    public $user_id='';
    public $author_name='';
    public $class_names='';
    public $dating='';
    public $price='';
    public $license='';
    public $origin='';
    public $roles='';
    public $materials='';
    public $description='';
    public $tags=array();
    public $latitude='';
    public $longitude='';
    public $artefact_image;
    public function __construct()
    {
        parent::__construct();

        $id_artefact=$_GET['id'];
        $statement = oci_parse($this->db,  "select  ARTEFACT_NAME,ID_USER,AUTHOR_NAME,DATING,
                                                            PRICE,DESCRIPTION,ORIGIN,LATITUDE,LONGITUDE,
                                                            ARTEFACT_IMAGE,UTILIZATION_LICENSE 
                                                            from tw.ARTEFACTS WHERE ID=:v_id");
        oci_bind_by_name($statement, ":v_id", $id_artefact);
        oci_execute($statement);
        while ($row = oci_fetch_array($statement,OCI_RETURN_NULLS+OCI_ASSOC)) {
                $this->artefact_name = $row['ARTEFACT_NAME'];
                $id_user = $row['ID_USER'];
                $this->author_name=$row['AUTHOR_NAME'];
                $this->dating=$row['DATING'];
                $this->price=$row['PRICE'];
                $this->description=$row['DESCRIPTION'];
                $this->origin=$row['ORIGIN'];
                $this->latitude=$row['LATITUDE'];
                $this->longitude=$row['LONGITUDE'];
                $this->license=$row['UTILIZATION_LICENSE'];
                $this->artefact_image=$row['ARTEFACT_IMAGE'];
            }
        $this->user_id = $id_user;
        $statement = oci_parse($this->db, "select NAME from tw.USERS where ID=:user_id");
        oci_bind_by_name($statement, ":user_id", $id_user);
        oci_execute($statement, OCI_DEFAULT);
        if (oci_fetch($statement)) {
            $this->user_name = oci_result($statement, 1);
        }
     // comletare variabila $class_names
        $statement = oci_parse($this->db,  "select  CLASS_NAME from tw.CLASSES c join tw.ARTEFACTS_CLASSES a_c
                                     on c.ID = a_c.ID_CLASS  where a_c.ID_ARTEFACT=:v_id_artefact ");
        oci_bind_by_name($statement, ":v_id_artefact", $id_artefact);
        oci_execute($statement);
        $flag=0;
        while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS+OCI_ASSOC)) {
            if ($flag == 0) {
                $this->class_names = $row['CLASS_NAME'];
                $flag = 1;
            } else {
                $this->class_names = $this->class_names . ', ' . $row['CLASS_NAME'];
            }
        }
        // comletare variabila $roles
        $statement = oci_parse($this->db,  "select  ROLE_NAME from tw.ROLES r join tw.ARTEFACTS_ROLES a_r
                                     on r.ID = a_r.ID_ROLE  where a_r.ID_ARTEFACT=:v_id_artefact ");
        oci_bind_by_name($statement, ":v_id_artefact", $id_artefact);
        oci_execute($statement);
        $flag=0;
        while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS+OCI_ASSOC)) {
            if ($flag == 0) {
                $this->roles = $row['ROLE_NAME'];
                $flag = 1;
            } else {
                $this->roles = $this->roles . ', ' . $row['ROLE_NAME'];
            }
        }

        // comletare variabila $materials
        $statement = oci_parse($this->db,  "select  MATERIAL_NAME from tw.MATERIALS m
                                                    join tw.ARTEFACTS_MATERIALS a_m
                                     on m.ID = a_m.ID_MATERIAL  where a_m.ID_ARTEFACT=:v_id_artefact ");
        oci_bind_by_name($statement, ":v_id_artefact", $id_artefact);
        oci_execute($statement);
        $flag=0;
        while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS+OCI_ASSOC)) {
            if ($flag == 0) {
                $this->materials = $row['MATERIAL_NAME'];
                $flag = 1;
            } else {
                $this->materials = $this->materials . ', ' . $row['MATERIAL_NAME'];
            }
        }
        // comletare array $tags
        $statement= oci_parse($this->db, "select  TAG_NAME FROM tw.TAGS t 
                                                  join ARTEFACTS_TAGS a_t on t.ID = a_t.ID_TAG
                                                   where a_t.ID_ARTEFACT=:v_id_artefact");
        oci_bind_by_name($statement, ":v_id_artefact", $id_artefact);
        oci_execute($statement);
        $contor=0;
        while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS+OCI_ASSOC)){
            $this->tags[$contor]=$row['TAG_NAME'];
            $contor=$contor+1;
        }
    }
}