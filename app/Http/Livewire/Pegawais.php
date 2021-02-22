<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Pegawai;

class Pegawais extends Component
{
    public $pegawais,$name,$email,$phone_number,$status,$address,$pegawai_id;
    public $isReg;

    public function render()
    {
        $this->pegawais = Pegawai::orderBy('created_at','DESC')->get();
        return view('livewire.pegawais');
    }
    
    public function create(){

        $this->resetFields();
        $this->openReg();

        }
        public function resetFields(){

            $this-> name = '';
            $this-> email = '';
            $this-> phone_number = '';
            $this-> status = '';
            $this-> address = '';
            $this-> pegawai_id = '';
        }

    public function openReg(){

        $this->isReg=true;

    }

    public function closeReg(){

        $this->isReg=false;

    }

    public function store(){

        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:pegawais,email,' . $this->pegawai_id,
            'phone_number' => 'required|numeric',
            'address' => 'required|string',
            'status' => 'required'
        ]);

        Pegawai::updateOrCreate(
            ['id' => $this->pegawai_id],
            [
                'name' => $this->name,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'address' => $this->address,
                'status' => $this->status

        ]);

        session()->flash('message', $this->pegawai_id ? $this ->name  . 'Diperbaharui':$this->name.'Ditambahkan');
        $this->closeReg();
        $this ->resetFields();
    }

    public function edit($id){

        $pegawai = Pegawai::find($id);
        $this-> pegawai_id = $id ;
        $this-> name = $pegawai->name ;
        $this-> email = $pegawai->email ;
        $this-> phone_number = $pegawai->phone_number ;
        $this-> status = $pegawai->status ;
        $this-> address = $pegawai->address ;

        $this->openReg();
      
    }

    public function delete($id){

        $pegawai = Pegawai::find($id);
        $pegawai -> delete();
        session() -> flash('message',$pegawai->name.'Dihapus');

    }
}
