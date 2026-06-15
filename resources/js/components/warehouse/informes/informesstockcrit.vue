<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Bodega</th>
                            <th>Estante</th>
                            <th rowspan="2">
                                <button type="button" @click="descargarinforme()" title="Filtrar Stock" class="btn btn-primary">Generar Informe</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td>
                            <select class="form-control form-control-sm t-regular w-s" v-model="filtros.bodega" >
                                <option value="">------</option>
                                <option v-for="(item, index) in bodega" :key="index" :value="item.idbodega">
                                    {{ item.idbodega }}
                                </option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control form-control-sm t-regular w-s" v-model="filtros.estante" >
                                <option value="">---</option>
                                <option v-for="(item, index) in estantefiltrado" :key="index" :value="item.id">
                                    {{ item.nroestante }}
                                </option>
                            </select>
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
                 console.log(this.filtros);
                axios.post('/informes/generar', {tipo:'informesstockcritico',detalle: this.filtros})
                    .then((res) =>{
                    
                    this.detalleinforme = res.data;
                    console.log(this.detalleinforme );
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
             },
             descargarinforme(){
                 console.log(this.filtros);
                axios.post('/informes/export', {tipo:'informesstockcritico',detalle: this.filtros, arreglo:this.detalleinforme})
                    .then((res) =>{
                    setTimeout(function() {
                        window.open("/documents/informes/"+res.data);
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
