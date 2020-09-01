<template>
    <div class="container-fluid">
        <div class="row justify-content-start">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fechas</th>
                            <th>Sub Categoría</th>
                            <th>Colaborador</th>
                            <th></th>
                            <th rowspan="2">
                                <button type="button" @click="filtrar()" title="Filtrar Stock" class="btn btn-primary">Generar Informe</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input class="form-control form-control-sm t-regular" type="date" id="example-date-input" v-model="filtros.fechai">
                                <input class="form-control form-control-sm t-regular" type="date" id="example-date-input" v-model="filtros.fechaf">
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
                                        v-model="nombreselect"
                                        :inputClass="'upcase form-control form-control-sm'"
                                        :minMatchingChars="3"
                                        ref="nombrefiltro"
                                        :data="nombres"
                                        >
                                </vue-bootstrap-typeahead>
                            </td>
                            <td>
                                <button @click="addnombre()" class="btn btn-primary btn-sm" title="Agregar Colaborador">
                                    <img style="width:23px;heigth:23px;" src="css/img/agregar.png" />
                                </button>
                            </td>
                            <td>
                                <button @click="descargarinforme()" v-show="detalleinforme!=null" class="btn btn-success" title="Descargar Informe">
                                    <img style="width:30px;heigth:30px;" src="css/img/informeexcel.png" />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    
                </table>
            </div>
            <div class="col-8 align-self-start">
                <ul class="list-group list-group-horizontal-md">
                    <li class="list-group-item" v-for="(item, index) in filtros.nombres" :key="index">
                        {{item.nombrecortocolab}} <span class="badge badge-danger pointer" @click="eliminarnom(index)">x</span>
                    </li>
                </ul><br><br>
                <table
                id="tablainformeentcol"
                class="table table-striped table-sm table-bordered table-dark t-regular w-100"
                v-show="detalleinforme!=null"
                >
                <thead>
                    <tr>
                    <th class="all">Pedido</th>
                    <th class="all">Fecha</th>
                    <th class="all">Colaborador</th>
                    <th class="all">Nomnre Art</th>
                    <th class="all">Cantidad Ent</th>
                    <th class="all">Cantidad Dev</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item,index) in detalleinforme" :key="index">
                        <td>{{item.pedido_id}}</td>
                        <td>{{item.updated_at}}</td>
                        <td>{{item.nombrecortocolab}}</td>
                        <td>{{item.nombreart}}</td>
                        <td>{{item.cantidadproceso}}</td>
                        <td>{{item.cantidaddevolucion}}</td>
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
                filtros:{fechai:'', fechaf:'',subcategoria:'',nombres:new Array()},
                nombreselect:'',
                bodega: [],
                detalleinforme: null,
                usuarios: [],
                estantes: [],
                bodegaselect:'',
                estanteselect:'',
                nombres:'',
            }
         },
         created(){
             this.usuarios = this.datainformes[0];
             this.bodega = this.datainformes[8];
             this.estantes = this.datainformes[9];
             var nom =_.mapValues(this.datainformes[1], function(o) { return o.nombrecortocolab; });
             var nom2 =_.mapValues(this.datainformes[1], function(o) { return o.rutcolaborador; });

            this.nombres =Object.values(nom2).concat(Object.values(nom));
            //this.nombres =Object.values(nom);
         },
         computed: {
        // a computed getter
         },
         methods: {
             addnombre(){
                 let nom;
                 if(this.nombreselect!=''){
                    nom =this.datainformes[1].find( items => items.nombrecortocolab === this.nombreselect );
                    //newart.codigo= art.codigoart;
                    if(nom==null){
                        nom =this.datainformes[1].find( items => items.rutcolaborador === this.nombreselect );
                        if(nom==null){
                            this.$toastr.w("Colaborador no encontrado, favor revisar");
                            return;
                        }
                        
                    }
                    let nom2 ={"rutcolaborador": nom.rutcolaborador, "nombrecortocolab":nom.nombrecortocolab}
                    this.filtros.nombres.push(nom2);
                    this.nombreselect='';
                    this.$refs.nombrefiltro.inputValue = '';
                 }
             },
             eliminarnom(index){
                 if(confirm("¿Estás seguro de quitar este Colaborador de la lista?")){
                     this.filtros.nombres.splice(index,1);
                 }
             },
             filtrar(){
                 console.log(this.filtros);
                axios.post('/informes/generar', {tipo:'informeentregacolaborador',detalle: this.filtros})
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
                axios.post('/informes/export', {tipo:'informeentregacolaborador',detalle: this.filtros, arreglo:this.detalleinforme})
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
