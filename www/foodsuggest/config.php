<?php
session_start();                                                             

echo '<html><body></body>';                                                  

$db = new SQLite3('food.db');                                                
$db->query('CREATE TABLE IF NOT EXISTS food(
    f_id INTEGER PRIMARY KEY,
    f_name VARCHAR UNIQUE,
    f_group VARCHAR,
    f_lastpick INTEGER,
    f_pickdate TEXT,
    f_template BOOL )');

$results = $db->query('SELECT DISTINCT(f_group) FROM food');                 
$food_groups = array();                                                      
while( $group = $results->fetchArray( SQLITE3_ASSOC ) ) {                    
    array_push( $food_groups, $group['f_group'] );                           
}                                                                            

if ( ISSET($_POST['edit_id']) ) {
    $food_name = $_POST['edit_name'];
    $food_group = $_POST['edit_group'];
    $food_id = $_POST['edit_id'];
    if ( $_POST['edit_action'] == 'Delete' ) {
        $results = $db->query("DELETE FROM food WHERE f_id = $food_id");
        
    } elseif ( $_POST['edit_action'] == 'Save' ) {
        $results = $db->query("UPDATE food set f_name='$food_name',f_group='$food_group' WHERE f_id = $food_id");
    }
}

if ( ISSET($_POST['new_action'] ) ) {
    if ( $_POST['new_action'] == 'Save' ) {
        $food_name = $_POST['new_name']; 
        $food_group = $_POST['new_group']; 
        if ( ! empty($food_name) ) {
            $db->query("INSERT INTO food VALUES(NULL,'$food_name','$food_group',0,'',0)");
        }
    }
}

if ( ISSET($_REQUEST['edit']) ) {
    $results = $db->query("SELECT * FROM food WHERE f_template = 0 AND f_id = ".$_REQUEST['edit']);
    $food = $results->fetchArray( SQLITE3_ASSOC );
    $food_id = $food['f_id'];
    echo '<form method=post action=config.php>
    <INPUT type=text name="edit_name" value="'.$food['f_name'].'">
    <SELECT name="edit_group">';
    foreach ( $food_groups as $group ) {
        echo '<OPTION value="'.$group.'"';
        if ( $group == $food['f_group'] ) {
            echo ' SELECTED';
        }
        echo '>'.$group.'</option>';
    }
    echo '</SELECT> <INPUT type=hidden name="edit_id" value='.$food_id.'><INPUT type=submit name="edit_action" value="Save"> <INPUT type="submit" name="edit_action" value="Delete"></form>';
    exit;
}

echo '<form method=post action=config.php>
<INPUT type=text name="new_name">
<SELECT name="new_group">';
foreach ( $food_groups as $group ) {
    echo '<OPTION value="'.$group.'">'.$group.'</option>';
}
echo '</SELECT> <INPUT type=submit name="new_action" value="Save"> <INPUT type="submit" name="new_action" value="Cancel"></form>';

echo '<table><tr><td><b>Name</b></td><td><b>Group</b></td></tr>';
$results = $db->query("SELECT * FROM food WHERE f_template = 0 ORDER BY f_name");                                 
while ( $food = $results->fetchArray( SQLITE3_ASSOC ) ) {                    
    $food_id = $food['f_id'];                                                
    echo '<tr><td><a href="config.php?edit='.$food_id.'">'.$food['f_name'].'</a></td>';
    echo '<td>'.$food['f_group'].'</td>';
}                                                                            
echo '</table>';
echo '</html>';                                                              

