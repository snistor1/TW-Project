<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Artifacty</title>
    <link rel="stylesheet" type="text/css" href="/public/css/pagina_artefact-style.css">
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
        <h2>--ArtefactName--</h2>

        <div>
            <img src="/public/Images/img_artefact1.jpg" alt="artefact" style="width:100%;">
        </div>

        <!-- begin Informatii artefact-->
        <div>
            <h4>Added by: <a href="/public/paginaAltUtilizator"> User </a></h4>
            <hr>

            <h4>Author:</h4> <p>--AuthorName--</p>
            <hr>

            <h4>Class:</h4> <p>--Origin--</p>
            <hr>

            <h4>Dating:</h4> <p>--Dating_the_artefact--</p>
            <hr>

            <h4>Price:</h4> <p>--ArtefactEstimatedPrice--</p>
            <hr>

            <h4>License:</h4> <p>--UseLicense--</p>
            <hr>

            <h4>Origin:</h4> <p>--Origin--</p>
            <hr>

            <h4>Roles:</h4> <p>--Roles--</p>
            <hr>

            <h4>Materials:</h4> <p>--Materials--</p>
            <hr>

            <h4>Description:</h4> <p>--ArtefactDescription--</p>
            <hr>

            <h4>Tags:</h4>
            <a class="tag">tag1</a>
            <a class="tag">tag2</a>
            <a class="tag">tag3</a>
            <a class="tag">tag4</a>
            <a class="tag">tag5</a>
            <a class="tag">tag6</a>
            <a class="tag">tag7</a>
            <a class="tag">tag8</a>
            <hr>
            <!--Api Google Maps-->
            <h4>Localization:</h4>
            <div id="map" style="width:400px;height:400px;background:grey"></div>

        </div>
    </div>
</section>

<h3 style="text-align:center; color:grey;"> Export</h3>
<div class="exportButtons">
    <input type="submit" name="JSON" value="JSON" id="button">
    <input type="submit" name="XML" value="XML" id="button">
    <input type="submit" name="CSV" value="CSV" id="button">
</div>

<hr>
<section class="boxRelatedArtefacts">
    <h3 style="text-align:center; color:grey;"> Related artefacts:</h3>
    <hr>
    <div class="responsive">
        <div class="gallery">
            <a href="/public/paginaArtefact">
                <img src="/public/Images/img_artefact1.jpg" alt="Imagine Artefact" width="600" height="400">
            </a>
            <div class="desc">---Nume_artefact---</div>
        </div>
    </div>


    <div class="responsive">
        <div class="gallery">
            <a href="/public/paginaArtefact">
                <img src="/public/Images/img_artefact1.jpg" alt="Imagine Artefact" width="600" height="400">
            </a>
            <div class="desc">---Nume_artefact---</div>
        </div>
    </div>


    <div class="responsive">
        <div class="gallery">
            <a href="/public/paginaArtefact">
                <img src="/public/Images/img_artefact1.jpg" alt="Imagine Artefact" width="600" height="400">
            </a>
            <div class="desc">---Nume_artefact---</div>
        </div>
    </div>


    <div class="responsive">
        <div class="gallery">
            <a href="/public/paginaArtefact">
                <img src="/public/Images/img_artefact1.jpg" alt="Imagine Artefact" width="600" height="400">
            </a>
            <div class="desc">---Nume_artefact---</div>
        </div>
    </div>

    <div class="clearfix"></div>
    <hr>
</section>

<script>
    function myMap() {
        var mapOptions = {
            center: new google.maps.LatLng(51.5, -0.12),
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.HYBRID
        }
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDx6GgomrtePy3-K91tI_1eValNVkkT4mQ&callback=myMap"></script>

</body>
</html>

