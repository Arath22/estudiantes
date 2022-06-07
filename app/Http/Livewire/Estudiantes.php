<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Estudiante;

class Estudiantes extends Component
{
    #Variables
    public $estudiantes, $Nombres, $Apellidos, $Edad, $DNI, $Correo;
    public $modal = 0;

    public function render()
    {
        $this->estudiantes = Estudiante::all();
        return view('livewire.estudiantes');
    }

    public function crear()
    {
        $this->limpiarCampos();
        $this->abrirModal();
    }

    public function abrirModal() {
        $this->modal = true;
    }
    public function cerrarModal(){
        $this->modal = false;
    }
    public function limpiarCampos(){
        $this->Nombres = '';
        $this->Apellidos = '';
        $this->Edad = '';
        $this->DNI = '';
        $this->Correo = '';
        $this->id_estudiante = '';
    }
    public function editar($id){
        $estudiante = Estudiante::findOrFail($id);
        $this->id_estudiante = $id;
        $this->Nombres = $estudiante->Nombres;
        $this->Apellidos = $estudiante->Apellidos;
        $this->Edad = $estudiante->Edad;
        $this->DNI = $estudiante->DNI;
        $this->Correo = $estudiante->Correo;
        $this->abrirModal();
    }

    public function borrar($id)
    {
        Estudiante::find($id)->delete();
        session()->flash('message','Registro Eliminado correctamente');
    }
    public function guardar(){
        Estudiante::updateOrCreate(['id'=>$this->id_estudiante],
            [
                'Nombres' => $this->Nombres,
                'Apellidos' => $this->Apellidos,
                'Edad' => $this->Edad,
                'DNI' => $this->DNI,
                'Correo' => $this->Correo
            ]);
        
        session()->flash('message',
        $this->id_estudiante ? '¡Actualizacion de datos exitosa!' : '¡Alumno añadido con exito!');
        $this->cerrarModal();
        $this->limpiarCampos();
    }
}
