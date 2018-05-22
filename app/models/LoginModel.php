<?php

class LoginModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        if(isset($_POST['email']) and isset($_POST['password']))
        {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $encrypted = md5($password);
            if($this->validate($email,$encrypted)==1)
            {
                echo "<script type='text/javascript'>alert(\"Account doesn't exist!\");window.location.href='/public/login';</script>";
                exit();
            }
            else if($this->validate($email,$encrypted)==2)
            {
                echo "<script type='text/javascript'>alert(\"Password is invalid!\");window.location.href='/public/login';</script>";
                exit();
            }
            else
            {
                Session::set('email',$email);
                echo "<script type='text/javascript'>alert(\"Login Successful!\");window.location.href='/public/paginaUtilizator';</script>";
                exit();
            }
        }
    }

    public function validate($email, $password)
    {
        $statement = oci_parse($this->db,"select count(*) from tw.USERS where EMAIL=:email");
        oci_bind_by_name($statement,"email",$email);
        oci_execute($statement,OCI_DEFAULT);
        if(oci_fetch($statement))
        {
            $number = oci_result($statement,1);
            if($number==0)
                return 1;
        }
        $statement2 = oci_parse($this->db,"select count(*) from tw.USERS where EMAIL=:email and PASS=:pass");
        oci_bind_by_name($statement2,"email",$email);
        oci_bind_by_name($statement2,"pass",$password);
        oci_execute($statement2,OCI_DEFAULT);
        if(oci_fetch($statement2))
        {
            $number2 = oci_result($statement2,1);
            if($number2==0)
                return 2;
        }
        return 0;
    }
}