<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
   public function index(Request $request)
   {
       $empresas = Empresa::search($request->nombre)->orderBy('id', 'ASC')->paginate(5);

       return view('empresas.index')->with('empresas', $empresas);
   }

    public function show($id)
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return redirect()->route('empresas.index')->with('error', 'Empresa no encontrada');
        }

        return view('empresas.show')->with('empresa', $empresa);
    }

    public function showByNombre($nombre)
    {

        $nombre = trim($nombre); // Elimina espacios al inicio y final del nombre
        $empresa = Empresa::whereRaw('LOWER(nombre) = ?', [strtolower($nombre)])->first();

        if (!$empresa) {
            return redirect()->route('empresas.index')->with('error', 'Empresa no encontrada');
        }

        return redirect()->route('empresas.show', $empresa);
    }

    public function showByCif($cif)
    {

        $empresa = Empresa::where('cif', $cif)->first();

        if (!$empresa) {
            return redirect()->route('empresas.index')->with('error', 'Empresa no encontrada');
        }

        return redirect()->route('empresas.show', $empresa);
    }

   public function create()
   {
       return view ('empresas.create');
   }

    public function store(Request $request)
    {
        $request->validate([
            'cif'=> ['required', 'regex:/^[A-HJNP-SUVW][0-9]{7}[0-9A-J]$/'],
            'nombre'=> 'required|max:255',
            'direccion'=> 'required|max:255',
            'cuentaBancaria' => ['required', 'regex:/^ES\d{2}\s?\d{4}\s?\d{4}\s?\d{2}\s?\d{10}$/'],
            'telefono'=> ['required','regex:/^(\+34|0034)?[679]\d{8}$/'],
            'email'=> 'required|email|max:255',
            'imagen' => 'nullable|image|max:2048' // Validación para la imagen
        ]);

        try {
            $empresa = new Empresa($request->except('imagen'));

            if ($request->hasFile('imagen')) {
                $empresa->imagen = $request->file('imagen')->store('empresas', 'public');
            }

            $empresa->usuario_id = auth()->id();

            $empresa->save();

            return redirect()->route('empresas.index')->with('status', 'Empresa creada correctamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('empresas.create')->with('error', 'Error al crear la empresa: '.$e->getMessage());
        }
    }



   public function edit($id)
       {
           $empresa = Empresa::find($id);

           return view('empresas.edit')->with('empresa', $empresa);
       }

   public function update(Request $request, $id)
   {
       $request->validate([
           'cif'=> ['required', 'regex:/^[A-HJNP-SUVW][0-9]{7}[0-9A-J]$/'],
           'nombre'=> 'required|max:255',
           'direccion'=> 'required|max:255',
           'cuentaBancaria' => ['required', 'regex:/^ES\d{2}\s?\d{4}\s?\d{4}\s?\d{2}\s?\d{10}$/'],
           'telefono'=> ['required','regex:/^(\+34|0034)?[679]\d{8}$/'],
           'email'=> 'required|email|max:255'
       ]);

       try{
           $empresa = Empresa::find($id);

           $empresa->fill($request->all());

           if($request->hasFile('imagen')){
               if(Storage::exists($empresa->imagen)){
                   Storage::delete($empresa->imagen);
               }
               $empresa->imagen = $request->file('imagen')->store('storage');
           }
           $empresa->save();

           return redirect()->route('empresas.index')->with('status', 'Empresa actualizada correctamente');
       }catch (\Exception $e) {
    return redirect()->route('empresas.edit', $id)->with('error', 'Error al actualizar la empresa: '.$e->getMessage());
       }
   }

   public function destroy($id)
   {
       $empresa = Empresa::find($id);

       if($empresa){
           if(Storage::exists($empresa->imagen)){
               Storage::delete($empresa->imagen);
           }
           $empresa->delete();

           return redirect()->route('empresas.index')->with('status', 'Empresa eliminada correctamente');
       }

       return redirect()->route('empresas.index')->with('error', 'No se ha encontrado la empresa');
   }
}
