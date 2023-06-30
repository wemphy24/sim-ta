<?php

namespace App\Http\Livewire;

use App\Models\DetailUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class UserDetailIndex extends Component
{
    use WithPagination;
    public $showingUser = false;
    public $isEdit = false;
    public $showingMainPage = true;

    public $name, $email, $phone, $address, $department, $roles_id, $user_id;

    public function render()
    {
        return view('livewire.user-detail-index', [
            'detailusers' => DetailUser::paginate(15),
            'roles' => Role::all(),
        ])->layout('layouts.admin');
    }

    public function showUser()
    {
        $this->reset();
        $this->showingUser = true;
        $this->roles_id = 6;
    }

    public function closeModal()
    {
        $this->showingUser = false;
    }
    
    public function store()
    {
        $getUserId = DB::table('users')->insertGetId([
                            'name' => $this->name,
                            'email' => $this->email,
                            'password' => Hash::make("haha123"),
                        ]);

        DetailUser::create([
            'users_id' => $getUserId,
            'phone' => $this->phone,
            'address' => $this->address,
            'department' => $this->department,
            'roles_id' => $this->roles_id,
        ]);

        $this->closeModal();
        $this->dispatchBrowserEvent('store-success');
    }

    public function edit($id)
    {
        $this->showingUser = true;
        $this->isEdit = true;

        $this->user_id = User::findOrFail($id);
        $this->name = $this->user_id->name;
        $this->email = $this->user_id->email;

        $this->phone = DetailUser::where('id','=',$id)->first('phone')->phone;
        $this->address = DetailUser::where('id','=',$id)->first('address')->address;
        $this->department = DetailUser::where('id','=',$id)->first('department')->department;
        $this->roles_id = DetailUser::where('id','=',$id)->first('roles_id')->roles_id;
    }

    public function update()
    {
        User::where('id','=',$this->user_id->id)->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        DetailUser::where('id','=',$this->user_id->id)->update([
            'users_id' => $this->user_id->id,
            'phone' => $this->phone,
            'address' => $this->address,
            'department' => $this->department,
            'roles_id' => $this->roles_id,
        ]);

        $this->closeModal();
        $this->dispatchBrowserEvent('store-success');
    }
}
