<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('إعدادات الحساب')]
class SettingsPage extends Component
{
    public function render()
    {
        return view('livewire.settings-page');
    }
}
