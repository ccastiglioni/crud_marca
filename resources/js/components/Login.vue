<template>
 <div class="container">

   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">- Login Vue - </div>

               <div class="card-body">
                <form method="POST" action="" @submit.prevent="login($event)">
                <input type="hidden" name="_token" v-bind:value="csrf_token">
                       <div class="row mb-3">
                           <label for="email" class="col-md-4 col-form-label text-md-end"> Email Address</label>

                           <div class="col-md-6">
                               <input id="email" type="email" class="form-control" name="email" value="" required autocomplete="email" autofocus v-model="email">
                           </div>
                       </div>

                       <div class="row mb-3">
                           <label for="password" class="col-md-4 col-form-label text-md-end">Senha</label>

                           <div class="col-md-6">
                               <input id="password" type="password" class="form-control " name="password" required autocomplete="current-password" v-model="password">

                           </div>
                       </div>

                       <div class="row mb-3">
                           <div class="col-md-6 offset-md-4">
                               <div class="form-check">
                                   <input class="form-check-input" type="checkbox" name="remember" id="remember" >

                                   <label class="form-check-label" for="remember">
                                     Lembra de mim
                                   </label>
                               </div>
                           </div>
                       </div>

                       <div class="row mb-0">
                           <div class="col-md-8 offset-md-4">
                               <button type="submit" class="btn btn-primary">
                                   Login
                               </button>

                                   <a class="btn btn-link" href="">
                                       Esqueceu a senha?
                                   </a>
                           </div>
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>
</div>
</template>

<script>
    export default {
        props: ['csrf_token'], //data (semelhante)
        data() {
            return {
                email: '',
                password: ''
            }
        },
        methods: {
            login(e) {

                let url = 'http://localhost:8000/api/login'
                let configuracao = {
                    method: 'post',
                    body: new URLSearchParams({  //essa funcao encapsula pra x-www.form
                        'email': this.email,
                        'password': this.password
                    })
                }

                fetch(url, configuracao)
                  .then(response => response.json())
                    .then(dados => {
                        if(dados.token) {
                            document.cookie = 'token='+dados.token+';SameSite=Lax';
                            localStorage.setItem("tokenapi", dados.token);
                            //document.cookie = 'token='+dados.token+'docume';
                        }
                        //console.log("Criado:",document.cookie);
                        //console.log('Token : ',dados.token); return false;

                        //dar sequência no envio do form de autenticação por sessão
                       e.target.submit()
                    })
            }
        }
    }
</script>
