<?php

use Core\Authenticator;
use Http\Forms\LoginForm;

$form = LoginForm::validate($attributes = [
    "email" => $_POST['email'],
    "password" => $_POST['password']
]);

$signedIn = (new Authenticator)->attempt(
    $attributes["email"], $attributes["password"]
);

if (!$signedIn) {
    $form->error(
        'password', "There was a problem with the credentials provided."
    )->throw();
}

redirect('/');
