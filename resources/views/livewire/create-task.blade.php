<div class="bg-slate-100 p-4 rounded-lg w-50 mb-3">
    <form wire:submit="addTask" class="">
        <div class="flex justify-center">
            <x-text-input wire:model="form.content" class="block mt-1 me-2 w-full" type="search" name="content" autofocus placeholder="Add Task" />
            <x-primary-button type="submit"> Add </x-primary-button>
        </div>
        <div>
            <x-input-error :messages="$errors->get('form.content')" class="mt-2" />
        </div>
    </form>
</div>
