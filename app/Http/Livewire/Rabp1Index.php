<?php

namespace App\Http\Livewire;

use App\Models\BillMaterial;
use App\Models\Contract;
use App\Models\DetailRabp;
use App\Models\Good;
use App\Models\Production;
use App\Models\Quotation;
use App\Models\Rabp;
use App\Models\RabpMaterial;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class Rabp1Index extends Component
{
    use WithPagination;
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'rabp_code';
    public $orderAsc = true;

    public $showingRabp = false;
    public $showingDetail = false;
    public $showingMainPage = true;
    public $showingProduction = false;
    public $showingRevision = false;
    public $showedDetail = false;
    public $isEdited = false;
    
    // Tabel rabps
    public $quotations_id, $rabp_code, $name, $description, $date, $discount, $rabp_value, $status_id, $users_id;
    public $rabp, $rabps_id, $getCustomersId, $listMaterials, $getAllGoodsId;

    // Tabel detail_rabps
    public $goods_id, $qty_b, $price_b, $total_price_b;
    public $good;

    // Tabel productions
    public $production_code;
    
    // Tabel contracts
    public $contract_code;


    public function render()
    {
        return view('livewire.rabp1-index', [
            'rabps' => Rabp::with('quotation','status')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
            'quotations' => Quotation::where('status_id','=',2)->get(),
            'detailrabps' => DetailRabp::where('rabps_id','=',$this->rabps_id)->get(),
            'goods' => Good::where('customers_id','=',$this->getCustomersId)->get(),
            // 'setbillmaterials' => SetBillMaterial::where('set_goods_id','=',$this->getBMId)->get(),
        ])->layout('layouts.admin');
    }

    public function closeModal()
    {
        // Menutup modal 
        $this->showingRabp = false;
        $this->showingDetail = false;
    }

    public function back()
    {
        // Menutup detail page dan menampilkan main page
        $this->showingDetail = false;
        $this->showingMainPage = true;
        $this->showedDetail = false;
    }

    public function createRabpCode() 
    {
        // Membuat kode rabp
        $countRabp = Rabp::count();
        if($countRabp == 0) {
            $this->rabp_code = 'RABP.' . "0" . (Carbon::now()->day) . "." . (Carbon::now()->month) . "." . (Carbon::now()->year) . '.' . 1001;
        } else {
            $getLastRabp = Rabp::all()->last();
            $convertRabp = (int)substr($getLastRabp->rabp_code, -4) + 1;
            $this->rabp_code = 'RABP.' . "0" . (Carbon::now()->day) . "." . (Carbon::now()->month) . "." . (Carbon::now()->year) . '.' . $convertRabp;
        }
    }

    public function showRabp()
    {
        // Menampilkan rabp modal
        $this->reset();
        $this->showingRabp = true;

        $this->createRabpCode();
        $this->date = Carbon::now()->format('Y-m-d');
        $this->description = "Menunggu Review";
    }

    public function storeRabp()
    {
        $this->createRabpCode();

        // Store data rabp
        Rabp::create([
            'quotations_id' => $this->quotations_id,
            'rabp_code' => $this->rabp_code,
            'name' => $this->name,
            'description' => $this->description,
            'date' => $this->date,
            'status_id' => 1,
            'users_id' => Auth::user()->id,
        ]);

        $this->reset();
        $this->closeModal();
        $this->dispatchBrowserEvent('store-success');
    }

    public function recalculate()
    {
        // $getGoodsId = DetailRabp::where('rabps_id','=',$this->rabps_id)->first('goods_id')->goods_id;
        $getGoodsId = DetailRabp::select('goods_id')
                                ->where('rabps_id','=',$this->rabps_id)->exists();
        if ($getGoodsId) {
            DetailRabp::where('goods_id','=',$getGoodsId)->where('is_lock','=', NULL)->update([
                'price' => Good::where('id','=', $getGoodsId)->first('sell_price')->sell_price,
                'total_price' => Good::where('id','=', $getGoodsId)->first('sell_price')->sell_price * DetailRabp::where('rabps_id','=',$this->rabps_id)->first('qty')->qty,
            ]);

            $hitungTotalSemuaBarang = DetailRabp::where('rabps_id','=',$this->rabps_id)->sum('total_price'); //TOTAL SEMUA
            $hitungTotalDiskon = $hitungTotalSemuaBarang * ($this->discount * 0.01); // TOTAL DISKON
            $hitungSetelahDiskon = $hitungTotalSemuaBarang - $hitungTotalDiskon;
            $hitungTotalPPN = $hitungSetelahDiskon * 0.11;
            $hitungRabpValue = $hitungSetelahDiskon + $hitungTotalPPN;

            Rabp::where('id','=',$this->rabps_id)->update([
                'discount' => $this->discount,
                'rabp_value' => $hitungRabpValue,
            ]);
            $this->dispatchBrowserEvent('store-success');
        } else {
            "";
        }
        
    }

    public function showDetail($id)
    {
        $this->showedDetail = true;

        $this->showingDetail = true;
        $this->showingMainPage = false;
        $this->rabps_id = $id;

        // Menampilkan detail data rabp
        $this->rabp = Rabp::findOrFail($id);
        $this->rabp_code = $this->rabp->rabp_code;
        $this->quotations_id = $this->rabp->quotation['name'];
        $this->name = $this->rabp->name;
        $this->description = $this->rabp->description;
        $this->date = $this->rabp->date;
        $this->discount = $this->rabp->discount;
        $this->rabp_value = $this->rabp->rabp_value;
        $this->status_id = $this->rabp->status['name'];
        $this->users_id = $this->rabp->user['name'];

        // Ambil customers_id dari quotation
        $this->getCustomersId = $this->rabp->quotation['customers_id'];
        $this->qty_b = 1;

        // Ambil semua goods_id pada RABP
        $this->getAllGoodsId = DetailRabp::where('rabps_id','=',$this->rabps_id)->pluck('goods_id');

        // Ambil list material sesuai dengan barang yang dipesan
        $this->listMaterials = RabpMaterial::whereIn('goods_id', $this->getAllGoodsId)->orderBy('materials_id', 'asc')->get();

        // Hitung ulang setelah revisi, jika sudah ada item bill materialnya maka akan menghitung ulang kembali
        // if (DetailRabp::where('rabps_id','=',$this->rabps_id)->first('goods_id')->goods_id != NULL) {
            $this->recalculate();
        // } else {
        //     "";
        // }
    }

    public function updateRabp()
    {
        Rabp::where('id','=',$this->rabps_id)->update([
            'discount' => $this->discount,
            'name' => $this->name,
        ]);

        $hitungTotalSemuaBarang = DetailRabp::where('rabps_id','=',$this->rabps_id)->sum('total_price'); //TOTAL SEMUA
        $hitungTotalDiskon = $hitungTotalSemuaBarang * ($this->discount * 0.01); // TOTAL DISKON
        $hitungSetelahDiskon = $hitungTotalSemuaBarang - $hitungTotalDiskon;
        $hitungTotalPPN = $hitungSetelahDiskon * 0.11;
        $hitungRabpValue = $hitungSetelahDiskon + $hitungTotalPPN;

        Rabp::where('id','=',$this->rabps_id)->update([
            'discount' => $this->discount,
            'rabp_value' => $hitungRabpValue,
        ]);

        $this->dispatchBrowserEvent('store-success');
        $this->reset();
    }

    public function storeGood()
    {
        DetailRabp::create([
            'rabps_id' => $this->rabps_id,
            'goods_id' => $this->goods_id,
            'qty' => $this->qty_b,
            'price' => $this->price_b,
            'total_price' => $this->total_price_b,
        ]);

        // Simpan data material yang terpakai
        $data = BillMaterial::where('goods_id','=',$this->goods_id)->get(); 

        foreach ($data as $item) {
            $rabpmaterial = new RabpMaterial();
            $rabpmaterial->rabps_id = $this->rabps_id;
            $rabpmaterial->goods_id = $this->goods_id;
            $rabpmaterial->materials_id = $item['materials_id'];
            $rabpmaterial->qty = $item['qty'] * $this->qty_b;
            $rabpmaterial->price = $item['price'];
            $rabpmaterial->total_price = $item['total_price'] * $this->qty_b;
            $rabpmaterial->qty_received = 0;
            $rabpmaterial->qty_install = 0;
            $rabpmaterial->qty_remaining = 0;
            $rabpmaterial->status = "Belum Diambil";
            $rabpmaterial->save();
        }


        $hitungTotalSemuaBarang = DetailRabp::where('rabps_id','=',$this->rabps_id)->sum('total_price'); //TOTAL SEMUA
        $hitungTotalDiskon = $hitungTotalSemuaBarang * ($this->discount * 0.01); // TOTAL DISKON
        $hitungSetelahDiskon = $hitungTotalSemuaBarang - $hitungTotalDiskon;
        $hitungTotalPPN = $hitungSetelahDiskon * 0.11;
        $hitungRabpValue = $hitungSetelahDiskon + $hitungTotalPPN;

        Rabp::where('id','=',$this->rabps_id)->update([
            'discount' => $this->discount,
            'rabp_value' => $hitungRabpValue,
        ]);

        $this->dispatchBrowserEvent('store-success');
        $this->reset();
    }

    public function editGood($id)
    {
        $this->isEdited = true;

        $this->good = DetailRabp::findOrFail($id);
        $this->goods_id = $this->good->goods_id;
        $this->qty_b = $this->good->qty;
        $this->price_b = $this->good->price;
        $this->total_price_b = $this->good->total_price;
    }

    public function updateGood()
    {
        DetailRabp::where('id','=',$this->good->id)->update([
            'goods_id' => $this->goods_id,
            'qty' => $this->qty_b,
            'price' => $this->price_b,
            'total_price' => $this->total_price_b,
        ]);

        $this->dispatchBrowserEvent('store-success');
        $this->isEdited = false;
    }

    public function closeEdit()
    {
        $this->isEdited = false;
        $this->goods_id = "";
        $this->qty_b = 1;
        $this->price_b = "";
        $this->total_price_b = "";
    }

    // REVISION SECTION
    public function showRevision()
    {
        $this->showingRevision = true;
        $this->description = $this->rabp->description;
    }

    public function storeRevision()
    {
        Rabp::findOrFail($this->rabps_id)->update([
            'status_id' => 2,
            'description' => $this->description,
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('update-success');
    }

    public function closeRevision()
    {
        $this->showingRevision = false;
    }
    // END ---------

    // APPROVAL SECTION 
    public function approve1()
    {
        Rabp::findOrFail($this->rabps_id)->update([
            'status_id' => 2,
            'description' => "Menunggu Deal Penawaran",
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('update-success');
    }

    public function approve2()
    {
        Rabp::findOrFail($this->rabps_id)->update([
            'status_id' => 3,
            'description' => "Siap Produksi",
        ]);

        DetailRabp::where('rabps_id','=',$this->rabps_id)->update([
            'is_lock' => "Yes"
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('update-success');
    }
    // END ---------

    // PRODUCTION & CONTRACT SECTION
    public function showProduction()
    {
        $this->showingProduction = true;
        $this->createProductionCode();
        $this->createContractCode();
    }

    public function createProductionCode()
    {
        // Membuat kode produksi
        $countProduction = Production::count();
        if($countProduction == 0) {
            $this->production_code = 'PROD.' . "0" . (Carbon::now()->day) . "." . (Carbon::now()->month) . "." . (Carbon::now()->year) . '.' . 1001;
        } else {
            $getLastProd = Production::all()->last();
            $convertProd = (int)substr($getLastProd->production_code, -4) + 1;
            $this->production_code = 'PROD.' . "0" . (Carbon::now()->day) . "." . (Carbon::now()->month) . "." . (Carbon::now()->year) . '.' . $convertProd;
        }
    }

    public function createContractCode()
    {
        // Membuat kode kontrak
        $countContract = Contract::count();
        if($countContract == 0) {
            $this->contract_code = 'KONT.' . "0" . (Carbon::now()->day) . "." . (Carbon::now()->month) . "." . (Carbon::now()->year) . '.' . 1001;
        } else {
            $getLastCont = Contract::all()->last();
            $convertCont = (int)substr($getLastCont->contract_code, -4) + 1;
            $this->contract_code = 'KONT.' . "0" . (Carbon::now()->day) . "." . (Carbon::now()->month) . "." . (Carbon::now()->year) . '.' . $convertCont;
        }
    }

    public function closeProduction(){
        $this->showingProduction = false;
    }

    public function storeProduction()
    {
        Production::create([
            'rabps_id' => $this->rabps_id,
            'production_code' => $this->production_code,
            // 'name' => "Produksi" . substr($this->name, 20),
            'name' => "Produksi" . substr($this->name, 4),
            'description' => "Menunggu Produksi",
            'deadline' => $this->date,
            'status_id' => 1,
            'users_id' => Auth::user()->id,
        ]);

        // Mencari total harga barang yang dipesan, menjadi value total kontrak
        $assignContractValue = Rabp::where('id', '=', $this->rabps_id)->first('rabp_value')->rabp_value;

        Contract::create([
            'quotations_id' => $this->rabp->quotation['id'],
            'contract_code' => $this->contract_code,
            'project_code' => "0",
            // 'name' => "Kontrak" . substr($this->name, 20),
            'name' => "Kontrak" . substr($this->name, 4),
            'contract_value' => $assignContractValue,
            'start_date' => Carbon::now()->format('Y-m-d'),
            'finish_date' => $this->date,
            'status_id' => 2,
            'users_id' => Auth::user()->id,
        ]);


        // Update status RABP
        Rabp::where('id','=',$this->rabps_id)->update([
            'description' => "Sedang Produksi",
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('update-success');
    }
    // END ---------

    public function viewPdf()
    {
        // Ambil data penawaran berdasarkan rabps
        $idPenawaran = Rabp::where('id', '=', $this->rabps_id)->first(['quotations_id'])->quotations_id;
        $dataPenawaran = Quotation::where('id', '=', $idPenawaran)->get();

        // Ambil data barang berdasarkan rabps
        $dataBarang = DetailRabp::where('rabps_id', '=', $this->rabps_id)->get();

        // Ambild data biaya berdasarkan rabps
        $dataRabpValue = Rabp::where('id', '=', $this->rabps_id)->get();

        // Ambil jumlah total diskon
        $jumlahDiskon = DetailRabp::where('rabps_id', '=', $this->rabps_id)->sum('total_price') * (Rabp::where('id', '=', $this->rabps_id)->first('discount')->discount * 0.01);

        // Ambil jumlah ppn
        $jumlahPPN = (DetailRabp::where('rabps_id', '=', $this->rabps_id)->sum('total_price') - $jumlahDiskon) * 0.11;

        // Ambil string kode penawaran
        $getFileName = Quotation::where('id', '=', $this->rabp->quotation['id'])->first('quotation_code')->quotation_code;
        
        $pdfContent = FacadePdf::loadView('pdf.penawaran', 
        ['dataPenawaran' => $dataPenawaran, 
        'dataBarang' => $dataBarang, 
        'dataRabpValue' => $dataRabpValue,
        'jumlahDiskon' => $jumlahDiskon,
        'jumlahPPN' => $jumlahPPN,
        ])->output();
        return response()->streamDownload(
        fn () => print($pdfContent),
        "Penawaran." . $getFileName . ".pdf"
        );
    }

    public function updated($key, $value)
    {
        // Realtime update value 
        if ($this->showedDetail != true) {
            if($this->quotations_id != NULL) {
                $this->name = "RABP" . substr(Quotation::where('id','=',$this->quotations_id)->first(['name'])->name, 9);
            } else {
                $this->name = NULL;
            }
        } else {
            "";
        }
        

        // Realtime update value 
        if($this->goods_id != NULL) {
            $this->price_b = Good::where('id','=',$this->goods_id)->first('sell_price')->sell_price;
            $this->total_price_b = $this->qty_b * $this->price_b;
        } 
    }
}
