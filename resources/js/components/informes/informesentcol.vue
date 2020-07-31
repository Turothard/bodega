<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fechas</th>
                            <th>Artículo</th>
                            <th rowspan="2">
                                <button type="button" @click="filtrar()" title="Filtrar Stock" class="btn btn-primary">Generar Informe</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input class="form-control" type="date" id="example-date-input" v-model="filtros.fechai"><input class="form-control" type="date" id="example-date-input" v-model="filtros.fechaf">
                            </td>
                            <td>
                                <vue-bootstrap-typeahead                         
                                        v-model="filtros.articulo"
                                        :inputClass="'upcase form-control form-control-sm'"
                                        :minMatchingChars="3"
                                        ref="articulodetoc"
                                        :data="codigos"
                                        >
                                        
                                    </vue-bootstrap-typeahead>
                            </td>
                        </tr>
                    </tbody>
                    
                </table>
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
                filtros:{fechai:'', fechaf:'',articulo:''},
                bodega: [],
                usuarios: [],
                estantes: [],
                bodegaselect:'',
                estanteselect:'',
                codigos:'',
            }
         },
         created(){
             this.usuarios = this.datainformes[0];
             this.bodega = this.datainformes[8];
             this.estantes = this.datainformes[9];
             var nom = _.mapValues(this.datainformes[4], function(o) { return o.nombreart; });
            this.codigos =Object.values(nom);
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
                axios.post('/informes/export', {tipo:'informesstock',detalle: this.filtros})
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
