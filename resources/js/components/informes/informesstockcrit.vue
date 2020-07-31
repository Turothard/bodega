<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <button type="button" @click="filtrar()" title="Filtrar Stock Crítico" class="btn btn-primary">Generar Informe</button>           
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['datainformes'],
         data(){
            return{
                preestablecidovue:null,
                filtros:{bodega:'', estante:''},
                bodega: [],
                usuarios: [],
                estantes: [],
                bodegaselect:'',
                estanteselect:''
            }
         },
         created(){
             this.usuarios = this.datainformes[0];
             this.bodega = this.datainformes[8];
             this.estantes = this.datainformes[9];
         },
         computed: {
        // a computed getter
            estantefiltrado: function(){
                if(this.filtros.bodega!=''){
                    let estantes = this.estantes;
                    return _.filter(estantes, {'bodega_id':this.filtros.bodega});
                }
                return null;
            },
         },
         methods: {
             filtrar(){
                axios.post('/informes/export', {tipo:'informesstockcritico'})
                    .then((res) =>{
                    console.log(res.data);
                    setTimeout(function() {
                        window.open("documents/informes/"+res.data);
                    }, 1000);
                }).catch(function (error) {
                    if (error.response) {
                    // Request made and server responded
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                    } else if (error.request) {
                    // The request was made but no response was received
                    console.log(error.request);
                    } else {
                    // Something happened in setting up the request that triggered an Error
                    console.log('Error', error.message);
                    }
                });
             }
         },
    }
</script>
