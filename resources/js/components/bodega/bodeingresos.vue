<template>
    <div class="container-fluid">
        <h1>Ingresos Bodega</h1>
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
                             <button v-if="item.fechaing == item.updated_at" @click="revertiringreso(item, index)" title="Revertir Ingreso" class="btn btn-danger btn-sm"><img style="width:23px;heigth:23px;" src="css/img/revertir.png"/></button>
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
                bodegaselect:'',
                estanteselect:'',
                articulomov:[],
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
            console.log('Component created.');
            axios.post('/bodega/getdatos', {tipo:'ingresos'}).then((res) =>{
                this.detalleingresos = res.data;
                if(this.detalleingresos.length>0){
                    console.log(this.detalleingresos);
                // this.cargando=false;
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
</script>
