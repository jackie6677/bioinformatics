<?php 
include('./get_edge_style.php');

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
      
    $query=mysql_query("SELECT DISTINCT ancestor.name, ancestor.acc, graph_path.distance, graph_path.term1_id AS ancestor_id, relation.id AS relation_id, relation.name AS relation_name
               FROM term child, graph_path, term ancestor, term relation WHERE child.id=graph_path.term2_id AND ancestor.id=graph_path.term1_id AND graph_path.relationship_type_id = relation.id AND distance = 1
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
                'relationship' => array(
                    'id' => $row['relation_id'],
                    'name' => $row['relation_name'],
                    'color' => get_edge_style($row['relation_id'])

                )

            );
          
        }
        return $ancestors;  
        
    }
    else{
        return array();
    }

}
 

if(isset($_GET["go"]) && !isset($_GET["alpha"])) {
    $go = $_GET["go"];
    $response = file_get_contents("http://dragon.bio.purdue.edu:4567/get_parent/".$go);
    //$response = preg_replace('/{|}/', '', $response);
    //$response = preg_replace('/\["/', '[{"', $response);
    //$response = preg_replace('/"\]/', '"}]', $response);
    //$response = preg_replace('/","/', '"},{"', $response);
    //$response = preg_replace('/{"/', '{"id":"', $response);
    echo $response;
}
  
if(isset($_GET["go"]) && isset($_GET["alpha"])) {
    $res = get_ancestors($_GET["go"]);
    $json = json_encode($res);
    echo $json;
}
 
?>