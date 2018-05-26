<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Artifacty</title>
    <link rel="stylesheet" type="text/css" href="/public/css/register-style.css">
</head>
<body>
<div class="navbar">
    <a href="/public/paginaUtilizator"><img src="/public/Images/png_profile.png" alt="ProfilePage" ></a>
    <a href="/public/login"><img src="/public/Images/png_login.png" alt="LoginPage" ></a>
    <a href="/public/index"><img src="/public/Images/png_home.png" alt="HomePage" ></a>
    <a href="/public/colectieArtefacte"><img src="/public/Images/png_collection.png" alt="CollectionPage" ></a>
    <a href="/public/statistics"><img src="/public/Images/png_statistics.png" alt="StatisticsPage" ></a>
</div>

<div class="register-box">
    <h1>Register</h1>
    <form action="/public/register/submit" method="post">
        <?php
            echo '<p>Name</p>';
            if(isset($_GET['name'])){
                $name = $_GET['name'];
                echo '<input type="text" name="name" placeholder="Enter Name" value="'.$name.'" required autocomplete="off">';
            }
            else
                echo '<input type="text" name="name" placeholder="Enter Name" required autocomplete="off">';

            echo '<p>Email</p>';
            if(isset($_GET['email'])){
                $email = $_GET['email'];
                echo '<input type="text" name="email" placeholder="Enter Email" value="'.$email.'" required autocomplete="off">';
            }
            else
                echo '<input type="text" name="email" placeholder="Enter Email" required autocomplete="off">';
        ?>
        <p>Password</p>
        <input type="password" name="password" placeholder="Enter Password" required autocomplete="off">
        <p>Confirm Password</p>
        <input type="password" name="confirm_password" placeholder="Repeat Password" required autocomplete="off">
        <input type="submit" name="submit" value="Register">
        <a href="/public/login">Already registered?</a><br>
    </form>
    <?php
        if(!isset($_GET['signup'])){
            exit();
        }
        else{
            $message = $_GET['signup'];
            if($message == 'name'){
                echo '<br><p style="text-align: center; color: red">Name is invalid!</p>';
            }
            else if($message == 'email'){
                echo '<br><p style="text-align: center; color: red">Email is invalid!</p>';
            }
            else if($message == 'emailDuplicate'){
                echo '<br><p style="text-align: center; color: red">Email already exists!</p>';
            }
            else if($message == 'password'){
                echo '<br><p style="text-align: center; color: red">Passwords should match!</p>';
            }
        }
    ?>

</div>
</body>
</html>