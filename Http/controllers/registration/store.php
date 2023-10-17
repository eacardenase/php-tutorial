<?php

use Core\Validator;
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$email = $_POST['email'];
$password = $_POST['password'];

$errors = [];

if (!Validator::email($email)) {
    $errors['email'] = 'Please provide a valid email address.';
}

if (!Validator::string($password, 6, 16)) {
    $errors['password'] = 'Please provide a password of at least 7 characters.';
}

if (!empty($errors)) {
    view('registration/create.view.php', [
        "errors" => $errors
    ]);

    return;
}

$user = $db->query('SELECT * FROM users WHERE email = :email', [
    'email' => $email
])->findOne();

if ($user) {
    header('location: /');

    exit();
} else {
    $db->query('INSERT INTO users(email, password) VALUES(:email, :password)', [
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT)
    ]);

    login([
        "email" => $email
    ]);

    header('location: /');
    exit();
}