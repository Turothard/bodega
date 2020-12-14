<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fechas</th>
                            <th>Sub Categoría</th>
                            <th>Artículo</th>
                            <th>Proveedor</th>
                            <th></th>
                            <th rowspan="2">
                                <button type="button" @click="filtrar()" title="Filtrar Stock" class="btn btn-primary">Generar Informe</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input class="form-control form-control-sm t-regular w-d" type="date" id="example-date-input" v-model="filtros.fechai">
                                <input class="form-control form-control-sm t-regular w-d" type="date" id="example-date-input" v-model="filtros.fechaf">
                            </td>
                            <td>
                                <select v-model="filtros.subcategoria" class="form-control form-control-sm t-regular w-l">
                                    <option value="">------</option>
                                    <option v-for="(item, index) in datainformes[3]" :key="index" :value="item.idsubcategoria">
                                        {{ item.nombresubcat }}
                                    </option>
                                </select>
                            </td>
                            <td>
                                <vue-bootstrap-typeahead                         
                                        v-model="articuloselect"
                                        :inputClass="'upcase form-control form-control-sm'"
                                        :minMatchingChars="3"
                                        ref="articulofiltro"
                                        :data="codigos"
                                        >
                                </vue-bootstrap-typeahead>
                            </td>
                            <td>
                                <select v-model="filtros.proveedor" class="form-control form-control-sm t-regular w-l">
                                    <option value="">------</option>
                                        <option v-for="(item, index) in proveedores" :key="index" :value="item.rutproveedor">
                                            {{ item.nombreprov }}
                                        </option>
                                </select>
                            </td>
                            <td>
                                <button @click="addarticulo()" class="btn btn-primary btn-sm" title="Agregar Artículo">
                                    <img style="width:23px;heigth:23px;" src="css/img/agregar.png" />
                                </button>
                            </td>
                            <th v-if="detalleinforme!=null">
                                <button type="button" @click="descargarinforme()" title="Generar Informe Costos" class="btn btn-success">Generar Informe</button>
                            </th>
                        </tr>
                    </tbody>
                    
                </table>
            </div>
            <div class="col-12">
                <ul class="list-group list-group-horizontal-md">
                    <li class="list-group-item" v-for="(item, index) in filtros.articulos" :key="index">
                        {{item.nombreart}} <span class="badge badge-danger pointer" @click="eliminarart(index)">x</span>
                    </li>
                </ul><br><br>
                <table
                id="tablainformeentart"
                class="table table-striped table-sm table-bordered table-dark t-regular w-100"
                v-show="detalleinforme!=null"
                >
                <thead>
                    <tr>
                    <th class="all">Fecha</th>
                    <th class="all">Proveedor</th>
                    <th class="all">Artículo</th>
                    <th class="all">Cantidad</th>
                    <th class="all">Costo Unitario</th>
                    <th class="all">Total Neto</th>
                    <th class="all">I.V.A</th>
                    <th class="all">Total Bruto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item,index) in detalleinforme" :key="index">
                        <td>{{item.fechaoc}}</td>
                        <td>{{item.nombreprov}}</td>
                        <td>{{item.nombreart}}</td>
                        <td>{{item.cantidaddetoc}}</td>
                        <td>{{item.montounitariodetoc}}</td>
                        <td>{{item.montototaldetoc}}</td>
                        <td>{{Math.round(parseInt(item.montototaldetoc)*0.19)}}</td>
                        <td>{{parseInt(item.montototaldetoc)+Math.round(parseInt(item.montototaldetoc)*0.19)}}</td>
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
                filtros:{fechai:'', fechaf:'',subcategoria:'',articulos:new Array(), proveedor:''},
                articuloselect:'',
                bodega: [],
                detalleinforme: null,
                usuarios: [],
                estantes: [],
                proveedores: [],
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
                axios.post('/informes/generar', {tipo:'informecostos',detalle: this.filtros})
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
                axios.post('/informes/export', {tipo:'informecostos',detalle: this.filtros, arreglo:this.detalleinforme})
                    .then((res) =>{
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
