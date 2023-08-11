<?php

namespace App\Livewire\InvoiceGenerator;

use App\Livewire\Item\Create as ItemCreate;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Item;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;

class Create extends Component
{

    public $item = [];



    /**
     * @var array
     */
    public $products = [];

    public $customers = [];

    public $itemList = [];

    /**
     * @var array
     */

     protected function rules()
     {
         return [
             'item.title' => 'required|string|max:255',
             'item.description' => 'nullable|string|max:1000', // Adjust max length as needed
             'item.customer_id' => 'required|exists:customers,id', // Change 'products' to 'customers' if that's the intended table
             'item.invoice_date' => 'required|date',
             'item.invoice_number' => 'required|integer',
             'item.due_date' => 'nullable|date|after_or_equal:item.invoice_date', // Add validation for due date
             'item.order_number' => 'nullable|string|max:50', // Adjust max length as needed
             'items' => 'array', // Validate items as an array
             'items.*.name' => 'required|string|max:255',
             'items.*.quantity' => 'required|integer|min:1',
             'items.*.product_id' => 'required|exists:products,id', // Validate product_id
         ];
     }
     

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.title' => 'title',
        'item.description' => 'description',
        'item.customer_id' => 'customer',
        'item.invoice_date' => 'invoice date',
        'item.invoice_number' => 'invoice number',
        'item.due_date' => 'due date',
        'item.order_number' => 'order number',
        'items.*.name' => 'item name',
        'items.*.quantity' => 'item quantity',
        'items.*.product_id' => 'item product',
    ];
    
    /**
     * @var bool
     */
    public $confirmingItemDeletion = false;

    /**
     * @var bool
     */
    public $confirmingItemCreation = false;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public $showSelectItem = false;

    public function mount()
    {
        $this->products = Item::all();
        $this->customers = Customer::all();
    }

    public function render(): View
    {
        return view('livewire.item.create');
    }

    #[On('showSelectItem')]

    public function showSelectItem()
    {
        $this->showSelectItem = true;
    }

    #[On('addItem')]
    public function addItem($selectItem = null)
    {
        if ($selectItem) {
            $this->itemList[]=[
                'id'=>$this->item['product_id'],
                'name'=>$selectItem,
            ];
        }else {
            $this->dispatch('showCreateForm')->to(ItemCreate::class);
        }
    
    }


    #[On('showDeleteForm')]
    public function showDeleteForm(Item $item): void
    {
        $this->confirmingItemDeletion = true;

        $this->itemModel = $item;
    }


    public function deleteItem(Item $Item): void
    {

        Category::find($this->itemModel->category_id)?->delete();
        $this->itemModel->delete();
        $this->confirmingItemDeletion = false;
        $this->itemModel = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('item.table');
        $this->dispatch('show', 'Record Deleted Successfully')->to('livewire-toast');
    }

    #[On('showCreateForm')]
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->products = Category::orderBy('name')->get();
    }

    public function createItem(): void
    {
        $this->validate();
        Item::create($this->item);

        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('item.table');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');
    }
    #[On('showEditForm')]
    public function showEditForm(Item $item): void
    {

        $this->resetErrorBag();
        $this->itemModel = $item;
        $this->item['name'] = $item->name;
        $this->item['description'] = $item->description;
        $this->item['sale_price'] = $item->sale_price;
        $this->item['purchase_price'] = $item->purchase_price;
        $this->item['category_id'] = $item->category_id;
        $this->item['quantity'] = $item->quantity;
        $this->item['enabled'] = $item->enabled;
        $this->confirmingItemEdit = true;

        $this->products = Category::orderBy('name')->get();
    }

    public function editItem(Item $Item): void
    {
        $this->validate();
        $this->itemModel->update($this->item);

        $this->confirmingItemEdit = false;
        $this->itemModel = '';
        $this->dispatch('item.table', 'refresh');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');
    }
}
