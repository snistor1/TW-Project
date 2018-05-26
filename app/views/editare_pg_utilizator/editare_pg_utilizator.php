<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Artifacty</title>
    <link rel="stylesheet" type="text/css" href="/public/css/editare_pg_utilizator-style.css">
</head>
<body>

<section class="intro">

    <div class="navbar">
        <a href="/public/paginaUtilizator"><img src="/public/Images/png_profile.png" alt="ProfilePage" ></a>
        <a href="/public/login"><img src="/public/Images/png_login.png" alt="LoginPage" ></a>
        <a href="/public/index"><img src="/public/Images/png_home.png" alt="HomePage" ></a>
        <a href="/public/colectieArtefacte"><img src="/public/Images/png_collection.png" alt="CollectionPage" ></a>
        <a href="/public/statistics"><img src="/public/Images/png_statistics.png" alt="StatisticsPage" ></a>
    </div>

    <div class="inner">
        <div class="content">
            <h1><a href="/public/index">ARTIFACTY</a></h1>
        </div>
    </div>
</section>
<hr>
<br><br><br>
<hr>
<section class="BigBox">
    <img src="/public/Images/user.png" alt="This is the users profile picture" width="100" height="100">
    <hr>
    <form action="/public/editarePgUtilizator/save" method="post">
        <?php
            echo '<p><strong>Name:</strong></p>';
            if(isset($_GET['name'])){
                $name = $_GET['name'];
                echo '<input  class="stanga" type="text" name="name" placeholder="Enter Name" value="'.$name.'">';
            }
            else
                echo '<input  class="stanga" type="text" name="name" placeholder="Enter Name">';

            include $_SERVER['DOCUMENT_ROOT']."/app/models/EditareUtilizatorModel.php";
            $ed=new EditareUtilizatorModel();
            $length=count($ed->clase);

            echo '<p><strong>Add Class:</strong></p>';
            echo '<p>';
            $flag=0;
            for($contor=0;$contor<$length;$contor++) {
                if($ed->verificare[$contor]=='0') {
                    if($flag==0){
                        echo $ed->clase[$contor];
                    }
                    else{
                        echo ", ".$ed->clase[$contor];
                    }
                     $flag=$flag+1;
                }
            }
            if($flag==0){echo "You are already in every class!";}
            echo '</p>';
            if(isset($_GET['add_class'])){
                $add_class = $_GET['add_class'];
                echo '<input class="stanga" type="text" name="add_class" placeholder="Enter Class" value="'.$add_class.'">';
            }
            else
                echo '<input class="stanga" type="text" name="add_class" placeholder="Enter Class">';

            echo '<p><strong>Delete Class:</strong></p>';
            echo '<p>';
            $flag=0;
            for($contor=0;$contor<$length;$contor++) {
               if($ed->verificare[$contor]=='1') {
                   if($flag==0){
                       echo $ed->clase[$contor];
                   }
                   else{
                       echo ", ".$ed->clase[$contor];
                   }
                $flag=$flag+1;
               }
            }
            if($flag==0){ echo "You aren't in any class";}
            echo '</p>';
            if(isset($_GET['delete_class'])){
                $delete_class = $_GET['delete_class'];
                echo '<input class="stanga" type="text" name="delete_class" placeholder="Enter Class" value="'.$delete_class.'">';
            }
            else
                echo '<input class="stanga" type="text" name="delete_class" placeholder="Enter Class">';

            echo '<p><strong>Email:</strong></p>';
            if(isset($_GET['email'])){
                $email = $_GET['email'];
                echo '<input class="stanga" type="text" name="email" placeholder="Enter Email" value="'.$email.'">';
            }
            else
                echo '<input class="stanga" type="text" name="email" placeholder="Enter Email">';
        ?>
        <br>
        <?php
        if(isset($_GET['edit'])){
            $message = $_GET['edit'];
            if($message=='name'){
                echo '<br><p style="text-align: center; color: red">Invalid name!</p>';
            }
            else if($message == 'email'){
                echo '<br><p style="text-align: center; color: red">Invalid email!</p>';
            }
            else if($message == 'emailDuplicate'){
                echo '<br><p style="text-align: center; color: red">Email already exists!</p>';
            }
            else if($message == 'addClass'){
                echo '<br><p style="text-align: center; color: red">Can\'t add this class! Class doesn\'t exist!</p>';
            }
            else if($message == 'addClassDuplicate'){
                echo '<br><p style="text-align: center; color: red">You are already in this class!</p>';
            }
            else if($message == 'deleteClass'){
                echo '<br><p style="text-align: center; color: red">Can\'t delete this class! Class doesn\'t exist!</p>';
            }
            else if($message == 'deleteClassMissing'){
                echo '<br><p style="text-align: center; color: red">Can\'t delete this class! You are not part of it!</p>';
            }
            else if($message == 'empty'){
                echo '<br><p style="text-align: center; color: red">Please fill in at least one field!</p>';
            }
        }
        ?>
        <br>
        <hr>
        <input onclick="location.href='/public/paginaUtilizator'" class="button" type="submit" value="Save Profile">
    </form>
    <form action="/public/editarePgUtilizator/delete" method="post">
        <input onclick="location.href='/public/'" class="button" name="delete" type="submit" value="Delete Profile">
    </form>
    <br><br>
</section>
</body>
</html>