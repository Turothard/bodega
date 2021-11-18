<template>
    <div class="container-fluid">
        <h1>Movimientos Bodega</h1>
        <div v-show="!cargando" class="container-fluid">
            <table id="tablamovimientos" class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100">
                <thead>
                    <tr>
                        <th class="all">Artículo</th>
                        <th class="desktop">Nombre Art</th>
                        <th class="desktop">Usuario</th>
                        <th class="all">Origen</th>
                        <th class="all">Destino</th>
                        <!-- <th class="all">Bodega Ori</th>
                        <th class="all">Estante Ori</th>
                        <th class="all">Sector Ori</th>
                        <th class="all">Nivel Ori</th>
                        <th class="all">Bodega Des</th>
                        <th class="all">Estante Des</th>
                        <th class="all">Sector Des</th>
                        <th class="all">Nivel Des</th> -->
                        <th class="all">Cantidad</th>
                        <th class="desktop">Fecha</th>
                        <th class="all">Funciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item,index) in detallemovimientos" :key="index">
                        <td>{{item.codigoart}}</td>
                        <td>{{item.nombreart}}</td>
                        <td>{{item.nombrecortocolab}}</td>
                        <td>
                            {{item.bodegaidori}} - {{ estantes.find( items => items.id === item.estanteori ).nroestante }} , {{item.sectorori}} , {{item.nivelori}}
                        </td>
                        <td>
                            {{item.bodegaiddes}} - {{ estantes.find( items => items.id === item.estantedes ).nroestante }} , {{item.sectordes}} , {{item.niveldes}}
                        </td>
                        <!-- <td>{{item.bodegaidori}}</td>
                        <td>{{ estantes.find( items => items.id === item.estanteori ).nroestante }}</td>
                        <td>{{item.sectorori}}</td>
                        <td>{{item.nivelori}}</td>
                        <td>{{item.bodegaiddes}}</td>
                        <td>{{ estantes.find( items => items.id === item.estantedes ).nroestante }}</td>
                        <td>{{item.sectordes}}</td>
                        <td>{{item.niveldes}}</td> -->
                        <td>{{item.cantidad}}</td>
                        <td>{{item.fechamov}}</td>
                        <td>
                             <button 
                                v-if="item.fechamov == item.updated_at" 
                                @click="revertirmovimiento(item, index)" 
                                title="Revertir Movimiento" 
                                class="btn btn-danger btn-sm">
                                <img style="width:23px;heigth:23px;" src="/css/img/revertir.png"/>
                             </button>
                             <button 
                                v-if="item.fechamov != item.updated_at && user=='ADMIN' && date_diff(item.fechamov)<3" 
                                @click="generarajuste(item)" 
                                data-toggle="modal" 
                                data-target="#bodegamovdetmodal"
                                title="Ajustar Movimiento" 
                                class="btn btn-warning btn-sm">
                                <img style="width:23px;heigth:23px;" src="/css/img/ajuste.png"/>
                             </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="modal fade" id="bodegamovdetmodal" tabindex="-1" role="dialog" aria-labelledby="bodegamovdetmodalTitle" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Ajuste Movimiento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="detalleart" class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular">
                            <thead>
                                <tr>
                                <th colspan="5">Código</th>
                                <th colspan="5">Nombre Artículo</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5">{{detallemov.codigoart}}</td>
                                    <td colspan="5">{{detallemov.nombreart}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table id="detalleart" class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular">
                            <thead>
                                <tr>
                                    <th colspan="5">Posición Original</th>
                                    <th colspan="5">Nueva Posición</th>
                                </tr>
                                <tr>
                                    <th>Bodega</th>
                                    <th>Estante</th>
                                    <th>Sector</th>
                                    <th>Nivel</th>
                                    <th>Bodega</th>
                                    <th>Estante</th>
                                    <th>Sector</th>
                                    <th>Nivel</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>   
                                    <td>{{detallemov.bodegaidori}}</td>
                                    <td  v-if="detallemov.estanteori !=null">{{ estantes.find( items => items.id === detallemov.estanteori ).nroestante }}</td>
                                    <td>{{detallemov.sectorori}}</td>
                                    <td>{{detallemov.nivelori}}</td>
                                    <td>{{detallemov.bodegaiddes}}</td>
                                    <td  v-if="detallemov.estanteori !=null">{{ estantes.find( items => items.id === detallemov.estantedes ).nroestante }}</td>
                                    <td>{{detallemov.sectordes}}</td>
                                    <td>{{detallemov.niveldes}}</td>
                                    <td>{{detallemov.cantidad}}</td>
                                    <td v-if="detallemov.estanteori !=null">
                                        <input type="text" v-model="detallemov.cantidad" class="form-control w-xs" :id="'cantidadmov'" name="cantidadmov">
                                    </td>
                                </tr>
                            </tbody>
                    </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Realizar Ajuste</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-show="cargando" class="container-fluid">
            <div class="d-flex justify-content-center">
                <div class="spinner-border" style="width: 4rem; height: 4rem;" role="status">
                <span class="sr-only">Loading...</span>
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
                detallemov:[],
                detallemovimientos:[],
                bodegaselect:'',
                estanteselect:'',
                detallemov:[],
                user:null,
                dt:null
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
            this.user = this.databodega[11];
            console.log('Component created.');
            axios.post('/bodega/getdatos', {tipo:'movimientos'}).then((res) =>{
                this.detallemovimientos = res.data;
                if(this.detallemovimientos.length>0){
                    console.log(this.detallemovimientos);
                // this.cargando=false;
                    this.$nextTick(function () {    
                        this.dt = $('#tablamovimientos').DataTable({
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
                }
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
            revertirmovimiento(movimiento, index){
                if(confirm("¿Está seguro de revertir este movimiento?")){
                    axios.post('/bodega/setdatos', {tipo:'revertirmovimiento',detalle: movimiento}).then((res) =>{
                        this.$toastr.s("Movimiento "+movimiento.id+" revertido con éxito");
                        this.detallemovimientos.splice(index, 1);
                        console.log(this.detallemovimientos);
                        //this.cargando=false;
                        this.dt.destroy();
                        this.$nextTick(function () {
                            
                            this.dt = $('#tablamovimientos').DataTable({
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
            },
            generarajuste(item){
                console.log(item);
                this.detallemov = item;
            },
            date_diff(date1,date2){
                var dt1 = new Date(date1);
                if(date2!=null){
                    var dt2 = new Date(date2);
                }else{
                    var dt2 = new Date();
                }
                //console.log(dt1);
                //dt2 = new Date(date2);
                return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
            }
        },
    }
</script>
