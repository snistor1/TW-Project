<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Artifacty</title>
    <link rel="stylesheet" type="text/css" href="/public/css/pagina_utilizator-style.css">
</head>
<body>
<section class="intro">

    <div class="navbar">
        <a href="/public/paginaUtilizator"><img src="/public/Images/png_profile.png" alt="ProfilePage" ></a>
        <a href="/public/login"><img src="/public/Images/png_login.png" alt="LoginPage" ></a>
        <a href="/public/index"><img src="/public/Images/png_home.png" alt="HomePage" ></a>
        <a href="/public/colectieArtefacte/submit"><img src="/public/Images/png_collection.png" alt="CollectionPage" ></a>
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
    <form action="/public/PaginaUtilizator" method="post">
        <img src="/public/Images/user.png" alt="This is the users profile picture" width="100" height="100">
        <br>
        <a href="/public/editarePgUtilizator" class="button">Edit Profile</a>
        <hr>
        <?php
            include $_SERVER['DOCUMENT_ROOT']."/app/models/UtilizatorModel.php";
            $u=new UtilizatorModel;
            print '<p style="display": inline;">Name:</p><h2>'.$u->name."</h2>";
            print "<hr>";
            print "<p>Class:</p><h2>".$u->class_names."</h2>";
            print "<hr>";
            print "<p>Email:</p><h2>".$u->email."</h2>";
            print "<hr>";
        ?>
    </form>
    <button onclick="location.href='/public/adaugareArtefact'" class='button'>Add an artefact</button>
    <button onclick="location.href='/public/paginaUtilizator/logout'" class="button">Logout</button>

    <div class="clearfix"></div>

    <hr>

    <?php
    $length=count($u->id_artefacte);
    for ($contor=0; $contor< $length; $contor++) {
        print '<div class="responsive">';
        print '<div class="gallery">';
        print '<a href="/public/paginaArtefact/' . $u->id_artefacte[$contor] . '">';
        print '<img src="/public/Images/img_artefact1.jpg" alt="Imagine Artefact" width="600" height="400">';
        print '</a>';
        print '<div class="desc">'.$u->name_artefacte[$contor].'</div>';
        print '</div>';
        print '</div>';
    }
    ?>


    <div class="clearfix"></div>



    <br>

    <div class="pagination">
        <a href="#">&laquo;</a>
        <a href="#">1</a>
        <a href="#" class="active">2</a>
        <a href="#">3</a>
        <a href="#">4</a>
        <a href="#">5</a>
        <a href="#">6</a>
        <a href="#">&raquo;</a>
    </div>
</section>
</body>
</html>