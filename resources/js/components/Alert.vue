<template>
  <div  v-bind:class="estilo" role="alert">
    {{ mensagemFixa }}.
    {{ mensagem }}
</div>

</template>



<script>
export default {
    props:['tipo','mensagemFixa','mensagem'],
    computed:{
        estilo(){
            return 'alert alert-'+this.tipo
        }
    }
}
</script>
