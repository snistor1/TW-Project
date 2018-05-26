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
        <?php
        include $_SERVER['DOCUMENT_ROOT']."/app/models/UtilizatorModel.php";
        $u=new UtilizatorModel;
        print '<img src="data:image/jpg;base64,'.base64_encode($u->profile_image).'" alt="This is the users profile picture" width="100" height="100">';
        print '<br>';
        print '<a href="/public/editarePgUtilizator" class="button">Edit Profile</a>';
        print '<hr>';
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
    $url= $_SERVER['REQUEST_URI'];
    if(!empty($u->id_artefacte)) {
        $length = count($u->id_artefacte);
        $max_page= intval($length/9);
        if($length%9>0){$max_page=$max_page+1;}
        $pg=substr($url, -1);
        if($pg=='r') {
            $pg = 1;
        }
        for ($contor = ($pg-1)*9; $contor < ($pg-1)*9+9 and $contor<$length; $contor++) {
            print '<div class="responsive">';
            print '<div class="gallery">';
            print '<a href="/public/paginaArtefact/' . $u->id_artefacte[$contor] . '">';
            print '<img src="data:image/jpg;base64,'.base64_encode($u->imagini_artefacte[$contor]).'" alt="Imagine Artefact" width="600" height="400">';
            print '</a>';
            print '<div class="desc">' . $u->name_artefacte[$contor] . '</div>';
            print '</div>';
            print '</div>';
        }
        print '<div class="clearfix"></div>';
        print '<br>';
        print '<div class="pagination">';
        if(substr($url, -1)!='r') {
            //caz in care nu sunt pe prima pagina
            $pg=substr($url, -1);
            $page_s = substr($url, -1) - 1;
            $page_d = substr($url, -1) + 1;
            if ($page_s ==1) {
                print '<a href="' . substr($url, 0, 24). '">&laquo;</a>';
            }
            else {print '<a href="' . substr($url, 0, 24) . '/' . $page_s . '">&laquo;</a>';}
            for ($contor = 0; $contor < $length; $contor += 9) {
                if (strcmp($url, '/public/paginaUtilizator/' .($contor / 9 + 1))==0) {
                    print '<a href ="' . substr($url, 0, 24). '/' . ($contor / 9 + 1) . '"class="active">' . ($contor / 9 + 1) . '</a >';
                } else {
                    if($contor==0){
                        print '<a href ="' . substr($url, 0, 24). '">' . ($contor / 9 + 1) . '</a >';
                    }
                    else {
                        print '<a href ="' . substr($url, 0, 24) . '/' . ($contor / 9 + 1) . '">' . ($contor / 9 + 1) . '</a >';
                    }
                }
            }
            if ($page_d > $max_page) {
                $page_d = $max_page;
            }
            if($pg!=$max_page) {
                print '<a href="' . substr($url, 0, 24) . '/' . $page_d . '">&raquo;</a>';
            }
        }
        else{//caz in care sunt pe prima pagina
            for ($contor = 0; $contor < $length; $contor += 9) {
                if($contor==0) {
                    print '<a href ="' . $url  . '"class="active">' . ($contor / 9 + 1) . '</a >';
                }
                else{
                    print '<a href ="' . $url . '/' . ($contor / 9 + 1) . '">' . ($contor / 9 + 1) . '</a >';
                }
            }
            if($max_page>1) {
                print '<a href="' . substr($url, 0, 24) . '/2'. '">&raquo;</a>';
            }
        }
        print '</div>';
    }
    ?>
</section>
</body>
</html>