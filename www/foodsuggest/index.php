<?php

$db = new SQLite3('food.db');
$db->query('CREATE TABLE IF NOT EXISTS food(
    f_id INTEGER PRIMARY KEY,
    f_name VARCHAR UNIQUE,
    f_group VARCHAR,
    f_lastpick INTEGER,
    f_pickdate TEXT,
    f_template BOOL )');

$db->query("INSERT INTO food VALUES(NULL,'template1','healthy',0,'',1)");
$db->query("INSERT INTO food VALUES(NULL,'template2','quick',0,'',1)");
$db->query("INSERT INTO food VALUES(NULL,'template3','standard',0,'',1)");

$results = $db->query('SELECT DISTINCT(f_group) FROM food');
$food_groups = array();
while( $group = $results->fetchArray( SQLITE3_ASSOC ) ) {
    array_push( $food_groups, $group['f_group'] );
}

foreach ( $food_groups as $group ) {
    /* check if we should select new food */
    $results = $db->query("SELECT COUNT(*) as food_count FROM food WHERE f_pickdate = date('now') and f_template = 0");
    $curday_food = $results->fetchArray( SQLITE3_ASSOC );
    if ( $curday_food['food_count'] != 3 ) {
        $results = $db->query("SELECT * FROM food WHERE f_group='$group' AND f_template = 0 AND f_lastpick < 1 ORDER BY RANDOM() LIMIT 1");
        $food = $results->fetchArray( SQLITE3_ASSOC );
        $food_id = $food['f_id'];
        $db->query("UPDATE food set f_lastpick = f_lastpick - 1 WHERE f_group='$group' AND f_lastpick > 0");
        $db->query("UPDATE food set f_lastpick = 5, f_pickdate = date('now') WHERE f_group='$group' AND f_id = $food_id");
    }
}

$json_food = array();

$results = $db->query("SELECT * FROM food WHERE f_template = 0 AND f_pickdate = date('now')");
while( $food = $results->fetchArray( SQLITE3_ASSOC ) ) {
    array_push($json_food, array( 'name' => $food['f_name'], 'group' => $food['f_group']));
}

print json_encode($json_food);

?>
