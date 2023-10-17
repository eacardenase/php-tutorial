<?php

use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$email = $_POST['email'];
$password = $_POST['password'];

$errors = [];

if (!Validator::email($email)) {
    $errors['email'] = 'Please provide a valid email address.';
}

if (!Validator::string($password)) {
    $errors['password'] = 'Please provide a valid password.';
}

if (!empty($errors)) {
    view('session/create.view.php', [
        "errors" => $errors
    ]);

    return;
}

$user = $db->query('SELECT * FROM users WHERE email = :email', [
    'email' => $email
])->findOne();

if (!$user || !password_verify($password, $user["password"])) {
    view('session/create.view.php', [
        "errors" => [
            "email" => "There was a problem with the credentials provided.",
            "password" => "There was a problem with the credentials provided."
        ]
    ]);

    return;
}

login([
    "email" => $email
]);

header("location: /");
exit();