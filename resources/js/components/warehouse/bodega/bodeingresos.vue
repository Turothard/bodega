<template>
    <div class="container-fluid">
        <h1>Ingresos Bodega</h1>
        <div role="group" aria-label="Botones Ingresos" class="btn-group" id="botonesingresos">
            <button type="button" class="btn btn-info" @click="mostraringresos()">Mostrar Ingreso</button>
            <button type="button" class="btn btn-secondary" @click="montrarcompracaja()">Mostrar Compra Caja Chica</button>
        </div><br/><br/>
        <div v-show="!cargando" class="container-fluid">
            <table id="tablaingresos" class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100">
                <thead>
                    <tr>
                        <th>Artículo</th>
                        <th>Nombre Art</th>
                        <th>Usuario</th>
                        <th>Bodega</th>
                        <th>Estante</th>
                        <th>Sector</th>
                        <th>Nivel</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th>Funciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item,index) in detalleingresos" :key="index">
                        <td>{{item.codigoart}}</td>
                        <td>{{item.nombreart}}</td>
                        <td>{{item.nombrecortocolab}}</td>
                        <td>{{item.bodega_id}}</td>
                        <td>{{item.nroestante}}</td>
                        <td>{{item.sectoring}}</td>
                        <td>{{item.niveling}}</td>
                        <td>{{item.cantidading}}</td>
                        <td>{{item.created_at}}</td>
                        <td>
                             <button 
                                v-if="item.fechaing == item.updated_at" 
                                @click="revertiringreso(item, index)" 
                                title="Revertir Ingreso" 
                                class="btn btn-danger btn-sm"
                            >
                                <img style="width:23px;heigth:23px;" src="/css/img/revertir.png"/>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table id="tablacompracaja" style="display:none" class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100">
                <thead>
                    <tr>
                        <th>Proveedor</th>
                        <th>Nombre Prov</th>
                        <th>Usuario</th>
                        <th>Tipo Doc</th>
                        <th>Nro Doc</th>
                        <th>Fecha</th>
                        <th>Cantidad</th>
                        <th>Monto</th>
                        <th>Funciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item,index) in detallecomprascaja" :key="index">
                        <td>{{item.proveedor_id}}</td>
                        <td>{{item.nombreproving}}</td>
                        <td>{{item.nombrecortocolab}}</td>
                        <td>{{item.tipodocing}}</td>
                        <td>{{item.nrodocing}}</td>
                        <td>{{item.fechaingresoing}}</td>
                        <td>{{item.cantidading}}</td>
                        <td>{{item.montoing}}</td>
                        <td>
                            <button
                            class="btn btn-success btn-sm"
                            data-toggle="modal"
                            data-target="#compracajamodal"
                            @click="detallecompracaja(item,item.id)"
                            >
                            <img style="width:23px;heigth:23px;" src="/css/img/moreinfo.png" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-show="cargando" class="container-fluid">
            <div class="d-flex justify-content-center">
                <div class="spinner-border" style="width: 4rem; height: 4rem;" role="status">
                <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <div class="modal fade" id="compracajamodal" tabindex="-1" role="dialog" aria-labelledby="compracajamodal" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Compra Caja Chica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-sm table-bordered table-dark dt-responsive t-regular w-100">
                <thead>
                    <tr>
                        <th>Proveedor</th>
                        <th>Nombre Prov</th>
                        <th>Usuario</th>
                        <th>Tipo Doc</th>
                        <th>Nro Doc</th>
                        <th>Fecha</th>
                        <th>Cantidad</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{compracaja.proveedor_id}}</td>
                        <td>{{compracaja.nombreproving}}</td>
                        <td>{{compracaja.nombrecortocolab}}</td>
                        <td>{{compracaja.tipodocing}}</td>
                        <td>{{compracaja.nrodocing}}</td>
                        <td>{{compracaja.fechaingresoing}}</td>
                        <td>{{compracaja.cantidading}}</td>
                        <td>{{compracaja.montoing}}</td>
                    </tr>
                </tbody>
            </table><br>
            <table class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100">
                <thead>
                    <tr>
                        <th>Artículo</th>
                        <th>Nombre Art</th>
                        <th>Bodega</th>
                        <th>Estante</th>
                        <th>Sector</th>
                        <th>Nivel</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item,index) in detcompracaja" :key="index">
                        <td>{{item.codigoart}}</td>
                        <td>{{item.nombreart}}</td>
                        <td>{{item.bodega_id}}</td>
                        <td>{{item.nroestante}}</td>
                        <td>{{item.sectoring}}</td>
                        <td>{{item.niveling}}</td>
                        <td>{{item.cantidading}}</td>
                        <td>{{item.precioing}}</td>
                        <td>{{item.totaling}}</td>                        
                    </tr>
                </tbody>
            </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
        </div>
    </div>
    
</template>

