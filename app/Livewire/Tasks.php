<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Attributes\Validate;
use Livewire\Component;
use PhpParser\Node\Stmt\TryCatch;

class Tasks extends Component
{
    #[Validate('required')]
    public $content = "";

    #[Validate('required')]
    public $contentEdit = "";

    // option edit
    public $edit = null;

    // fields form filter
    public $search = "";
    public $status = "";
    public $date = "";
    public $filter = false;

    // function for add
    public function addTask(){
        // validate field
        $this->validateOnly('content');
        // add new task inside the tasks of the user authenticated
        auth()->user()->tasks()->create([
            "content" => $this->content
        ]);
        // function for reset fields
        $this->resetFields();
        // alert for user
        session()->flash('status', 'Task successfully created.');
    }

    // function for habilitate input for edit. Param: id
    public function editTask($taskId){
        // get task inside tasks list user authenticated
        $this->edit = auth()->user()->tasks->find($taskId);
    }

    //function for update. Param: id
    public function updateTask($taskId){
        // validate
        $this->validateOnly("contentEdit");
        // update
        Task::find($taskId)->update([
            "content" => $this->contentEdit
        ]);
        // reset fields
        $this->resetFields();
        // alert for user
        session()->flash('status', 'Task successfully updated.');
    }

    // function for delete task. Param: id
    public function deleteTask($taskId){
        // delete
        Task::find($taskId)->delete();
    }

    // function for marked completed or not completed(pending)
    public function makeCompleted($taskId){
        // get task to update
        $task = Task::find($taskId);
        // update field
        $task->update(["completed" => !$task->completed]);
    }

    // function for reset inputs
    public function resetFields(){
        $this->content = "";
        $this->edit = null;
        $this->contentEdit = "";
        $this->search = "";
    }

    // function for filter
    public function filterTasks(){
        $this->filter = true;
        $this->render();
    }

    public function render()
    {
        // get tasks
        $tasks = $this->filter ? auth()->user()->tasks() : auth()->user()->tasks;
        // add the search by title to the query
        if (!empty($this->search)) {
            $tasks->where('content', 'LIKE', "%{$this->search}%");
        }
        // add the search by date to the query
        if(!empty($this->date)){
            $tasks->whereDate('created_at', $this->date);
        }
        // add the search by status to the query
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
