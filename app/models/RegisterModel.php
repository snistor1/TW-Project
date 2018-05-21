<?php

class RegisterModel extends Model
{
    public function __construct(){
        parent::__construct();
        if(isset($_POST['name']) and isset($_POST['email']) and
            isset($_POST['password']) and isset($_POST['confirm_password']))
        {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            if($this->validate($name,$email,$password,$confirm_password)) {
                $encrypted_password  =md5($password);
                $statement = oci_parse($this->db, "insert into tw.USERS(NAME,EMAIL,PASS) values 
                                    (:v_name,:v_email,:v_pass)");
                $values = array(':v_name' => $name, ':v_email' => $email, ':v_pass' => $encrypted_password);
                foreach ($values as $key => $val) {
                    oci_bind_by_name($statement, $key, $values[$key]);
                }
                oci_execute($statement);
                echo "<script type='text/javascript'>alert(\"Registration Successful!\");window.location.href='/public/login';</script>";
                exit();
            }
            exit();
        }
    }

    private function validate($name,$email,$password,$confirm_password){
        if(preg_match('/[^A-Za-z ]/',$name))
        {
            echo "<script type='text/javascript'>alert(\"Name should contain only letters!\");window.location.href='/public/register';</script>";
            return false;
        }
        if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            echo "<script type='text/javascript'>alert(\"Invalid Email!\");window.location.href='/public/register';</script>";
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
                echo "<script type='text/javascript'>alert(\"Email already exists!\");window.location.href='/public/register';</script>";
                return false;
            }
        }
        if($password!=$confirm_password)
        {
            echo "<script type='text/javascript'>alert(\"Passwords doesn't match!\");window.location.href='/public/register';</script>";
            return false;
        }
        return true;
    }
}