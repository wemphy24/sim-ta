<?php

namespace App\Http\Livewire;

use App\Models\Contract;
use App\Models\DetailRabp;
use App\Models\Production;
use App\Models\Quotation;
use App\Models\Rabp;
use App\Models\RabpCost;
use App\Models\SetBillMaterial;
use App\Models\SetGood;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\App;

class RabpIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'rabp_code';
    public $orderAsc = true;

    public $showingRabp = false;
    public $showingDetail = false;
    public $showingMainPage = true;
    public $showingDetailGood = false;
    public $showingProduction = false;
    public $showingEditGood = false;
    public $showingRevision = false;

    public $quotations_id, $rabp_code, $name, $description, $date, $status_id, $users_id;
    public $rabp;

    public $rabps_id, $set_goods_id, $qty_bg, $price_bg, $total_price_bg;

    public $overhead, $preliminary, $ppn, $profit,$total_profit, $total_price;

    // Display only total cost
    public $total_ppn, $total_price_production;

    // Display only daftar material barang
    public $billmaterials;

    public $rabp_cost;

    // Display material yang diperlukan untuk barang
    public $getBMId, $good_name, $count_material;

    public $assign_rabpid;

    // Untuk edit detail_rabps (barang)
    public $rabp_id, $s_good_id, $b_qty, $b_price, $b_total_price;
    public $detail_rabp;

    // Untuk assign otomatis ke tabel production
    public $production_code;

    // Untuk assign otomatis ke tabel production
    public $contract_code;

    

    public $test;
    public $listMaterials;

    public function render()
    {
        return view('livewire.rabp-index', [
            'rabps' => Rabp::with('quotation','status')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
            'quotations' => Quotation::where('status_id','=',2)->get(),
            'setgoods' => SetGood::where('quotations_id','=',$this->rabps_id )->get(),
            'detailrabps' => DetailRabp::where('rabps_id','=',$this->rabps_id)->get(),
            'rabpcosts' => RabpCost::all(),
            'setbillmaterials' => SetBillMaterial::where('set_goods_id','=',$this->getBMId)->get(),
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
    }

    public function createRabpCode() 
    {
        // Membuat kode rabp
        $countRabp = Rabp::count();
        if($countRabp == 0) {
            // $this->rabp_code = 'RABP.' . 1001;
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
        $this->ppn = 11;
    }

    public function storeRabp()
    {
        $this->validate([
            'quotations_id' => 'required|integer',
            'name' => 'required|string|max:128',
            'description' => 'string|max:128',
        ],[
        'name.required' => 'Nama wajib diisi',
        ]);

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

        // Mengambil id dari data rabp yang baru di input
        $getId = Rabp::where('quotations_id','=', $this->quotations_id)->first(['id'])->id;

        // Store data rabp_cost
        RabpCost::create([
            'rabps_id' => $getId,
            'overhead' => 0,
            'preliminary' => 0,
            'profit' => 0,
            'ppn' => 11,
            'total_profit' => 0,
            'total_price' => 0,
        ]);

        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('store-success');
    }

    // DETAIL RABP SECTION
    public function showDetail($id)
    {
        // $getGoodName = DetailRabp::where('rabps_id','=', $id)->first('set_goods_id')->set_goods_id;

        
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
        $this->status_id = $this->rabp->status['name'];
        $this->users_id = $this->rabp->user['name'];

        // Menampilkan detail data rabp_cost
        $this->rabp_cost = RabpCost::findOrFail($id);
        $this->overhead = $this->rabp_cost->overhead;
        $this->preliminary = $this->rabp_cost->preliminary;
        $this->profit = $this->rabp_cost->profit;
        $this->ppn = $this->rabp_cost->ppn;
        $this->total_price = $this->rabp_cost->total_price;
        $this->total_profit = $this->rabp_cost->total_profit;

        // $getQtySetGood = SetGood::where('quotations_id','=', $this->rabp->quotations_id)->first('qty')->qty;
        $this->qty_bg = 1;
        
        // Display data total cost barang
        // if(DetailRabp::where('rabps_id','=',$this->rabps_id)->first(['price'])->price == NULL) {
        //     $this->total_price_production = 0;
        // } else {
        //     $this->total_price_production = ((DetailRabp::where('rabps_id','=',$this->rabps_id)->first(['price'])->price) + $this->preliminary + $this->overhead); //////////////
        // }

        // $this->total_price_production = ((DetailRabp::where('rabps_id','=',$this->rabps_id)->first(['price'])->price) + $this->preliminary + $this->overhead); ////////////// ----
        $this->total_ppn = ($this->total_price_production + $this->total_profit) * (0.11);

        // Display data daftar material dari barang
        // $this->billmaterials = SetBillMaterial::where('set_goods_id', $this->rabps_id)->get();

        // $test = (DetailRabp::where('rabps_id','=',$this->rabps_id)->pluck('set_goods_id')->toArray()); -----
        // $test = (DetailRabp::where('rabps_id','=',$this->rabps_id)->pluck('set_goods_id'));
        // dd($test);


        // $haha = SetBillMaterial::whereIn('set_goods_id','=', [$test])->get();
        // dd($haha);

        // AMBIL DATA SET GOODS ID
        $this->test = DetailRabp::where('rabps_id','=',$this->rabps_id)->pluck('set_goods_id');

        $this->listMaterials = SetBillMaterial::whereIn('set_goods_id', $this->test)->orderBy('materials_id', 'asc')->get();

        
        // dd($mbud);

        
        // foreach($se as $t) {

        //    $this->test =  $t->set_goods_id;
        //    dd($this->test);
        //    $this->test = SetBillMaterial::whereIn('set_goods_id', $set)->get();
        //    foreach($ber as $b) {
        //     $mbud = $b
        //    }
        // pake groupby
        
        // }
        // dd($this->test);
        // dd($se);

        // dd($test);
        // $this->billmaterials = SetBillMaterial::whereIn('set_goods_id', $test)->orderBy('set_goods_id', 'asc')->get(); -----
        // dd($this->billmaterials);
        // $this->billmaterials = SetBillMaterial::where('set_goods_id', 2)->get();

        // $tes = DetailRabp::where('rabps_id','=',2)->orWhere('set_goods_id','=',2)->first(['qty'])->qty;
        // dd($tes);


        // dd($test[1]->price);
        // for($i = 0;$i < count($test);$i++) {
        //     $mek = $test[$i]->price;
        // }
        // dd($mek);
        // dd($test);
        // dd(explode(',',$test[0]->price));
        // foreach($test as $t => $p) {
        //     ($p->price);
        // }

        // Menghitung ulang total harga barang
        $this->updateProfitPrice();
    }
    // END ---------

    public function updateRabp()
    {
        $this->validate([
            'name' => 'required|string|max:128',
            'description' => 'string|max:128',
        ]);
        
        // Mengupdate data rabp
        $this->rabp->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        // $this->back();
        $this->dispatchBrowserEvent('update-success');
    }

    // COST SECTION
    public function updateCost()
    {
        $this->validate([
            'overhead' => 'required|integer',
            'preliminary' => 'required|integer',
            'profit' => 'required|integer',

            'total_profit' => 'required|integer',
            'total_price' => 'required|integer',
        ]);

        // Mengupdate data rabp cost
        RabpCost::findOrFail($this->rabps_id)->update([
            'overhead' => $this->overhead,
            'preliminary' => $this->preliminary,
            'profit' => $this->profit,
        ]);

        // Hitung harga barang + overhead + preliminary
        $countOverPrelim = DetailRabp::where('rabps_id','=', $this->rabps_id)->sum('price') + $this->overhead + $this->preliminary; 
        $countTotalProfit = $countOverPrelim * ($this->profit * 0.01);
        $countTotalTax = ($countOverPrelim + $countTotalProfit) * ($this->ppn * 0.01);

        // Update total harga seluruh barang
        RabpCost::findOrFail($this->rabps_id)->update([
            'total_profit' => $countTotalProfit,
            'total_price' => $countOverPrelim + $countTotalProfit + $countTotalTax,
        ]);

        // Hitung ulang total harga dan total profit setelah di update
        $this->total_price = RabpCost::where('id','=',$this->rabps_id)->first(['total_price'])->total_price;
        $this->total_profit = RabpCost::where('id','=',$this->rabps_id)->first(['total_profit'])->total_profit;

        $this->dispatchBrowserEvent('update-success');
    }
    // END ---------
    
    // GOOD SECTION
    public function storeGood()
    {
        // PERBAIKI DENGAN DIKALI QUANTITY
        $this->validate([
            'set_goods_id' => 'required|integer',
            'qty_bg' => 'required|integer',
            'price_bg' => 'required|integer',

            'total_profit' => 'required|integer',
            'total_price' => 'required|integer',
        ]);

        // Menambah barang yang di order
        DetailRabp::create([
            'rabps_id' => $this->rabps_id,
            'set_goods_id' => $this->set_goods_id,
            'qty' => $this->qty_bg,
            'price' => $this->price_bg,
        ]);


        // Caranya
        // $getUserId = DB::table('users')->insertGetId([
        //                     'name' => $this->name,
        //                     'email' => $this->email,
        //                     'password' => Hash::make("haha123"),
        //                 ]);



        // Update quantity per set
        // SetBillMaterial::where('')


        // Hitung harga barang + overhead + preliminary
        $countOverPrelim = DetailRabp::where('rabps_id','=', $this->rabps_id)->sum('price') + $this->overhead + $this->preliminary; 
        $countTotalProfit = $countOverPrelim * ($this->profit * 0.01);
        $countTotalTax = ($countOverPrelim + $countTotalProfit) * ($this->ppn * 0.01);

        // Update total harga seluruh barang
        RabpCost::findOrFail($this->rabps_id)->update([
            'total_profit' => $countTotalProfit,
            'total_price' => $countOverPrelim + $countTotalProfit + $countTotalTax,
        ]);

        // Reset form tambah barang
        $this->set_goods_id = NULL;
        $this->qty_bg = 1;
        $this->price_bg = NULL;
        $this->total_price_bg = NULL;

        // Reset total harga dan total profit
        $this->total_price = RabpCost::where('id','=',$this->rabps_id)->first(['total_price'])->total_price;
        $this->total_profit = RabpCost::where('id','=',$this->rabps_id)->first(['total_profit'])->total_profit;

        $this->total_ppn = (DetailRabp::where('rabps_id','=',$this->rabps_id)->first(['price'])->price + $this->total_profit) * (0.11);

        $this->reset();
        $this->dispatchBrowserEvent('store-success');
    }

    public function editSetGood($id)
    {
        // Menampilkan modal edit barang
        $this->showingEditGood = true;

        $this->detail_rabp = DetailRabp::findOrFail($id);
        $this->s_good_id = $this->detail_rabp->set_goods_id;
        $this->b_qty = $this->detail_rabp->qty;
        $this->b_price = $this->detail_rabp->price;
        $this->b_total_price = $this->detail_rabp->price * $this->b_qty;
    }

    public function updateSetGood()
    {
        // Mengupdate data detail rabp
        $this->detail_rabp->update([
            'rabps_id' => $this->rabps_id,
            'set_goods_id' => $this->s_good_id,
            'qty' => $this->b_qty,
            'price' => $this->b_price,
        ]);

        // Hitung harga barang + overhead + preliminary
        $countOverPrelim = DetailRabp::where('rabps_id','=', $this->rabps_id)->sum('price') + $this->overhead + $this->preliminary; 
        $countTotalProfit = $countOverPrelim * ($this->profit * 0.01);
        $countTotalTax = ($countOverPrelim + $countTotalProfit) * ($this->ppn * 0.01);

        // Update total harga seluruh barang
        RabpCost::findOrFail($this->rabps_id)->update([
            'total_profit' => $countTotalProfit,
            'total_price' => $countOverPrelim + $countTotalProfit + $countTotalTax,
        ]);

        // Hitung ulang display total cost
        $this->total_price_production = ((DetailRabp::where('rabps_id','=',$this->rabps_id)->first(['price'])->price) + $this->preliminary + $this->overhead);
        $this->total_profit = $countOverPrelim * ($this->profit * 0.01);
        $this->total_ppn = ($countOverPrelim + $countTotalProfit) * ($this->ppn * 0.01);
        $this->total_price = RabpCost::where('rabps_id', '=', $this->rabps_id)->first('total_price')->total_price;

        $this->dispatchBrowserEvent('update-success');
        $this->closeEdit();
    }

    public function closeEdit()
    {
        // Menutup modal edit barang
        $this->showingEditGood = false;
    }

    public function detailGood($id)
    {
        $this->showingDetailGood = true;
        $this->getBMId = $id;
        $this->good_name = SetGood::where('id','=',$id)->first(['name'])->name;
        $this->count_material = DetailRabp::where('rabps_id','=',$this->rabps_id)->orWhere('set_goods_id','=',$this->getBMId)->first(['qty'])->qty;
    }
    // END ---------


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
    // public function approvee($id)
    // {
    //     Rabp::findOrFail($id)->update([
    //         'status_id' => 2,
    //         'description' => "Menunggu Deal Penawaran",
    //     ]);

    //     $this->reset();
    //     $this->dispatchBrowserEvent('update-success');
    // }

    public function approve1()
    {
        Rabp::findOrFail($this->rabps_id)->update([
            'status_id' => 2,
            'description' => "Menunggu Deal Penawaran",
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('update-success');
    }

    public function approvee2($id)
    {
        Rabp::findOrFail($id)->update([
            'status_id' => 3,
            'description' => "Siap Produksi",
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
            // $this->contract_code = 'KONT.' . 1001;
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
            'name' => "Produksi" . substr($this->name, 20),
            'description' => "Menunggu Produksi",
            'deadline' => $this->date,
            'status_id' => 1,
            'users_id' => Auth::user()->id,
        ]);

        // Mencari total harga barang yang dipesan, menjadi value total kontrak
        $assignContractValue = RabpCost::where('rabps_id', '=', $this->rabps_id)->first(['total_price'])->total_price;

        Contract::create([
            'quotations_id' => $this->rabp->quotation['id'],
            'contract_code' => $this->contract_code,
            'project_code' => "0",
            'name' => "Kontrak" . substr($this->name, 20),
            'contract_value' => $assignContractValue,
            'start_date' => Carbon::now()->format('Y-m-d'),
            'finish_date' => $this->date,
            'status_id' => 2,
            'users_id' => Auth::user()->id,
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('update-success');
    }
    // END ---------

    public function closeDetailGood()
    {
        $this->showingDetailGood = false;
    }

    public function updated($key, $value)
    {
        // Realtime update value set good ketika insert data
        if($this->set_goods_id != NULL) {
            $this->price_bg = SetGood::where('id','=',$this->set_goods_id)->first(['price'])->price;
            $this->total_price_bg = ($this->qty_bg * $this->price_bg);
        } else {
            $this->price_bg = NULL;
            $this->total_price_bg = NULL;
        }

        // Realtime update value detail rabp ketika update data
        if($this->s_good_id != NULL) {
            $this->b_price = SetGood::where('id','=',$this->s_good_id)->first(['price'])->price;
            $this->b_total_price = ($this->b_qty * $this->b_price);
        }

        // if($this->quotations_id !=NULL) {
        //     $this->name = "RABP " . Quotation::where('id','=',$this->quotations_id)->first('name')->name;
        // } else {
        //     $this->name = NULL;
        // }
    }

    public function updateProfitPrice()
    {
        $countOverPrelim = DetailRabp::where('rabps_id','=', $this->rabps_id)->sum('price') + $this->overhead + $this->preliminary; 
        $countTotalProfit = $countOverPrelim * ($this->profit * 0.01);
        $countTotalTax = ($countOverPrelim + $countTotalProfit) * ($this->ppn * 0.01);

        // Update total harga seluruh barang
        RabpCost::findOrFail($this->rabps_id)->update([
            'total_profit' => $countTotalProfit,
            'total_price' => $countOverPrelim + $countTotalProfit + $countTotalTax,
        ]);

        // Reset total harga dan total profit
        $this->total_price = RabpCost::where('id','=',$this->rabps_id)->first(['total_price'])->total_price;
        $this->total_profit = RabpCost::where('id','=',$this->rabps_id)->first(['total_profit'])->total_profit;
        $this->dispatchBrowserEvent('store-success');
    }

    // public function getReview()
    // {
    //     $this->rabp->update([
    //         'status_id' => 2,
    //     ]);

    //     $this->back();
    //     $this->dispatchBrowserEvent('update-success');
    // }

    public function printPdf($id)
    {
        // Ambil data nama barang berdasarkan set goods
        $namaBarang = DetailRabp::where('rabps_id','=',$this->rabps_id)->where('set_goods_id','=',$id)->get();

        // Ambil data material berdasarkan barang
        $dataMaterial = SetBillMaterial::where('set_goods_id', '=', $id)->get();

        $pdfContent = FacadePdf::loadView('pdf.material-penawaran', ['namaBarang' => $namaBarang, 'dataMaterial' => $dataMaterial])->output();
        return response()->streamDownload(
        fn () => print($pdfContent),
        "filename.pdf"
        );
    }

    public function viewPdf()
    {
        
        // Untuk mendownload file pdf
        // return response()->streamDownload(function () {
        //     $pdf = App::make('dompdf.wrapper');
        //     $pdf->loadView('pdf.penawaran');
        //     echo $pdf->stream();
        // }, 'pen.pdf');

        // Ambil data penawaran berdasarkan rabps
        $idPenawaran = Rabp::where('id', '=', $this->rabps_id)->first(['quotations_id'])->quotations_id;
        $dataPenawaran = Quotation::where('id', '=', $idPenawaran)->get();

        // Ambil data barang berdasarkan rabps
        $dataBarang = DetailRabp::where('rabps_id', '=', $this->rabps_id)->get();

        // Ambild data biaya berdasarkan rabps
        $dataBiaya = RabpCost::where('rabps_id', '=', $this->rabps_id)->get();

        // 
        $getFileName = Quotation::where('id', '=', $this->rabp->quotation['id'])->first('quotation_code')->quotation_code;
        
        $pdfContent = FacadePdf::loadView('pdf.penawaran', ['dataPenawaran' => $dataPenawaran, 'dataBarang' => $dataBarang, 'dataBiaya' => $dataBiaya])->output();
        return response()->streamDownload(
        fn () => print($pdfContent),
        "Penawaran." . $getFileName . ".pdf"
        );
        
    }
}
