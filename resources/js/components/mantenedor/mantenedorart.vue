<template>
    <div class="container-fluid">
        <br>
        <div>
            <button class="btn btn-info btn-sm"  data-toggle="modal" data-target="#pedidomodal" @click="cargarcrear()">Agregar Artículos</button>
        </div>
        <div>
            <table id="tabladetalle" class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100">
                <thead>
                    <tr>
                        <th class="all">Código Art</th>
                        <th class="desktop">Categoría</th>
                        <th class="desktop">Sub Cate</th>
                        <th class="all">Nombre Art</th>
                        <th class="desktop">Color</th>
                        <th class="desktop">Talla</th>
                        <th class="desktop">Marca</th>
                        <th class="all">Imagen</th>
                        <th class="none">Per Devo</th>
                        <th class="none">St Crít</th>
                        <th class="none">Ind Rot</th>
                        <th class="all">Funciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item,index) in articulos" :key="index">
                        <td>{{item.codigoart}}</td>
                        <td :title="item.nombrecat">{{item.codigocat}}</td>
                        <td :title="item.nombresubcat">{{item.codigosubcat}}</td>
                        <td>{{item.nombreart}}</td>
                        <td :title="item.nombrecol">{{item.color_id}}</td>
                        <td :title="item.nombretipounimed+' '+item.codigounimed">{{item.codigounimed}}</td>
                        <td>{{item.nombremar}}</td>
                        <td v-if="item.image!=null">
                            <button class="btn btn-info btn-sm" @click="cargareditar(item)"><img style="width:23px;heigth:23px;" src="css/img/verimage.png"/></button>
                        </td>
                        <td v-else>
                            <button class="btn btn-info btn-sm" @click="cargareditar(item)"><img style="width:23px;heigth:23px;" src="css/img/addimage.png"/></button>
                        </td>
                        <td :title="item.descripcionper">{{item.periododevo}}</td>
                        <td>{{item.stockcriticoart}}</td>
                        <td>{{item.indicerotacionart}}</td>
                        <td>
                            <button class="btn btn-info btn-sm" @click="cargareditar(item)"><img style="width:23px;heigth:23px;" src="css/img/editar.png"/></button>
                            <button class="btn btn-danger btn-sm"><img style="width:23px;heigth:23px;" src="css/img/delete.png"/></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="artoculosmodal" tabindex="-1" role="dialog" aria-labelledby="articulomodallabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="tipoarticulo=='crear'" class="modal-title" id="exampleModalLabel">Crear nuevo Artículo</h5>
                        <h5 v-if="tipoarticulo=='editar'" class="modal-title" id="exampleModalLabel">Actualizar Artículo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <dir class="row">
                            <div class="col-3">
                                <input type="text" name="codigoart" readonly id="codigoart" v-model="articulovue.codigoart">
                            </div>
                            <div class="col-3">
                                <select v-model="articulovue.categoria_id" >
                                    <option value="">------</option>
                                    <option v-for="(item, index) in datamantenedor[2]" :key="index" :value="item.idcategoria">
                                        {{ item.nombrecat }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-3">
                                <select v-model="articulovue.subcategoria_id" >
                                    <option value="">------</option>
                                    <option v-for="(item, index) in datamantenedor[3]" :key="index" :value="item.idcategoria">
                                        {{ item.nombresubcat }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-3"></div>
                            <div class="col-3"></div>
                            <div class="col-3"></div>
                            <div class="col-3"></div>
                            <div class="col-3"></div>
                            <div class="col-3"></div>
                            <div class="col-3"></div>
                            <div class="col-3"></div>
                            <div class="col-3"></div>
                        </dir>                        
                    </div>
                    <div class="modal-footer">
                        
                        <button type="button" class="btn btn-primary" @click="modificarpedido(pedido)">
                            <label v-if="tipoarticulo=='crear'" for="">Guardar Artículo</label>
                            <label v-if="tipoarticulo=='editar'" for="">Editar Artículo</label>
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        
                    </div>
                    </div>
                </div>
            </div>
    </div>
</template>

<script>
    export default {
        props: ['datamantenedor'],
        data(){
            return{
                preestablecidovue:null,
                cargando:true,
                articulos: [],
                tipoarticulo:'',
                articulovue:
                    {codigoart: '', codigoalternativoart: '', categoria_id: '', subcategoria_id: '', 
                    nombreart: '', proveedorart: '', descripcionart: '', color_id: '', unidad_id: '', 
                    marca_id: '', stockcriticoart: 1, indicerotacionart: 180, yearart: 2019, 
                    periododevo_id: 1, image: null},
                dt:null
            }
        },
        computed: {
        // a computed getter
        },
        created() {
            
            console.log('Component created.');
            axios.post('/mantenedores/getdatos', {tipo:'articulos'}).then((res) =>{
                this.articulos = res.data;
                //this.cargando=false;
                this.$nextTick(function () {
                
                    this.dt = $('#tabladetalle').DataTable({
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
        methods: {
            cargarcrear(){

            },
            cargareditar(arti){

            },
        },
    }
</script>
