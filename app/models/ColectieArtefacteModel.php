<?php

class ColectieArtefacteModel extends Model
{
    public $id_artefacte=array();
    public $id1_artefacte=array();
    public $name_artefacte=array();
    public $imagini_artefacte = array();
    public $key = "";
    public $cat = array();
    public $aux = array();
    public $i;
    public $mat = array();
    public $pur = array();
    public $dat = array();
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

        if(isset($_GET['mat'])) {
            $this->mat = $_GET['mat'];
        }

        if (isset($_GET['pur'])) {
            $this->pur = $_GET['pur'];
        }

        if(isset($_GET['dat'])) {
            $this->dat = $_GET['dat'];
        }



        if($this->key!=""){
             //cand este scris ceva in search bar
             $statement= oci_parse($this->db, "select  t.ID
                                                   FROM tw.ARTEFACTS t
                                                   where upper(t.ARTEFACT_NAME) like upper('%'||:key||'%')
                                                   order by t.ID");

             oci_bind_by_name($statement, ":key", $this->key);
             oci_execute($statement);
             $contor=0;
            while(oci_fetch($statement)){
                $temp = oci_result($statement,1);
                array_push($this->id_artefacte,$temp);
                $contor++;
            }
         }
         else {
             //cand nu este scris nimic in search bar
             $statement= oci_parse($this->db, "select  t.ID
                                                   FROM tw.ARTEFACTS t order by t.ID");
             oci_execute($statement);
             $contor=0;
             while(oci_fetch($statement)){
                 $temp = oci_result($statement,1);
                 array_push($this->id_artefacte,$temp);
                 $contor++;
             }
         }
         $this->id1_artefacte=$this->id_artefacte;
         if(isset($_GET['cat'])) {
             $this->i = 0;
             if ($this->cat[0] != 'All') {
             for ($contor = 0; $contor < count($this->cat); $contor++) {

                     //este aplicat un filtru pe categorie

                     if (substr($this->cat[$contor], 0, 1) != '-') {
                         //a ales ca filtru o categorie, asa ca va lua din toate categoriile
                         $statement = oci_parse($this->db, "select  t.ID
                                                   FROM tw.ARTEFACTS t join tw.ARTEFACTS_SUB_CATEGORIES a_s on t.id = a_s.id_artefact
                                                      join tw.SUB_CATEGORIES s on s.id = a_s.id_sub_category
                                                      join tw.CATEGORIES c on s.parent_id = c.id
                                                   where  c.category_name =:category
                                                   order by t.ID ");
                         $c = strstr($this->cat[$contor],'/',true);
                         if($c==FALSE)$c=$this->cat[$contor];
                         oci_bind_by_name($statement, ":category", $c);
                         oci_execute($statement);
                         while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS + OCI_ASSOC)) {
                             $this->aux[$this->i] = $row['ID'];
                             $this->i = $this->i + 1;

                         }

                     } else {

                         //a ales un filtru care este o subcategorie
                         $statement = oci_parse($this->db, "select  t.ID
                                                   FROM tw.ARTEFACTS t  join tw.ARTEFACTS_SUB_CATEGORIES a_s on t.id = a_s.id_artefact
                                                   join tw.SUB_CATEGORIES s on a_s.ID_SUB_CATEGORY = s.ID
                                                   where  SUB_CATEGORY_NAME=:subcategory
                                                   order by t.ID ");
                         $s_c = strstr(substr($this->cat[$contor],1),'/',true);
                         if($s_c==FALSE) $s_c=substr($this->cat[$contor],1);;
                         oci_bind_by_name($statement, ":subcategory", $s_c);
                         oci_execute($statement);
                         while (oci_fetch($statement)) {
                             $temp = oci_result($statement, 1);
                             array_push($this->aux, $temp);
                             $this->i = $this->i + 1;
                         }
                         /* while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS + OCI_ASSOC)) {
                              $this->aux[$i] = $row[0];
                              $this->i = $this->i + 1;

                          }*/
                     }
                 }
                 $this->id1_artefacte = $this->compara($this->id_artefacte, $this->aux);
             }

         }

         if(isset($_GET['mat'])) {
             $this->id_artefacte=$this->id1_artefacte;
             $this->aux = array();
             if ($this->mat[0] != 'All') {
             for ($contor=0;$contor<count($this->mat);$contor++) {

                     //este aplicat un filtru pe materiale
                     $statement = oci_parse($this->db, "select  t.ID
                                                   FROM tw.ARTEFACTS t  join tw.ARTEFACTS_MATERIALS a_m on t.id = a_m.ID_ARTEFACT
                                                   join tw.MATERIALS m on m.id = a_m.ID_MATERIAL
                                                   where  MATERIAL_NAME=:material
                                                   order by t.ID ");
                     $m=strstr($this->mat[$contor],'/',true);
                     if($m==FALSE) $m=$this->mat[$contor];
                     oci_bind_by_name($statement, ":material", $m);
                     oci_execute($statement);
                     $i = 0;
                     while (oci_fetch($statement)) {
                         $temp = oci_result($statement, 1);
                         array_push($this->aux, $temp);
                         $i = $i + 1;
                     }
                 }
                 $this->id1_artefacte = $this->compara($this->id_artefacte, $this->aux);
             }

         }

        if(isset($_GET['pur'])) {
             $this->id_artefacte=$this->id1_artefacte;
            $this->aux = array();
            if ($this->pur[0] != 'All') {
            for ($contor = 0; $contor < count($this->pur); $contor++) {

                    //este aplicat un filtru pe roluri
                    $statement = oci_parse($this->db, "select  t.ID
                                                   FROM tw.ARTEFACTS t  join tw.ARTEFACTS_ROLES a_r on t.ID = a_r.ID_ARTEFACT
                                                   join tw.ROLES on a_r.ID_ROLE = ROLES.ID
                                                   where  ROLE_NAME=:role
                                                   order by t.ID ");
                    $p=strstr($this->pur[$contor],'/',true);
                    if($p==FALSE) $p=$this->pur[$contor];
                    oci_bind_by_name($statement, ":role", $p);
                    oci_execute($statement);
                    $i = 0;
                    while (oci_fetch($statement)) {
                        $temp = oci_result($statement, 1);
                        array_push($this->aux, $temp);
                        $i = $i + 1;
                    }

                }
                $this->id1_artefacte = $this->compara($this->id_artefacte, $this->aux);
            }

        }
        if(isset($_GET['dat'])) {
            $this->id_artefacte=$this->id1_artefacte;
            $this->aux = array();
            if ($this->dat[0] != 'All') {
            for($contor=0;$contor<count($this->dat);$contor++) {

                    $d=strstr($this->dat[$contor],'/',true);
                        if($d==FALSE) $d=$this->dat[$contor];
                    if ($d == 'Prehistory') {
                        $statement = oci_parse($this->db, "select t.ID from TW.ARTEFACTS t where substr(DATING,length(DATING)-1)='BC' and to_number(substr(DATING,1,length(DATING)-3))>32");
                    }
                    if ($d == 'Ancient Period') {
                        $statement = oci_parse($this->db, "select t.ID from TW.ARTEFACTS t where (substr(DATING,length(DATING)-1)='BC' and to_number(substr(DATING,1,length(DATING)-3))<=32) or (substr(DATING,length(DATING)-1)='AC' and to_number(substr(DATING,1,length(DATING)-3))<5)");
                    }
                    if ($d == 'Middle Ages') {
                        $statement = oci_parse($this->db, "select t.ID  from TW.ARTEFACTS t where substr(DATING,length(DATING)-1)='AC' and to_number(substr(DATING,1,length(DATING)-3))>=5 and to_number(substr(DATING,1,length(DATING)-3))<15");
                    }
                    if ($d == 'Early Modern Period') {
                        $statement = oci_parse($this->db, "select t.ID  from TW.ARTEFACTS t where substr(DATING,length(DATING)-1)='AC' and to_number(substr(DATING,1,length(DATING)-3))>=15 and to_number(substr(DATING,1,length(DATING)-3))<18");
                    }
                    if ($d == 'Modern Era') {
                        $statement = oci_parse($this->db, "select t.ID  from TW.ARTEFACTS t where substr(DATING,length(DATING)-1)='AC' and to_number(substr(DATING,1,length(DATING)-3))>=18");
                    }
                    oci_execute($statement);
                    $i = 0;
                    while (oci_fetch($statement)) {
                        $temp = oci_result($statement, 1);
                        array_push($this->aux, $temp);
                        $i = $i + 1;
                    }
                }
                $this->id1_artefacte = $this->compara($this->id_artefacte, $this->aux);
            }

        }

         for($contor=0;$contor<count($this->id1_artefacte);$contor++){
             $statement= oci_parse($this->db, "select  t.ARTEFACT_NAME,t.ARTEFACT_IMAGE FROM tw.ARTEFACTS t where t.ID=:v_id");
            oci_bind_by_name($statement, ":v_id", $this->id1_artefacte[$contor]);
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
            for ($contor=0;$contor<count($lista1);$contor++){
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
            return $lista3;
    }
}