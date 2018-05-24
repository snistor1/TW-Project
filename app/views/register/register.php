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
    <a href="/public/colectieArtefacte/submit"><img src="/public/Images/png_collection.png" alt="CollectionPage" ></a>
    <a href="/public/statistics"><img src="/public/Images/png_statistics.png" alt="StatisticsPage" ></a>
</div>

<div class="register-box">
    <h1>Register</h1>
    <form action="/public/register/submit" method="post">
        <p>Name</p>
        <input type="text" name="name" placeholder="Enter Name" required autocomplete="off">
        <p>Email</p>
        <input type="text" name="email" placeholder="Enter Email" required autocomplete="off">
        <p>Password</p>
        <input type="password" name="password" placeholder="Enter Password" required autocomplete="off">
        <p>Confirm Password</p>
        <input type="password" name="confirm_password" placeholder="Repeat Password" required autocomplete="off">
        <input type="submit" name="submit" value="Register">
        <a href="/public/login">Already registered?</a><br>
    </form>

</div>
</body>
</html>