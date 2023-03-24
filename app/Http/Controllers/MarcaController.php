<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{

     public function __construct(Marca $marca){
        // Usando Metodo Injecao do Model
        $this->marca = $marca;
     }

    /**
     * Display a listing of the resource.
     *  POST localhost:8000/api/marca
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->has('filtro')) {
            $filtros = $request->get('filtro');
            $filtros = explode(';', $filtros);

            foreach($filtros as $key => $condicao) {

                $c = explode(':', $condicao);
                $marca = $this->marca->where($c[0], $c[1], $c[2]);
            }
        }else{
            $marca = $this->marca->all();
        }

        return response()->json($marca, 200);
    }


    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $name_img='imagens/marcas/sem-imagem.jpg';
         $request->validate($this->marca->regras(), $this->marca->feedbacks() );

         if ($imagem = $request->file('imagem')) {
             $name_img =$imagem->store('imagens/marcas','public');
         }

         $dadosbd = [
            'nome'        => $request->get('nome'),
            'descricao'   => $request->get('descricao'),
            'tensao'      => $request->get('tensao'),
            'tipo_marca_id'=> $request->get('tipomarca'),
            'imagem'      => $name_img
         ];

         $marca  = $this->marca->create( $dadosbd);
         $return = response()->json( $marca , 201);

        return $return; 
    }

    /**
     * Display the specified resource.
     * GET [localhost:8000/api/marca/2]
     * @param  usa o \App\Models\Marca  $this->marca e int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            
       $marca = $this->marca->find($id);

       return $marca;
    }


    /**
     * Update the specified resource in storage.
     * PUT e PACHT
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 

        $marca = $this->marca->find($id);
        if ($marca ===NULL) {
            return  $marca = ['status'=>'Erro', "mensagem"=>'Id enviado nao foi encontrado para Atualizar!'];
        }
        $marca->fill($request->all());
        if($request->file('imagem')) {
            Storage::disk('public')->delete($marca->imagem);
            $imagem = $request->file('imagem');
            $imagem_urn =$imagem->store('imagens/marcas','public');
            $marca->imagem = $imagem_urn;
        } 
        $marca->save();
        $marca = ['status'=>'Success','message'=>"Produto {$id} Atualizada com Sucesso"];;

        return response()->json($marca, 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
     {
        $marca = $this->marca->find( $id );
        if ($marca ==NULL) {
            $marca = response()->json(['status'=>'Erro', "message"=>'Id enviado nao foi encontrado para Deletar!'], $status = 404);
        }else{
            $marca->delete();
            $marca = ['status'=>'Success','message'=>"Produto {$id} Deletado com Sucesso"];;
        }

        return $marca;
     }

     public function filtro($filtros) {

        $filtros = explode(';', $filtros);

        foreach($filtros as $key => $condicao) {
            $c = explode(':', $condicao);
            $this->model = $this->model->where($c[0], $c[1], $c[2]);
        }
    }
}
