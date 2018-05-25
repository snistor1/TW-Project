<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Artifacty</title>
    <link rel="stylesheet" type="text/css" href="/public/css/adaugare_artefact-style.css">
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
    <div class="box">
        <form action="/public/AdaugareArtefact/add" method="post">
            <?php
                echo '<h2>Add an artefact</h2>
                <h6 id="imageUpload-button">Upload image</h6>
                <hr>';
                if(isset($_GET['name'])){
                    $name = $_GET['name'];
                    echo '<h4>Name:</h4> <input type="text" name="nume" placeholder="Enter name..." value="'.$name.'" required>';
                }
                else
                    echo '<h4>Name:</h4> <input type="text" name="nume" placeholder="Enter name..." required>';

                echo '<hr>
                <h4>Category:</h4>
                <section class="category">
                    <input onclick="myFunction(0)" type="radio" name="categorie" value="ceva" id="C1"/><label for="C1">Weapons</label>
                    <div style="display:none" class="subcategorii">
    
                        <input type="radio" name="subcategorie" value="sword"><label>Sword</label>
                        <input type="radio" name="subcategorie" value="knife"/><label>Knife</label>
                        <input type="radio" name="subcategorie" value="artillery"/><label>Artillery</label>
                        <input type="radio" name="subcategorie" value="spear"/><label>Spear</label>
                        <input type="radio" name="subcategorie" value="armour"/><label>Armour</label>
                        <input type="radio" name="subcategorie" value="axe"/><label>Axe</label>
                        <input type="radio" name="subcategorie" value="another"/><label>Another</label>
                    </div>
    
                </section>
    
                <section class="category">
                    <input onclick="myFunction(1)" type="radio" name="categorie" value="ceva" id="C2"/><label for="C2">Textiles</label>
                    <div style="display:none" class="subcategorii">
                        <input type="radio" name="subcategorie" value="All"><label>SubCategorie</label>
                        <input type="radio" name="subcategorie" value="All"/><label>SubCategorie</label>
                        <input type="radio" name="subcategorie" value="All"/><label>SubCategorie</label>
                    </div>
    
                </section>
    
                <section class="category">
                    <input onclick="myFunction(2)" type="radio" name="categorie" value="ceva" id="C3"/><label for="C3">Cult Objects</label>
                    <div style="display:none" class="subcategorii">
                        <input type="radio" name="subcategorie" value="All"><label>SubCategorie</label>
                        <input type="radio" name="subcategorie" value="All"/><label>SubCategorie</label>
                        <input type="radio" name="subcategorie" value="All"/><label>SubCategorie</label>
                    </div>
    
                </section>
    
                <section class="category">
                    <input onclick="myFunction(3)" type="radio" name="categorie" value="ceva" id="C3"/><label for="C3">Jewels</label>
                    <div style="display:none" class="subcategorii">
                        <input type="radio" name="subcategorie" value="All"><label>SubCategorie</label>
                        <input type="radio" name="subcategorie" value="All"/><label>SubCategorie</label>
                        <input type="radio" name="subcategorie" value="All"/><label>SubCategorie</label>
                    </div>
    
                </section>
    
                <section class="category">
                    <input onclick="myFunction(4)" type="radio" name="categorie" value="ceva" id="C3"/><label for="C3">Furniture</label>
                    <div style="display:none" class="subcategorii">
                        <input type="radio" name="subcategorie" value="All"><label>SubCategorie</label>
                        <input type="radio" name="subcategorie" value="All"/><label>SubCategorie</label>
                        <input type="radio" name="subcategorie" value="All"/><label>SubCategorie</label>
                    </div>
    
                </section>
    
                <section class="category">
                    <input onclick="myFunction(5)" type="radio" name="categorie" value="ceva" id="C3"/><label for="C3">Fine art</label>
                    <div style="display:none" class="subcategorii">
                        <input type="radio" name="subcategorie" value="All"><label>SubCategorie</label>
                        <input type="radio" name="subcategorie" value="All"/><label>SubCategorie</label>
                        <input type="radio" name="subcategorie" value="All"/><label>SubCategorie</label>
                    </div>
    
                </section>
    
                <section class="category">
                    <input onclick="myFunction(6)" type="radio" name="categorie" value="ceva" id="C3"/><label for="C3">Coins</label>
                    <div style="display:none" class="subcategorii">
                        <input type="radio" name="subcategorie" value="All"><label>SubCategorie</label>
                        <input type="radio" name="subcategorie" value="All"/><label>SubCategorie</label>
                        <input type="radio" name="subcategorie" value="All"/><label>SubCategorie</label>
                    </div>
    
                </section>
    
                <section class="category">
                    <input onclick="myFunction(7)" type="radio" name="categorie" value="ceva" id="C3"/><label for="C3">Pottery</label>
                    <div style="display:none" class="subcategorii">
                        <input type="radio" name="subcategorie" value="All"><label>SubCategorie</label>
                        <input type="radio" name="subcategorie" value="All"/><label>SubCategorie</label>
                        <input type="radio" name="subcategorie" value="All"/><label>SubCategorie</label>
                    </div>
    
                </section>';

                echo '<hr>';
                if(isset($_GET['class'])) {
                    $class = $_GET['class'];
                    echo '<h4>Class:</h4> <input type="text" name="clasa" placeholder="Enter a class..." value="'.$class.'">';
                }
                else
                    echo '<h4>Class:</h4> <input type="text" name="clasa" placeholder="Enter a class...">';

                echo '<hr>';

                if(isset($_GET['author'])){
                    $author = $_GET['author'];
                    echo '<h4>Author:</h4> <input type="text" name="autor" placeholder="Enter the author..." value="'.$author.'" required>';
                }
                else
                    echo '<h4>Author:</h4> <input type="text" name="autor" placeholder="Enter the author..." required>';

                echo '<hr>
                <h4>Dating:</h4>
                Century:
                <input type="number" min="0" max="21" id="dating" name="secol" placeholder="number..." required>
                <input type="radio" onclick="document.getElementById(\'dating\').max=40" name="data" id="BC" value="" checked>
                <label for="">BC</label>
                <input type="radio" onclick="document.getElementById(\'dating\').max=21" name="data" id="AD" value="">
                <label for="">AD</label>
                <hr>';

                if(isset($_GET['price'])){
                    $price = $_GET['price'];
                    echo '<h4>Price:</h4> <input type="number" min="0" name="pret" placeholder="Price..." value="'.$price.'" > USD';
                }
                else
                    echo '<h4>Price:</h4> <input type="number" min="0" name="pret" placeholder="Price..." > USD';

                echo '<hr>
                <h4>License:</h4>
                <input type="radio" name="licenta" value="YES" id=""> <label for="">With license</label>
                <input type="radio" name="licenta" value="NO" id="" checked> <label for="">Without license</label>
                <hr>';

                if(isset($_GET['origin'])){
                    $origin = $_GET['origin'];
                    echo '<h4>Origin:</h4> <input type="text" name="origine" placeholder="Enter origin..." value="'.$origin.'">';
                }
                else
                    echo '<h4>Origin:</h4> <input type="text" name="origine" placeholder="Enter origin...">';

                echo '<hr>';
                if(isset($_GET['latitude'])){
                    $latitude = $_GET['latitude'];
                    echo '<h4>Aproximate latitude:</h4> <input type="text" name="latitudine" placeholder="Enter the latitude..." value="'.$latitude.'">';
                }
                else
                    echo '<h4>Aproximate latitude:</h4> <input type="text" name="latitudine" placeholder="Enter the latitude...">';

                echo '<hr>';
                if(isset($_GET['longitude'])){
                    $longitude = $_GET['longitude'];
                    echo '<h4>Aproximate longitude:</h4> <input type="text" name="longitudine" placeholder="Enter the longitude..." value="'.$longitude.'">';
                }
                else
                    echo '<h4>Aproximate longitude:</h4> <input type="text" name="longitudine" placeholder="Enter the longitude...">';

                echo '<hr>
                <h4>Roles:</h4>
                <input type="checkbox" name="rol[]" value="household"> Household
                <input type="checkbox" name="rol[]" value="beauty"> Beauty
                <input type="checkbox" name="rol[]" value="battle"> Battle
                <input type="checkbox" name="rol[]" value="agriculture"> Agriculture
                <input type="checkbox" name="rol[]" value="art"> Art <br>
                <input type="checkbox" name="rol[]" value="communication"> Communication
                <hr>
                <h4>Materials</h4>
                <input type="checkbox" name="material[]" value="metal"> Metal
                <input type="checkbox" name="material[]" value="wood"> Wood
                <input type="checkbox" name="material[]" value="stone"> Stone
                <input type="checkbox" name="material[]" value="porcelain"> Porcelain
                <input type="checkbox" name="material[]" value="glass"> Glass
                <input type="checkbox" name="material[]" value="textile"> Textile
                <input type="checkbox" name="material[]" value="paper"> Paper
                <input type="checkbox" name="material[]" value="bone"> Bone
                <hr>';

                if(isset($_GET['description'])){
                    $description = $_GET['description'];
                    echo ' <h4>Description:</h4>
                    <textarea id="description" name="descriere" placeholder="Add a description to this artefact...">'.$description.'</textarea>';
                }
                else
                    echo ' <h4>Description:</h4>
                    <textarea id="description" name="descriere" placeholder="Add a description to this artefact..."></textarea>';
            ?>

            <br>
            <?php
                if(isset($_GET['add'])){
                    $message = $_GET['add'];
                    if($message == 'name') {
                        echo '<br><p style="text-align: center; color: red">Name should contain only letters!</p>';
                    }
                    else if($message == 'author'){
                        echo '<br><p style="text-align: center; color: red">Author\'s name should contain only letters!</p>';
                    }
                    else if($message == 'price'){
                        echo '<br><p style="text-align: center; color: red">The price is not valid!</p>';
                    }
                    else if($message == 'origin'){
                        echo '<br><p style="text-align: center; color: red">The origin should contain only letters!</p>';
                    }
                    else if($message == 'class'){
                        echo '<br><p style="text-align: center; color: red">Class doesn\'t exist!</p>';
                    }
                }
            ?>
            <br>
            <hr>
            <hr>
            <input name="submit" id="submit" class="button" type="submit" value="Save">
        </form>
    </div>
</section>

<script>

    function myFunction(nr) {
        var subcategorii = document.getElementsByClassName("subcategorii");
        for(var i = 0; i < subcategorii.length; i++) {
            if(i!=nr){
                subcategorii[i].style.display = "none";
            }
            else{
                subcategorii[i].style.display = "block";
            }
        }

        var inputs = document.getElementsByTagName('input');

        for(var i = 0; i < inputs.length; i++) {
            if(inputs[i].name.toLowerCase() == 'subcategorie') {
                inputs[i].checked=false;
            }
        }
    }

</script>
</body>
</html>
