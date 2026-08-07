<?php

namespace App\Livewire\Public;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductSku;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Rule;

class OrderShow extends Component
{
    public array $cartItems = [];

    #[Rule(['required', 'string','min:3','max:255'])]
    public $name = '';

    #[Rule(['required', 'string','min:3','max:255'])]
    public $last_name = '';

    #[Rule(['required', 'numeric','digits_between:5,10'])]
    public $phone ='';

    #[Rule(['required', 'email'])]
    public $email = '';
    
    #[Rule(['required', 'string','min:3','max:255'])]
    public $address = '';

    // #[Rule(['required', 'string','min:3','max:255'])]
    public $shipping_fee = 0;

    // #[Rule(['required', 'string','min:3','max:255'])]
    public $descount_amount = 0;

    public function mount(){
        $this->cartItems = session()->get('cartItems', []);
    }

    #[Computed]
    public function subTotal(){
        return collect($this->cartItems)
        ->sum(
            fn($item)=>(float) $item['cantidad'] * (float) $item['precio'] 
        );
        
    }

    #[Computed]
    public function total(){
        return $this->subTotal() + (float) $this->shipping_fee - (float) $this->descount_amount;
    }

    // #[Computed]
    // public function subTotalProduct(){
    //     return collect($this->cartItems)
    //     ->sum()
    // }

    public function saveOrder(){

        $orderSubtotal = $this->subTotal();
        $total = $this->total();

    $this->validate();
    // foreach($cart)

    try{



        $order = DB::transaction(function(){
        $order = Order::create([
        'customer_name' => $this->name,
        'customer_email'=> $this->email,
        'customer_phone'=> $this->phone,
        'shipping_address'=> $this->address,
        'subtotal'=> $this->orderSubtotal(),
        'shipping_fee'=>$this->shipping_fee,
        'descount_amount'=>$this->descount_amount,
        'total'=> $this->total(),
        ]);

        foreach ($this->cartItems as $key => $item){
        $itemSubTotal = (int)$item['cantidad']*(float)$item['precio'];
            $order->orderItems()->create([
                'product_id'=>$item['product_id'],
                'sku_id'=>$item['sku_id'],
                'product_name'=>$item['nombre'],
                'sku_code'=>$item['sku_code'],
                'unit_price'=>$item['precio'],
                'quantity'=>$item['cantidad'],
                'subtotal'=>$itemSubTotal,
                // 'subtotal'=>$item[''],
            ]);
            if(isset($item['sku_id'])){
                ProductSku::find($item['sku_id'])?->decrement('stock',$item['cantidad']);
            }
        }
        return $order;
        });

        session()->forget('cartItems');
        return redirect()->route('reverb.catalog', $order->id);
    }catch(\Exception $e){
        session()->flash('error', 'ocurrio un error al momento de procesar tu compra'. $e->getMessage());
    }
    }

    public function render()
    {
        return view('livewire.public.order-show');
    }
}
