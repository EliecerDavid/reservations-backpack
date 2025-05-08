<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin
                            {--N|name= : The name of the admin}
                            {--E|email= : The admin\'s email address}
                            {--P|password= : Admin\'s password}
                            {--encrypt=true : Encrypt admin\'s password if it\'s plain text ( true by default )}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Creating a new admin');

        if (! $name = $this->option('name')) {
            $name = $this->ask('Name');
        }

        if (! $email = $this->option('email')) {
            $email = $this->ask('Email');
        }

        if (! $password = $this->option('password')) {
            $password = $this->secret('Password');
        }

        if ($this->option('encrypt')) {
            $password = Hash::make($password);
        }

        $auth = config('backpack.base.user_model_fqn', 'App\User');
        $user = new $auth();
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->role = User::ROLE_ADMIN;

        if ($user->save()) {
            $this->info('Successfully created new admin');
        } else {
            $this->error('Something went wrong trying to save your admin');
        }
    }
}
