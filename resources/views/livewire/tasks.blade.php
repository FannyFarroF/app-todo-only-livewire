<div>
    <h1 class="font-bold text-blue-600 mb-3 text-2xl">My Tasks</h1>
    <form wire:submit="addTask" class="mb-3">
        <div class="flex justify-center">
            <x-text-input wire:model="content" class="block mt-1 me-2 w-full" type="text" name="content" autofocus placeholder="Add Task" />
            <x-primary-button type="submit"> Add </x-primary-button>
        </div>
        <div>
            <x-input-error :messages="$errors->get('content')" class="mt-2" />
        </div>
    </form>
    <div class="flex justify-start mt-6 bg-slate-100 px-2 py-3 rounded-lg">
        <div class="me-2">
            <form wire:submit="filterTasks">
                <x-input-label for="search" value="Search" />
                <x-text-input wire:model.defer="search" id="search" class="block mt-1 w-full" type="text" autofocus placeholder="Search by title"/>
            </form>
        </div>
        <div class="me-2">
            <form wire:input="filterTasks">
                <x-input-label for="date" value="Date" />
                <x-text-input wire:model.defer="date" id="date" class="block mt-1 w-full" type="date" autofocus />
            </form>
        </div>
        <div class="me-2">
            <form wire:click="filterTasks">
                <x-input-label for="status" value="Status" />
                <select wire:model.defer="status"  id="status" name="status" class="mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option>All</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                </select>
            </form>
        </div>
    </div>
    <table class="border-collapse border border-slate-400 w-full my-10">
        <thead class="bg-slate-100">
            <tr>
                <th class="border border-slate-300 p-3">Title</th>
                <th class="border border-slate-300 p-3">Status</th>
                <th class="border border-slate-300 p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $item)
                <tr wire:key="{{ $item->id }}">
                    <td class="border p-2 border-slate-300">
                        @if ($edit && $edit->id == $item->id)
                            <x-text-input wire:model="contentEdit" class="block mt-1 me-2 w-full" value="{{ $edit->content }}" type="text" name="text" autofocus placeholder="Edit Task" />
                            <x-input-error :messages="$errors->get('contentEdit')" class="mt-2" />
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
                            <x-primary-button wire:click="updateTask({{ $item->id }})" class="bg-blue-500 m-1 hover:bg-blue-600">
                                Guardar
                            </x-primary-button>
                        @else
                            <x-primary-button wire:click="editTask({{ $item->id }})" class="bg-yellow-500 m-1 hover:bg-yellow-600">
                                Edit
                            </x-primary-button>
                        @endif
                        <x-primary-button wire:click.prevent="deleteTask({{ $item->id }})" class="bg-red-500 m-1 hover:bg-red-600 ">
                            Delete
                        </x-primary-button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
