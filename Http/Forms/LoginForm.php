<?php

namespace Http\Forms;

use Core\ValidationException;
use Core\Validator;

class LoginForm
{
    protected array $errors = [];

    public function __construct(public array $attributes)
    {
        if (!Validator::email($this->attributes["email"])) {
            $this->errors['email'] = 'Please provide a valid email address.';
        }

        if (!Validator::string($this->attributes["password"])) {
            $this->errors['password'] = 'Please provide a valid password.';
        }
    }

    public static function validate(array $attributes): LoginForm
    {
        $instance = new static($attributes);

        return $instance->failed() ? $instance->throw() : $instance;
    }

    public function throw(): void
    {
        ValidationException::throw($this->errors(), $this->attributes);
    }

    public function failed(): bool
    {
        return (bool)count($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function error(string $field, string $message): LoginForm
    {
        $this->errors[$field] = $message;

        return $this;
    }
}