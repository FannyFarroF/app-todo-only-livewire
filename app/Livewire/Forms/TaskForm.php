<?php

namespace App\Livewire\Forms;

use App\Models\Task;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TaskForm extends Form
{
    #[Validate('required|min:3')] //rules of validation
    public $content = "";

    // logic for create task
    public function store(){
        $this->validate(); // validation
        auth()->user()->tasks()->create($this->all()); // add new task inside the tasks of the user authenticated
        $this->reset();
    }

    // logic for create task. Param: id(integer)
    public function update($id){
        $this->validate(); // validation
        Task::find($id)->update($this->all()); // find task and update the task
        $this->reset();
    }

    public function destroy($id){
        Task::find($id)->delete();
    }

}
