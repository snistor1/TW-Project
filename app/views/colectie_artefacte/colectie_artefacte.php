<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta charset="UTF-8"><title>Artifacty</title><link rel="stylesheet" type="text/css" href="/public/css/colectie_artefacte-style.css"></head><body>

<section class="intro"><div class="navbar">
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

<form action="/public/colectieArtefacte" >
    <div class="search-bar">

        <input type="text" name="search" placeholder="Search..." class="search-input">

        <button type="submit" class="search-button"><img src="/public/Images/search-icon.png" alt="S" width="18" height="18"></button>

    </div>

    <br>

    <div class="filters-container">

        <?php
        include $_SERVER['DOCUMENT_ROOT']."/app/models/AdaugareArtefactModel.php";
        $a=new AdaugareArtefactModel;
        echo '<div class="select">';
            echo '<select name="cat" id="slct">';
                echo '<option style="display:none;">Category</option>';
                echo '<option value="All">All</option>';
        for($contor=0;$contor<count($a->categorii);$contor++){
            echo '<option value="'.$a->categorii[$contor].'">'.$a->categorii[$contor].'</option>';
            $subcategory_array=$a->subcategorii[$contor];
            $length2=count($subcategory_array);
            for($contor2=0;$contor2<$length2;$contor2++)
            {
                $subcategory=$subcategory_array[$contor2];
                echo '<option value="-'.$subcategory.'">-'.$subcategory.'</option>';
            }
        }
        echo '</select>';
        echo '</div>';

        echo '<div class="select">';
        echo '<select name="mat" id="slct">';
        echo '<option style="display:none;">Materials</option>';
        echo '<option value="All">All</option>';
        for($contor=0;$contor<count($a->materiale);$contor++){
            echo '<option value="'.$a->materiale[$contor].'">'.$a->materiale[$contor].'</option>';
        }
        echo '</select>';
        echo '</div>';

        echo '<div class="select">';
        echo '<select name="pur" id="slct">';
        echo '<option style="display:none;">Purpose</option>';
        echo '<option value="All">All</option>';
        for($contor=0;$contor<count($a->roluri);$contor++){
            echo '<option value="'.$a->roluri[$contor].'">'.$a->roluri[$contor].'</option>';
        }
        echo '</select>';
        echo '</div>';

         echo '<div class="select">';
            echo '<select name="dat" id="slct">';
        echo '<option style="display:none;">Dating</option>';
                echo '<option value="All">All</option>';
                echo '<option value="Prehistory">Prehistory</option>';
                echo '<option value="Ancient Period">Ancient Period</option>';
                echo '<option value="Middle Ages">Middle Ages</option>';
                echo '<option value="Early Modern Period">Early Modern Period</option>';
                echo '<option value="Modern Era">Modern era</option>';
            echo '</select>';
        echo '</div>';
        ?>
    </div>
</form>
<div class="clearfix"></div>

<hr>



