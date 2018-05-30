<?php
/**
 * Created by PhpStorm.
 * User: Cosmin
 * Date: 28-May-18
 * Time: 8:00 PM
 */

class StatisticsModel extends Model
{
    public $cat = array();
    public $mat = array();
    public $rol = array();
    public $dat = array();
    public function __construct()
    {
        parent::__construct();
        $q = $_GET['q'];

        //get categories
        $statement = oci_parse($this->db, "select  c.CATEGORY_NAME, nvl(count(t.id), 0) as \"NR\"
                                                  from tw.CATEGORIES c left outer join tw.SUB_CATEGORIES s on s.parent_id = c.id
                                                                        left outer join tw.ARTEFACTS_SUB_CATEGORIES a_s on s.id = a_s.id_sub_category 
                                                                        left outer join tw.ARTEFACTS t on t.id = a_s.id_artefact
                                                                        group by c.CATEGORY_NAME");

        oci_execute($statement);

        while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS + OCI_ASSOC)) {
            $this->cat[$row['CATEGORY_NAME']] = $row['NR'];
        }

        //get materials
        $statement = oci_parse($this->db, "select m.MATERIAL_NAME, nvl(count(t.id), 0) as \"NR\"
                                                    from tw.MATERIALS m left outer join tw.ARTEFACTS_MATERIALS a_m on m.id = a_m.ID_MATERIAL
                                                                        left outer join tw.ARTEFACTS t on t.id = a_m.ID_ARTEFACT
                                                                        group by m.MATERIAL_NAME");
        oci_execute($statement);

        while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS + OCI_ASSOC)) {
            $this->mat[$row['MATERIAL_NAME']] = $row['NR'];
        }

        //get roles
        $statement = oci_parse($this->db, "select r.ROLE_NAME, nvl(count(t.id), 0) as \"NR\"
                                                    from tw.roles r left outer join tw.ARTEFACTS_ROLES a_r on r.id = a_r.ID_ROLE
                                                                        left outer join tw.ARTEFACTS t on t.id = a_r.ID_ARTEFACT
                                                                        group by r.ROLE_NAME");
        oci_execute($statement);

        while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS + OCI_ASSOC)) {
            $this->rol[$row['ROLE_NAME']] = $row['NR'];
        }



        if($q == 1) {
            echo '<h2 >Statistics</h2>';

            echo '<br>';
            echo '<div class="filters-container">';
            //categories dropdown
            echo '<form>
                    <select name="cat" id="cat" onchange="showInfo(this.value)">
                        <option style="display:none;">Category</option>
                        <option value="All">All</option>';

            foreach($this->cat as $key=>$r)
            {
                echo '<option value="'.$key.'">';
                echo $key;
                echo '</option>';
            }

            echo '</select>
                </form>';

            //materials dropdown
            echo '<form>
                    <select name="mat" id="mat" onchange="showInfo(this.value)">
                        <option style="display:none;">Material</option>
                        <option value="All">All</option>';

            foreach($this->mat as $key=>$r)
            {
                echo '<option value="'.$key.'">';
                echo $key;
                echo '</option>';
            }

            echo '</select>
                </form>';

            //roles dropdown
            echo '<form>
                    <select name="rol" id="rol" onchange="showInfo(this.value)">
                        <option style="display:none;">Role</option>
                        <option value="All">All</option>';

            foreach($this->rol as $key=>$r)
            {
                echo '<option value="'.$key.'">';
                echo $key;
                echo '</option>';
            }

            echo '</select>
                </form>';

            //time periods dropdown
            echo '<form>
                    <div class="select">
                    <select name = "dat" id = "dat" onchange="showInfo(this.value)">
                        <option style="display:none;">Time period</option>
                        <option value="All">All</option>
                        <option value="Prehistory">Prehistory</option>
                        <option value="Ancient Period">Ancient Period</option>
                        <option value="Middle Ages">Middle Ages</option>
                        <option value="Early Modern Period">Early Modern Period</option>
                        <option value="Modern Era">Modern Era</option>
                    </select>
                    </div>
                    </form>';

            echo '</div>';
            echo  '<div class="clearfix"></div>';

            //rest of page
            echo '<div id="results"></div>';

            echo '<div style="clear: both; height: 3%;"></div>';

            echo '<section style="padding-left:17%; padding-top: 10%;">
                        <h6>heading</h6>
                        <div id="piechart">
                        </div>
                    </section>';


        }
        else if($q == 2){


            echo '
                google.charts.load(\'current\', {\'packages\':[\'corechart\']});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
            
                    var data = google.visualization.arrayToDataTable([
                        [\'Category\', \'Number of items\'],';

            foreach ($this->cat as $key=>$r)
            {
                echo '[\''.$key.'\', ' . $r . '], ';
            }



            echo ']);
            
                    var options = {
                        title: \'Percent of items by category\'
                    };
            
                    var chart = new google.visualization.PieChart(document.getElementById(\'piechart\'));
            
                    chart.draw(data, options);
                }
                ';
        }
        else if($q == 3) {
            $category = $_GET['cat'];
            $material = $_GET['mat'];
            $role = $_GET['rol'];
            $date = $_GET['dat'];
            $number = 0;

            $sql_query = "select t.id
                                                        from tw.artefacts t left outer join tw.artefacts_sub_categories a_s on t.id = a_s.id_artefact
                                                                            left outer join tw.sub_categories s on s.id = a_s.id_sub_category
                                                                            left outer join tw.categories c on c.id = s.parent_id
                                                        where c.CATEGORY_NAME like '%'|| :category
                                                        intersect
                                                        select t.ID
                                                        from tw.artefacts t left outer join tw.artefacts_materials a_m on t.id = a_m.ID_ARTEFACT
                                                                            left outer join tw.materials m on m.id = a_m.ID_MATERIAL
                                                        where m.material_name like '%'|| :material
                                                        intersect
                                                        select unique t.ID
                                                        from tw.artefacts t left outer join tw.artefacts_roles a_r on t.id = a_r.ID_ARTEFACT
                                                                            left outer join tw.roles r on r.id = a_r.ID_ROLE
                                                        where r.role_name like '%'|| :role ";

            if ($date == 'Prehistory') {
                $sql_query = $sql_query . " intersect select unique ID from tw.ARTEFACTS where substr(DATING,length(DATING)-1)='BC' and to_number(substr(DATING,1,length(DATING)-3))>32";
            }else
            if ($date == 'Ancient Period') {
                $sql_query = $sql_query . " intersect select unique ID from tw.ARTEFACTS where (substr(DATING,length(DATING)-1)='BC' and to_number(substr(DATING,1,length(DATING)-3))<=32) or (substr(DATING,length(DATING)-1)='AD' and to_number(substr(DATING,1,length(DATING)-3))<5)";
            }else
            if ($date == 'Middle Ages') {
                $sql_query = $sql_query . " intersect select unique ID from tw.ARTEFACTS where substr(DATING,length(DATING)-1)='AD' and to_number(substr(DATING,1,length(DATING)-3))>=5 and to_number(substr(DATING,1,length(DATING)-3))<15";
            }else
            if ($date == 'Early Modern Period') {
                $sql_query = $sql_query . " intersect select unique ID from tw.ARTEFACTS where substr(DATING,length(DATING)-1)='AD' and to_number(substr(DATING,1,length(DATING)-3))>=15 and to_number(substr(DATING,1,length(DATING)-3))<18";
            }else
            if ($date == 'Modern Era') {
                $sql_query = $sql_query . " intersect select unique ID from tw.ARTEFACTS where substr(DATING,length(DATING)-1)='AD' and to_number(substr(DATING,1,length(DATING)-3))>=18";
            }

            $statement = oci_parse($this->db, $sql_query);

            oci_bind_by_name($statement, ":category", $category);
            oci_bind_by_name($statement, ":material", $material);
            oci_bind_by_name($statement, ":role", $role);

            oci_execute($statement);

            while ($row = oci_fetch_array($statement, OCI_RETURN_NULLS + OCI_ASSOC)) {
                $number = $number + 1;
            }

            if($category == "") $category = "All";
            if($material == "") $material = "All";
            if($role == "") $role = "All";
            if($date == "") $date = "All";

            echo '<p>Category: '.$category.'</p>';
            echo '<p>Material: '.$material.'</p>';
            echo '<p>Role: '.$role.'</p>';
            echo '<p>Time period: '.$date.'</p>';
            echo '<p>Number of artefacts that match these attributes: '.$number.'</p>';
        }
    }
}