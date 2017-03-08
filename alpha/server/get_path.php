<!-- # GO Visualizer is  released under the terms of the GNU Lesser General Public License Ver.2.1. 
# https://www.gnu.org/licenses/old-licenses/lgpl-2.1.en.html
-->
<?php 
include('./get_edge_style.php');
//error_reporting(E_ALL);
//ini_set('display_errors', '1');


function get_term_name($id) {

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
      
    $query=mysql_query("select t.name from term t where t.id = \"".$id."\"");
    $find=mysql_num_rows($query);
      //echo $find; sadas
    $hash = array();
    if($find > 0){
           
           
      
        while($row = mysql_fetch_array($query,MYSQLI_ASSOC)){
            $name = $row['name'];
            return $name;
          
        }
    }
    return "";
}

function get_childern($term) {

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
      
    $query=mysql_query("select t.name, t.acc, t.id, t2t.relationship_type_id from term t, term2term t2t, term t1 where t2t.term1_id= t1.id AND t2t.term2_id=t.id AND t1.acc = \"".$term."\"");
    $find=mysql_num_rows($query);
      //echo $find;
    $hash = array();
    if($find > 0){
      
        while($row = mysql_fetch_array($query,MYSQLI_ASSOC)){
            $id = $row['acc'];
            if(count($hash[$id]) < 1)$hash[$id] = 1;
            else continue;
             
             
             
            $recent[] = array(
                'id' => $row['acc'],
                'name' => $row['name'],
                'data' => array(),
                'children' => array(),
                'relationship' => array(
                    'id' => $row['relationship_type_id'],
                    'name' => get_term_name($row['relationship_type_id']),
                    'color' => get_edge_style($row['relationship_type_id'])
                )
            );
          
        }
         
        return $recent;
    }
    
    return array();
}
 
function get_ancestors($term) {
    include('./db_config.php');
    $go = $term;
    $connection = mysql_connect($db_host, $db_username, $db_password);
    if(!$connection){
        echo "could not connect to database";
    }
    $db_select = mysql_select_db($go_table);
    if(!$db_select){
        echo "could not select database";
    }
      
    $query=mysql_query("SELECT DISTINCT ancestor.name, ancestor.acc, graph_path.distance, graph_path.term1_id AS ancestor_id, relation.name AS relation_name
               FROM term child, graph_path, term ancestor, term relation WHERE child.id=graph_path.term2_id AND ancestor.id=graph_path.term1_id AND graph_path.relationship_type_id = relation.id
               AND child.acc=\"".$go."\" AND graph_path.relationship_type_id <= 30 ORDER BY distance DESC");
    $find=mysql_num_rows($query);
    //echo $find;
    $hash = array();
    if($find > 0) {
        while($row = mysql_fetch_array($query,MYSQLI_ASSOC)) {
            $id = $row['acc'];
            if(count($hash[$id]) < 1)$hash[$id] = 1;
            else continue;
             
            $ancestors[] = array(
                'id' => $row['acc'],
                'name' => $row['name'],
            );
          
        }
        return $ancestors;  
        
    }
    else{
        return array();
    }

}
  
  #echo $db_database;
if(isset($_GET["go"]) && !isset($_GET["parent"]) && !isset($_GET["alpha"])) {
    $go = $_GET["go"];
    $response = file_get_contents("http://dragon.bio.purdue.edu:4567/get_path/".$go);
    //$response = preg_replace('/{|}/', '', $response);
    //$response = preg_replace('/\["/', '[{"', $response);
    //$response = preg_replace('/"\]/', '"}]', $response);
    //$response = preg_replace('/","/', '"},{"', $response);
    //$response = preg_replace('/{"/', '{"id":"', $response);
    echo $response;
}
 
if(isset($_GET["go"]) && isset($_GET["parent"])) {
    $res = get_ancestors($_GET["go"]);
    $json = json_encode($res);
    echo $json;
  
}  
 
if(isset($_GET["go"]) && isset($_GET["alpha"])) {
    $res = get_ancestors($_GET["go"]);
    $json = json_encode($res);
    $ids = array_column($res, 'id');
    
    foreach($res as $anc) {
        $id = $anc["id"];
        $children = get_childern($id);
//         echo  json_encode($children);
    
        $tmp = array();
        foreach($children as $child) {
            if (in_array($child["id"], $ids, true)) {
                array_push($tmp, $child);
            }
        }
//         echo  json_encode($tmp);
        $ancestors[] = array(
            'id' => $anc['id'],
            'name' => $anc['name'],
            'data' => array(),
            'children' => $tmp
        );
    }
    if ($ancestors == null) {
        echo "[]";
    } else {
        echo json_encode($ancestors);
    }
    

}
  
  
  
 
?>