<section class="BoxForCollection" id="Collection">

    <?php
    include $_SERVER['DOCUMENT_ROOT']."/app/models/ColectieArtefacteModel.php";
    $c = new ColectieArtefacteModel;

    $url= $_SERVER['REQUEST_URI'];

    if(!empty($c->id_artefacte)) {
        $length = $c->length;
        $max_page = intval($length / 9);

        if ($length % 9 > 0) {
            $max_page = $max_page + 1;
        }
        if ( strcmp($url,'/public/colectieArtefacte')==0  or (strstr($url,'?')!=FALSE and strstr(strstr($url,'?'),'/')==FALSE)) {
            $pg = 1;
        }
        else $pg=substr($url,-1);
        for ($contor = ($pg - 1) * 9; $contor < ($pg - 1) * 9 + 9 and $contor < $length; $contor++) {
            print '<div class="responsive">';
            print '<div class="gallery">';
            print '<a href="/public/paginaArtefact?id=' . $c->id_artefacte[$contor] . '">';
            if($c->imagini_artefacte[$contor]!=null){
                echo '<img src="data:image/jpg;base64,'.base64_encode($c->imagini_artefacte[$contor]->load()).'" alt="Imagine Artefact" width="600" height="400">';
            }
            print '</a>';
            print '<div class="desc">' . $c->name_artefacte[$contor] . '</div>';
            print '</div>';
            print '</div>';

        }

        print '<div class="clearfix"></div>';
        print '<br>';

        print '<div class="pagination">';

        if(strcmp($url,'/public/colectieArtefacte')!=0 and strstr($url,'?')==FALSE)
        {
            //caz in care nu sunt pe prima pagina fara filtre
            $page_s = substr($url, -1) - 1;
            $page_d = substr($url, -1) + 1;
            if ($page_s ==1) {
                    print '<a href="' . substr($url, 0, 25). '">&laquo;</a>';
            }
            else {
                print '<a href="' . substr($url, 0, 25). '/'.$page_s.'">&laquo;</a>';
            }
            for ($contor = 0; $contor < $length; $contor += 9) {
                    if (strcmp($url, '/public/colectieArtefacte' .'/'.($contor / 9 + 1))==0) {
                        print '<a href ="' . substr($url, 0, 25). '/' . ($contor / 9 + 1) . '"class="active">' . ($contor / 9 + 1) . '</a >';
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

            if(substr($url,-1)!=$max_page) {
                    print '<a href="' . substr($url, 0, 25) . '/' . $page_d . '">&raquo;</a>';
            }
        }
        else {if(strstr($url,'?')!=FALSE and strstr(strstr($url,'?'),'/')!=FALSE){

            //caz in care nu sunt pe prima pagina si sunt filtre
            $page_s = substr($url, -1) - 1;
            $page_d = substr($url, -1) + 1;
            if ($page_s ==1) {
                print '<a href="' . strstr($url,'?',true).strstr(strstr($url,'?'),'/',true). '">&laquo;</a>';
            }
            else {
                print '<a href="' . strstr($url,'?',true).strstr(strstr($url,'?'),'/',true) . '/' . $page_s . '">&laquo;</a>';
            }
            for ($contor = 0; $contor < $length; $contor += 9){
                    if (strcmp($url, strstr($url,'?',true).strstr(strstr($url,'?'),'/',true).'/' .($contor / 9 + 1))==0) {
                        print '<a href ="' .strstr($url,'?',true).strstr(strstr($url,'?'),'/',true). '/' . ($contor / 9 + 1) . '"class="active">' . ($contor / 9 + 1) . '</a >';
                    } else {
                        if($contor==0){
                            print '<a href ="' .strstr($url,'?',true).strstr(strstr($url,'?'),'/',true). '">' . ($contor / 9 + 1) . '</a >';
                        }
                        else {
                            print '<a href ="' .strstr($url,'?',true).strstr(strstr($url,'?'),'/',true). '/' . ($contor / 9 + 1) . '">' . ($contor / 9 + 1) . '</a >';
                        }
                    }

                }

            if ($page_d > $max_page) {
                $page_d = $max_page;
            }

            if(substr($url,-1)!=$max_page)  {
                    print '<a href="' .strstr($url,'?',true).strstr(strstr($url,'?'),'/',true). '/' . $page_d . '">&raquo;</a>';
                }
        }
            else {//caz in care sunt pe prima pagina
                for ($contor = 0; $contor < $length; $contor += 9) {
                    if (strstr($url, '?') == FALSE) {
                        if ($contor == 0) {
                            print '<a class="active">' . ($contor / 9 + 1) . '</a >';
                        } else {
                            print '<a href ="' . $url . '/' . ($contor / 9 + 1) . '">' . ($contor / 9 + 1) . '</a >';
                        }
                    } else {
                        if ($contor == 0) {
                            print '<a class="active">' . ($contor / 9 + 1) . '</a >';
                        } else {
                            print '<a href ="' . $url . '/' . ($contor / 9 + 1) . '">' . ($contor / 9 + 1) . '</a >';
                        }
                    }
                }
                if ($max_page > 1) {
                    if (strstr($url, '?') == FALSE) {
                        print '<a href="' . substr($url, 0, 25) . '/2' . '">&raquo;</a>';
                    } else {
                        print '<a href="' . strstr($url, '?', true) . strstr(strstr($url, '?'), '/', true) . '/2' . '">&raquo;</a>';
                    }
                }
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