<?php

class ImportModelCsv extends Model
{
    public function __construct()
    {
        parent::__construct();
        $file = $_FILES['csv_file'];
        $fileName = $_FILES['csv_file']['name'];
        $fileError = $_FILES['csv_file']['error'];
        $fileType = $_FILES['csv_file']['type'];
        if(empty($fileName) || ($fileType!='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' && $fileType!='.csv' && $fileType!='application/vnd.ms-excel'))
        {
            echo "<script type='text/javascript'>alert(\"Please insert a valid csv file!\");window.location.href='/public/paginaUtilizator';</script>";
            exit();
        }
        $content = file_get_contents($_FILES['csv_file']['tmp_name']);
        $new_content = nl2br($content);
        $lines = explode("\n",$new_content);
        array_pop($lines);
        //aici am liniile corespunzatoare teoretic tabelelor in care trebuie sa inserez
        $this->do_inserts($lines);

        $statement = oci_parse($this->db,'select max(id) from tw.ARTEFACTS');
        oci_execute($statement);
        $artefact_id = 0;
        if(oci_fetch($statement)){
            $artefact_id = oci_result($statement,1);
        }

        echo "<script type='text/javascript'>alert(\"Artefact successfully added!\"); window.location.href='/public/paginaArtefact?id=".$artefact_id."'</script>";

    }