<script>
    export default {
        props: ['databodega'],
        data(){
            return{
                cargando:true,
                usuarios: [],
                colaboradores: [],
                areas: [],
                bodega: [],
                posiciones: [],
                sectores: [],
                codigos:null,
                articulos: [],
                estantes:[],
                detalleingresos:[],
                detallecomprascaja:[],
                compracaja:[],
                detcompracaja:[],
                bodegaselect:'',
                estanteselect:'',
                articulomov:[],
                dt:null,
                dt2:null
            }
        },
        created() {
            this.bodega = this.databodega[8];
            this.usuarios = this.databodega[0];
            this.colaboradores = this.databodega[1];
            this.sectores = this.databodega[5];
            this.areas = this.databodega[6];
            this.articulos = this.databodega[4];
            var cod =_.mapValues(this.databodega[4], function(o) { return o.codigoart; });
            var nom = _.mapValues(this.databodega[4], function(o) { return o.nombreart; });
            this.codigos =Object.values(cod).concat(Object.values(nom));
            //this.posiciones = this.databodega[10];
            this.estantes = this.databodega[9];
            console.log('Component created.');
            axios.post('/bodega/getdatos', {tipo:'ingresos'}).then((res) =>{
                this.detalleingresos = res.data[0];
                this.detallecomprascaja = res.data[1];
                if(this.detalleingresos.length>0){
                    console.log(this.detalleingresos);
                 
                    this.$nextTick(function () {
                        
                        this.dt = $('#tablaingresos').DataTable({
                            "language": {
                                "lengthMenu": "Mostrar _MENU_ filas por página",
                                "zeroRecords": "Ningún resultado según criterio",
                                "info": "Mostrando de _PAGE_ a _PAGES_ (_MAX_ totales)",
                                "infoEmpty": "No se encontraron resultados",
                                "infoFiltered": "(Filtrado desde _MAX_ resultados totales)",
                                "search":         "Buscar:",
                                "paginate": {
                                    "first":      "Primero",
                                    "last":       "Último",
                                    "next":       "Siguiente",
                                    "previous":   "Anterior"
                                },
                            },                        
                        });
                        //this.cargando=false;
                    });  
                }
                this.cargando=false;
                
            }).catch(function(error) {
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
              console.log("Error", error.message);
            }
          });
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            mostraringresos(){
                console.log(this.dt,this.dt2);
                $("#tablacompracaja").hide();
                $("#tablaingresos").show();
                if(this.dt2!=null){
                    this.dt2.destroy();
                    this.dt2=null;
                }
                if(this.dt!=null){
                    this.dt.destroy();
                    this.dt=null;
                }
                this.$nextTick(function () {
                        
                        this.dt = $('#tablaingresos').DataTable({
                            "language": {
                                "lengthMenu": "Mostrar _MENU_ filas por página",
                                "zeroRecords": "Ningún resultado según criterio",
                                "info": "Mostrando de _PAGE_ a _PAGES_ (_MAX_ totales)",
                                "infoEmpty": "No se encontraron resultados",
                                "infoFiltered": "(Filtrado desde _MAX_ resultados totales)",
                                "search":         "Buscar:",
                                "paginate": {
                                    "first":      "Primero",
                                    "last":       "Último",
                                    "next":       "Siguiente",
                                    "previous":   "Anterior"
                                },
                            },                        
                        });
                        //this.cargando=false;
                    });
            },
            montrarcompracaja(){
                console.log(this.dt,this.dt2);
                $("#tablaingresos").hide();
                $("#tablacompracaja").show();
                if(this.dt!=null){
                    this.dt.destroy();
                    this.dt=null;
                }
                if(this.dt2!=null){
                    this.dt2.destroy();
                    this.dt2=null;
                }
                this.$nextTick(function () {
                        
                        this.dt2 = $('#tablacompracaja').DataTable({
                            "language": {
                                "lengthMenu": "Mostrar _MENU_ filas por página",
                                "zeroRecords": "Ningún resultado según criterio",
                                "info": "Mostrando de _PAGE_ a _PAGES_ (_MAX_ totales)",
                                "infoEmpty": "No se encontraron resultados",
                                "infoFiltered": "(Filtrado desde _MAX_ resultados totales)",
                                "search":         "Buscar:",
                                "paginate": {
                                    "first":      "Primero",
                                    "last":       "Último",
                                    "next":       "Siguiente",
                                    "previous":   "Anterior"
                                },
                            },                        
                        });
                        //this.cargando=false;
                    });
                
            },
            detallecompracaja(compra, id){
                this.compracaja=compra;
                axios.post('/bodega/getdatos', {tipo:'detallecompracaja',detalle: id}).then((res) =>{
                        this.detcompracaja = res.data;
                       
                        console.log(res.data);
                        
                    }).catch(function(error) {
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
                        console.log("Error", error.message);
                        }
                    });
            },
            revertiringreso(ingreso, index){
                if(confirm("¿Está seguro de revertir este ingreso a bodega?")){
                    axios.post('/bodega/setdatos', {tipo:'revertiringreso',detalle: ingreso}).then((res) =>{
                        this.$toastr.s("Ingreso "+ingreso.id+" revertido con éxito");
                        this.detalleingresos.splice(index, 1);
                        console.log(this.detalleingresos);
                        this.cargando=false;
                        this.dt.destroy();
                        this.$nextTick(function () {
                            
                            this.dt = $('#tablaingresos').DataTable({
                                "language": {
                                    "lengthMenu": "Mostrar _MENU_ filas por página",
                                    "zeroRecords": "Ningún resultado según criterio",
                                    "info": "Mostrando de _PAGE_ a _PAGES_ (_MAX_ totales)",
                                    "infoEmpty": "No se encontraron resultados",
                                    "infoFiltered": "(Filtrado desde _MAX_ resultados totales)",
                                    "search":         "Buscar:",
                                    "paginate": {
                                        "first":      "Primero",
                                        "last":       "Último",
                                        "next":       "Siguiente",
                                        "previous":   "Anterior"
                                    },
                                },                        
                            });
                            this.cargando=false;
                        });  
                        
                    }).catch(function(error) {
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
                        console.log("Error", error.message);
                        }
                    });
                }
                
            }
        },
    }
    $(document).on('click', '#botonesingresos button',function(e){
        $("#botonesingresos button").each(function(){
            $(this).removeClass("btn-info");
            $(this).addClass("btn-secondary");
        });
        $(this).removeClass("btn-secondary");
        $(this).addClass("btn-info");
    });
</script>
