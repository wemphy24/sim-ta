<?php

namespace App\Http\Livewire;

use App\Models\DetailPo;
use App\Models\GoodReceive;
use App\Models\Material;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PurchaseOrderIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'purchase_order_code';
    public $orderAsc = true;

    public $showingMainPage = true;
    public $showingDetail = false;
    public $showingPO = false;
    public $showingEditPO = false;

    // Tabel purchase orders
    public $purchase_order_code, $name, $description, $deadline, $total_price, $discount, $suppliers_id, $status_id, $users_id;
    public $purchase_order;

    // Tabel detail pos
    public $materials_id, $qty, $price, $total_price_m;
    public $purchase_orders_id;

    // For editing detail po
    public $getEditId, $materials_id_e, $qty_e, $price_e, $total_price_e;

    // For display price
    public $real_price, $total_discount, $total_ppn;

    // Assign table good receive
    public $good_receive_code;

    public function render()
    {
        return view('livewire.purchase-order-index', [
            'purchaseorders' => PurchaseOrder::with('supplier','status')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
            'suppliers' => Supplier::all(),
            'materials' =>Material::where('categories_id','=',1)->orWhere('categories_id','=','2')->get(),
            'detailpos' => DetailPo::all(),
            'editdetailpos' => DetailPo::where('id','=',$this->getEditId)->get(),
        ])->layout('layouts.admin');
    }

    public function back()
    {
        // Menutup detail page dan menampilkan main page
        $this->showingDetail = false;
        $this->showingMainPage = true;
    }

    public function closeModal()
    {
        $this->showingPO = false;
    }

    public function createPOCode()
    {
        // Membuat kode PO
        $countPO = PurchaseOrder::count();
        if($countPO == 0) {
            $this->purchase_order_code = 'PO.' . 1001;
        } else {
            $getLastPO = PurchaseOrder::all()->last();
            $convertPO = (int)substr($getLastPO->purchase_order_code, -4) + 1;
            $this->purchase_order_code = 'PO.' . $convertPO;
        }
    }

    public function showPO()
    {
        $this->showingPO = true;

        $this->description = "Menunggu Pembelian";
        $this->createPOCode();
        $this->name = $this->purchase_order_code;
    }

    public function store()
    {
        PurchaseOrder::create([
            'purchase_order_code' => $this->purchase_order_code,
            'name' => $this->name,
            'description' => "Menunggu Pembelian",
            'deadline' => $this->deadline,
            // 'total_price' => $this->total_price,
            // 'discount' => $this->discount,
            'suppliers_id' => $this->suppliers_id,
            'status_id' => 1,
            'users_id' => Auth::user()->id,
        ]);

        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('store-success');
    }

    // DETAILS SECTION --------------------------------
    public function detail($id)
    {
        // Menampilkan detail page
        $this->showingDetail = true;
        $this->showingMainPage = false;

        // Assign id produksi
        $this->purchase_orders_id = $id;

        // Menampilkan detail data purchase order
        $this->purchase_order = PurchaseOrder::findOrFail($id);
        $this->purchase_order_code = $this->purchase_order->purchase_order_code;
        $this->name = $this->purchase_order->name;
        $this->description = $this->purchase_order->description;
        $this->suppliers_id = $this->purchase_order->suppliers_id;
        $this->deadline = $this->purchase_order->deadline;
        $this->total_price = $this->purchase_order->total_price;
        $this->discount = $this->purchase_order->discount;
        $this->status_id = $this->purchase_order->status['name'];
        $this->users_id = $this->purchase_order->users_id;

        $this->qty = 1;
        $this->price = 0;
        $this->real_price = DetailPo::where('purchase_orders_id','=',$this->purchase_orders_id)->sum('total_price');
        $this->total_discount = DetailPo::where('purchase_orders_id','=',$this->purchase_orders_id)->sum('total_price') * ($this->discount * 0.01);
        $this->total_ppn = $this->total_discount * (11 * 0.01);
    }

    public function update()
    {
        // Mengupdate data po
        $this->purchase_order->update([
            'name' => $this->name,
            'suppliers_id' => $this->suppliers_id,
            'discount' => $this->discount,
        ]);

        $this->dispatchBrowserEvent('update-success');
    }

    public function storeOrderPO()
    {
        DetailPo::create([
            'purchase_orders_id' => $this->purchase_orders_id,
            'materials_id' => $this->materials_id,
            'qty' => $this->qty,
            'price' => $this->price,
            'total_price' => $this->total_price_m,
            'status' => "Menunggu Pesanan",
        ]);

        $hitungTotalHargaAsli = DetailPo::where('purchase_orders_id','=',$this->purchase_orders_id)->sum('total_price'); 
        $hitungPotonganDiskon = $hitungTotalHargaAsli * ($this->discount * 0.01);
        $hitungPajak = ($hitungTotalHargaAsli - $hitungPotonganDiskon) * 0.11;
        $hitungTotalBayar = ($hitungTotalHargaAsli - $hitungPotonganDiskon) + $hitungPajak;
        
        PurchaseOrder::where('id', '=', $this->purchase_orders_id)->update([
            'discount' => $this->discount,
            'total_price' => $hitungTotalBayar,
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('update-success');
    }

    public function editOrderPO($id)
    {
        $this->showingEditPO = true;
        $this->getEditId = $id;
        $this->materials_id_e = DetailPo::where('id', '=', $this->getEditId)->first('materials_id')->materials_id;
        $this->qty_e = DetailPo::where('id', '=', $this->getEditId)->first('qty')->qty;
        $this->price_e = DetailPo::where('id', '=', $this->getEditId)->first('price')->price;
        $this->total_price_e = DetailPo::where('id', '=', $this->getEditId)->first('total_price')->total_price;
    }

    public function storeEditPO()
    {
        // update data detail po
        DetailPo::where('id', '=', $this->getEditId)->update([
            'materials_id' => $this->materials_id_e,
            'qty' => $this->qty_e,
            'price' => $this->price_e,
            'total_price' => $this->total_price_e,
        ]);

        $hitungTotalHargaAsli = DetailPo::where('purchase_orders_id','=',$this->purchase_orders_id)->sum('total_price'); 
        $hitungPotonganDiskon = $hitungTotalHargaAsli * ($this->discount * 0.01);
        $hitungPajak = ($hitungTotalHargaAsli - $hitungPotonganDiskon) * 0.11;
        $hitungTotalBayar = ($hitungTotalHargaAsli - $hitungPotonganDiskon) + $hitungPajak;

        // Update total harga pada purchase order
        $this->purchase_order->update([
            'total_price' => $hitungTotalBayar,
        ]);

        $this->dispatchBrowserEvent('update-success');
        $this->reset();
    }

    public function createGRCode()
    {
        // Membuat kode GR
        $countGR = GoodReceive::count();
        if($countGR == 0) {
            $this->good_receive_code = 'GR.' . 1001;
        } else {
            $getLastGR = GoodReceive::all()->last();
            $convertGR = (int)substr($getLastGR->good_receive_code, -4) + 1;
            $this->good_receive_code = 'GR.' . $convertGR;
        }
    }

    public function printGRN($id)
    {
        // Membuat kode gr
        $this->createGRCode();

        // Memasukkan data ke tabel good receive
        GoodReceive::create([
            'purchase_orders_id' => DetailPo::where('id','=',$id)->first(['purchase_orders_id'])->purchase_orders_id,
            'good_receive_code' => $this->good_receive_code,
            'materials_id' => DetailPo::where('id','=',$id)->first(['materials_id'])->materials_id,
            'qty' => DetailPo::where('id','=',$id)->first(['qty'])->qty,
            'price' => DetailPo::where('id','=',$id)->first(['total_price'])->total_price,
            'print_date' => Carbon::now()->format('Y-m-d'),
            'suppliers_id' => PurchaseOrder::where('id','=',$this->purchase_orders_id)->first(['suppliers_id'])->suppliers_id,
            'status_id' => 1,
            'users_id' => Auth::user()->id,
        ]);

        // Mengupdate status material yang sudah di cetak gr
        DetailPo::where('purchase_orders_id','=',$this->purchase_orders_id)->update([
            'status' => "Sudah Cetak"
        ]);

        PurchaseOrder::where('id','=',$this->purchase_orders_id)->update([
            'status_id' => 2,
        ]);

        $this->dispatchBrowserEvent('update-success');
    }

    public function closeEditPO()
    {
        $this->showingEditPO = false;
    }
    // END --------------------------------

    public function updated($key, $value)
    {
        // Realtime update value set good
        // if($this->name != NULL) {
        //     $this->categories_id = Material::where('name','=',$this->name)->first(['categories_id'])->categories_id;
        //     $this->measurements_id = Material::where('name','=',$this->name)->first(['measurements_id'])->measurements_id;
        // } else {
        //     $this->categories_id = NULL;
        //     $this->measurements_id = NULL;
        // }



        // Realtime update value detail pos ketika insert data
        if($this->materials_id != NULL) {
            // $this->price = Material::where('id','=',$this->materials_id)->first(['price'])->price;
            $this->total_price_m = ($this->qty * $this->price);
        } elseif ($this->materials_id_e != NULL) {
            $this->total_price_e = ($this->qty_e * $this->price_e);
        }
        else {
            // $this->price = NULL;
            $this->total_price_m = NULL;
        }

        // Realtime update value detail pos ketika update data
        // if($this->m_id != NULL) {
        //     $this->m_price = Material::where('id','=',$this->m_id)->first(['price'])->price;
        //     $this->m_total_price = ($this->m_qty * $this->m_price);
        // }
    }
}