    public function do_inserts($lines)
    {
        $my_id = Session::get('id_user');
        $contor = 0;
        $nume_categorie=null;
        foreach ($lines as $line){
            $contor++;
            $values = explode(",",$line);
            //print_r($values);
            if($contor==1){
                //inserez in artefact
                $sql = oci_parse($this->db,"insert into tw.ARTEFACTS(ID_USER,ARTEFACT_NAME,ARTEFACT_IMAGE,
                    AUTHOR_NAME,DATING,PRICE,UTILIZATION_LICENSE,ORIGIN,DESCRIPTION,LATITUDE,LONGITUDE) values(
                    :v_id,:v_name,empty_blob(),:v_author,:v_dating,:v_price,:v_license,:v_origin,:v_description,:latitude,:longitude
                    ) returning ARTEFACT_IMAGE into :image");
                oci_bind_by_name($sql,":v_id",$my_id);
                oci_bind_by_name($sql,":v_name",$values[0]);

                oci_bind_by_name($sql,":v_author",$values[2]);
                oci_bind_by_name($sql,":v_dating",$values[3]);
                $price = (int)$values[4];
                oci_bind_by_name($sql,":v_price",$price);
                $license = (int)$values[5];
                oci_bind_by_name($sql,":v_license",$license);
                $x=($values[6] == 'null' ? null:$values[6]);
                oci_bind_by_name($sql,":v_origin",$x);
                $y=($values[7] == 'null' ? null:$values[7]);
                oci_bind_by_name($sql,":v_description",$y);
                $z=($values[8] == 'null' ? null:doubleval($values[8]));
                oci_bind_by_name($sql,":latitude",$z);
                $t=($values[9] == 'null' ? null:doubleval($values[9]));
                oci_bind_by_name($sql,":longitude",$t);
                $blob = oci_new_descriptor($this->db,OCI_D_LOB);
                oci_bind_by_name($sql,":image",$blob,-1,OCI_B_BLOB);
                oci_execute($sql, OCI_NO_AUTO_COMMIT);
                if($blob->save(base64_decode($values[1])))
                {
                    oci_commit($this->db);
                }
                $blob->free();
            }
            else if($contor==2){
                $get_artefact_id = oci_parse($this->db,'select max(id) from tw.ARTEFACTS');
                oci_execute($get_artefact_id);
                $artefact_id = 0;
                if(oci_fetch($get_artefact_id)){
                    $artefact_id = oci_result($get_artefact_id,1);
                }

                for($index=0;$index<count($values)-1;$index++){
                    $single = $values[$index];
                    $statement = oci_parse($this->db, "select id from tw.CLASSES where CLASS_NAME=:class_name");
                    oci_bind_by_name($statement, ":class_name", $single);
                    oci_execute($statement,OCI_DEFAULT);
                    if(oci_fetch($statement)) {
                        $id_clasa = oci_result($statement, 1);
                        //echo $id_clasa;
                        $statement2 = oci_parse($this->db, "INSERT INTO TW.ARTEFACTS_CLASSES
                                                   VALUES(:v_id_artefact,:v_id_class)");
                        oci_bind_by_name($statement2, ":v_id_artefact", $artefact_id);
                        oci_bind_by_name($statement2, ":v_id_class", $id_clasa);
                        oci_execute($statement2);
                    }
                }
                $single = $values[count($values)-1];
                $temp = substr($single,0,strlen($single)-6);
                $statement = oci_parse($this->db, "select id from tw.CLASSES where CLASS_NAME=:class_name");
                oci_bind_by_name($statement, ":class_name", $temp);
                oci_execute($statement,OCI_DEFAULT);
                if(oci_fetch($statement)) {
                    $id_clasa = oci_result($statement, 1);
                    //echo $id_clasa;
                    $statement2 = oci_parse($this->db, "INSERT INTO TW.ARTEFACTS_CLASSES
                                               VALUES(:v_id_artefact,:v_id_class)");
                    oci_bind_by_name($statement2, ":v_id_artefact", $artefact_id);
                    oci_bind_by_name($statement2, ":v_id_class", $id_clasa);
                    oci_execute($statement2);
                }
            }
            else if($contor==3){
                foreach ($values as $single){
                    $nume_categorie = substr($single,0,strlen($single)-6);
                }
            }
            else if($contor==4){
                //inserez in sub-categorii
                $get_artefact_id = oci_parse($this->db,'select max(id) from tw.ARTEFACTS');
                oci_execute($get_artefact_id);
                $artefact_id = 0;
                if(oci_fetch($get_artefact_id)){
                    $artefact_id = oci_result($get_artefact_id,1);
                }
                if($nume_categorie!=null)
                {
                    $exista_sub_categorie = 0;
                    for($index=0;$index<count($values)-1;$index++) {
                        $single = $values[$index];
                        $exista_sub_categorie =1;
                        $statement = oci_parse($this->db, "select s.id from tw.SUB_CATEGORIES s join tw.CATEGORIES c 
                                                                   on s.PARENT_ID=c.ID where SUB_CATEGORY_NAME=:subcategory_name
                                                                   and CATEGORY_NAME=:category_name");
                        oci_bind_by_name($statement, ":subcategory_name", $single);
                        oci_bind_by_name($statement, ":category_name",$nume_categorie);
                        oci_execute($statement, OCI_DEFAULT);
                        if (oci_fetch($statement)) {
                            $id_subcategory = oci_result($statement, 1);
                            $statement = oci_parse($this->db, "INSERT INTO TW.ARTEFACTS_SUB_CATEGORIES
                                                   VALUES(:v_id_artefact,:v_id_subcategory)");
                            oci_bind_by_name($statement, ":v_id_artefact", $artefact_id);
                            oci_bind_by_name($statement, ":v_id_subcategory", $id_subcategory);
                            oci_execute($statement);
                        }
                    }
                    if(isset($values[count($values)-1])) {
                        $single = $values[count($values)-1];
                        $temp = substr($single,0,strlen($single)-6);
                        $exista_sub_categorie = 1;
                        $statement = oci_parse($this->db, "select s.id from tw.SUB_CATEGORIES s join tw.CATEGORIES c 
                                                                   on s.PARENT_ID=c.ID where SUB_CATEGORY_NAME=:subcategory_name
                                                                   and CATEGORY_NAME=:category_name");
                        oci_bind_by_name($statement, ":subcategory_name", $temp);
                        oci_bind_by_name($statement, ":category_name", $nume_categorie);
                        oci_execute($statement, OCI_DEFAULT);
                        if (oci_fetch($statement)) {
                            $id_subcategory = oci_result($statement, 1);
                            $statement = oci_parse($this->db, "INSERT INTO TW.ARTEFACTS_SUB_CATEGORIES
                                                   VALUES(:v_id_artefact,:v_id_subcategory)");
                            oci_bind_by_name($statement, ":v_id_artefact", $artefact_id);
                            oci_bind_by_name($statement, ":v_id_subcategory", $id_subcategory);
                            oci_execute($statement);
                        }
                    }
                    if($exista_sub_categorie==0){
                        $statement = oci_parse($this->db, "select s.id from tw.SUB_CATEGORIES s join tw.CATEGORIES c 
                                                                   on s.PARENT_ID=c.ID where SUB_CATEGORY_NAME=:subcategory_name 
                                                                   and CATEGORY_NAME=:category_name");
                        $subcategorie='another';
                        oci_bind_by_name($statement, ":subcategory_name",$subcategorie);
                        oci_bind_by_name($statement, ":category_name",$nume_categorie);
                        oci_execute($statement, OCI_DEFAULT);
                        if (oci_fetch($statement)) {
                            $id_subcategory = oci_result($statement, 1);
                            $statement = oci_parse($this->db, "INSERT INTO TW.ARTEFACTS_SUB_CATEGORIES
                                                   VALUES(:v_id_artefact,:v_id_subcategory)");
                            oci_bind_by_name($statement, ":v_id_artefact", $artefact_id);
                            oci_bind_by_name($statement, ":v_id_subcategory", $id_subcategory);
                            oci_execute($statement);
                        }
                    }
                }
            }
            else if($contor==5){
                //inserez in roluri
                $get_artefact_id = oci_parse($this->db,'select max(id) from tw.ARTEFACTS');
                oci_execute($get_artefact_id);
                $artefact_id = 0;
                if(oci_fetch($get_artefact_id)){
                    $artefact_id = oci_result($get_artefact_id,1);
                }
                for($index=0;$index<count($values)-1;$index++) {
                    $single = $values[$index];
                    $statement = oci_parse($this->db, "select id from tw.ROLES where ROLE_NAME=:role_name");
                    oci_bind_by_name($statement, ":role_name", $single);
                    oci_execute($statement, OCI_DEFAULT);
                    if (oci_fetch($statement)) {
                        $id_rol = oci_result($statement, 1);
                        $statement = oci_parse($this->db, "INSERT INTO TW.ARTEFACTS_ROLES
                                                   VALUES(:v_id_artefact,:v_id_rol)");
                        oci_bind_by_name($statement, ":v_id_artefact", $artefact_id);
                        oci_bind_by_name($statement, ":v_id_rol", $id_rol);
                        oci_execute($statement);
                    }
                }
                if(isset($values[count($values)-1])){
                    $single = $values[$index];
                    $temp = substr($single,0,strlen($single)-6);
                    $statement = oci_parse($this->db, "select id from tw.ROLES where ROLE_NAME=:role_name");
                    oci_bind_by_name($statement, ":role_name", $temp);
                    oci_execute($statement, OCI_DEFAULT);
                    if (oci_fetch($statement)) {
                        $id_rol = oci_result($statement, 1);
                        $statement = oci_parse($this->db, "INSERT INTO TW.ARTEFACTS_ROLES
                                                   VALUES(:v_id_artefact,:v_id_rol)");
                        oci_bind_by_name($statement, ":v_id_artefact", $artefact_id);
                        oci_bind_by_name($statement, ":v_id_rol", $id_rol);
                        oci_execute($statement);
                    }
                }
            }
            else if($contor==6){
                //inserez in materiale
                $get_artefact_id = oci_parse($this->db,'select max(id) from tw.ARTEFACTS');
                oci_execute($get_artefact_id);
                $artefact_id = 0;
                if(oci_fetch($get_artefact_id)){
                    $artefact_id = oci_result($get_artefact_id,1);
                }
                for($index=0;$index<count($values)-1;$index++) {
                    $single = $values[$index];
                    $statement = oci_parse($this->db, "select id from tw.MATERIALS where MATERIAL_NAME=:material_name");
                    oci_bind_by_name($statement, ":material_name", $single);
                    oci_execute($statement, OCI_DEFAULT);
                    if (oci_fetch($statement)) {
                        $id_material = oci_result($statement, 1);
                        $statement = oci_parse($this->db, "INSERT INTO TW.ARTEFACTS_MATERIALS
                                                   VALUES(:v_id_artefact,:v_id_material)");
                        oci_bind_by_name($statement, ":v_id_artefact", $artefact_id);
                        oci_bind_by_name($statement, ":v_id_material", $id_material);
                        oci_execute($statement);
                    }
                }
                if(isset($values[count($values)-1])){
                    $single = $values[$index];
                    $temp = substr($single,0,strlen($single)-6);
                    $statement = oci_parse($this->db, "select id from tw.MATERIALS where MATERIAL_NAME=:material_name");
                    oci_bind_by_name($statement, ":material_name", $temp);
                    oci_execute($statement, OCI_DEFAULT);
                    if (oci_fetch($statement)) {
                        $id_material = oci_result($statement, 1);
                        $statement = oci_parse($this->db, "INSERT INTO TW.ARTEFACTS_MATERIALS
                                                   VALUES(:v_id_artefact,:v_id_material)");
                        oci_bind_by_name($statement, ":v_id_artefact", $artefact_id);
                        oci_bind_by_name($statement, ":v_id_material", $id_material);
                        oci_execute($statement);
                    }
                }

            }
            else if($contor==7){
                //inserez in taguri
                $get_artefact_id = oci_parse($this->db,'select max(id) from tw.ARTEFACTS');
                oci_execute($get_artefact_id);
                $artefact_id = 0;
                if(oci_fetch($get_artefact_id)){
                    $artefact_id = oci_result($get_artefact_id,1);
                }
                for($index=0;$index<count($values)-1;$index++) {
                    $single = $values[$index];
                    $statement = oci_parse($this->db, "select count(*) from tw.TAGS where TAG_NAME=:tag_name ");
                    oci_bind_by_name($statement, ":tag_name", $single);
                    oci_execute($statement, OCI_DEFAULT);
                    if (oci_fetch($statement)) {
                        $count_tag = oci_result($statement, 1);
                        if($count_tag==0){
                            //aflam id pentru tag-ul pe care trebuie sa il adaugam
                            $statement = oci_parse($this->db, "select max(id) from tw.TAGS");
                            oci_execute($statement, OCI_DEFAULT);
                            if (oci_fetch($statement)) {
                                $id_tag = oci_result($statement, 1)+1;
                            }
                            $statement = oci_parse($this->db, "INSERT INTO TW.TAGS
                                                   VALUES(:v_id_tag,:v_nume_tag)");
                            oci_bind_by_name($statement, ":v_id_tag", $id_tag);
                            oci_bind_by_name($statement, ":v_nume_tag", $single);
                            oci_execute($statement);
                        }
                        else {
                            $statement = oci_parse($this->db, "select id from tw.TAGS where TAG_NAME=:tag_name ");
                            oci_bind_by_name($statement, ":tag_name", $single);
                            oci_execute($statement, OCI_DEFAULT);
                            if (oci_fetch($statement))
                            {$id_tag = oci_result($statement, 1);}
                        }

                        $statement = oci_parse($this->db, "INSERT INTO TW.ARTEFACTS_TAGS
                                                   VALUES(:v_id_artefact,:v_id_tag)");
                        oci_bind_by_name($statement, ":v_id_artefact", $artefact_id);
                        oci_bind_by_name($statement, ":v_id_tag", $id_tag);
                        oci_execute($statement);
                    }
                }
                if(isset($values[count($values)-1])){
                    $single = $values[$index];
                    $temp = substr($single,0,strlen($single)-6);
                    $statement = oci_parse($this->db, "select count(*) from tw.TAGS where TAG_NAME=:tag_name ");
                    oci_bind_by_name($statement, ":tag_name", $temp);
                    oci_execute($statement, OCI_DEFAULT);
                    if (oci_fetch($statement)) {
                        $count_tag = oci_result($statement, 1);
                        if($count_tag==0){
                            //aflam id pentru tag-ul pe care trebuie sa il adaugam
                            $statement = oci_parse($this->db, "select max(id) from tw.TAGS");
                            oci_execute($statement, OCI_DEFAULT);
                            if (oci_fetch($statement)) {
                                $id_tag = oci_result($statement, 1)+1;
                            }
                            $statement = oci_parse($this->db, "INSERT INTO TW.TAGS
                                                   VALUES(:v_id_tag,:v_nume_tag)");
                            oci_bind_by_name($statement, ":v_id_tag", $id_tag);
                            oci_bind_by_name($statement, ":v_nume_tag", $single);
                            oci_execute($statement);
                        }
                        else {
                            $statement = oci_parse($this->db, "select id from tw.TAGS where TAG_NAME=:tag_name ");
                            oci_bind_by_name($statement, ":tag_name", $temp);
                            oci_execute($statement, OCI_DEFAULT);
                            if (oci_fetch($statement))
                            {$id_tag = oci_result($statement, 1);}
                        }

                        $statement = oci_parse($this->db, "INSERT INTO TW.ARTEFACTS_TAGS
                                                   VALUES(:v_id_artefact,:v_id_tag)");
                        oci_bind_by_name($statement, ":v_id_artefact", $artefact_id);
                        oci_bind_by_name($statement, ":v_id_tag", $id_tag);
                        oci_execute($statement);
                    }
                }
            }
        }
    }
}