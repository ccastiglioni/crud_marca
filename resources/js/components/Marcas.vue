<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- início do card de busca -->
                <div class="card mb-3">
                    <div class="card-header">Busca de marcas</div>
                    <div class="card-footer">
                        <button type="submit" v-on:click="pesquisa()" class="btn btn-primary btn-sm float-right">Refresh</button>
                    </div>
                </div>
                <!-- fim do card de busca -->

                <!-- início do card de listagem de marcas -->
                <div class="card">
                    <div class="card-header">Relação de Marcas </div>

                    <div class="card-body">
                        <table-marcas-component
                                v-bind:visualizar="true"
                                v-bind:atualizar="true"
                                v-bind:remover  ="true"
                                v-bind:dados="marcas"
                                v-bind:titulo="['id','nome','imagem']" >
                        </table-marcas-component>
                    </div>

                    <div class="card-footer">
                        <!-- <button type="button" data-bs-toggle="modal" data-bs-target="#modalMarca" class="btn btn-primary btn-sm float-right">Adicionar</button> -->
                        <button type="button" data-bs-toggle="modal" data-bs-target="#modalMarca" v-on:click="clearformcad()" class="btn btn-primary btn-sm float-right">Cadastrar</button>
                    </div>
                </div>
                <!-- fim do card de listagem de marcas -->
                <div class="row justify-content-center">

                    <nav aria-label="Page navigation example">
                        <ul class="pagination" style="cursor: pointer;">
                            <li v-for="(l,key) in marcas.links" :key="key" v-on:click="pagination(l)" class="page-item">
                                <a class="page-link" v-html="l.label"> </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Modal Adicionar -->
        <modal-component valortarget="modalMarca" titulo="Adicionar Produto">
            <template v-slot:alertas>
                <alert-component tipo="success" mensagemFixa="Produto cadastrado com Sucesso!"  v-bind:mensagem="TransacaoMsg" v-if="TransacaoStatus=='success'"></alert-component>
                <alert-component tipo="danger" mensagemFixa="Erro A cadastrar!" v-bind:mensagem="TransacaoMsg" v-if="TransacaoStatus=='erro'" ></alert-component>
            </template>

            <template v-slot:conteudo>  <!-- Com o name=conteudo criei um slot no Modal.vue -->
                <div class="form-row">
                    <div class="col mb-3">
                        <label for="inputId">Nome</label>
                        <input type="text" class="form-control" id="nome"   placeholder="Digite o nome" v-model="nomeMarca">
                    </div>

                    <div class="col mb-3">
                        <label for="inputId">Descrição</label>
                        <input type="text" class="form-control" id="descricao"   placeholder="Digite a descrição" v-model="decricaoMarca">
                    </div>

                    <div class="col mb-3">
                        <label for="inputId">Tensão</label>
                        <input type="text" class="form-control" id="tensao"   placeholder="Digite a Tensão" v-model="tensaoMarca">
                    </div>
                    
                    <div class="col mb-3">
                        <label for="inputId">Tipo </label>
                         <select class="form-select" name="tipoMarca" id="tipo_marca" v-on:change="setTipo($event)" >
                            <option value="1">Electrolux</option>
                            <option value="2">Brastemp</option>
                            <option value="3">Fischer</option>
                            <option value="4">Samsung</option>
                            <option value="5">LG</option>
                         </select>
                    </div>

                    <div class="col mb-3">
                        <label for="inputNome">Arquivo</label>
                        <input type="file" ref="inputFile" id="file" v-on:change="carregarImagem($event)" aria-describedby="imagemHelp" class="form-control-file" placeholder="Digite o Nome da imagem">
                    </div>
                  
                    </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" v-on:click="salvar()" >Salvar</button>
            </template>
        </modal-component>


        <!-- Modal VISUALIZAR -->
        <modal-component valortarget="modalMarcaVisualizar" titulo="Visualição simplificado de Produto">

            <template v-slot:alertas>
            </template>

            <template v-slot:conteudo>
                <input-component titulo="ID">
                    <input type="text" v-bind:value="$store.state.item.id" class="form-control" >
                </input-component>

                <input-component titulo="Nome Marca">
                    <input type="text" v-model="$store.state.item.nome" class="form-control" >
                </input-component>

                <input-component titulo="Nome Marca">
                   <img  v-if="$store.state.item.imagem" :src="'storage/'+$store.state.item.imagem"  width="35%"  alt="">
                </input-component>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </template>
        </modal-component>


        <!-- Modal REMOVER -->
        <modal-component valortarget="modalMarcaRemover" titulo="Remover Marca">

            <template v-slot:alertas>
                <alert-component v-if="$store.state.transacao.status =='sucesso'" title="Transacao Sucesso" tipo="success" mensagemFixa="Parabéns" v-bind:mensagem="$store.state.transacao.mensagem" > </alert-component>
                <alert-component v-if="$store.state.transacao.status =='erro'" title="Erro Transacao " tipo="danger" mensagemFixa="Erro" v-bind:mensagem="$store.state.transacao.mensagem" > </alert-component>
            </template>

            <template v-slot:conteudo>
                <input-component titulo="ID">
                    <input type="text" v-bind:value="$store.state.item.id" class="form-control" >
                </input-component>

                <input-component titulo="Nome Marca">
                    <input type="text" v-bind:value="$store.state.item.nome" class="form-control" >
                </input-component>

            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" v-on:click="remover()" class="btn btn-danger">Excluir</button>
            </template>
        </modal-component>

        <!-- Modal ATUALIZAR -->
        <modal-component valortarget="modalMarcaAtualizar" titulo="Atualizar Produto">

            <template v-slot:alertas>
                <alert-component v-if="$store.state.transacao.status =='sucesso'" title="Transacao Sucesso" tipo="success" mensagemFixa="Parabéns" v-bind:mensagem="$store.state.transacao.mensagem" > </alert-component>
                <alert-component v-if="$store.state.transacao.status =='erro'" title="Erro Transacao " tipo="danger" mensagemFixa="Erro" v-bind:mensagem="$store.state.transacao.mensagem" > </alert-component>
            </template>

            <template v-slot:conteudo>
                <input-component titulo="ID">
                    <input type="text" v-bind:value="$store.state.item.id" class="form-control" disabled>
                </input-component>

                <input-component titulo="Nome ">
                    <input type="text" v-model="$store.state.item.nome" class="form-control" >
                </input-component>
                
                <input-component titulo="Descrição">
                    <input type="text" v-model="$store.state.item.descricao" class="form-control" >
                </input-component> 

                <input-component titulo="Tensão">
                    <input type="text" v-model="$store.state.item.tensao" class="form-control" >
                </input-component>    
                
                <select-component titulo="tipo" :tipos_marcas="$store.state.item.tipo_marca_id" >
                
                </select-component>

                <input-component titulo="Imagem :">
                <input type="file" id="file" v-on:change="carregarImagem($event)" aria-describedby="imagemHelp" class="form-control-file" placeholder="Digite o Nome da imagem"></input>
                   <br>
                   <br>
                <label for=""><b>Imagem atual: </b> </label>
                <img  v-if="$store.state.item.imagem" :src="'storage/'+$store.state.item.imagem"  width="25%"  alt="">
                </input-component>

            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" v-on:click="atualizar()" class="btn btn-primary">Atualizar</button>
            </template>
        </modal-component>

    </div>
