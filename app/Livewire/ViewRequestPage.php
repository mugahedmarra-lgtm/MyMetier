<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PublicRequest;

class ViewRequestPage extends Component
{
    public $request;

    public function mount($id)
    {
        $this->request = PublicRequest::with(['user', 'category', 'city', 'district'])
            ->findOrFail($id);
            
        if ($this->request->status !== 'open') {
            abort(404);
        }
    }

    public function render()
    {
        return view('livewire.view-request-page')->title($this->request->title . ' - MyMetier');
    }
}
