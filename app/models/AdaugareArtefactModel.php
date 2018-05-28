<?php

class AdaugareArtefactModel extends Model{
    /**
     * AdaugareArtefactModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
        if(isset($_POST['submit'])){
            $nume = $_POST['nume'];
            //$categorie = $_POST['categorie'];
            //$subcategorie = $_POST['subcategorie'];
            $clasa = $_POST['clasa'];
            $autor = $_POST['autor'];
            $secol = $_POST['secol'];
            $data = $_POST['data'];
            $pret = $_POST['pret'];
            $origine = $_POST['origine'];
            $latitudine = $_POST['latitudine'];
            $longitudine = $_POST['longitudine'];
            $descriere = $_POST['descriere'];
            $dating = $secol.' '.$data;
            $file = $_FILES['pic'];
            $fileName = $_FILES['pic']['name'];
            $fileError = $_FILES['pic']['error'];
            $fileType = $_FILES['pic']['type'];

            if($_POST['licenta']=='YES')
                $licenta = 1;
            else
                $licenta = 0;
            if($this->validate($nume,$clasa,$autor,$pret,$origine,$secol,$latitudine,$longitudine,$descriere)) {
                //adaugare informatii in tabela ARTEFACTS
                //daca totul e ok, iau si imaginea
                if(!empty($fileName)){
                    if($fileType!='image/gif' && $fileType!='image/jpg' && $fileType!='image/jpeg' && $fileType!='image/png')
                    {
                        header('Location: /public/AdaugareArtefact?add=image&name='.$nume.'&class='.$clasa.
                        '&author='.$autor.'&price='.$pret.'&origin='.$origine.'&ev='.$secol.'&latitude='.$latitudine.
                        '&longitude='.$longitudine.'&description='.$descriere);
                        exit();
                    }
                    $image = file_get_contents($_FILES['pic']['tmp_name']);
                }
                else {
                    $image = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/public/Images/dummy-image.jpg');
                }
                $statement = oci_parse($this->db, "insert into tw.ARTEFACTS(ARTEFACT_NAME,ID_USER,AUTHOR_NAME,DATING,
                                                                                 PRICE,DESCRIPTION,ORIGIN,LATITUDE,
                                                                                 LONGITUDE,ARTEFACT_IMAGE,UTILIZATION_LICENSE) values 
                                    (:v_name,:v_id_user,:v_author,:v_dating,:v_price,:v_description,:v_origin,
                                      :v_latitude,:v_longitude,empty_blob(),:v_license) returning ARTEFACT_IMAGE into :image");
                $blob = oci_new_descriptor($this->db,OCI_D_LOB);

                $values = array(':v_name' => $nume, ':v_id_user' => Session::get('id_user'), 'v_author' => $autor,
                    ':v_dating' => $dating, ':v_price' => $pret, ':v_description' => $descriere,
                    ':v_origin' => $origine, ':v_latitude' => $latitudine,
                    ':v_longitude' => $longitudine, ':v_license' => $licenta
                );
                foreach ($values as $key => $val) {
                    oci_bind_by_name($statement, $key, $values[$key]);
                }
                oci_bind_by_name($statement,":image",$blob,-1,OCI_B_BLOB);
                oci_execute($statement, OCI_NO_AUTO_COMMIT);
                if($blob->save($image))
                {
                    oci_commit($this->db);
                }
                $blob->free();
                //aflam id_artefact curent
                $statement = oci_parse($this->db, "select max(id) from tw.ARTEFACTS");
                oci_execute($statement, OCI_DEFAULT);
                if (oci_fetch($statement)) {
                    $id_artefact = oci_result($statement, 1);
                }
                //adaugare informatii in tabela ARTEFACTS_SUB_CATEGORIES
                if(isset($_POST['subcategorie'])) {
                    $statement = oci_parse($this->db, "select s.id from tw.SUB_CATEGORIES s join tw.CATEGORIES c 
                                                                   on s.PARENT_ID=c.ID where SUB_CATEGORY_NAME=:subcategory_name
                                                                   and CATEGORY_NAME=:category_name");
                    oci_bind_by_name($statement, ":subcategory_name", $_POST['subcategorie']);
                    oci_bind_by_name($statement, ":category_name",$_POST['categorie']);
                    oci_execute($statement, OCI_DEFAULT);
                    if (oci_fetch($statement)) {
                            $id_subcategory = oci_result($statement, 1);
                            $statement = oci_parse($this->db, "INSERT INTO TW.ARTEFACTS_SUB_CATEGORIES
                                                   VALUES(:v_id_artefact,:v_id_subcategory)");
                            oci_bind_by_name($statement, ":v_id_artefact", $id_artefact);
                            oci_bind_by_name($statement, ":v_id_subcategory", $id_subcategory);
                            oci_execute($statement);

                    }
                }
                else{
                    if(isset($_POST['categorie'])) {
                        $statement = oci_parse($this->db, "select s.id from tw.SUB_CATEGORIES s join tw.CATEGORIES c 
                                                                   on s.PARENT_ID=c.ID where SUB_CATEGORY_NAME=:subcategory_name 
                                                                   and CATEGORY_NAME=:category_name");
                        $subcategorie='another';
                        oci_bind_by_name($statement, ":subcategory_name",$subcategorie);
                        oci_bind_by_name($statement, ":category_name",$_POST['categorie']);
                        oci_execute($statement, OCI_DEFAULT);
                        if (oci_fetch($statement)) {
                            $id_subcategory = oci_result($statement, 1);
                            $statement = oci_parse($this->db, "INSERT INTO TW.ARTEFACTS_SUB_CATEGORIES
                                                   VALUES(:v_id_artefact,:v_id_subcategory)");
                            oci_bind_by_name($statement, ":v_id_artefact", $id_artefact);
                            oci_bind_by_name($statement, ":v_id_subcategory", $id_subcategory);
                            oci_execute($statement);
                        }
                    }
                }
                //adaugare informatii in tabela ARTEFACTS_CLASS
                if(isset($_POST['clasa'])) {
                    $statement = oci_parse($this->db, "select id from tw.CLASSES where CLASS_NAME=:class_name");
                    oci_bind_by_name($statement, ":class_name", $_POST['clasa']);
                    oci_execute($statement, OCI_DEFAULT);
                    if (oci_fetch($statement)) {
                        $id_clasa = oci_result($statement, 1);
                            $statement = oci_parse($this->db, "INSERT INTO TW.ARTEFACTS_CLASSES
                                                   VALUES(:v_id_artefact,:v_id_class)");
                            oci_bind_by_name($statement, ":v_id_artefact", $id_artefact);
                            oci_bind_by_name($statement, ":v_id_class", $id_clasa);
                            oci_execute($statement);
                    }
                }

                //adaugare informatii in tabela ARTEFACTS_ROLES
                if(!empty($_POST['rol'])) {
                    foreach($_POST['rol'] as $rol) {
                        $statement = oci_parse($this->db, "select id from tw.ROLES where ROLE_NAME=:role_name");
                        oci_bind_by_name($statement, ":role_name", $rol);
                        oci_execute($statement, OCI_DEFAULT);
                        if (oci_fetch($statement)) {
                            $id_rol = oci_result($statement, 1);
                            $statement = oci_parse($this->db, "INSERT INTO TW.ARTEFACTS_ROLES
                                                   VALUES(:v_id_artefact,:v_id_rol)");
                            oci_bind_by_name($statement, ":v_id_artefact", $id_artefact);
                            oci_bind_by_name($statement, ":v_id_rol", $id_rol);
                            oci_execute($statement);
                        }
                    }
                }

                //adaugare informatii in tabela ARTEFACTS_MATERIALS
                if(!empty($_POST['material'])) {
                    foreach($_POST['material'] as $material) {
                        $statement = oci_parse($this->db, "select id from tw.MATERIALS where MATERIAL_NAME=:material_name");
                        oci_bind_by_name($statement, ":material_name", $material);
                        oci_execute($statement, OCI_DEFAULT);
                        if (oci_fetch($statement)) {
                            $id_material = oci_result($statement, 1);
                            $statement = oci_parse($this->db, "INSERT INTO TW.ARTEFACTS_MATERIALS
                                                   VALUES(:v_id_artefact,:v_id_material)");
                            oci_bind_by_name($statement, ":v_id_artefact", $id_artefact);
                            oci_bind_by_name($statement, ":v_id_material", $id_material);
                            oci_execute($statement);
                        }
                    }
                }

                //adaugare informatii in tabela TAGS si ARTEFACTS_TAGS
                if(!empty($_POST['tag'])) {
                    foreach($_POST['tag'] as $tag) {
                        $statement = oci_parse($this->db, "select count(*) from tw.TAGS where TAG_NAME=:tag_name ");
                        oci_bind_by_name($statement, ":tag_name", $tag);
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
                                oci_bind_by_name($statement, ":v_nume_tag", $tag);
                                oci_execute($statement);
                            }
                            else {
                                $statement = oci_parse($this->db, "select id from tw.TAGS where TAG_NAME=:tag_name ");
                                oci_bind_by_name($statement, ":tag_name", $tag);
                                oci_execute($statement, OCI_DEFAULT);
                                if (oci_fetch($statement))
                                {$id_tag = oci_result($statement, 1);}
                            }

                            $statement = oci_parse($this->db, "INSERT INTO TW.ARTEFACTS_TAGS
                                                   VALUES(:v_id_artefact,:v_id_tag)");
                            oci_bind_by_name($statement, ":v_id_artefact", $id_artefact);
                            oci_bind_by_name($statement, ":v_id_tag", $id_tag);
                            oci_execute($statement);
                        }
                    }
                }
                header('Location: /public/PaginaArtefact'.'?id='.$id_artefact);
                exit();
            }
            exit();
        }
    }

    private function validate($nume,$clasa,$autor,$pret,$origine,$secol,$latitudine,$longitudine,$descriere){
        if(preg_match('/[^A-Za-z ]/',$nume))
        {
            //Name should contain only letters!
            header('Location: /public/AdaugareArtefact?add=name&class='.$clasa.'&author='.$autor.
                '&price='.$pret.'&origin='.$origine.'&ev='.$secol.'&latitude='.$latitudine.
                '&longitude='.$longitudine.'&description='.$descriere);
            return false;
        }
        if(preg_match('/[^A-Za-z ]/',$autor))
        {
            //Author's name should contain only letters!
            header('Location: /public/AdaugareArtefact?add=author&name='.$nume.'&class='.$clasa.
                '&price='.$pret.'&origin='.$origine.'&ev='.$secol.'&latitude='.$latitudine.
                '&longitude='.$longitudine.'&description='.$descriere);
            return false;
        }
        if(!preg_match('/^[1-9][0-9]*$/',$pret) or $pret>99999)
        {
            //The price is not valid!
            header('Location: /public/AdaugareArtefact?add=price&name='.$nume.'&class='.$clasa.
                '&author='.$autor.'&origin='.$origine.'&ev='.$secol.'&latitude='.$latitudine.
                '&longitude='.$longitudine.'&description='.$descriere);
            return false;
        }

        if(preg_match('/[^A-Za-z ]/',$origine))
        {
            //The origin should contain only letters!
            header('Location: /public/AdaugareArtefact?add=origin&name='.$nume.'&class='.$clasa.
                '&author='.$autor.'&price='.$pret.'&ev='.$secol.'&latitude='.$latitudine.
                '&longitude='.$longitudine.'&description='.$descriere);
            return false;
        }

        $statement = oci_parse($this->db,"select count(*) from tw.CLASSES where CLASS_NAME=:class_name");
        oci_bind_by_name($statement,":class_name",$clasa);
        oci_execute($statement,OCI_DEFAULT);
        if(oci_fetch($statement))
        {
            $number = oci_result($statement,1);
            if($number==0)
            {
                //Class doesn't exist!
                header('Location: /public/AdaugareArtefact?add=class&name='.$nume.'&class='.$clasa.
                    '&author='.$autor.'&price='.$pret.'&origin='.$origine.'&ev='.$secol.
                    '&latitude='.$latitudine.'&longitude='.$longitudine.'&description='.$descriere);
                return false;
            }
        }
        return true;
    }
}