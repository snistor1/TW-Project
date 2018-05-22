<?php
class EditareUtilizatorModel extends Model{

    public function __construct(){
        parent::__construct();
        if(isset($_POST['name']) and isset($_POST['email']) and
            isset($_POST['class']))
        {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $class = $_POST['class'];
            if($this->validate($name,$email,$class)) {
                //update numele si email-ul din tabela users
                $statement = oci_parse($this->db, "update tw.USERS SET NAME=:v_name,EMAIL=:v_email 
                                                  where ID=:v_id");
                $values = array(':v_name' => $name, ':v_email' => $email, ':v_id' => Session::get('id_user'));
                foreach ($values as $key => $val) {
                    oci_bind_by_name($statement, $key, $values[$key]);
                }
                oci_execute($statement);
                //cauta id_class al clasei cu numele $class
                $statement1=oci_parse($this->db,"select id from tw.CLASSES where CLASS_NAME=:v_nume_clasa");
                oci_bind_by_name($statement1, ":v_nume_clasa", $class);
                oci_execute($statement1);
                $id_clasa = '';
                if(oci_fetch($statement1)){
                    $id_clasa=oci_result($statement1,1);
                }
                //adauga in tabela users_classes un rand cu id-ul utilizatorului si id-ul clasei noi
                $statement2 = oci_parse($this->db, "INSERT INTO tw.USERS_CLASSES (ID_USER,ID_CLASS)
                                                  VALUES (:v_id_user,:v_id_class)");
                $values = array(':v_id_user' =>Session::get('id_user'), ':v_id_class' =>$id_clasa );
                foreach ($values as $key => $val) {
                    oci_bind_by_name($statement2, $key, $values[$key]);
                }
                oci_execute($statement2);
                echo "<script type='text/javascript'>alert(\"Profile Edited Successfully!\");window.location.href='/public/paginaUtilizator';</script>";
                exit();
            }
            exit();
        }
    }
    private function validate($name,$email,$class){
        if(preg_match('/[^A-Za-z ]/',$name))
        {
            echo "<script type='text/javascript'>alert(\"Name should contain only letters!\");window.location.href='/public/editarePgUtilizator';</script>";
            return false;
        }
        if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            echo "<script type='text/javascript'>alert(\"Invalid Email!\");window.location.href='/public/editarePgUtilizator';</script>";
            return false;
        }
        $statement = oci_parse($this->db,"select count(*) from tw.USERS where EMAIL=:email");
        oci_bind_by_name($statement,"email",$email);
        oci_execute($statement,OCI_DEFAULT);
        if(oci_fetch($statement))
        {
            $number = oci_result($statement,1);
            if($number>0)
            {
                echo "<script type='text/javascript'>alert(\"Email already exists!\");window.location.href='/public/editarePgUtilizator';</script>";
                return false;
            }
        }
        $statement = oci_parse($this->db,"select count(*) from tw.CLASSES where CLASS_NAME=:class_name");
        oci_bind_by_name($statement,":class_name",$class);
        oci_execute($statement,OCI_DEFAULT);
        if(oci_fetch($statement))
        {
            $number = oci_result($statement,1);
            if($number>0)
            {
                echo "<script type='text/javascript'>alert(\"Class doesn't exist!\");window.location.href='/public/editarePgUtilizator';</script>";
                return false;
            }
        }
        return true;
    }
}