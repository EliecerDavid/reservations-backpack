<?php

namespace App\Http\Controllers\Admin\Auth;

use Backpack\CRUD\app\Http\Controllers\Auth\LoginController as Controller;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->redirectTo ??= backpack_url('reservation');
        parent::__construct();
    }
}
