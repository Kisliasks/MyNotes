<?php 
include "functions.php"; 

if(isset($_GET['note_id'])) {

    $note_id = $_GET['note_id'];

    delete_note($note_id);

    redirect("all_notes.php");
}

?>