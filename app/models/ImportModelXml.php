<?php

class ImportModelXml extends Model
{
    public function __construct()
    {
        parent::__construct();
        $file = $_FILES['xml_file'];
        $fileName = $_FILES['xml_file']['name'];
        $fileError = $_FILES['xml_file']['error'];
        $fileType = $_FILES['xml_file']['type'];
        if(empty($fileName) || $fileType!='text/xml')
        {
            echo "<script type='text/javascript'>alert(\"Please insert a valid xml file!\");window.location.href='/public/paginaUtilizator';</script>";
            exit();
        }
        $content = file_get_contents($_FILES['xml_file']['tmp_name']);
        $xml = simplexml_load_string($content);


        $result = $this->xml_to_array($xml);

        $this->do_inserts($result);

        $my_id = Session::get('id');
        $statement = oci_parse($this->db,'select max(id) from tw.ARTEFACTS');
        oci_execute($statement);
        $artefact_id = 0;
        if(oci_fetch($statement)){
            $artefact_id = oci_result($statement,1);
        }

        echo "<script type='text/javascript'>alert(\"Artefact successfully added!\"); window.location.href='/public/paginaArtefact?id=".$artefact_id."'</script>";
    }

    function xml_to_array($xml,$out=array())
    {
        foreach ((array)$xml as $index => $node){
            $out[$index] = (is_object($node)) ? $this->xml_to_array($node) : $node;
        }
        return $out;
    }

    public function do_inserts($result)
    {
        $single_values = array();
        $ok=1;
        $my_id = Session::get('id_user');
        foreach ($result as $key=>$value) {
            //iau valorile pentru tabela artefacts
            if(!is_array($value))
                array_push($single_values,$value);
            else{
                //am terminat de luat valorile initiale asa ca le inserez si trec la vectori
                if($ok==1){
                    $ok=0;
                    $sql = oci_parse($this->db,"insert into tw.ARTEFACTS(ID_USER,ARTEFACT_NAME,ARTEFACT_IMAGE,
                    AUTHOR_NAME,DATING,PRICE,UTILIZATION_LICENSE,ORIGIN,DESCRIPTION,LATITUDE,LONGITUDE) values(
                    :v_id,:v_name,empty_blob(),:v_author,:v_dating,:v_price,:v_license,:v_origin,:v_description,:latitude,:longitude
                    ) returning ARTEFACT_IMAGE into :image");
                    oci_bind_by_name($sql,":v_id",$my_id);
                    oci_bind_by_name($sql,":v_name",$single_values[0]);

                    oci_bind_by_name($sql,":v_author",$single_values[2]);
                    oci_bind_by_name($sql,":v_dating",$single_values[3]);
                    oci_bind_by_name($sql,":v_price",$single_values[4]);
                    oci_bind_by_name($sql,":v_license",$single_values[5]);
                    oci_bind_by_name($sql,":v_origin",$single_values[6]);
                    oci_bind_by_name($sql,":v_description",$single_values[7]);
                    oci_bind_by_name($sql,":latitude",$single_values[8]);
                    oci_bind_by_name($sql,":longitude",$single_values[9]);
                    $blob = oci_new_descriptor($this->db,OCI_D_LOB);
                    oci_bind_by_name($sql,":image",$blob,-1,OCI_B_BLOB);
                    oci_execute($sql, OCI_NO_AUTO_COMMIT);
                    if($blob->save(base64_decode($single_values[1])))
                    {
                        oci_commit($this->db);
                    }
                    $blob->free();
                }
                else{

                }
            }
        }
    }
}