<html>
<head>
    <meta charset="UTF-8">
    <title>Artifacty</title>
    <link rel="stylesheet" type="text/css" href="css/adaugare_artefact-style.css">
</head>
<body>

<section class="intro">

    <div class="navbar">
        <a href="paginaUtilizator"><img src="Images/png_profile.png" alt="ProfilePage" ></a>
        <a href="login"><img src="Images/png_login.png" alt="LoginPage" ></a>
        <a href="index"><img src="Images/png_home.png" alt="HomePage" ></a>
        <a href="colectieArtefacte"><img src="Images/png_collection.png" alt="CollectionPage" ></a>
        <a href="statistics"><img src="Images/png_statistics.png" alt="StatisticsPage" ></a>
    </div>

    <div class="inner">
        <div class="content">
            <h1><a href="index">ARTIFACTY</a></h1>
        </div>
    </div>
</section>

<div class="box">
    <h2>Add an artefact</h2>


    <!-- begin Informatii artefact-->
    <div>


        <hr>
        <h4>Name:</h4> <input type="text" name="name" placeholder="Enter name...">
        <hr>
        <h4>Category:</h4> <input type="text" name="category" placeholder="Enter a category...">
        <hr>
        <h4>Dating:</h4> <input type="text" name="dating" placeholder="Dating...">
        <hr>
        <h4>Value:</h4> <input type="text" name="value" placeholder="Price...">
        <hr>
        <h4>User License:</h4> <input type="text" name="userLicense" placeholder="User License...">
        <hr>
        <h4>Research state (0-100):</h4>
        <input type="text" name="state" placeholder="Research state...">
        <hr>
        <h4>Description:</h4>
        <textarea id="description" placeholder="Add a description to this artefact..."></textarea>
        <hr>


        <!--Api Google Maps-->

        <h4>Localizare:</h4>

        <div id="map" style="width:400px;height:400px;background:grey">

        </div>

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

        <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY&callback=myMap"></script>


    </div>

    <!--end Informatii artefact-->
    <hr>
    <a id="submit" href="paginaArtefact">Submit</a>

</div>

</body>
</html>
