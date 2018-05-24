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

        <a href="/public/colectieArtefacte/submit"><img src="/public/Images/png_collection.png" alt="CollectionPage"></a>

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
    <form action="/public/colectieArtefacte/submit" method="post">
        <input type="text" name="key" placeholder="Search..." class="search-input">
        <button type="submit" name="submit" class="search-button"><img src="/public/Images/search-icon.png" alt="S" width="18" height="18"></button>
    </form>
</div>
<hr>
<div class="filters-container">
    <div class="select">
        <select name="slct" id="slct">
            <option style="display:none;">Category</option>
            <option value="All">All</option>
            <option value="Weapons">Weapons</option>
            <option value="Carpets">Textiles</option>
            <option value="Cult Objects">Cult Objects</option>
            <option value="Jewels">Jewels</option>
            <option value="Furniture">Furniture</option>
            <option value="Fine art">Fine art</option>
            <option value="Coins">Coins</option>
            <option value="Coins">Pottery</option>
        </select>
    </div>

    <div class="select">
        <select name="slct" id="slct">
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
        <select name="slct" id="slct">
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
        <select name="slct" id="slct">
            <option style="display:none;">Dating</option>
            <option value="All">All</option>
            <option value="date">Prehistory</option>
            <option value="date">Protohistory</option>
            <option value="date">Ancient Period</option>
            <option value="date">Middle Ages</option>
            <option value="date">Early Modern Period</option>
            <option value="date">Modern era</option>
        </select>
    </div>
</div>

<div class="clearfix"></div>
<button class="button">Filter</button>
<section class="BoxForCollection" id="Collection"><h6>heading</h6><div class="responsive"><div class="gallery"><a href="/public/paginaArtefact/id=1"><img src="/public/Images/img_artefact1.jpg" alt="Imagine Artefact" width="600" height="400"></a><div class="desc">Old Sword</div></div></div><div class="responsive"><div class="gallery"><a href="/public/paginaArtefact/id=2"><img src="/public/Images/img_artefact1.jpg" alt="Imagine Artefact" width="600" height="400"></a><div class="desc">Heavy Artilery</div></div></div><div class="responsive"><div class="gallery"><a href="/public/paginaArtefact/id=3"><img src="/public/Images/img_artefact1.jpg" alt="Imagine Artefact" width="600" height="400"></a><div class="desc">Ceramic Vase</div></div></div><div class="responsive"><div class="gallery"><a href="/public/paginaArtefact/id=4"><img src="/public/Images/img_artefact1.jpg" alt="Imagine Artefact" width="600" height="400"></a><div class="desc">Silver Sword</div></div></div><div class="responsive"><div class="gallery"><a href="/public/paginaArtefact/id=5"><img src="/public/Images/img_artefact1.jpg" alt="Imagine Artefact" width="600" height="400"></a><div class="desc">Old Silver Ring</div></div></div><div class="responsive"><div class="gallery"><a href="/public/paginaArtefact/id=6"><img src="/public/Images/img_artefact1.jpg" alt="Imagine Artefact" width="600" height="400"></a><div class="desc">Heavy Dirt Vase</div></div></div><div class="clearfix"></div><div class="pagination"><a>&laquo;</a><a>1</a><a>2</a><a>&raquo;</a></div></section></body>
</html>
