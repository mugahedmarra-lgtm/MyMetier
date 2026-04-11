<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterPage extends Component
{
    public $name = '';
    public $phone = '';
    public $password = '';
    public $password_confirmation = '';

    public function register()
    {
        $this->validate([
            'name' => 'required|string|min:2|max:255',
            'phone' => 'required|digits:9|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'role' => 'customer',
            'status' => 'active',
            'last_seen_at' => now(),
        ]);

        Auth::login($user);

        return redirect()->to('/');
    }

    #[Title('حساب جديد - MyMetier')]
    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
