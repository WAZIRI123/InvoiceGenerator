<?php

namespace App\Livewire\InvoiceGenerator;

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

    public $itemList = [];

    /**
     * @var array
     */

    protected function rules()
    {
        return [
            'item.name' => 'required|string',
            'item.description' => 'nullable|string',
            'item.sale_price' => 'required|numeric|between:0,999999999999999.9999',
            'item.purchase_price' => 'required|numeric|between:0,999999999999999.9999',
            'item.category_id' => 'required|exists:products,id',
            'item.quantity' => 'required|integer',
            'item.enabled' => 'boolean',
        ];
    }

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'name',
        'item.description' => 'description',
        'item.sale_price' => 'sale price',
        'item.purchase_price' => 'purchase price',
        'item.category_id' => 'category',
        'item.quantity' => 'quantity',
        'item.enabled' => 'enabled',
    ];
    /**
     * @var bool
     */
    public $confirmingItemDeletion = false;


    public $itemModel;

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
            $product=Item::create([
                'id'=>$product->id,
                'name'=>$product->name,
                'price'=>
            ]);
            $this->itemList[]=[
                'id'=>$product->id,
                'name'=>$product->name,
            ];
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
