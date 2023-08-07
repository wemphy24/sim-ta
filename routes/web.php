<?php

use App\Http\Livewire\LoginIndex;

use App\Http\Livewire\DashboardIndex;
use App\Http\Livewire\QuotationIndex;
use App\Http\Livewire\RabpIndex;
use App\Http\Livewire\InquiryIndex;

use App\Http\Livewire\CategoryIndex;
use App\Http\Livewire\ContractIndex;
use App\Http\Livewire\MeasurementIndex;
use App\Http\Livewire\MaterialIndex;
use App\Http\Livewire\CustomerIndex;
use App\Http\Livewire\DeliveryIndex;
use App\Http\Livewire\DetailSetGoodIndex;
use App\Http\Livewire\GoodIndex;
use App\Http\Livewire\GoodReceiveIndex;
use App\Http\Livewire\LogisticGoodIndex;
use App\Http\Livewire\LogisticMaterialIndex;
use App\Http\Livewire\MachineIndex;
use App\Http\Livewire\PlanningCostIndex;
use App\Http\Livewire\ProductionIndex;
use App\Http\Livewire\PurchaseOrderIndex;
use App\Http\Livewire\PurchaseRequestIndex;
use App\Http\Livewire\QualityControlIndex;
use App\Http\Livewire\Rabp1Index;
use App\Http\Livewire\ReturIndex;
use App\Http\Livewire\SetGoodIndex;
use App\Http\Livewire\SupplierIndex;
use App\Http\Livewire\UserDetailIndex;
use App\Models\DetailUser;
use App\Models\QualityControl;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LoginIndex::class, 'render']);

Route::group(['middleware' => ['auth:sanctum',config('jetstream.auth_session'), 'verified']], function() {
    Route::get('/general', DashboardIndex::class)->name('general');
    Route::get('/inquiry', InquiryIndex::class)->name('inquiry');
    Route::get('/quotation', QuotationIndex::class)->name('quotation');
    Route::get('/setgood', SetGoodIndex::class)->name('setgood');
    Route::get('/rabp', RabpIndex::class)->name('rabp');
    Route::get('/rabp1', Rabp1Index::class)->name('rabp1');
    Route::get('/contract', ContractIndex::class)->name('contract');
    Route::get('/production', ProductionIndex::class)->name('production');
    Route::get('/logistic', LogisticMaterialIndex::class)->name('logistic');
    Route::get('/retur', ReturIndex::class)->name('retur');
    Route::get('/qualitycontrol', QualityControlIndex::class)->name('qualitycontrol');
    Route::get('/purchaserequest', PurchaseRequestIndex::class)->name('purchaserequest');
    Route::get('/purchaseorder', PurchaseOrderIndex::class)->name('purchaseorder');
    Route::get('/goodreceive', GoodReceiveIndex::class)->name('goodreceive');
    Route::get('/qualitycontrol', QualityControlIndex::class)->name('qualitycontrol');
    Route::get('/logisticgood', LogisticGoodIndex::class)->name('logisticgood');
    Route::get('/delivery', DeliveryIndex::class)->name('delivery');
    Route::get('/detailuser', UserDetailIndex::class)->name('detailuser');
});

// Untuk masterdata
Route::group(['prefix' => 'masterdata', 'as' => 'masterdata.', 'middleware' => ['auth:sanctum',config('jetstream.auth_session'), 'verified']],
function() {
    Route::get('/category', CategoryIndex::class)->name('category');
    Route::get('/measurement', MeasurementIndex::class)->name('measurement');
    Route::get('/material', MaterialIndex::class)->name('material');
    Route::get('/supplier', SupplierIndex::class)->name('supplier');
    Route::get('/customer', CustomerIndex::class)->name('customer');
    Route::get('/good', GoodIndex::class)->name('good');
    // Route::get('/machine', MachineIndex::class)->name('machine');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
