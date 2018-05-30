<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Statistics</title>
    <link rel="stylesheet" type="text/css" href="/public/css/statistics-style.css">
</head>


<body onload="loadPage()">
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
</section>
<hr>
<br><br><br>
<hr>

<section class="BoxForStatictics">
    <div class="box" id = "statContent">

    </div>
</section>

<script src="https://www.gstatic.com/charts/loader.js"></script>
<script>

    function addElements(){
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.open("GET","/public/statistics/date?q=1",true);
        xmlhttp.send();

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("statContent").innerHTML = this.responseText;
            }
        };
    }

    function pieChart(){

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.open("GET","/public/statistics/date?q=2",true);
        xmlhttp.send();

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                eval(this.responseText);
            }
        };
    }

    function loadPage() {
        addElements();
        pieChart();
    }

    function showInfo(str){
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        var mat = document.getElementById("mat").value;
        var cat = document.getElementById("cat").value;
        var rol = document.getElementById("rol").value;
        var dat = document.getElementById("dat").value;

        if(mat == "All" || mat == "Material")
            mat = "";
        if(cat == "All" || cat == "Category")
            cat = "";
        if(rol == "All" || rol == "Role")
            rol = "";
        if(dat == "All" || dat == "Time period")
            dat = "";

        xmlhttp.open("GET","/public/statistics/date?q=3&cat="+cat+"&mat="+mat+"&rol="+rol+"&dat="+dat,true);
        xmlhttp.send();

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("results").innerHTML = this.responseText;
            }
        };
    }
</script>

</body>
</html>