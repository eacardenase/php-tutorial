<?php

$config = require('config.php');
$db = new Database($config['database'], 'root', '');

$heading = 'Note';
$id = $_GET['id'];
$currentUserId = 1;


$note = $db->query('SELECT * FROM notes WHERE id = :id', [
    'id' => $id
])->findOrFail();

authorize($note['user_id'] === $currentUserId);

require 'views/note.view.php';