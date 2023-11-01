<?php

namespace App\Livewire\Stream;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Stream;

class StreamChild extends Component
{

    public $item=[];

    /**
     * @var array
     */
    protected $listeners = [
        'showDeleteForm',
        'showCreateForm',
        'showEditForm',
    ];

    /**
     * @var array
     */
    protected $rules = [
        'item.name' => '',
        'item.classes_id' => 'required',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'Name',
        'item.classes_id' => 'Classes Id',
    ];

    /**
     * @var bool
     */
    public $confirmingItemDeletion = false;

    /**
     * @var string | int
     */
    public $primaryKey;

    /**
     * @var bool
     */
    public $confirmingItemCreation = false;

    public $stream ;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        return view('livewire.stream.stream-child');
    }
    #[On('showDeleteForm')]
    public function showDeleteForm(Stream $stream): void
    {
        $this->confirmingItemDeletion = true;
        $this->stream = $stream;
    }

    public function deleteItem(): void
    {
        $this->stream->delete();
        $this->confirmingItemDeletion = false;
        $this->stream = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('stream');
        $this->dispatch('show', 'Record Deleted Successfully')->to('livewire-toast');

    }
 
    #[On('showCreateForm')]
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);
    }

    public function createItem(): void
    {
        $this->validate();
        $item = Stream::create([
            'name' => $this->item['name'] ?? '', 
            'classes_id' => $this->item['classes_id'] ?? '', 
        ]);
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('stream');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    }
        
    #[On('showEditForm')]
    public function showEditForm(Stream $stream): void
    {
        $this->resetErrorBag();
        $this->stream = $stream;
        $this->item = $stream->toArray();
        $this->confirmingItemEdit = true;
    }

    public function editItem(): void
    {
        $this->validate();
        $item = $this->stream->update([
            'name' => $this->item['name'] ?? '', 
            'classes_id' => $this->item['classes_id'] ?? '', 
         ]);
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->dispatch('refresh')->to('stream');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}
