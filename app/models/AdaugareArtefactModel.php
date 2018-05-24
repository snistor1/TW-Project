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
            //$_POST['rol'] si $_POST['material']: vectori

            if($_POST['licenta']=='YES')
                $licenta = 1;
            else
                $licenta = 0;
            if($this->validate($nume,$clasa,$autor,$pret,$origine)) {
                //adaugare informatii in tabela ARTEFACTS
                $statement = oci_parse($this->db, "insert into tw.ARTEFACTS(ARTEFACT_NAME,ID_USER,AUTHOR_NAME,DATING,
                                                                                 PRICE,DESCRIPTION,ORIGIN,LATITUDE,
                                                                                 LONGITUDE,UTILIZATION_LICENSE) values 
                                    (:v_name,:v_id_user,:v_author,:v_dating,:v_price,:v_description,:v_origin,
                                      :v_latitude,:v_longitude,:v_license)");
                $values = array(':v_name' => $nume, ':v_id_user' => Session::get('id_user'), 'v_author' => $autor,
                    ':v_dating' => $secol, ':v_price' => $pret, ':v_description' => $descriere,
                    ':v_origin' => $origine, ':v_latitude' => $latitudine,
                    ':v_longitude' => $longitudine, ':v_license' => $licenta
                );
                foreach ($values as $key => $val) {
                    oci_bind_by_name($statement, $key, $values[$key]);
                }
                oci_execute($statement);
                //aflam id_artefact curent
                $statement = oci_parse($this->db, "select max(id) from tw.ARTEFACTS");
                oci_execute($statement, OCI_DEFAULT);
                if (oci_fetch($statement)) {
                    $id_artefact = oci_result($statement, 1);
                }
                //adaugare informatii in tabela ARTEFACTS_SUB_CATEGORIES
                if(isset($_POST['subcategorie'])) {
                    $statement = oci_parse($this->db, "select id from tw.SUB_CATEGORIES where SUB_CATEGORY_NAME=:subcategory_name");
                    oci_bind_by_name($statement, ":subcategory_name", $_POST['subcategorie']);
                    oci_execute($statement, OCI_DEFAULT);
                    if (oci_fetch($statement)) {
                            $statement = oci_parse($this->db, "INSERT INTO TW.ARTEFACTS_SUB_CATEGORIES
                                                   VALUES(:v_id_artefact,:v_id_subcategory)");
                            oci_bind_by_name($statement, ":v_id_artefact", $id_artefact);
                            oci_bind_by_name($statement, ":v_id_subcategory", $id_subcategory);
                            oci_execute($statement);

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


                echo "<script type='text/javascript'>alert(\"Artefact added successfully!\");window.location.href='/public/PaginaArtefact';</script>";
                exit();
            }
            exit();
        }
    }

    private function validate($nume,$clasa,$autor,$pret,$origine){
        if(preg_match('/[^A-Za-z ]/',$nume))
        {
            echo "<script type='text/javascript'>alert(\"Name should contain only letters!\");window.location.href='/public/AdaugareArtefact';</script>";
            return false;
        }
        if(preg_match('/[^A-Za-z ]/',$autor))
        {
            echo "<script type='text/javascript'>alert(\"Author's name should contain only letters!\");window.location.href='/public/AdaugareArtefact';</script>";
            return false;
        }
        if(!preg_match('/^[1-9][0-9]*$/',$pret) or $pret>99999){
            echo "<script type='text/javascript'>alert(\"The price is not valid!\");window.location.href='/public/AdaugareArtefact';</script>";
            return false;
        }

        if(preg_match('/[^A-Za-z ]/',$origine))
        {
            echo "<script type='text/javascript'>alert(\"the origin should contain only letters!\");window.location.href='/public/AdaugareArtefact';</script>";
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
                echo "<script type='text/javascript'>alert(\"Class doesn't exist!\");window.location.href='/public/AdaugareArtefact';</script>";
                return false;
            }
        }
        return true;
    }
}