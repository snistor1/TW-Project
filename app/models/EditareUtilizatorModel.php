<?php
class EditareUtilizatorModel extends Model{

    public $clase=array();
    public $verificare=array();
    public function __construct(){
        parent::__construct();
        if(isset($_POST['name']) or isset($_POST['email']) or
            isset($_POST['add_class'])or isset($_POST['delete_class']))
        {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $add_class = $_POST['add_class'];
            $delete_class=$_POST['delete_class'];
            if($this->validate($name,$email,$add_class,$delete_class)) {
                if($name != NULL) {
                    //update numele din tabela users
                    $statement = oci_parse($this->db, "update tw.USERS SET NAME=:v_name
                                                  where ID=:v_id");
                    $values = array(':v_name' => $name, ':v_id' => Session::get('id_user'));
                    foreach ($values as $key => $val) {
                        oci_bind_by_name($statement, $key, $values[$key]);
                    }
                    oci_execute($statement);
                }
                if($email!= NULL){
                    //update email-ul din tabela users
                    $statement = oci_parse($this->db, "update tw.USERS SET EMAIL=:v_email 
                                                  where ID=:v_id");
                    $values = array(':v_email' => $email, ':v_id' => Session::get('id_user'));
                    foreach ($values as $key => $val) {
                        oci_bind_by_name($statement, $key, $values[$key]);
                    }
                    oci_execute($statement);
                }
                if($add_class!=NULL) {
                    //cauta id_class al clasei cu numele $class
                    $statement1 = oci_parse($this->db, "select id from tw.CLASSES where CLASS_NAME=:v_nume_clasa");
                    oci_bind_by_name($statement1, ":v_nume_clasa", $add_class);
                    oci_execute($statement1);
                    if (oci_fetch($statement1)) {
                        $id_clasa = oci_result($statement1, 1);
                        //adauga in tabela users_classes un rand cu id-ul utilizatorului si id-ul clasei noi
                        $statement2 = oci_parse($this->db, "INSERT INTO tw.USERS_CLASSES (ID_USER,ID_CLASS)
                                                  VALUES (:v_id_user,:v_id_class)");
                        $values = array(':v_id_user' => Session::get('id_user'), ':v_id_class' => $id_clasa);
                        foreach ($values as $key => $val) {
                            oci_bind_by_name($statement2, $key, $values[$key]);
                        }
                        oci_execute($statement2);
                    }
                }
                if($delete_class!=NULL){
                    //cauta id_class al clasei cu numele $class
                    $statement1 = oci_parse($this->db, "select id from tw.CLASSES where CLASS_NAME=:v_nume_clasa");
                    oci_bind_by_name($statement1, ":v_nume_clasa", $delete_class);
                    oci_execute($statement1);
                    if (oci_fetch($statement1)) {
                        $id_clasa = oci_result($statement1, 1);
                        //sterge din tabela users_classes rand-ul cu id-ul utilizatorului si id-ul clasei noi
                        $statement2 = oci_parse($this->db, "DELETE FROM tw.USERS_CLASSES where ID_USER=:v_id_user and 
                                                                                   ID_CLASS=:v_id_class");
                        $values = array(':v_id_user' => Session::get('id_user'), ':v_id_class' => $id_clasa);
                        foreach ($values as $key => $val) {
                            oci_bind_by_name($statement2, $key, $values[$key]);
                        }
                        oci_execute($statement2);
                    }
                }

                header('Location: /public/paginaUtilizator');
                exit();
            }
            exit();
        }
        //sterge contul utilizatorului
        if(isset($_POST['delete'])){
            $statement=oci_parse($this->db,"delete from tw.USERS where ID=:v_id");
            $myid=Session::get('id_user');
            oci_bind_by_name($statement, ":v_id",$myid);
            oci_execute($statement);
            echo "<script type='text/javascript'>alert(\"Profile Deleted Successfully!\");window.location.href='/public/PaginaUtilizator/logout';</script>";
            exit();
        }
        //afisarea claselor pentru butoanele radio
        $statement=oci_parse($this->db,"select CLASS_NAME,ID from TW.CLASSES");
        oci_execute($statement);
        $contor=0;
        while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS+OCI_ASSOC)){
            $statement1=oci_parse($this->db,"select count(*) from tw.USERS_CLASSES where 
                                                           ID_USER=:v_id_user and ID_CLASS=:v_id_class");
            $values = array(':v_id_user' => Session::get('id_user'), ':v_id_class' => $row['ID']);
            foreach ($values as $key => $val) {
                oci_bind_by_name($statement1, $key, $values[$key]);
            }
            oci_execute($statement1);
            //verifica daca utilizatorul nu este deja in clasa respectiva
            $nr=0;
            if (oci_fetch($statement1)) {
                $nr = oci_result($statement1, 1);
            }
            if($nr==0) {
                $this->clase[$contor] = $row['CLASS_NAME'];
                $this->verificare[$contor]="0";
            }
            else{
                $this->clase[$contor] = $row['CLASS_NAME'];
                $this->verificare[$contor]=("1");
            }
            $contor=$contor+1;
        }

        }
    private function validate($name,$email,$add_class,$delete_class){
        if(preg_match('/[^A-Za-z ]/',$name))
        {
            if($name!=NULL){
                header('Location: /public/editarePgUtilizator?edit=name&email='.$email.'&add_class='.$add_class.'&delete_class='.$delete_class);
                return false;
            }
        }
        if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            if($email!=NULL) {
                header('Location: /public/editarePgUtilizator?edit=email&name='.$name.'&add_class='.$add_class.'&delete_class='.$delete_class);
                return false;
            }
        }
        if($email!=NULL) {
            $statement = oci_parse($this->db, "select count(*) from tw.USERS where EMAIL=:email");
            oci_bind_by_name($statement, "email", $email);
            oci_execute($statement, OCI_DEFAULT);
            if (oci_fetch($statement)) {
                $number = oci_result($statement, 1);
                if ($number > 0) {
                    //verifica daca mai exista un email identic, daca exista inseamna ca nu e valid
                    header('Location: /public/editarePgUtilizator?edit=emailDuplicate&name='.$name.'&add_class='.$add_class.'&delete_class='.$delete_class);
                    return false;
                }
            }
        }
        if($add_class!=NULL) {
            $statement1 = oci_parse($this->db, "select count(*) from tw.CLASSES where CLASS_NAME=:class_name");
            oci_bind_by_name($statement1, ":class_name", $add_class);
            oci_execute($statement1, OCI_DEFAULT);
            if (oci_fetch($statement1)) {
                $number = oci_result($statement1, 1);
                if ($number == 0) {
                    header('Location: /public/editarePgUtilizator?edit=addClass&name='.$name.'&email='.$email.'&delete_class='.$delete_class);
                    return false;

                }
            }
            //cauta id_class al clasei cu numele $delete_class
            $statement1 = oci_parse($this->db, "select id from tw.CLASSES where CLASS_NAME=:v_nume_clasa");
            oci_bind_by_name($statement1, ":v_nume_clasa", $add_class);
            oci_execute($statement1);
            if (oci_fetch($statement1)) {
                $id_clasa = oci_result($statement1, 1);
                //numara daca sunt in tabela users_classes liniii cu id_class si is_user
                $statement2 = oci_parse($this->db, "SELECT COUNT(*) FROM TW.USERS_CLASSES where ID_CLASS=:v_id_class 
                                                       and ID_USER=:v_id_user");
                $values = array(':v_id_user' => Session::get('id_user'), ':v_id_class' => $id_clasa);
                foreach ($values as $key => $val) {
                    oci_bind_by_name($statement2, $key, $values[$key]);
                }
                oci_execute($statement2);
                if (oci_fetch($statement2)) {
                    $number = oci_result($statement2, 1);
                    //daca rezultatul este >0 inseamna ca user-ul se afla deja in clasa respectiva
                    if ($number > 0) {
                        header('Location: /public/editarePgUtilizator?edit=addClassDuplicate&name='.$name.'&email='.$email.'&delete_class='.$delete_class);
                        return false;

                    }
                }
            }
        }
        if($delete_class!=NULL){
            $statement1 = oci_parse($this->db, "select count(*) from tw.CLASSES where CLASS_NAME=:class_name");
            oci_bind_by_name($statement1, ":class_name", $delete_class);
            oci_execute($statement1, OCI_DEFAULT);
            if (oci_fetch($statement1)) {
                $number = oci_result($statement1, 1);
                if ($number == 0) {
                    //verifica daca exista clasa respectiva
                    header('Location: /public/editarePgUtilizator?edit=deleteClass&name='.$name.'&email='.$email.'&add_class='.$add_class);
                    return false;

                }
            }
            //cauta id_class al clasei cu numele $delete_class
            $statement1 = oci_parse($this->db, "select id from tw.CLASSES where CLASS_NAME=:v_nume_clasa");
            oci_bind_by_name($statement1, ":v_nume_clasa", $delete_class);
            oci_execute($statement1);
            if (oci_fetch($statement1)) {
                $id_clasa = oci_result($statement1, 1);
                //numara daca sunt in tabela users_classes liniii cu id_class si is_user
                $statement2 = oci_parse($this->db, "SELECT COUNT(*) FROM TW.USERS_CLASSES where ID_CLASS=:v_id_class 
                                                       and ID_USER=:v_id_user");
                $values = array(':v_id_user' => Session::get('id_user'), ':v_id_class' => $id_clasa);
                foreach ($values as $key => $val) {
                    oci_bind_by_name($statement2, $key, $values[$key]);
                }
                oci_execute($statement2);
                if (oci_fetch($statement2)) {
                    $number = oci_result($statement2, 1);
                    //daca rezultatul este =0 inseamna ca user-ul nu se afla in clasa respectiva
                    if ($number == 0) {
                        header('Location: /public/editarePgUtilizator?edit=deleteClassMissing&name='.$name.'&email='.$email.'&add_class='.$add_class);
                        return false;

                    }
                }
            }
        }
        if($name==NULL and $email==NULL and $add_class==NULL and $delete_class==NULL){
            header('Location: /public/editarePgUtilizator?edit=empty');
            return false;
        }

        return true;
    }


}
