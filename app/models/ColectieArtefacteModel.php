<?php

class ColectieArtefacteModel extends Model
{
    public $id_artefacte=array();
    public $name_artefacte=array();
    public $imagini_artefacte = array();
    public $length;
    public $key = "";
    public $cat = "";
    public $mat = "";
    public $pur = "";
    public $dat = "";
    public function __construct()
    {
        parent::__construct();

        if(isset($_GET['search'])){
            $this->key=$_GET['search'];
        }
        else{
            $this->key="";
        }
        if(isset($_GET['cat'])) {
            $this->cat = $_GET['cat'];
        }
        else{
            $this->cat="Category";
        }
        if(isset($_GET['mat'])) {
            $this->mat = $_GET['mat'];
        }
        else{
            $this->mat="Materials";
        }
        if (isset($_GET['pur'])) {
            $this->pur = $_GET['pur'];
        }
        else{
            $this->pur='Purpose';
        }
        if(isset($_GET['dat'])) {
            $this->dat = $_GET['dat'];
        }
        else {
            $this->dat="Dating";
        }
        if($this->key=="")
            $this->id_artefacte[0]="da";
        else $this->id_artefacte[0]="nu";
        $this->id_artefacte[5]=$this->key;
        $this->id_artefacte[1]=$this->cat;
        $this->id_artefacte[2]=$this->mat;
        $this->id_artefacte[3]=$this->pur;
        $this->id_artefacte[4]=$this->dat;


        if($this->key!=""){
             //cand este scris ceva in search bar
             $statement= oci_parse($this->db, "select  t.ID
                                                   FROM tw.ARTEFACTS t
                                                   where upper(t.ARTEFACT_NAME) like upper('%'||:key||'%')
                                                   order by t.ID");

             oci_bind_by_name($statement, ":key", $this->key);
             oci_execute($statement);
             $i=0;
             while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS+OCI_ASSOC)){
                 $this->id_artefacte[$i]=$row['ID'];
                 $i=$i+1;
             }
             $this->length=$i;
         }
         else {
             //cand nu este scris nimic in search bar
             $statement= oci_parse($this->db, "select  t.ID
                                                   FROM tw.ARTEFACTS t order by t.ID");
             oci_execute($statement);
             $i=0;
             while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS+OCI_ASSOC)){
                 $this->id_artefacte[$i]=$row['ID'];
                 $i=$i+1;
             }
             $this->length=$i;
         }
         if($this->cat!='Category' and $this->cat!='All') {
             //este aplicat un filtru pe categorie

             if (substr($this->cat, 0, 1) != '-') {
                 //a ales ca filtru o categorie, asa ca va lua din toate categoriile
                 $statement = oci_parse($this->db, "select  t.ID
                                                   FROM tw.ARTEFACTS t join tw.ARTEFACTS_SUB_CATEGORIES a_s on t.id = a_s.id_artefact
                                                      join tw.SUB_CATEGORIES s on s.id = a_s.id_sub_category
                                                      join tw.CATEGORIES c on s.parent_id = c.id
                                                   where  c.category_name =:category
                                                   order by t.ID ");

                 oci_bind_by_name($statement, ":category", $this->cat);
                 oci_execute($statement);
                 $i = 0;
                 $aux = array();
                 while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS + OCI_ASSOC)) {
                     $aux[$i] = $row['ID'];
                     $i = $i + 1;

                 }
                 $this->id_artefacte = $this->compara($this->id_artefacte, $aux);
             } else {

                 //a ales un filtru care este o subcategorie
                 $statement = oci_parse($this->db, "select  t.ID
                                                   FROM tw.ARTEFACTS t  join tw.ARTEFACTS_SUB_CATEGORIES a_s on t.id = a_s.id_artefact
                                                   join tw.SUB_CATEGORIES s on a_s.ID_SUB_CATEGORY = s.ID
                                                   where  SUB_CATEGORY_NAME=:subcategory
                                                   order by t.ID ");
                 $s_c = substr($this->cat, 1);
                 oci_bind_by_name($statement, ":subcategory", $s_c);
                 oci_execute($statement);
                 $i = 0;
                 $aux = array();
                 while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS + OCI_ASSOC)) {
                     $aux[$i] = $row['ID'];
                     $i = $i + 1;

                 }
                 $this->id_artefacte = $this->compara($this->id_artefacte, $aux);
             }
         }
         if($this->mat!='Materials' and $this->mat!='All'){
             //este aplicat un filtru pe materiale
             $statement = oci_parse($this->db, "select  t.ID
                                                   FROM tw.ARTEFACTS t  join tw.ARTEFACTS_MATERIALS a_m on t.id = a_m.ID_ARTEFACT
                                                   join tw.MATERIALS m on m.id = a_m.ID_MATERIAL
                                                   where  MATERIAL_NAME=:material
                                                   order by t.ID ");
             oci_bind_by_name($statement, ":material", $this->mat);
             oci_execute($statement);
             $i = 0;
             $aux = array();
             while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS + OCI_ASSOC)) {
                 $aux[$i] = $row['ID'];
                 $i = $i + 1;

             }
             $this->length=$i;
             $this->id_artefacte = $this->compara($this->id_artefacte, $aux);
         }
         if($this->pur!='Purpose' and $this->pur!='All'){
             //este aplicat un filtru pe roluri
             $statement = oci_parse($this->db, "select  t.ID
                                                   FROM tw.ARTEFACTS t  join tw.ARTEFACTS_ROLES a_r on t.ID = a_r.ID_ARTEFACT
                                                   join tw.ROLES on a_r.ID_ROLE = ROLES.ID
                                                   where  ROLE_NAME=:role
                                                   order by t.ID ");
             oci_bind_by_name($statement, ":role", $this->pur);
             oci_execute($statement);
             $i = 0;
             $aux = array();
             while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS + OCI_ASSOC)) {
                 $aux[$i] = $row['ID'];
                 $i = $i + 1;

             }
             $this->id_artefacte = $this->compara($this->id_artefacte, $aux);
         }
         if($this->dat!='Dating' and $this->dat!='All'){
                if ($this->dat == 'Prehistory') {
                    $statement = oci_parse($this->db, "select t.ID from TW.ARTEFACTS t where substr(DATING,length(DATING)-1)='BC' and to_number(substr(DATING,1,length(DATING)-3))>32");
                }
                if ($this->dat == 'Ancient Period') {
                    $statement = oci_parse($this->db, "select t.ID from TW.ARTEFACTS t where (substr(DATING,length(DATING)-1)='BC' and to_number(substr(DATING,1,length(DATING)-3))<=32) or (substr(DATING,length(DATING)-1)='AC' and to_number(substr(DATING,1,length(DATING)-3))<5)");
                }
                if ($this->dat == 'Middle Ages') {
                    $statement = oci_parse($this->db, "select t.ID  from TW.ARTEFACTS t where substr(DATING,length(DATING)-1)='AC' and to_number(substr(DATING,1,length(DATING)-3))>=5 and to_number(substr(DATING,1,length(DATING)-3))<15");
                }
                if ($this->dat == 'Early Modern Period') {
                    $statement = oci_parse($this->db, "select t.ID  from TW.ARTEFACTS t where substr(DATING,length(DATING)-1)='AC' and to_number(substr(DATING,1,length(DATING)-3))>=15 and to_number(substr(DATING,1,length(DATING)-3))<18");
                }
                if ($this->dat == 'Modern Era') {
                    $statement = oci_parse($this->db, "select t.ID  from TW.ARTEFACTS t where substr(DATING,length(DATING)-1)='AC' and to_number(substr(DATING,1,length(DATING)-3))>=18");
                }
             oci_execute($statement);
             $i = 0;
             $aux = array();
             while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS + OCI_ASSOC)) {
                 $aux[$i] = $row['ID'];
                 $i = $i + 1;

             }
             $this->id_artefacte = $this->compara($this->id_artefacte, $aux);
         }

         for($contor=0;$contor<$this->length;$contor++){
             $statement= oci_parse($this->db, "select  t.ARTEFACT_NAME,t.ARTEFACT_IMAGE FROM tw.ARTEFACTS t where t.ID=:v_id");
            oci_bind_by_name($statement, ":v_id", $this->id_artefacte[$contor]);
            oci_execute($statement);
             while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS + OCI_ASSOC)) {
                 $this->name_artefacte[$contor]=$row['ARTEFACT_NAME'];
                 $this->imagini_artefacte[$contor]=$row['ARTEFACT_IMAGE'];
             }
         }

    }



    public function compara($lista1,$lista2){//pastreaza doar elementele comune
            $lista3=array();
            $contor3=0;
            for ($contor=0;$contor<$this->length;$contor++){
                $ok=0;
                $contor2=0;
                while($ok==0 and $contor2<count($lista2)){
                    if($lista1[$contor]==$lista2[$contor2]){
                        $ok=1;
                    }
                    $contor2++;
                }
                if($ok!=0){
                    $lista3[$contor3]=$lista1[$contor];
                    $contor3++;
                }
            }
            $this->length=$contor3;
            return $lista3;
    }
}