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
        <form action="/public/AdaugareArtefact/add" method="post" enctype="multipart/form-data">
            <?php
                echo '<h2>Add an artefact</h2>
                <h4>Upload image:</h4>
                <input type="file" name="pic" id="imageUpload-button" accept="image/*">
                <hr>';
                if(isset($_GET['name'])){
                    $name = $_GET['name'];
                    echo '<h4>Name:</h4> <input type="text" name="nume" placeholder="Enter name..." value="'.$name.'" required>';
                }
                else
                    echo '<h4>Name:</h4> <input type="text" name="nume" placeholder="Enter name..." required>';

            echo '<hr>';
            include $_SERVER['DOCUMENT_ROOT']."/app/models/AdaugareArtefactModel.php";
            $a=new AdaugareArtefactModel;
            $c=$a->categorii;
            $length=count($c);

            echo '<p><strong>Category:</strong></p>';
            for($contor=0;$contor<$length;$contor++) {
                $category=$a->categorii[$contor];
                echo '<section class="category">
                    <input onclick="myFunction('.$contor.')" type="radio" name="categorie" value="'.$category.'" id="C1"/>
                    <label for="C1">'.ucfirst($category).'</label>
                    <div style="display:none" class="subcategorii">';
                $subcategory_array=$a->subcategorii[$contor];
                $length2=count($subcategory_array);
                for($contor2=0;$contor2<$length2;$contor2++)
                {
                    $subcategory=$subcategory_array[$contor2];
                    echo'<input type="radio" name="subcategorie" value="'.$subcategory.'"><label>'.ucfirst($subcategory).'</label>';
                }
                echo '</div> </section>';
            }

                echo '<hr>';
               $length=count($a->clase);
               echo '<h4>Clase:</h4>';
                for($contor=0;$contor<$length;$contor++) {
                    echo '<input type="checkbox" name="clasa[]" value="'.$a->clase[$contor].'">'.ucfirst($a->clase[$contor]).'<br>';
                }
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
                <input type="radio" onclick="document.getElementById(\'dating\').max=40" name="data" id="BC" value="BC" checked>
                <label for="">BC</label>
                <input type="radio" onclick="document.getElementById(\'dating\').max=21" name="data" id="AD" value="AD">
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
                /*
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

                echo '<hr>';
                */
            echo'<input id="origin" style="display: none;" type="text" name="origine"  value="">';

            echo'<input id="latitude" style="display: none;" type="text" name="latitudine"  value="">';

            echo'<input id="longitude" style="display: none;" type="text" name="longitudine"  value="">';


            echo '<h4>Roles</h4>';
             $length=count($a->roluri);
              for($contor=0;$contor<$length;$contor++) {
                echo '<input type="checkbox" name="rol[]" value="'.$a->roluri[$contor].'">'.ucfirst($a->roluri[$contor]);
               }
            echo '<hr>';

            echo '<h4>Materials</h4>';
            $length=count($a->materiale);
            for($contor=0;$contor<$length;$contor++) {
                echo '<input type="checkbox" name="material[]" value="'.$a->materiale[$contor].'">'.ucfirst($a->materiale[$contor]);
            }
            echo '<hr>';


                echo '<h4>Tags</h4>
                        <label for="tag-typer">
                         <div id="tags">
                           <div id="demo"></div>
                           <input id="tag-typer" type="text" onkeypress="Function(event)" placeholder="Add tag..."/>
                         </div> 
                        </label>
                     <hr>';
                if(isset($_GET['description'])){
                    $description = $_GET['description'];
                    echo ' <h4>Description:</h4>
                    <textarea id="description" name="descriere" placeholder="Add a description to this artefact...">'.$description.'</textarea>';
                }
                else
                    echo ' <h4>Description:</h4>
                    <textarea id="description" name="descriere" placeholder="Add a description to this artefact..."></textarea>';
            echo '<hr>';
            echo ' <h4>Localization:</h4>';
            echo ' <div>Move the red marker to point the location of the artefact.</div><br>';
            echo '<div id="mapCanvas"></div>
        <div id="infoPanel">
        <b>Marker status:</b>
        <div id="markerStatus"><i>Click and drag the marker.</i></div>
        <b>Current position:</b>
        <div id="info"></div>
        <b>Closest matching address:</b>
        <div id="address"></div>
       </div>';
            echo '<br class="clear-fix">';
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
                    else if($message == 'image'){
                        echo '<br><p style="text-align: center; color: red">Invalid file!</p>';
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

    var $max_id=0;
    function Function(event) {
        $max_id++;
        var x = event.which || event.keyCode;
        if(x==32){
            document.getElementById("demo").innerHTML="<span class='tag' id="+$max_id.toString()+" onclick='removeTag"+"("+$max_id.toString()+")'><span class='close'>&times;</span>"+document.getElementById("tag-typer").value+"</span>"+"<div id='demo'></div>"+"<input name='tag[]' style='display:none;' value="+document.getElementById("tag-typer").value+" id="+'I'+$max_id.toString()+">";
            document.getElementById("demo").id="altceva";
            document.getElementById("tag-typer").value="";
        }
    };

    function removeTag(id) {
        var elem = document.getElementById(id);
        elem.parentNode.removeChild(elem);

        var elem = document.getElementById('I'+id);
        elem.parentNode.removeChild(elem);
    }
</script>
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

    var $max_id=0;
    function Function(event) {
        $max_id++;
        var x = event.which || event.keyCode;
        if(x==32){
            document.getElementById("demo").innerHTML="<span class='tag' id="+$max_id.toString()+" onclick='removeTag"+"("+$max_id.toString()+")'><span class='close'>&times;</span>"+document.getElementById("tag-typer").value+"</span>"+"<div id='demo'></div>"+"<input name='tag[]' style='display:none;' value="+document.getElementById("tag-typer").value+" id="+'I'+$max_id.toString()+">";
            document.getElementById("demo").id="altceva";
            document.getElementById("tag-typer").value="";
        }
    };

    function removeTag(id) {
        var elem = document.getElementById(id);
        elem.parentNode.removeChild(elem);

        var elem = document.getElementById('I'+id);
        elem.parentNode.removeChild(elem);
    }
</script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDx6GgomrtePy3-K91tI_1eValNVkkT4mQ"></script>
<script type="text/javascript">
    var geocoder = new google.maps.Geocoder();

    function geocodePosition(pos) {
        geocoder.geocode({
            latLng: pos
        }, function(responses) {
            if (responses && responses.length > 0) {
                updateMarkerAddress(responses[0].formatted_address);
            } else {
                updateMarkerAddress('Cannot determine address at this location.');
            }
        });
    }

    function updateMarkerStatus(str) {
        document.getElementById('markerStatus').innerHTML = str;
    }

    function updateMarkerPosition(latLng) {
        document.getElementById('info').innerHTML = [
            latLng.lat(),
            latLng.lng()
        ].join(', ');

        document.getElementById('latitude').value=latLng.lat();
        document.getElementById('longitude').value=latLng.lng();
    }

    function updateMarkerAddress(str) {
        document.getElementById('address').innerHTML = str;
        document.getElementById('origin').value = str;
    }

    function initialize() {
        var latLng = new google.maps.LatLng(46.92609589009538, 26.931308856844907);
        var map = new google.maps.Map(document.getElementById('mapCanvas'), {
            zoom: 8,
            center: latLng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var marker = new google.maps.Marker({
            position: latLng,
            title: 'Point A',
            map: map,
            draggable: true
        });

        // Update current position info.
        updateMarkerPosition(latLng);
        geocodePosition(latLng);

        // Add dragging event listeners.
        google.maps.event.addListener(marker, 'dragstart', function() {
            updateMarkerAddress('Dragging...');
        });

        google.maps.event.addListener(marker, 'drag', function() {
            updateMarkerStatus('Dragging...');
            updateMarkerPosition(marker.getPosition());
        });

        google.maps.event.addListener(marker, 'dragend', function() {
            updateMarkerStatus('Drag ended');
            geocodePosition(marker.getPosition());
        });
    }

    // Onload handler to fire off the app.
    google.maps.event.addDomListener(window, 'load', initialize);
</script>

</body>
</html>
