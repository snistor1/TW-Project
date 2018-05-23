<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Artifacty</title>
    <link rel="stylesheet" type="text/css" href="/public/css/login-style.css">
</head>
<body>

<div class="navbar">
    <a href="/public/paginaUtilizator"><img src="/public/Images/png_profile.png" alt="ProfilePage" ></a>
    <a href="/public/login"><img src="/public/Images/png_login.png" alt="LoginPage" ></a>
    <a href="/public/index"><img src="/public/Images/png_home.png" alt="HomePage" ></a>
    <a href="/public/colectieArtefacte"><img src="/public/Images/png_collection.png" alt="CollectionPage" ></a>
    <a href="/public/statistics"><img src="/public/Images/png_statistics.png" alt="StatisticsPage" ></a>
</div>

<div class="login-box">
    <h1>Login</h1>
    <form action="/public/login/submit" method="post">
        <p>Email</p>
        <input type="text" name="email" placeholder="Enter Email" autocomplete="off" required>
        <p>Password</p>
        <input type="password" name="password" placeholder="Enter Password" autocomplete="off" required>
        <input type="submit" name="submit" value="Login">
        <a href="/public/register">Don't have an account?</a><br>
    </form>
</div>
</body>
</html>