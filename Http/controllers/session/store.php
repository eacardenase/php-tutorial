<?php

use Core\App;
use Core\Database;
use Http\Forms\LoginForm;

$db = App::resolve(Database::class);

$email = $_POST['email'];
$password = $_POST['password'];

$form = new LoginForm();

if (!$form->validate($email, $password)) {
    view('session/create.view.php', [
        "errors" => $form->errors()
    ]);

    exit();
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
    "email" => $email,
    "id" => $user["id"]
]);

header("location: /");
exit();