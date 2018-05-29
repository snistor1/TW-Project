<?php

class ExportModel extends Model
{
    public $rows = array();
    public $xml_array = array();

    public function __construct()
    {
        parent::__construct();
        $my_id = $_GET['id'];
        $sql_artefact  = oci_parse($this->db,
            "select ARTEFACT_NAME, artefact_image, author_name,dating, price,
                    utilization_license, origin, description,LATITUDE,LONGITUDE from TW.ARTEFACTS where id=:my_id");
        oci_bind_by_name($sql_artefact,":my_id",$my_id);
        oci_execute($sql_artefact);
        $this->rows = array();
        $this->xml_array = array();
        while($r = oci_fetch_assoc($sql_artefact)) {
            $x = array(
                $r['ARTEFACT_NAME'], base64_encode($r['ARTEFACT_IMAGE']->load()), $r['AUTHOR_NAME'], $r['DATING'],
                $r['PRICE'], $r['UTILIZATION_LICENSE'], $r['ORIGIN'],$r['DESCRIPTION'], $r['LATITUDE'], $r['LONGITUDE']
            );

            $y = array(
                'ARTEFACT_NAME' => $r['ARTEFACT_NAME'],'ARTEFACT_IMAGE' => base64_encode($r['ARTEFACT_IMAGE']->load()),
                'AUTHOR_NAME' => $r['AUTHOR_NAME'], 'DATING' => $r['DATING'], 'PRICE' => $r['PRICE'],
                'UTILIZATION_LICENSE' => $r['UTILIZATION_LICENSE'], 'ORIGIN' => $r['ORIGIN'],
                'DESCRIPTION' => $r['DESCRIPTION'], 'LATITUDE' => $r['LATITUDE'], 'LONGITUDE' => $r['LONGITUDE']
            );

            $this->xml_array[] = $y;
            $this->rows[] = $x;
        }

        $sql_classes = oci_parse($this->db,"select c.CLASS_NAME from TW.classes c join TW.artefacts_classes a_c on
                      c.id=a_c.id_class join TW.artefacts a on a.id = a_c.ID_ARTEFACT where a.id=:my_id");
        oci_bind_by_name($sql_classes,":my_id",$my_id);
        oci_execute($sql_classes);
        $my_classes = array();
        while(oci_fetch($sql_classes)){
            $temp = oci_result($sql_classes,1);
            array_push($my_classes,$temp);
        }
        $my_classes_xml = array('CLASSES' => $my_classes);
        $this->rows[] = $my_classes;
        $this->xml_array[] = $my_classes_xml;

        $sql_categories = oci_parse($this->db,"select c.CATEGORY_NAME from TW.CATEGORIES c join 
        TW.SUB_CATEGORIES s on c.id=s.PARENT_ID join TW.ARTEFACTS_SUB_CATEGORIES a_s on a_s.ID_SUB_CATEGORY=s.ID
        join TW.ARTEFACTS a on a.ID=a_s.ID_ARTEFACT WHERE a.id=:my_id");
        oci_bind_by_name($sql_categories,":my_id",$my_id);
        oci_execute($sql_categories);
        $my_categories = array();
        while(oci_fetch($sql_categories)){
            $temp = oci_result($sql_categories,1);
            array_push($my_categories,$temp);
        }
        $my_categories_xml = array('CATEGORIES' => $my_categories);
        $this->rows[] = $my_categories;
        $this->xml_array[] = $my_categories_xml;

        $sql_sub_categories = oci_parse($this->db,"select s.SUB_CATEGORY_NAME from TW.SUB_CATEGORIES s 
        join TW.ARTEFACTS_SUB_CATEGORIES a_s on s.id = a_s.ID_SUB_CATEGORY
        join TW.ARTEFACTS a on a_s.ID_ARTEFACT=a.id where a.id=:my_id");
        oci_bind_by_name($sql_sub_categories,":my_id",$my_id);
        oci_execute($sql_sub_categories);
        $my_sub_categories = array();
        while(oci_fetch($sql_sub_categories)){
            $temp = oci_result($sql_sub_categories,1);
            array_push($my_sub_categories,$temp);
        }
        $my_sub_categories_xml = array('SUB_CATEGORIES' => $my_sub_categories);
        $this->rows[] = $my_sub_categories;
        $this->xml_array[] = $my_sub_categories_xml;

        $sql_roles = oci_parse($this->db,"select r.ROLE_NAME from TW.roles r join 
        TW.ARTEFACTS_ROLES a_r on r.ID = a_r.ID_ROLE
        join TW.artefacts a on a_r.ID_ARTEFACT=a.id where a.id=:my_id");
        oci_bind_by_name($sql_roles,":my_id",$my_id);
        oci_execute($sql_roles);
        $my_roles = array();
        $contor = 0;
        while(oci_fetch($sql_roles)){
            $temp = oci_result($sql_roles,1);
            array_push($my_roles,$temp);
        }
        $my_roles_xml = array('ROLES' => $my_roles);
        $this->rows[] = $my_roles;
        $this->xml_array[] = $my_roles_xml;

        $sql_materials = oci_parse($this->db,"select m.MATERIAL_NAME from TW.MATERIALS m 
        join TW.ARTEFACTS_MATERIALS a_m on m.ID = a_m.ID_MATERIAL
        join TW.artefacts a on a_m.ID_ARTEFACT=a.id where a.id=:my_id");
        oci_bind_by_name($sql_materials,":my_id",$my_id);
        oci_execute($sql_materials);
        $my_materials = array();
        while(oci_fetch($sql_materials)){
            $temp = oci_result($sql_materials,1);
            array_push($my_materials,$temp);
        }
        $my_materials_xml = array('MATERIALS' => $my_materials);
        $this->rows[] = $my_materials;
        $this->xml_array[] = $my_materials_xml;

        $sql_tags = oci_parse($this->db,"select t.TAG_NAME from TW.tags t 
        join TW.ARTEFACTS_TAGS a_t on t.id=a_t.ID_TAG
        join TW.ARTEFACTS a on a.ID = a_t.ID_ARTEFACT where a.id=:my_id");
        oci_bind_by_name($sql_tags,":my_id",$my_id);
        oci_execute($sql_tags);
        $my_tags = array();
        while(oci_fetch($sql_tags)){
            $temp = oci_result($sql_tags,1);
            array_push($my_tags,$temp);
        }
        $my_tags_xml = array('TAGS' => $my_tags);
        $this->rows[] = $my_tags;
        $this->xml_array[] = $my_tags_xml;
    }

    public function exportJson()
    {
        $json_data =(json_encode($this->xml_array));
        $jsonfile = fopen($_SERVER['DOCUMENT_ROOT'].'/app/files/jsonFile.json',"w");
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/app/files/jsonFile.json',$json_data);
    }

    public function exportCsv()
    {
        $csvfile = fopen($_SERVER['DOCUMENT_ROOT'].'/app/files/csvFile.csv',"w");
        foreach($this->rows as $row)
            if($row!=null)
                fputcsv($csvfile,$row);
            else
                fputcsv($csvfile,array('null'));

    }

    public function exportXml()
    {
        $xmlfile = fopen($_SERVER['DOCUMENT_ROOT'].'/app/files/xmlFile.xml',"w");
        function array_to_xml($array, &$xml) {
            foreach($array as $key => $value) {
                if(is_numeric($key)){
                    $key = 'item'.$key;
                }
                if(is_array($value)) {
                    $subnode = $xml->addChild($key);
                    array_to_xml($value, $subnode);
                } else {
                    $xml->addChild($key, $value == null ? 'null' : $value);
                }
            }
        }
        $xml = new SimpleXMLElement('<Artefact/>');
        foreach ($this->xml_array as $h)
            array_to_xml($h,$xml);
        $xml->asXML($_SERVER['DOCUMENT_ROOT'].'/app/files/xmlFile.xml');
    }
}