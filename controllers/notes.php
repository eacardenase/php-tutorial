<?php

$config = require('config.php');
$db = new Database($config['database'], 'root', '');

$heading = 'My Notes';

$notes = $db->query('SELECT * FROM notes WHERE user_id = 1')->findAll();

require 'views/notes.view.php';