<template>
    <div class="form-group">
         
        <label  class="form-label">{{titulo}}</label>
       
        <select v-model="selected" class="form-select" v-on:change="setTipo($event)" > 
            <option v-for="(item, index) in marca_selects"  :value="item.id"   :key="index">
                {{item.name}}  
            </option>
        </select>
        <br>
</div>
</template>
 
<script>
    export default {
        props:['tipos_marcas','titulo'],
        data() {
            return{
                marca_selects: [
                    {name: 'Electrolux ', id: 1},
                    {name: 'Brastemp ', id: 2},
                    {name: 'Fischer ', id: 3},
                    {name: 'Samsung', id: 4},
                    {name: 'LG', id: 5}
                    ],
                    tipoMarca:''
            }
        },
        computed:{
            selected(){
                return this.tipos_marcas
            }
        },
        methods:{
            setTipo(e){
            console.log(e.target.value)
            this.$store.state.item.valor=e.target.value
            this.tipoMarca = e.target.value
        }
        }
      
        }
</script>
