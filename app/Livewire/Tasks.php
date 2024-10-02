<?php

namespace App\Livewire;

use App\Livewire\Forms\TaskForm;
use App\Models\Task;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Tasks extends Component
{
    public TaskForm $form; // form
    // option edit
    public $edit = null;

    // fields form filter
    public $search = "";
    public $status = "";
    public $date = "";
    public $filter = false;

    // function for add task
    public function addTask(){
        $this->form->store(); // use functionality for create of the formObj
    }

    // function for habilitate input for edit. Param: id(integer)
    public function editTask($taskId){
        $this->edit = auth()->user()->tasks->find($taskId); // get task inside tasks list user authenticated
        $this->form->content = $this->edit->content;
    }

    //function for update. Param: id(integer)
    public function updateTask($taskId){
        $this->form->update($taskId); // use update for formObj
        $this->edit = null;
    }

    // function for delete task. Param: id (integer)
    public function deleteTask($taskId){
        $this->form->destroy($taskId); // use destroy for formObj
    }

    // function for marked completed or not completed(pending)-. Param: id(integer)
    public function makeCompleted($taskId){
        $task = Task::find($taskId); // get record
        $task->update(["completed" => !$task->completed]); // update
    }

    // function cancel update: reset completed
    public function cancelEdit($taskId){
        $this->reset();
    }

    // function for filter
    public function filterTasks(){
        $this->filter = true;
        $this->render();
    }

    #[On('refresh-list')]
    public function refresh(){
        $this->render();
    }

    public function updatedSearch(){
        $this->filter = true;
        $this->render();
    }

    public function render()
    {
        // get tasks
        $tasks = $this->filter ? auth()->user()->tasks() : auth()->user()->tasks;

        // filter por text
        if (!empty($this->search)) {
            $tasks->where('content', 'LIKE', "%{$this->search}%");
        }

        // filter by date
        if(!empty($this->date)){
            $tasks->whereDate('created_at', $this->date);
        }

        // filter by status
        if ($this->status == 'completed'){
            $tasks->where('completed', true);
        }elseif($this->status == 'pending'){
            $tasks->where('completed', false);
        }

        // return list tasks
        $tasks = $this->filter ? $tasks->get() : $tasks;

        // send tasks to the view
        return view('livewire.tasks', compact('tasks'));
    }
}
