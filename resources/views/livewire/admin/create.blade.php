<div>

    <x-tall-crud-confirmation-dialog wire:model.live="confirmingItemDeletion">
        <x-slot name="title">
            Delete Record
        </x-slot>

        <x-slot name="content">
            Are you sure you want to Delete Record?
        </x-slot>

        <x-slot name="footer">
            <x-tall-crud-button wire:click="$set('confirmingItemDeletion', false)">Cancel</x-tall-crud-button>
            <x-tall-crud-button mode="delete" wire:loading.attr="disabled" wire:click="deleteItem()">Delete</x-tall-crud-button>
        </x-slot>
    </x-tall-crud-confirmation-dialog>

    <x-tall-crud-dialog-modal wire:model.live="confirmingItemCreation">
        <x-slot name="title">
            Add Record
        </x-slot>

        <x-slot name="content"><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Name</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.name" />
                @error('item.name') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Email</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.email" />
                @error('item.email') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
   
            <div class="mt-4">
                <x-tall-crud-label>Password</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.password" />
                @error('item.password') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>

            <div class="mt-4">
                <x-tall-crud-label>Password Confirmation</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.password_confirmation" />
                @error('item.password_confirmation') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div>
            
            <div class="grid grid-cols-2 gap-8">
            <div class="mt-4"         
        x-data="{ uploading: false, progress: 0 }"
        x-on:livewire-upload-start="$dispatch('uploadings')"
        x-on:livewire-upload-finish="$dispatch('uploading')"
        x-on:livewire-upload-error="$dispatch('uploading')"
        x-on:livewire-upload-progress="progress = $event.detail.progress">
                <x-tall-crud-label>Profile Picture</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="file" wire:model="profile" />
                @error('profile') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror

            </div></div>
        </x-slot>

        <x-slot name="footer">
        <div x-data="{ uploading: false, progress: 0 }" x-on:uploadings.window="uploading =true" x-on:uploading.window="uploading =false">
            <x-tall-crud-button wire:click="$set('confirmingItemCreation', false)">Cancel</x-tall-crud-button>
            <x-tall-crud-button mode="add" wire:uploading.attr="disabled" x-bind:disabled="uploading" wire:target="profile" wire:click="createItem()" >Save</x-tall-crud-button>
            <span x-show="uploading">uploading...</span>
            </div>
        </x-slot>
    </x-tall-crud-dialog-modal>

    <x-tall-crud-dialog-modal wire:model.live="confirmingItemEdit">
        <x-slot name="title">
            Edit Record
        </x-slot>

        <x-slot name="content"><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Name</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.name" />
                @error('item.name') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Email</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.email" />
                @error('item.email') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
   
            <div class="mt-4">
                <x-tall-crud-label>Password</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.password" />
                @error('item.password') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>

            <div class="mt-4">
                <x-tall-crud-label>Password confirmation</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.password_confirmation" />
                @error('item.password_confirmation') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>

        </div><div class="grid grid-cols-2 gap-8">
        <div class="mt-4"         
        x-data="{ uploading: false, progress: 0 }"
        x-on:livewire-upload-start="$dispatch('uploadings')"
        x-on:livewire-upload-finish="$dispatch('uploading')"
        x-on:livewire-upload-error="$dispatch('uploading')"
        x-on:livewire-upload-progress="progress = $event.detail.progress">

                <x-tall-crud-label>Profile Picture</x-tall-crud-label>
                @if($profileImage && !$profile)
                  <img src="{{ asset($profileImage) }}" alt="profile photo" class="w-1/2  object-cover">

                @endif
                @if($profile && $profile!='')
              <img src="{{$profile->temporaryUrl() ?? ""}}" alt="profile photo" class="w-1/2  object-cover">
            @endif
            @if($profile)
            <x-tall-crud-button mode="delete" wire:click="removeImage()" class="Justify-center">Clear Image</x-tall-crud-button>

              @endif
                <x-tall-crud-input class="block mt-1 w-full" type="file" wire:model.live="profile" />
              
                @error('profile') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror

            </div></div>
        </x-slot>

        <x-slot name="footer">
        <div x-data="{ uploading: false, progress: 0 }" x-on:uploadings.window="uploading =true" x-on:uploading.window="uploading =false">
            <x-tall-crud-button wire:click="$set('confirmingItemEdit', false)">Cancel</x-tall-crud-button>
            <x-tall-crud-button mode="add" wire:uploading.attr="disabled" x-bind:disabled="uploading" wire:target="profile" wire:click="editItem()" >Save</x-tall-crud-button>
            <span x-show="uploading">uploading...</span>
            </div>
        </x-slot>
    </x-tall-crud-dialog-modal>
</div>
