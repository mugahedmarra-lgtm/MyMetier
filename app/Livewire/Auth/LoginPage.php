<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

class LoginPage extends Component
{
    public $phone = '';
    public $password = '';
    public $remember = false;

    public function login()
    {
        $this->validate([
            'phone' => 'required|digits:9',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['phone' => $this->phone, 'password' => $this->password, 'status' => 'active'], $this->remember)) {
            session()->put('_login_success', true);
            return redirect()->intended('/');
        }

        $this->addError('phone', 'رقم الهاتف أو كلمة المرور غير صحيحة');
    }

    #[Title('تسجيل الدخول - MyMetier')]
    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
