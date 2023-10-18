<?php

use Core\Authenticator;
use Core\Session;
use Http\Forms\LoginForm;

var_dump("I've been POSTED");

$email = $_POST['email'];
$password = $_POST['password'];

$form = new LoginForm();

if ($form->validate($email, $password)) {
    if ((new Authenticator)->attempt($email, $password)) {
        redirect('/');
    }

    $form->error('email', "There was a problem with the credentials provided.");
    $form->error('password', "There was a problem with the credentials provided.");
}

Session::flash("errors", $form->errors());
Session::flash("old", [
    "email" => $email,
]);

return redirect("/login");