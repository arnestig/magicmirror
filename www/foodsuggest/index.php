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
$results = $db->query('INSERT INTO food VALUES(NULL,"Mousakka","Husmanskost",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Spaghetti köttfärsås","Snabblagat",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Korv stroganoff","Snabblagat",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Laxpasta","Husmanskost",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Kött och sallad","Nyttigt",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Chili con carne","Nyttigt",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Pasta sallad med bönor","Nyttigt",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Pytt i panna","Husmanskost",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Ungsstekt lax med potatis och romsås","Husmanskost",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Ungspannkaka","Snabblagat",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Tacos","Husmanskost",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Fläsk och bruna bönor","Husmanskost",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Fisk med remouladsås","Husmanskost",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Torskrygg med citronsås","Snabblagat",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Kycklingwraps","Nyttigt",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Lasagne","Husmanskost",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Pannbiff och mos","Husmanskost",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Omelett","Nyttigt",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Kycklingsallad med senapssås","Nyttigt",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Räksmörgås","Snabblagat",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Grönsakssoppa","Nyttigt",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Ärtsoppa","Snabblagat",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Grekisk sallad","Nyttigt",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Chili torsk i ugn","Snabblagat",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Kyckling/fläsk wok med grönsaker","Snabblagat",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Tonfisksallad med ägg","Nyttigt",0)');
$results = $db->query('INSERT INTO food VALUES(NULL,"Kastler hawaii","Snabblagat",0)');

?>