</template>

<script>
export default {

    computed: {
            token() {

                let token = document.cookie.split(';').find(indice => {
                    return indice.includes('token=')
                })

                token = token.split('=')[1]
                token = 'Bearer ' + token
                return token;
            }
    },
    data() {
        return {
            //url:'http://localhost:8000/api/marca',
            url:'http://127.0.0.1:8000/api/marca',
            url_paginacao:'',
            url_filtro:'',
            nomeMarca:'',
            decricaoMarca:'',
            tensaoMarca:'',
            tipoMarca:'',
            arquivoImagem:[],
            TransacaoStatus:"",
            TransacaoMsg:"",
            marcas:[],
            id_busca:'',
            nome_busca:''
        }
    },
    methods: {
        atualizar(){
            let parametros = new FormData()
            parametros.append('_method','PATCH');
            parametros.append('nome', this.$store.state.item.nome);
            parametros.append('descricao', this.$store.state.item.descricao);
            parametros.append('tensao', this.$store.state.item.tensao);
            parametros.append('tipo_marca_id', this.$store.state.item.valor);
            if (this.arquivoImagem[0]) {
                parametros.append('imagem', this.arquivoImagem[0]);
            }

            let urlpost = this.url + '/'+ this.$store.state.item.id

            let configuracao = {
                headers: {
                    'Content-Type':'multipart/form-data',
                    'Accept': 'application/json',
                    'Authorization': this.token
                }
            }

             axios.post(urlpost, parametros,configuracao)
             .then( response => {
                this.$store.state.transacao.status   ='sucesso'
                this.$store.state.transacao.mensagem =response.data.message

                this.carregarLista()
                console.log('respota :',response.data)
            })
            .catch(error => {
                this.$store.state.transacao.status ='erro'
                this.$store.state.transacao.mensagem =error.response.data.message
                console.log('erro :',error.response.data.message)
             })
        },
        remover(){
            let parametros = new FormData()
            parametros.append('_method','DELETE');

            let urlpost = this.url + '/'+ this.$store.state.item.id

            let configuracao = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.token
                }
            }

             axios.post(urlpost, parametros,configuracao)
             .then( response => {
                this.$store.state.transacao.status   ='sucesso'
                this.$store.state.transacao.mensagem =response.data.message
                this.carregarLista()
                console.log('respota :',response.data)
            })
            .catch(error => {
                this.$store.state.transacao.status ='erro'
                this.$store.state.transacao.mensagem =error.response.data.message
                console.log('erro :',error.response.data.message)
             })
        },
        pesquisa(){
            
            let filtro ='&filtro=';

            if(this.id_busca != ''){
                filtro += 'id:like:'+this.id_busca;
            }
            if(this.nome_busca != ''){

                if(filtro !=='&filtro='){
                    filtro += ';';
                }
                filtro += 'nome:like:'+this.nome_busca;
            }

            if(filtro !== '&filtro='){
                this.url_paginacao='page=1'
                this.url_filtro   =filtro
            }else{
                this.url_filtro=''
            }
            this.carregarLista();
        },
        pagination(l){
            if(l.url){
                //this.url = l.url
                this.url_paginacao = l.url.split("?")[1]
                this.carregarLista();
            }

        },
        carregarLista(){
            
            let config = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.token
                }
            }
            let url_inc = this.url + '?' + this.url_paginacao + this.url_filtro;

            console.log(url_inc);

            axios.get(url_inc, config)
              .then(response => {
                  this.marcas = response.data
                  console.log(this.marcas)
                    //this.nomeMarca = response.data.nome
                })
              .catch(error => {
                    console.log(error)
                })
        },
        carregarImagem(e){
            this.arquivoImagem = e.target.files
        },
        setTipo(e){
            console.log(e.target.value)
            this.tipoMarca = e.target.value
        },
        clearformcad(){
                this.TransacaoStatus ='success'
                this.TransacaoMsg = "Envido!"
                this.nomeMarca ='';
                this.decricaoMarca ='';
                this.tensaoMarca ='';
                this.TransacaoStatus=''
                this.$refs.inputFile.reset();
                this.$refs.file.type='inputFile'; 

        },
        salvar(){
            //console.log(this.nomeMarca,this.arquivoImagem[0])
            let formData = new FormData()
            formData.append('nome',this.nomeMarca)
            formData.append('descricao',this.decricaoMarca)
            formData.append('tensao',this.tensaoMarca)
            formData.append('tipomarca',this.tipoMarca)
            formData.append('imagem',this.arquivoImagem[0])

            let config = {
                headers: {
                    'Content-Type':'multipart/form-data',
                    'Accept': 'application/json',
                    //'Authorization': this.token
                }
            }

            axios.post(this.url,formData,config)
            .then(response =>{
                console.log(response)
                this.TransacaoStatus ='success'
                this.TransacaoMsg = "Envido!"
                this.nomeMarca ='';this.decricaoMarca ='';this.tensaoMarca ='';
            })
            .catch(error =>{
                console.warn(error.response.data.message)
                this.TransacaoStatus='erro'
                // através do metodos response pode-se pegar os erro como Mensagem!! :D
                 this.TransacaoMsg = error.response.data.message
            })

        }
   },
   mounted(){
    this.carregarLista()
   }

}
</script>
