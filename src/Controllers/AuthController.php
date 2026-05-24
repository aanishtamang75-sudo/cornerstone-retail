<?php

declare(strict_types=1);

namespace App\Controllers;

use App\ActivityLogger;
use App\Auth;
use App\Models\UserModel;
use App\Validator;

final class AuthController
{
    public function loginForm(): void
    {
        if (Auth::check()) {
            redirect(url('products.index'));
        }
        view('auth.login', ['title' => 'Log in']);
    }

    public function login(): void
    {
        if (!verify_csrf()) {
            flash('error', 'Invalid session. Please try again.');
            redirect(url('login'));
        }
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        set_old(['email' => $email]);

        $v = new Validator(['email' => $email, 'password' => $password]);
        $v->required('email', 'Email')->email('email', 'Email')->required('password', 'Password');
        if ($v->fails()) {
            flash('error', implode(' ', $v->errors()));
            redirect(url('login'));
        }

        $user = UserModel::findByEmail($email);
        if (!$user || !password_verify($password, $user['password_hash'])) {
            flash('error', 'Invalid email or password.');
            redirect(url('login'));
        }
        clear_old();
        Auth::login($user);
        ActivityLogger::log('login', 'user', (int) $user['id'], $user['email']);
        flash('success', 'Welcome back, ' . $user['full_name'] . '!');
        redirect(url('products.index'));
    }

    public function registerForm(): void
    {
        if (Auth::check()) {
            redirect(url('products.index'));
        }
        view('auth.register', ['title' => 'Register']);
    }

    public function register(): void
    {
        if (!verify_csrf()) {
            flash('error', 'Invalid session.');
            redirect(url('register'));
        }
        $data = [
            'full_name' => trim($_POST['full_name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'password_confirm' => $_POST['password_confirm'] ?? '',
        ];
        set_old($data);

        $v = new Validator($data);
        $v->required('full_name', 'Full name')->minLen('full_name', 2, 'Full name')
            ->required('email', 'Email')->email('email', 'Email')
            ->required('password', 'Password')->minLen('password', 8, 'Password');
        if ($data['password'] !== $data['password_confirm']) {
            flash('error', 'Passwords do not match.');
            redirect(url('register'));
        }
        if ($v->fails()) {
            flash('error', implode(' ', $v->errors()));
            redirect(url('register'));
        }
        if (UserModel::findByEmail($data['email'])) {
            flash('error', 'Email already registered.');
            redirect(url('register'));
        }

        $id = UserModel::create($data['email'], $data['password'], $data['full_name']);
        clear_old();
        $user = UserModel::findById($id);
        Auth::login(array_merge($user, ['password_hash' => '']));
        ActivityLogger::log('register', 'user', $id);
        flash('success', 'Account created successfully.');
        redirect(url('products.index'));
    }

    public function logout(): void
    {
        if (Auth::check()) {
            ActivityLogger::log('logout', 'user', Auth::id());
        }
        Auth::logout();
        redirect(url('login'));
    }
}
