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

        echo'
<div class="dropdown">
<button type=button onclick="myFunction(\'filter1\')" class="dropbtn">Category</button>
  <div id="filter1" class="dropdown-content">';
        echo ' <input type="checkbox" name="cat[]" value="All">'.'All'.'<br>';
        for($contor=0;$contor<count($a->categorii);$contor++){
            echo '<option style="font-weight:bold;" value="'.$a->categorii[$contor].'">'.$a->categorii[$contor].'</option>';
            $subcategory_array=$a->subcategorii[$contor];
            $length2=count($subcategory_array);
            for($contor2=0;$contor2<$length2;$contor2++)
            {
                $subcategory=$subcategory_array[$contor2];
                if($subcategory!='Another')
                    echo ' <input type="checkbox" name="cat[]" value="-'.$subcategory.'">'.$subcategory.'<br>';
                else
                    echo ' <input type="checkbox" name="cat[]" value="'.$a->categorii[$contor].'">All<br>';
            }
        }
 echo '</div>
       </div>';


        echo'
<div class="dropdown">
<button type=button onclick="myFunction(\'filter2\')" class="dropbtn">Materials</button>
  <div id="filter2" class="dropdown-content">';
        echo ' <input type="checkbox" name="mat[]" value="All">'.'All'.'<br>';
        for($contor=0;$contor<count($a->materiale);$contor++){
            $material=$a->materiale[$contor];
                if($material!='another')
                    echo ' <input type="checkbox" name="mat[]" value="'.$material.'">'.$material.'<br>';
                else
                    echo ' <input type="checkbox" name="mat[]" value="All">All<br>';
        }
        echo '</div>
       </div>';


        echo'
<div class="dropdown">
<button type=button onclick="myFunction(\'filter3\')" class="dropbtn">Roles</button>
  <div id="filter3" class="dropdown-content">';
        echo ' <input type="checkbox" name="pur[]" value="All">'.'All'.'<br>';
        for($contor=0;$contor<count($a->roluri);$contor++){
            $rol=$a->roluri[$contor];
            if($rol!='another')
                echo ' <input type="checkbox" name="pur[]" value="'.$rol.'">'.$rol.'<br>';
            else
                echo ' <input type="checkbox" name="pur[]" value="All">All<br>';
        }
        echo '</div>
       </div>';


        echo'
<div class="dropdown">
<button type=button onclick="myFunction(\'filter4\')" class="dropbtn">Dating</button>
  <div id="filter4" class="dropdown-content">';
        echo '<input type="checkbox" name="dat[]" value="All"/>All<br>';
        echo '<input type="checkbox"  name="dat[]" value="Prehistory"/>Prehistory<br>';
        echo '<input type="checkbox"  name="dat[]" value="Ancient Period"/>Ancient Period<br>';
        echo '<input type="checkbox"  name="dat[]" value="Middle Ages"/>Middle Ages<br>';
        echo '<input type="checkbox"  name="dat[]" value="Early Modern Period"/>Early Modern Period<br>';
        echo '<input type="checkbox"  name="dat[]" value="Modern Era"/>Modern Era<br>';
        echo '</div>
       </div>';

      echo'<input style="display:block;margin-top:10%;" type="submit" class="button" value="Filter">' ;

        ?>
    </div>
</form>
<div class="clearfix"></div>

<hr>



<section class="BoxForCollection" id="Collection">

    <?php
    include $_SERVER['DOCUMENT_ROOT']."/app/models/ColectieArtefacteModel.php";
    $c = new ColectieArtefacteModel;
    $ok =1;
    $url= $_SERVER['REQUEST_URI'];

    if(!empty($c->id_artefacte)) {
        $length = count($c->id1_artefacte);

        $max_page = intval($length / 9);

        if ($length % 9 > 0) {
            $max_page = $max_page + 1;
        }
        $pg=substr($url,-1);
        if ( strcmp($url,'/public/colectieArtefacte')==0  or (strstr($url,'?')!=FALSE and strstr(strstr($url,'?'),'/')==FALSE)) {
            $pg = 1;
        }
        for ($contor = ($pg - 1) * 9; $contor < ($pg - 1) * 9 + 9 and $contor < $length; $contor++) {
            print '<div class="responsive">';
            print '<div class="gallery">';
            print '<a href="/public/paginaArtefact?id=' . $c->id1_artefacte[$contor] . '">';
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
        print '<h3>No results!</h3>';
    }
    ?>

</section>
<script>

    function myFunction(id) {
        document.getElementById(id).classList.toggle("show");
    }
</script>
</body>
</html>