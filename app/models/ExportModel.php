<?php

class ExportModel extends Model
{
    public $rows = array();
    public $xml_array = array();

    public function __construct()
    {
        parent::__construct();
        $my_id = $_GET['id'];
        $sql  = oci_parse($this->db, "select * from TW.ARTEFACTS where id=:my_id");
        oci_bind_by_name($sql,":my_id",$my_id);
        oci_execute($sql);
        $this->rows = array();
        $this->xml_array = array();
        while($r = oci_fetch_assoc($sql)) {
            if($r['ARTEFACT_IMAGE']!=null) {
                $x = array(
                    $r['ID'], $r['ARTEFACT_NAME'], $r['ID_USER'], $r['AUTHOR_NAME'], $r['DATING'], $r['PRICE'], $r['DESCRIPTION'],
                    $r['ORIGIN'], $r['LATITUDE'], $r['LONGITUDE'], base64_encode($r['ARTEFACT_IMAGE']->load()), $r['UTILIZATION_LICENSE']
                );

                $y = array(
                    'ID' => $r['ID'], 'ARTEFACT_NAME' => $r['ARTEFACT_NAME'], 'ID_USER' => $r['ID_USER'],
                    'AUTHOR_NAME' => $r['AUTHOR_NAME'], 'DATING' => $r['DATING'], 'PRICE' => $r['PRICE'], 'DESCRIPTION' => $r['DESCRIPTION'],
                    'ORIGIN' => $r['ORIGIN'], 'LATITUDE' => $r['LATITUDE'], 'LONGITUDE' => $r['LONGITUDE'],
                    'ARTEFACT_IMAGE' => base64_encode($r['ARTEFACT_IMAGE']->load()), 'UTILIZATION_LICENSE' => $r['UTILIZATION_LICENSE']
                );
            }
            else{
                $x = array(
                    $r['ID'], $r['ARTEFACT_NAME'], $r['ID_USER'], $r['AUTHOR_NAME'], $r['DATING'], $r['PRICE'], $r['DESCRIPTION'],
                    $r['ORIGIN'], $r['LATITUDE'], $r['LONGITUDE'], $r['UTILIZATION_LICENSE']
                );

                $y = array(
                    'ID' => $r['ID'], 'ARTEFACT_NAME' => $r['ARTEFACT_NAME'], 'ID_USER' => $r['ID_USER'],
                    'AUTHOR_NAME' => $r['AUTHOR_NAME'], 'DATING' => $r['DATING'], 'PRICE' => $r['PRICE'], 'DESCRIPTION' => $r['DESCRIPTION'],
                    'ORIGIN' => $r['ORIGIN'], 'LATITUDE' => $r['LATITUDE'], 'LONGITUDE' => $r['LONGITUDE'],
                     'UTILIZATION_LICENSE' => $r['UTILIZATION_LICENSE']
                );
            }
            $this->xml_array[] = $y;
            $this->rows[] = $x;
        }
    }

    public function exportJson()
    {
        $json_data =(json_encode($this->rows));
        $jsonfile = fopen($_SERVER['DOCUMENT_ROOT'].'/app/files/jsonFile.json',"w");
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/app/files/jsonFile.json',$json_data);
    }

    public function exportCsv()
    {
        $csvfile = fopen($_SERVER['DOCUMENT_ROOT'].'/app/files/csvFile.csv',"w");
        foreach($this->rows as $row)
            fputcsv($csvfile,$row);
    }

    public function exportXml()
    {
        $xmlfile = fopen($_SERVER['DOCUMENT_ROOT'].'/app/files/xmlFile.xml',"w");
        function array_to_xml($array, &$xml) {
            foreach($array as $key => $value) {
                if(is_array($value)) {
                    if(!is_numeric($key)){
                        $subnode = $xml->addChild($key);
                        array_to_xml($value, $subnode);
                    } else {
                        array_to_xml($value, $subnode);
                    }
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