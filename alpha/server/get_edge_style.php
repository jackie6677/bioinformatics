<?php
    function get_edge_style($id) {
        if ($id == "1") {
            return "#000";
        } else if ($id == "3") {
            return "#f0f";
        } else if ($id == "27") {
            return "#f00";
        } else if ($id == "25") {
            return "#00f";
        } else if ($id == "26") {
            return "#0ff";
        } else if ($id == "23") {
            return "#ff0";
        } else {
            return "";
        }
    }
?>