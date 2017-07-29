<?php

$db = new SQLite3('food.db');
$results = $db->query('CREATE TABLE IF NOT EXISTS food(
    f_id INTEGER PRIMARY KEY,
    f_name VARCHAR UNIQUE,
    f_group VARCHAR,
    f_lastpick INTEGER )');

$results = $db->query('SELECT DISTINCT(f_group) FROM food');
$food_groups = array();
while( $group = $results->fetchArray( SQLITE3_ASSOC ) ) {
    array_push( $food_groups, $group['f_group'] );
}

foreach ( $food_groups as $group ) {
    $results = $db->query("SELECT * FROM food WHERE f_group='$group' AND f_lastpick < 1 ORDER BY RANDOM() LIMIT 1");
    $food = $results->fetchArray( SQLITE3_ASSOC );
    $food_id = $food['f_id'];
    echo $food['f_name']."<br>";
    $db->query("UPDATE food set f_lastpick = f_lastpick - 1 WHERE f_group='$group' AND f_lastpick > 0");
    $db->query("UPDATE food set f_lastpick = 5 WHERE f_group='$group' AND f_id = $food_id");
}

?>
