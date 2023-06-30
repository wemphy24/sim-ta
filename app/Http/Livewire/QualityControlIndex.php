<?php

namespace App\Http\Livewire;

use App\Models\DetailRabp;
use App\Models\LogisticGood;
use App\Models\LogisticMaterial;
use App\Models\Material;
use App\Models\Production;
use App\Models\QualityControl;
use App\Models\Retur;
use App\Models\SetBillMaterial;
use App\Models\SetGood;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class QualityControlIndex extends Component
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

    // Tabel quality control
    public $quality_controls_id, $rabps_id, $quality_control_code, $name, $description, $start_qc, $end_qc, $status_id, $users_id;

    public $quality;

    // Tabel set bill material
    public $getBMId, $good_name, $count_material, $qty_received, $qty_install, $qty_remaining, $getEditBMId;

    // Assign ke tabel retur
    public $retur_code;

    // Assign ke tabel logistic good
    public $logistic_good_code;

    public $productions_id;
    
    public function render()
    {
        return view('livewire.quality-control-index', [
            'qualitycontrols' => QualityControl::with('production','status')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
            'detailrabps' => DetailRabp::where('rabps_id','=',$this->rabps_id)->get(),
            'setbillmaterials' => SetBillMaterial::where('set_goods_id','=',$this->getBMId)->get(),
            'editsetbillmaterials' => SetBillMaterial::where('id','=',$this->getEditBMId)->get(),
            'productions' => Production::all(),
        ])->layout('layouts.admin');
    }

    public function back()
    {
        // Menutup detail page dan menampilkan main page
        $this->showingDetail = false;
        $this->showingMainPage = true;
    }

    public function detail($id)
    {
        // Menampilkan detail page
        $this->showingDetail = true;
        $this->showingMainPage = false;

        // Assign id produksi
        $this->quality_controls_id = $id;

        // Menampilkan detail data produksi
        $this->quality = QualityControl::findOrFail($id);
        $this->rabps_id = $this->quality->rabp['id'];
        $this->productions_id = $this->quality->productions_id;
        $this->quality_control_code = $this->quality->quality_control_code;
        $this->name = $this->quality->name;
        $this->description = $this->quality->description;
        $this->start_qc = $this->quality->start_qc;
        $this->end_qc = $this->quality->end_qc;
        $this->status_id = $this->quality->status['name'];
        $this->users_id = $this->quality->users_id;
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

    public function changeStatus($id)
    {
        SetGood::where('id','=',$id)->update(
            [
                'status' => "Sedang QC",
            ]
        );

        QualityControl::where('id','=',$this->quality_controls_id)->update(
            [
                'status_id' => 2,
            ]
        );
        $this->dispatchBrowserEvent('store-success');
    }

    public function createReturCode()
    {
        // Membuat kode retur
        $countRetur = Retur::count();
        if($countRetur == 0) {
            $this->retur_code = 'RETUR.' . 1001;
        } else {
            $getLastRetur = Retur::all()->last();
            $convertRetur = (int)substr($getLastRetur->logistic_code, -4) + 1;
            $this->retur_code = 'RETUR.' . $convertRetur;
        }
    }

    public function printRetur($id)
    {
        $this->createReturCode();

        Retur::create([
            'set_goods_id' => SetBillMaterial::where('id','=',$id)->first('set_goods_id')->set_goods_id,
            'retur_code' => $this->retur_code,
            'materials_id' => SetBillMaterial::where('id','=',$id)->first('materials_id')->materials_id,
            'qty' => SetBillMaterial::where('id','=',$id)->first('qty_remaining')->qty_remaining,
            'price' => SetBillMaterial::where('id','=',$id)->first('price')->price,
            'retur_date' => Carbon::now()->format('Y-m-d'),
            'status_id' => 1,
            'users_id' => Auth::user()->id,
        ]); 

        SetBillMaterial::where('id','=',$id)->update([
            'status' => "Sedang Retur",
        ]);

        $this->dispatchBrowserEvent('store-success');
        $this->closeDetailMaterial();
    }

    public function createLogisticCode()
    {
        // Membuat kode logistik good
        $countLogistic = LogisticMaterial::count();
        if($countLogistic == 0) {
            $this->logistic_good_code = 'LOG.BARANG.' . 1001;
        } else {
            $getLastLog = LogisticMaterial::all()->last();
            $convertLog = (int)substr($getLastLog->logistic_code, -4) + 1;
            $this->logistic_good_code = 'LOG.BARANG.' . $convertLog;
        }
    }

    public function doneRetur($id)
    {
        $this->createLogisticCode();

        $getMaterialName = SetGood::where('id','=',$id)->first('name')->name;
        $getMaterialId = Material::where('name','=',$getMaterialName)->first('id')->id;

        // dd(SetGood::where('name', '=', $getMaterialName)->first('price')->price);

        SetGood::where('id','=',$id)->update([
            'status' => "Selesai QC"
        ]);

        QualityControl::where('id','=', $this->quality_controls_id,)->update([
            'end_qc' => Carbon::now()->format('Y-m-d'),
            'status_id' => 3,
        ]);

        LogisticGood::create([
            'set_goods_id' => $id,
            'logistic_good_code' => $this->logistic_good_code,
            'materials_id' => $getMaterialId,
            'qty_ask' => SetGood::where('name', '=', $getMaterialName)->first('qty')->qty,
            'qty_stock' => Material::where('id', '=', $getMaterialId)->first('stock')->stock,
            'price' => SetGood::where('name', '=', $getMaterialName)->first('price')->price,
            'type' => "Barang Masuk",
            'categories_id' => Material::where('id', '=', $getMaterialId)->first('categories_id')->categories_id,
            'measurements_id' => Material::where('id', '=', $getMaterialId)->first('measurements_id')->measurements_id,
            'status_id' => 1,
            'users_id' => Auth::user()->id,
        ]);

        Production::where('id', '=', $this->productions_id)->update([
            'status_id' => 3,
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('store-success');
    }
}
