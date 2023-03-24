<template>
    <div>

    <table class="table table-hover">
    <thead class="thead-dark">
        <tr>
            <th scope="col" v-for="t,key in titulo" :key="key" >  {{ t }} </th>
            <th></th>
        </tr>
    </thead>
    <tbody>
       
    <tr v-for="objeto in dados" :key="objeto.id">
        <td v-if="titulo.includes(chave)" v-for="valor,chave in objeto" :key="chave" >

            <span v-if="chave =='imagem'">
                <img v-bind:src="'/storage/'+objeto[chave]" width="20%"></img>
            </span>
            <span v-else>
                {{ valor }}
            </span>
        </td>
        <td>
            <button v-if="visualizar" v-on:click="setStore(objeto)" data-bs-toggle="modal" data-bs-target="#modalMarcaVisualizar" class="btn btn-outline-primary btn-sm" > Visualizar</button>
            <button v-if="atualizar"  v-on:click="setStore(objeto)" data-bs-toggle="modal" data-bs-target="#modalMarcaAtualizar" class="btn btn-outline-primary btn-sm"> Atualizar</button>
            <button v-if="remover"    v-on:click="setStore(objeto)" data-bs-toggle="modal" data-bs-target="#modalMarcaRemover" class="btn btn-outline-danger btn-sm"> Remover</button>
        </td>
    </tr>
    </tbody>
    </table>
    </div>
</template>

 <script>
    export default {
        methods:{
            setStore(objeto){
                this.$store.state.transacao.status=''
                this.$store.state.transacao.mensagem=''
                this.$store.state.item = objeto;
            }
        },
        props: ['dados','titulo','visualizar','atualizar','remover']
    }
    /*
    // Variaveis vinda do template Marcas
    <table-marcas-component
        v-bind:visualizar="true"
        v-bind:atualizar="true"
        v-bind:remover  ="true"
        v-bind:dados="marcas.data"
        v-bind:titulo="['id','nome','imagem']" >
    </table-marcas-component>
    */
</script>

