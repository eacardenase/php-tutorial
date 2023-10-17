<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$userId = $_SESSION['user']['id'];
$notes = $db->query('SELECT * FROM notes WHERE user_id = :id', [
    'id' => $userId
])->findAll();

view('notes/index.view.php', [
    'heading' => 'My Notes',
    'notes' => $notes
]);