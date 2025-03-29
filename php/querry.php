<?php
function query($query_select){
    require 'db_connect.php';
    $select = mysqli_query($connect, $query_select);
    $array = mysqli_fetch_array($select, MYSQLI_ASSOC);
    return $array;
}
?>