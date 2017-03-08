<!-- # GO Visualizer is  released under the terms of the GNU Lesser General Public License Ver.2.1. 
# https://www.gnu.org/licenses/old-licenses/lgpl-2.1.en.html
-->
<?php 
include('./get_edge_style.php');
function get_relationship() {

    include('./db_config.php');
    $go = $_GET["go"];
    $connection = mysql_connect($db_host, $db_username, $db_password);
    if(!$connection){
        echo "could not connect to database";
    }
    $db_select = mysql_select_db($go_table);
    if(!$db_select){
        echo "could not select database";
    }
      
    $query=mysql_query("SELECT * FROM `term` WHERE `is_relation` = 1");
    $find=mysql_num_rows($query);

    if($find > 0){
           
        while($row = mysql_fetch_array($query,MYSQLI_ASSOC)){
             
             
            $recent[] = array(
                'id' => $row['id'],
                'name' => $row['acc'],
                'color' => get_edge_style($row['id'])
            );
          
        }
        return $recent;
    }
    return array();
}


if(isset($_GET["alpha"]) && !isset($_GET["html"])) {
    $res = get_relationship();
    $json = json_encode($res);
    echo $json;
}

if(isset($_GET["alpha"]) && isset($_GET["html"])) {
    $res = get_relationship();
    echo "<br>";
    foreach($res as $re) {
        $name = $re["name"];
        $color = $re["color"];
        if ($color == "") {
            continue;
        }
        echo $name . ": <span style=\"color:$color\">----></span><br>";
    }
    //echo $json;
}

?>