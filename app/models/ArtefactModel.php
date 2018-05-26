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
    public $id_tags=array();
    public $latitude='';
    public $longitude='';
    public $artefact_image;
    public $id_related_art=array(0,0,0,0,0);
    public $name_related_art=array();
    public $img_related_art=array();
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
        $statement= oci_parse($this->db, "select  TAG_NAME,ID_TAG FROM tw.TAGS t 
                                                  join TW.ARTEFACTS_TAGS a_t on t.ID = a_t.ID_TAG
                                                   where a_t.ID_ARTEFACT=:v_id_artefact");
        oci_bind_by_name($statement, ":v_id_artefact", $id_artefact);
        oci_execute($statement);
        $contor=0;
        while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS+OCI_ASSOC)){
            $this->tags[$contor]=$row['TAG_NAME'];
            $this->id_tags[$contor]=$row['ID_TAG'];
            $contor=$contor+1;
        }
        //related artefacts
        $statement=oci_parse($this->db,"select max(id) from tw.ARTEFACTS");
        oci_execute($statement);
        if(oci_fetch($statement)) {
            $max_id = oci_result($statement, 1);
            $artefacts = array();//vector de frecventa
            for ($contor = 1; $contor <= $max_id; $contor++) {
                $artefacts[$contor] = 0;
            }
            $max_id = 0;
            //luam fiecare tag in parte si incrementam vec de frecventa la artefactele care au acelasi tag
            for ($contor = 0; $contor < count($this->id_tags); $contor++) {
                $statement = oci_parse($this->db, "select ID_ARTEFACT from TW.ARTEFACTS_TAGS where ID_TAG=:v_id_tag 
                                  and ID_ARTEFACT!=:v_id_artefact");
                $values = array(':v_id_tag' => $this->id_tags[$contor], ':v_id_artefact' => $id_artefact);
                foreach ($values as $key => $val) {
                    oci_bind_by_name($statement, $key, $values[$key]);
                }
                oci_execute($statement);
                while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS + OCI_ASSOC)) {
                    $artefacts[$row['ID_ARTEFACT']]++;
                    if ($row['ID_ARTEFACT'] > $max_id) {
                        $max_id = $row['ID_ARTEFACT'];//in max_id retinem cel mai mare id_artefact care este related cu artefactul nostru
                    }
                }
            }
            if ($max_id == 0) {
                $this->id_related_art[0]='0';//nu s-au gasit artefacte asemanatoare
            }
            else {
                $this->id_related_art[0]='1';
                $max1=0;
                $max2=0;
                $max3=0;
                $max4=0;
                //artefacts contine lista cu artefactele si cate tag-uri au in comun cu artefactul nostru
                //vom retine in id_related_art primele 4 cu cele mai multe tag-uri in comun
                for ($contor = 1; $contor <=$max_id; $contor++) {
                    if ($artefacts[$contor]>0){
                        if ($artefacts[$contor]>$max1)
                        {
                            $this->id_related_art[4]=$this->id_related_art[3];
                            $max4=$max3;
                            $this->id_related_art[3]=$this->id_related_art[2];
                            $max3=$max2;
                            $this->id_related_art[2]=$this->id_related_art[1];
                            $max2=$max1;
                            $this->id_related_art[1]=$contor;
                            $max1=$artefacts[$contor];
                        }
                        else {
                            if ($artefacts[$contor] == $max1 or $artefacts[$contor]>$max2) {
                                $this->id_related_art[4]=$this->id_related_art[3];
                                $max4=$max3;
                                $this->id_related_art[3]=$this->id_related_art[2];
                                $max3=$max2;
                                $this->id_related_art[2]=$contor;
                                $max2=$artefacts[$contor];
                            }
                            else{
                                if ($artefacts[$contor]==$max2 or $artefacts[$contor]>$max3){
                                    $this->id_related_art[4]=$this->id_related_art[3];
                                    $max4=$max3;
                                    $this->id_related_art[3]=$contor;
                                    $max3=$artefacts[$contor];
                                }
                                else{
                                    if ($artefacts[$contor]==$max3 or $artefacts[$contor]>$max4){
                                        $this->id_related_art[4]=$contor;
                                        $max4=$artefacts[$contor];
                                    }
                                }
                            }
                        }
                    }
                }

                //aflam numele si imaginea celor 4 artefacte
                $contor1=1;
                while($this->id_related_art[$contor1]!=0) {
                    $statement1=oci_parse($this->db,"select ARTEFACT_NAME,ARTEFACT_IMAGE from TW.ARTEFACTS where ID=:v_id_artefact");
                    oci_bind_by_name($statement1, ":v_id_artefact", $this->id_related_art[$contor1]);
                    oci_execute($statement1);
                    if(oci_fetch($statement1)){
                        $this->name_related_art[$contor1]=oci_result($statement1, 1);
                            $this->img_related_art[$contor1]=oci_result($statement1, 2);
                    }
                    $contor1++;
                }
            }
        }
    }
}