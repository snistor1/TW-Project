<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <title>Artifacty</title>
    <link rel="stylesheet" type="text/css" href="/public/css/colectie_artefacte-style.css">
</head>
<body>

<section class="intro">

    <div class="navbar">
        <a href="/public/paginaUtilizator"><img src="/public/Images/png_profile.png" alt="ProfilePage"></a>
        <a href="/public/login"><img src="/public/Images/png_login.png" alt="LoginPage"></a>
        <a href="/public/index"><img src="/public/Images/png_home.png" alt="HomePage"></a>

        <a href="/public/colectieArtefacte"><img src="/public/Images/png_collection.png" alt="CollectionPage"></a>

        <a href="/public/statistics"><img src="/public/Images/png_statistics.png" alt="StatisticsPage"></a>
    </div>

    <div class="inner">
        <div class="content">
            <h1><a href="/public/index">ARTIFACTY</a></h1>
        </div>
    </div>
</section>
<div class="clearfix"></div>
<hr>

<div class="search-bar">
    <form action="/public/colectieArtefacte" >
        <input type="text" name="search" placeholder="Search..." class="search-input">

        <button type="submit" class="search-button"><img src="/public/Images/search-icon.png" alt="S" width="18" height="18"></button>
    </form>

</div>
<hr>

    <div class="filters-container">

        <div class="select">
            <select name="cat" id="slct">
                <option style="display:none;">Category</option>
                <option value="All">All</option>
                <option value="Weapons">Weapons</option>
                <option value="Textiles">Textiles</option>
                <option value="Cult Objects">Cult Objects</option>
                <option value="Furniture">Furniture</option>
                <option value="Fine art">Fine art</option>
                <option value="Jewels">Jewels</option>
                <option value="Coins">Coins</option>
                <option value="Pottery">Pottery</option>
            </select>
        </div>

        <div class="select">
            <select name="mat" id="slct">
                <option style="display:none;">Materials</option>
                <option value="All">All</option>
                <option value="Metal">Metal</option>
                <option value="Wood">Wood</option>
                <option value="Stone">Stone</option>
                <option value="Ceramic">Ceramic</option>
                <option value="Glass">Glass</option>
                <option value="Textile">Textile</option>
                <option value="Paper">Paper</option>
                <option value="Bone">Bone</option>
            </select>
        </div>

        <div class="select">
            <select name="pur" id="slct">
                <option style="display:none;">Purpose</option>
                <option value="All">All</option>
                <option value="Household">Household</option>
                <option value="Beauty">Beauty</option>
                <option value="Battle">Battle</option>
                <option value="Agriculture">Agriculture</option>
                <option value="Art">Art</option>
                <option value="Communication">Communication</option>
            </select>
        </div>

        <div class="select">
            <select name="dat" id="slct">
                <option style="display:none;">Dating</option>
                <option value="All">All</option>
                <option value="Prehistory">Prehistory</option>
                <option value="Protohistory">Protohistory</option>
                <option value="Ancient Period">Ancient Period</option>
                <option value="Middle Ages">Middle Ages</option>
                <option value="Early Modern Period">Early Modern Period</option>
                <option value="Modern Era">Modern era</option>
            </select>
        </div>
    </div>

    <div class="clearfix"></div>
    <button class="button">Filter</button>


<section class="BoxForCollection" id="Collection">

    <?php
    include $_SERVER['DOCUMENT_ROOT']."/app/models/ColectieArtefacteModel.php";
    $c = new ColectieArtefacteModel;

    $url= $_SERVER['REQUEST_URI'];
    if(!empty($c->id_artefacte)) {
        $length = count($c->id_artefacte);
        $max_page = intval($length / 9);

        if ($length % 9 > 0) {
            $max_page = $max_page + 1;
        }
        $pg = substr($url, -1);
        if ($pg == substr($c->key, -1) or $pg == 'e' or $pg == '=' or $pg == '/') {
            $pg = 1;
        }

        for ($contor = ($pg - 1) * 9; $contor < ($pg - 1) * 9 + 9 and $contor < $length; $contor++) {
            print '<div class="responsive">';
            print '<div class="gallery">';
            print '<a href="/public/paginaArtefact/' . $c->id_artefacte[$contor] . '">';
            print '<img src="/public/Images/img_artefact1.jpg" alt="Imagine Artefact" width="600" height="400">';
            print '</a>';
            print '<div class="desc">' . $c->name_artefacte[$contor] . '</div>';
            print '</div>';
            print '</div>';

        }

        print '<div class="clearfix"></div>';
        print '<br>';

        print '<div class="pagination">';
        if(substr($url, -1) != substr($c->key, -1) and substr($url, -1) != 'e' and substr($url, -1) != '=' and substr($url, -1) != '/') {
            //caz in care nu sunt pe prima pagina
            $page_s = substr($url, -1) - 1;
            $page_d = substr($url, -1) + 1;
            if ($page_s ==1) {
                print '<a href="' . substr($url, 0, 25). '">&laquo;</a>';
            }
            else {print '<a href="' . substr($url, 0, 25) . '/' . $page_s . '">&laquo;</a>';}
            for ($contor = 0; $contor < $length; $contor += 9) {
                if (strcmp($url, '/public/colectieArtefacte/' .($contor / 9 + 1))==0) {
                    print '<a class="active">' . ($contor / 9 + 1) . '</a >';
                } else {
                    if($contor==0){
                        print '<a href ="' . substr($url, 0, 25). '">' . ($contor / 9 + 1) . '</a >';
                    }
                    else {
                        print '<a href ="' . substr($url, 0, 25) . '/' . ($contor / 9 + 1) . '">' . ($contor / 9 + 1) . '</a >';
                    }
                }

            }
            if ($page_d > $max_page) {
                $page_d = $max_page;
            }
            if($page_d!=$max_page) {
                print '<a href="' . substr($url, 0, 25) . '/' . $page_d . '">&raquo;</a>';
            }
        }
        else{//caz in care sunt pe prima pagina
            for ($contor = 0; $contor < $length; $contor += 9) {
                if($contor==0) {
                    print '<a class="active">' . ($contor / 9 + 1) . '</a >';
                }
                else{
                    print '<a href ="' . $url . '/' . ($contor / 9 + 1) . '">' . ($contor / 9 + 1) . '</a >';
                }
            }
            if($max_page>1) {
                print '<a href="' . substr($url, 0, 25) . '/2'. '">&raquo;</a>';
            }

        }
        print '</div>';
    }
    else {
        print '<h3>No results found for "' . $c->key . '".</h3>';
    }
    ?>

</section>
</body>
</html>
