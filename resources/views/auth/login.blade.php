@extends('layouts.app')
{{--
    Aqui acima a estancia do componente:
    Vue.component('login-component', require('./components/Login.vue').default);
--}}

@section('content')
   {{--
     A tag 'login-component' esta declarada em : resources/js/components/Login.vue
    onde esta todo HTML passando o csrf_token gerado por esse blade.
    --}}

    <login-component csrf_token="{{ @csrf_token() }}" > </login-component>
@endsection
