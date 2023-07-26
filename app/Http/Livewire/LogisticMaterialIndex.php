<?php

namespace App\Http\Livewire;

use App\Models\Good;
use App\Models\LogisticMaterial;
use App\Models\Material;
use App\Models\PurchaseRequest;
use App\Models\RabpMaterial;
use App\Models\SetBillMaterial;
use App\Models\SetGood;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class LogisticMaterialIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'logistic_code';
    public $orderAsc = true;

    public $showingMainPage = true;
    public $showingDetail = false;

    // Assign ke tabel purchase request
    public $purchase_request_code;
    
    public function render()
    {
        return view('livewire.logistic-material-index', [
            'logistics' => LogisticMaterial::with('good','status')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
        ])->layout('layouts.admin');
    }

    public function back()
    {
        // Menutup detail page dan menampilkan main page
        $this->showingDetail = false;
        $this->showingMainPage = true;
    }

    public function store()
    {

    }

    public function createPRCode()
    {
        // Membuat kode PR
        $countPR = PurchaseRequest::count();
        if($countPR == 0) {
            $this->purchase_request_code = 'PR.' . 1001;
        } else {
            $getLastPR = PurchaseRequest::all()->last();
            $convertPR = (int)substr($getLastPR->purchase_request_code, -4) + 1;
            $this->purchase_request_code = 'LOGI.' . $convertPR;
        }
    }

    public function approve($id)
    {
        // Mengambil id material
        $getMaterialId = LogisticMaterial::where('id', '=', $id)->first('materials_id')->materials_id; // 1
        $getGoodsId = LogisticMaterial::where('id', '=', $id)->first('goods_id')->goods_id; // 5

        // Menambah data set bill material setelah di approve oleh logistik
        RabpMaterial::where('goods_id', '=', $getGoodsId)->where('materials_id', '=', $getMaterialId)->update([ // SALAH !!!!
            'qty_received' => LogisticMaterial::where('id', '=', $id)->first('qty_ask')->qty_ask, // SALAH !!!! --- //5
            'status' => "Sudah Diambil",
        ]);

        // Update status logistic material
        LogisticMaterial::where('id', '=', $id)->update([
            'status_id' => 3,
            'qty_stock' => (LogisticMaterial::where('id', '=', $id)->where('materials_id', '=', $getMaterialId)->first('qty_stock')->qty_stock) - (LogisticMaterial::where('id', '=', $id)->where('materials_id', '=', $getMaterialId)->first('qty_ask')->qty_ask),
        ]);

        // Mengurangi stok pada master data
        Material::where('id', '=', $getMaterialId)->update([
            'stock' => (Material::where('id', '=', $getMaterialId)->first('stock')->stock) - (LogisticMaterial::where('id', '=', $id)->where('materials_id', '=', $getMaterialId)->first('qty_ask')->qty_ask),
        ]);

        // Melakukan cek jika stok material sudah mencapai minimum pr_status akan "Menunggu"
        $minStockMaterial = Material::where('id','=',$getMaterialId)->first('min_stock')->min_stock;
        $stockMaterial = Material::where('id','=',$getMaterialId)->first('stock')->stock;

        if($stockMaterial <= $minStockMaterial)
        {
            Material::where('id', '=', $getMaterialId)->update([
                'pr_status' => "Menunggu",
            ]);
        }

        $this->dispatchBrowserEvent('store-success');
    }

    public function approveBarang($id) //SALAH !!!! ---
    {
        // Mengambil id material
        // $getMaterialId = LogisticMaterial::where('id', '=', $id)->first('materials_id')->materials_id;
        $getGoodId = LogisticMaterial::where('id', '=', $id)->first('goods_id')->goods_id; //5

        // Update status logistic material
        LogisticMaterial::where('id', '=', $id)->update([
            'status_id' => 3,
            'qty_stock' => (Good::where('id', '=', $getGoodId)->first('stock')->stock) - (LogisticMaterial::where('id', '=', $id)->where('goods_id', '=', $getGoodId)->first('qty_ask')->qty_ask),
        ]);

        // Mengurangi stok pada master data
        // Material::where('id', '=', $getMaterialId)->update([
        //     'stock' => (Material::where('id', '=', $getMaterialId)->first('stock')->stock) - (LogisticMaterial::where('materials_id', '=', $getMaterialId)->first('qty_ask')->qty_ask),
        // ]);

        // Mengurangi stok pada master data
        Good::where('id', '=', $getGoodId)->update([
            'stock' => (Good::where('id', '=', $getGoodId)->first('stock')->stock) - (LogisticMaterial::where('id', '=', $id)->where('goods_id', '=', $getGoodId)->first('qty_ask')->qty_ask),
        ]);

        Good::where('id','=',$getGoodId)->update([
            'status_delivery' => "Sedang Dikirim"
        ]);

        $this->dispatchBrowserEvent('store-success');
    }

    // public function approveGR($id)
    // {
    //     // Mengambil id material
    //     $getMaterialId = LogisticMaterial::where('id', '=', $id)->first('materials_id')->materials_id;

    //     // Mengupdate data material karena telah menerima material dari approve GR
    //     Material::where('id', '=', $getMaterialId)->update([
    //         'stock' => LogisticMaterial::where('materials_id', '=', $getMaterialId)->first('qty_stock')->qty_stock + LogisticMaterial::where('materials_id', '=', $getMaterialId)->first('qty_ask')->qty_ask,
    //     ]);

    //     // Update status logistic material
    //     LogisticMaterial::where('id', '=', $id)->update([
    //         'status_id' => 3
    //     ]);

    //     $this->dispatchBrowserEvent('store-success');
    // }

    public function requestPR($id)
    {
        $this->createPRCode();

        PurchaseRequest::create([
            // 'productions_id' => $this->productions_id, /////////////
            'purchase_request_code' => $this->purchase_request_code,
            'materials_id' => LogisticMaterial::where('id', '=', $id)->first('materials_id')->materials_id,
            'qty_ask' => LogisticMaterial::where('id', '=', $id)->first('qty_ask')->qty_ask,
            'description' => "Request Pembelian",
            'deadline' => $this->deadline,
            'categories_id' => LogisticMaterial::where('id', '=', $id)->first('categories_id')->categories_id,
            'measurements_id' => LogisticMaterial::where('id', '=', $id)->first('measurements_id')->measurements_id,
            'status_id' => 1,
            'users_id' => Auth::user()->id,
        ]);
    }

    // DETAILS SECTION --------------------------------
    // public function detail($id)
    // {
    //     Menampilkan detail page
    //     $this->showingDetail = true;
    //     $this->showingMainPage = false;

    //     $this->contract = Contract::findOrFail($id);
    //     $this->contract_code = $this->contract->contract_code;
    //     $this->name = $this->contract->name;
    //     $this->quotations_id = $this->contract->quotation['id'];
    //     $this->contract_value = $this->contract->contract_value;
    //     $this->start_date = $this->contract->start_date;
    //     $this->finish_date = $this->contract->finish_date;
    //     $this->status_id = $this->contract->status['name'];
    //     $this->total_price = RabpCost::where('rabps_id', '=', $this->quotations_id)->first('total_price')->total_price;
    // }
    // END --------------------------------
}
