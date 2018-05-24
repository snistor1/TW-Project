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
    <form class="box">
        <h2>Add an artefact</h2>
        <h6 id="imageUpload-button">Upload image</h6>
        <hr>
        <h4>Name:</h4> <input type="text" name="name" placeholder="Enter name...">
        <hr>
        <h4>Category:</h4> <input type="text" name="category" placeholder="Enter a category...">
        <hr>
        <h4>Class:</h4> <input type="text" name="category" placeholder="Enter a class...">
        <hr>
        <h4>Dating:</h4> <input type="text" name="dating" placeholder="Dating...">
        <hr>
        <h4>Price:</h4> <input type="text" name="value" placeholder="Price...">
        <hr>
        <h4>License:</h4> <input type="text" name="userLicense" placeholder="User License...">
        <hr>
        <h4>Origin:</h4> <input type="text" name="category" placeholder="Enter origin...">
        <hr>
        <h4>Aproximate latitude:</h4> <input type="text" name="category" placeholder="Enter the latitude...">
        <hr>
        <h4>Aproximate longitude:</h4> <input type="text" name="category" placeholder="Enter the longitude...">
        <hr>
        <h4>Roles:</h4> <input type="text" name="category" placeholder="Enter the roles...">
        <hr>
        <h4>Materials</h4> <input type="text" name="category" placeholder="Enter the materials...">
        <hr>
        <h4>Description:</h4>
        <textarea id="description" placeholder="Add a description to this artefact..."></textarea>
        <hr>
        <hr>
        <button id="submit" href="/public/paginaArtefact">Submit</button>
    </form>
</section>

</body>
</html>
