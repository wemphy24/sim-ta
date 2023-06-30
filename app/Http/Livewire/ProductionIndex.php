<?php

namespace App\Http\Livewire;

use App\Models\DetailRabp;
use App\Models\LogisticMaterial;
use App\Models\Material;
use App\Models\Production;
use App\Models\QualityControl;
use App\Models\Rabp;
use App\Models\SetBillMaterial;
use App\Models\SetGood;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ProductionIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'name';
    public $orderAsc = true;

    public $showingMainPage = true;
    public $showingDetail = false;
    public $showingDetailMaterial = false;
    public $showingEditDetailMaterial = false;
    

    // Tabel production
    public $productions_id, $rabps_id, $production_code, $name, $description, $deadline, $status_id, $users_id;

    public $production;

    // Tabel set bill material
    public $getBMId, $good_name, $count_material, $qty_received, $qty_install, $qty_remaining, $getEditBMId;

    // Assign ke tabel logistic material
    public $logistic_code;

    // Assign ke tabel quality control
    public $quality_code;

    public function render()
    {
        return view('livewire.production-index', [
            'productions' => Production::with('rabp','status')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
            'detailrabps' => DetailRabp::where('rabps_id','=',$this->rabps_id)->get(),
            'rabps' => Rabp::all(),
            'setbillmaterials' => SetBillMaterial::where('set_goods_id','=',$this->getBMId)->get(),
            'editsetbillmaterials' => SetBillMaterial::where('id','=',$this->getEditBMId)->get(),
        ])->layout('layouts.admin');
    }

    public function back()
    {
        // Menutup detail page dan menampilkan main page
        $this->showingDetail = false;
        $this->showingMainPage = true;
    }

    // DETAILS SECTION --------------------------------
    public function detail($id)
    {
        // Menampilkan detail page
        $this->showingDetail = true;
        $this->showingMainPage = false;

        // Assign id produksi
        $this->productions_id = $id;

        // Menampilkan detail data produksi
        $this->production = Production::findOrFail($id);
        $this->rabps_id = $this->production->rabp['id'];
        $this->production_code = $this->production->production_code;
        $this->name = $this->production->name;
        $this->description = $this->production->description;
        $this->deadline = $this->production->deadline;
        $this->status_id = $this->production->status['name'];
        $this->users_id = $this->production->users_id;
    }

    public function detailMaterial($id)
    {
        // Menampilkan modal detail material
        $this->showingDetailMaterial = true;
        $this->getBMId = $id;
        $this->good_name = SetGood::where('id','=',$id)->first(['name'])->name;
        $this->count_material = DetailRabp::where('rabps_id','=',$this->rabps_id)->orWhere('set_goods_id','=',$this->getBMId)->first(['qty'])->qty;
    }

    public function closeDetailMaterial()
    {
        // Menutup modal detail material
        $this->showingDetailMaterial = false;
    }

    public function changeProgress($id)
    {
        SetGood::where('id','=',$id)->update(
            [
                'status' => "Sedang Dirakit",
            ]
        );

        Production::where('id','=',$this->productions_id)->update(
            [
                'status_id' => 2,
            ]
        );
        $this->dispatchBrowserEvent('store-success');
    }

    public function editProgress($id)
    {
        // Menampilkan modal edit progress
        $this->showingDetailMaterial = false;
        $this->showingEditDetailMaterial = true;

        $this->getEditBMId = $id;
        $this->qty_received = SetBillMaterial::where('id', '=', $id)->first('qty_received')->qty_received;
        $this->qty_install = SetBillMaterial::where('id', '=', $id)->first('qty_install')->qty_install;
        $this->qty_remaining = SetBillMaterial::where('id', '=', $id)->first('qty_remaining')->qty_remaining;
    }

    public function storeEditProgress()
    {
        // Menyimpan data perubahan progress
        SetBillMaterial::findOrFail($this->getEditBMId)->update([
            'qty_received' => $this->qty_received,
            'qty_install' => $this->qty_install,
            'qty_remaining' => $this->qty_remaining,
        ]);

        $this->dispatchBrowserEvent('store-success');
        $this->showingEditDetailMaterial = false;
    }

    public function createLogisticCode()
    {
        // Membuat kode logistik
        $countLogistic = LogisticMaterial::count();
        if($countLogistic == 0) {
            $this->logistic_code = 'LOGI.' . 1001;
        } else {
            $getLastLog = LogisticMaterial::all()->last();
            $convertLog = (int)substr($getLastLog->logistic_code, -4) + 1;
            $this->logistic_code = 'LOGI.' . $convertLog;
        }
    }

    public function printMaterial($id)
    {
        $this->createLogisticCode();
        
        // Meminta material yang untuk produksi
        LogisticMaterial::create([
            'set_goods_id' => $this->getBMId,
            'logistic_code' => $this->logistic_code,
            'materials_id' => Material::where('id', '=', $id)->first('id')->id,
            'qty_ask' => SetBillMaterial::where('materials_id', '=', $id)->first('qty')->qty,
            'qty_stock' => Material::where('id', '=', $id)->first('stock')->stock,
            'price' => Material::where('id', '=', $id)->first('price')->price,
            'type' => "Material Keluar",
            'categories_id' => Material::where('id', '=', $id)->first('categories_id')->categories_id,
            'measurements_id' => Material::where('id', '=', $id)->first('measurements_id')->measurements_id,
            'status_id' => 1,
            'users_id' => Auth::user()->id,
        ]);

        SetBillMaterial::where('materials_id', '=', $id)->update([
            'status' => "Sedang Diambil",
        ]);

        $this->dispatchBrowserEvent('store-success');
        $this->closeEditProgress();
    }

    public function doneProduction($id)
    {
        SetGood::where('id','=',$id)->update(
            [
                'status' => "Selesai Dirakit",
            ]
        );

        $this->dispatchBrowserEvent('store-success');
    }

    public function createQCCode()
    {
        // Membuat kode kontrak
        $countQuality = QualityControl::count();
        if($countQuality == 0) {
            $this->quality_code = 'QC.' . 1001;
        } else {
            $getLastQuality = QualityControl::all()->last();
            $convertQuality = (int)substr($getLastQuality->quality_code, -4) + 1;
            $this->quality_code = 'QC.' . $convertQuality;
        }
    }

    public function startQC($id)
    {
        $this->createQCCode();

        QualityControl::create([
            'productions_id' => Production::where('rabps_id','=',$this->rabps_id)->first('id')->id,
            'rabps_id' => $this->rabps_id,
            'quality_control_code' => $this->quality_code,
            'name' => "Quality Control " . substr($this->name, 9),
            'description' => "Menunggu QC",
            'start_qc' => Carbon::now()->format('Y-m-d'),
            'end_qc' => NULL,
            'status_id' => 1,
            'users_id' => Auth::user()->id,
        ]);

        SetGood::where('id','=',$id)->update(
            [
                'status' => "Selesai Produksi",
            ]
        );

        $this->dispatchBrowserEvent('store-success');
    }

    public function closeEditProgress()
    {
        // Menutup modal edit progress
        $this->showingDetailMaterial = false;
        $this->showingEditDetailMaterial = false;
    }
    // END --------------------------------

    public function updateProduction()
    {
        $this->production->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('store-success');
    }

    public function updated($key, $value) 
    {
        
    }
}
