<template>
    <div class="container-fluid">
        <div class="row justify-content-start">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha Inicial</th>
                            <th>Fecha Final</th>
                            <th>Bodega</th>
                            <th>
                                <button type="button" @click="filtrar()" title="Filtrar Stock" class="btn btn-primary">Filtrar Informe</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input class="form-control form-control-sm t-regular" type="date" id="example-date-input" v-model="filtros.fechai">
                                
                            </td>
                            <td>
                                <input class="form-control form-control-sm t-regular" type="date" id="example-date-input" v-model="filtros.fechaf">
                            </td>
                             <td>
                                <select class="form-control form-control-sm t-regular w-s" v-model="filtros.bodega" >
                                    <option value="">------</option>
                                    <option v-for="(item, index) in bodega" :key="index" :value="item.idbodega">
                                        {{ item.idbodega }}
                                    </option>
                                </select>
                            </td>
                            <th v-if="detalleinforme!=null">
                                <button type="button" @click="descargarinforme()" class="btn btn-success" title="Descargar Informe">Generar Informe</button>
                            </th>
                        </tr>
                    </tbody>
                    
                </table>
            </div>
            <div class="col-12">
                
                <table
                id="tablainformeentart"
                class="table table-striped table-sm table-bordered table-dark t-regular w-100"
                v-show="detalleinforme!=null"
                >
                <thead>
                    <tr>
                    <th class="all">Fecha</th>
                    <th class="all">Tipo Doc.</th>
                    <th class="all">Documento</th>
                    <th class="all">Proveedor</th>
                    <th class="all">Monto Total Neto</th>
                    <th class="all">Monto Total Bruto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item,index) in detalleinforme" :key="index">
                        <td>{{item.fechaingresoing}}</td>
                        <td>{{item.tipodocing}}</td>
                        <td>{{item.nrodocing}}</td>
                        <td>{{item.nombreproving}}</td>
                        <td>{{item.montoing}}</td>
                        <td>{{Math.round(item.montoing*1.19)}}</td>
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
                filtros:{fechai:'', fechaf:'',subcategoria:'',articulos:new Array()},
                articuloselect:'',
                bodega: [],
                detalleinforme: null,
                usuarios: [],
                estantes: [],
                proveedores:[],
                bodegaselect:'',
                estanteselect:'',
                codigos:'',
            }
         },
         created(){
             this.usuarios = this.datainformes[0];
             this.bodega = this.datainformes[8];
             this.estantes = this.datainformes[9];
             this.proveedores = this.datainformes[12];
             var cod =_.mapValues(this.datainformes[4], function(o) { return o.codigoart; });
            var nom = _.mapValues(this.datainformes[4], function(o) { return o.nombreart; });
            this.codigos =Object.values(cod).concat(Object.values(nom));
            //this.codigos =Object.values(nom);
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
             addarticulo(){
                 let art;
                 if(this.articuloselect!=''){
                     art =this.datainformes[4].find( items => items.codigoart === this.articuloselect );
                    if(art==null){
                        art =this.datainformes[4].find( items => items.nombreart === this.articuloselect );
                    }
                    //newart.codigo= art.codigoart;
                    if(art==null){
                        this.$toastr.w("Artículo no encontrado, favor revisar");
                        return;
                    }
                    let art2 ={"codigoart": art.codigoart, "nombreart":art.nombreart}
                     this.filtros.articulos.push(art2);
                     this.articuloselect='';
                     this.$refs.articulofiltro.inputValue = '';
                 }
             },
             eliminarart(index){
                 if(confirm("¿Estás seguro de quitar este artículo de la lista?")){
                     this.filtros.articulos.splice(index,1);
                 }
             },
             filtrar(){
                 console.log(this.filtros);
                axios.post('/informes/generar', {tipo:'informeinventario',detalle: this.filtros})
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
                axios.post('/informes/export', {tipo:'informeinventario',detalle: this.filtros, arreglo:this.detalleinforme})
                    .then((res) =>{
                    setTimeout(function() {
                        console.log(res.data);
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
