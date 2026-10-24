<?php
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
Artisan::command('alhasm:admin {email}', function (string $email) {
    if (!filter_var($email,FILTER_VALIDATE_EMAIL)) { $this->error('Invalid email.'); return 1; }
    $name = $this->ask('Full name', 'Administrator');
    $password = $this->secret('Secure password (12+ characters)');
    if (mb_strlen((string)$password) < 12) { $this->error('Password must contain at least 12 characters.'); return 1; }
    User::updateOrCreate(['email'=>$email], ['name'=>$name,'password'=>Hash::make($password),'role'=>'admin','active'=>true]);
    $this->info('Administrator created/updated.');
})->purpose('Create or update a secure administrator account');
