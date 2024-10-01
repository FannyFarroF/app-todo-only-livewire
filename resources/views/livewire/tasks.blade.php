<div>
    <h1 class="font-bold text-blue-600 mb-3 text-2xl">My Tasks</h1>

    {{-- form new task --}}
    @livewire('create-task')
    {{-- end form new task --}}

    {{-- section filter --}}
    <div class="bg-slate-100 flex  flex-wrap justify-between p-3 rounded-lg  mb-3">
        <div class="me-2 w-full lg:w-7/12">
            <form wire:submit="filterTasks">
                <x-input-label for="search" value="Search" />
                <x-text-input wire:model.defer="search" id="search" class="block mt-1 w-full" type="text" autofocus placeholder="Search by title"/>
            </form>
        </div>
        <div class="me-2 w-full lg:w-2/12">
            <form wire:input="filterTasks">
                <x-input-label for="date" value="Date" />
                <x-text-input wire:model.defer="date" id="date" class="block mt-1 w-full" type="date" autofocus />
            </form>
        </div>
        <div class="me-2 w-full lg:w-2/12">
            <form wire:click="filterTasks">
                <x-input-label for="status" value="Status" />
                <select wire:model.defer="status" id="status" name="status" class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option>All</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                </select>
            </form>
        </div>
    </div>
    {{-- end section filter --}}

    {{-- section tasks --}}
    <table class="w-full border-collapse border border-slate-300 mb-10 text-left">
        <thead class="bg-slate-200">
            <tr>
                <th class="border border-slate-300 p-3">Title</th>
                <th class="border border-slate-300 p-3">Status</th>
                <th class="border border-slate-300 p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $item)
                <tr >
                    <td class="border p-2 border-slate-300">
                        @if ($edit && $edit->id == $item->id)
                            <x-text-input wire:model="form.content" class="block mt-1 me-2 w-full" type="text" autofocus placeholder="Edit Task" />
                            <x-input-error :messages="$errors->get('form.content')" class="mt-2" />
                        @else
                            {{ $item->content }}
                        @endif
                    </td>
                    <td class="border p-2 border-slate-300 text-center">
                        <label for="" class="inline-flex items-center">
                            <input wire:click="makeCompleted({{ $item->id }})" @if ($item->completed) checked
                            @endif type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                                Completed
                            </span>
                        </label>
                    </td>
                    <td class="border p-2 border-slate-300 text-center">
                        @if ($edit && $edit->id == $item->id)
                            <x-primary-button wire:click="updateTask({{ $item->id }})" class="bg-blue-700 m-1 hover:bg-blue-900 focus:">
                                Guardar
                            </x-primary-button>
                            <x-primary-button wire:click="cancelEdit({{ $item->id }})" id="cancel" class="bg-slate-600 m-1 hover:bg-slate-700 ">
                                Cancelar
                            </x-primary-button>
                        @else
                            <x-primary-button wire:click="editTask({{ $item->id }})" class="bg-yellow-500 m-1 hover:bg-yellow-600">
                                Edit
                            </x-primary-button>
                            <x-primary-button wire:click="deleteTask({{ $item->id }})" id="delete" wire:confirm="Are you sure you want to delete this task?" class="bg-red-500 m-1 hover:bg-red-600 ">
                                Delete
                            </x-primary-button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- end section tasks --}}
</div>
