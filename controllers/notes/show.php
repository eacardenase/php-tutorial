<?php

use Core\Database;

$config = require base_path('config.php');
$db = new Database($config['database']);

$id = $_GET['id'];
$currentUserId = 1;

$note = $db->query('SELECT * FROM notes WHERE id = :id', [
    'id' => $id
])->findOrFail();

authorize($note['user_id'] === $currentUserId);

view('notes/show.view.php', [
    'heading' => 'Note',
    'note' => $note
]);