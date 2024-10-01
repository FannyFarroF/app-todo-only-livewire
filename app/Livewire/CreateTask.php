<?php

namespace App\Livewire;

use App\Livewire\Forms\TaskForm;
use Livewire\Component;

class CreateTask extends Component
{
    public TaskForm $form;

    public function addTask(){
        $this->form->store();
        $this->dispatch('refresh-list');
    }

    public function render()
    {
        return view('livewire.create-task');
    }
}
