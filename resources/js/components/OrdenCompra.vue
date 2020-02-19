<template>
    <div class="container-fluid">
        <div v-show="terminado==1" class="container-fluid">
            <div class="btn-group" role="group" aria-label="Generar Orden">
                <button
                type="button"
                class="btn btn-info"
                data-toggle="modal"
                data-target="#ordencompramodal"
                >Generar Orden Compra</button>
            </div>
            <div>
                <table
                id="tablaordencompra"
                class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100"
                >
                <thead>
                    <tr>
                    <th class="all">OC</th>
                    <th class="desktop">Categoría</th>
                    <th class="all">Proveedor</th>
                    <th class="desktop">Fecha</th>
                    <th class="all">Usuario</th>
                    <th class="all">Cantidad Total</th>
                    <th class="desktop">Monto total</th>
                    <th class="all">Estado</th>
                    <th class="all">Funciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item,index) in ordencompras" :key="index">
                        <td>
                           {{item.nrooc}} 
                        </td>
                        <td v-if="item.categoria_id!=''">
                           {{ categorias.find( items => items.idcategoria === item.categoria_id ).nombrecat }}
                        </td>
                        <td>
                           {{ proveedores.find( items => items.rutproveedor === item.proveedor_id ).nombreprov }}
                        </td>
                        <td>
                           {{item.fechaoc}} 
                        </td>
                        <td>
                           {{ usuarios.find( items => items.id === item.user_id ).name }}
                        </td>
                        <td>
                           {{item.cantidadoc}} 
                        </td>
                        <td>
                           {{item.montooc}} 
                        </td>
                        <td>
                           {{item.estadooc}} 
                        </td>
                        <td>
                            <button class="btn btn-info btn-sm"
                                data-toggle="modal"
                                data-target="#detalleocmodal"
                                @click="buscardetalleoc(item,index)"
                                >
                                <img style="width:23px;heigth:23px;" title="Monstrar Detalle OC" src="css/img/moreinfo.png"
                                 />
                            </button>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
        <component v-bind:is="componenteactual" :dataordencompra="dataordencompra" ></component>
        <div class="modal fade" id="detalleocmodal" tabindex="-1" role="dialog" aria-labelledby="detalleocmodal" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div v-if="detordencompra!=null" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detalleocmodalTitle">Detalle OC {{oc.nrooc}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div>
                                <table class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100" >
                                    <thead>
                                        <tr>
                                        <th class="all">OC</th>
                                        <th class="desktop">Categoría</th>
                                        <th class="all">Proveedor</th>
                                        <th class="desktop">Fecha</th>
                                        <th class="all">Usuario</th>
                                        <th class="all">Cantidad Total</th>
                                        <th class="desktop">Monto total</th>
                                        <th class="all">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                            {{oc.nrooc}} 
                                            </td>
                                            <td v-if="oc.categoria_id!=''">
                                            {{ categorias.find( items => items.idcategoria === oc.categoria_id ).nombrecat }}
                                            </td>
                                            <td>
                                            {{ proveedores.find( items => items.rutproveedor === oc.proveedor_id ).nombreprov }}
                                            </td>
                                            <td>
                                            {{oc.fechaoc}} 
                                            </td>
                                            <td>
                                            {{ usuarios.find( items => items.id === oc.user_id ).name }}
                                            </td>
                                            <td>
                                            {{oc.cantidadoc}} 
                                            </td>
                                            <td>
                                            {{oc.montooc}} 
                                            </td>
                                            <td>
                                            {{oc.estadooc}} 
                                            </td>
                                            
                                        </tr>
                                    </tbody>
                                    </table>
                                <table id="tabladetalleoc" class="table table-striped display table-sm table-bordered table-dark t-regular dt-responsive w-100">
                                    <thead>
                                        <tr>
                                            <th class="all">Detalle Art</th>
                                            <th class="desktop">Código Art</th>
                                            <th class="desktop">Bodega</th>
                                            <th class="desktop">Sector</th>
                                            <th class="all">Color</th>
                                            <th class="desktop">Color Sis (*)</th>
                                            <th class="all">Marca</th>
                                            <th class="all">Talla</th>
                                            <th class="all">Cantidad</th>
                                            <th class="all">Monto</th>
                                            <th class="all">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item,index) in detordencompra" :key="index">
                                            <td>{{item.articulodetoc}}</td>
                                            <td>{{item.codigoart}}</td>
                                            <td>{{item.bodega_id}}</td>
                                            <td>{{dataordencompra[5].find( items => items.idsector === item.sector_id ).nombresec}}</td>
                                            <td>{{item.colordetoc}}</td>
                                            <td>{{dataordencompra[10].find( items => items.idcolor === item.color_id ).nombrecol }}</td>
                                            <td>{{item.marca_id}}</td>
                                            <td>{{dataordencompra[11].find( items => items.idunidad === item.unidad_id).descripcionunimed }}</td>
                                            <td>{{item.cantidaddetoc}}</td>
                                            <td>{{item.montounitariodetoc}}</td>
                                            <td>{{item.montototaldetoc}}</td>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="guardaroc()">Guardar </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        
                    </div>
                </div>
            </div>
        </div> 
    </div>
</template>

<script>
    import ingresooc from './ordencompra/ingresoordencompra.vue';

    export default {
        components: {
            ingresooc, 
        },
        data(){
            return{
                dt: null,
                dt2: null,
                dataordencompra:null,
                pedido:{},
                ordencompras:[],
                componenteactual:'',
                detordencompra:null,
                oc :[],
                usuarios: [],
                colaboradores: [],
                areas: [],
                categorias: [],
                sectores: [],
                proveedores: [],
                terminado:0,
                user:null
            }
        },
        created() {
            axios.post('/sistema/getdatos', {tipo:'OrdenCompra'}).then((res) =>{
                this.dataordencompra = res.data;
                this.usuarios = this.dataordencompra[0];
                this.colaboradores = this.dataordencompra[1];
                this.sectores = this.dataordencompra[5];
                this.areas = this.dataordencompra[6];
                this.categorias = this.dataordencompra[2];
                this.ordencompras = this.dataordencompra[8];
                this.proveedores = this.dataordencompra[9];
                console.log(this.ordencompras);
                this.terminado=1;
                this.componenteactual='ingresooc';
                this.$nextTick(function() {
                    if(this.dt!=null){
                        this.dt.destroy();
                    }
                this.dt = $("#tablaordencompra").DataTable({
                    language: {
                    lengthMenu: "Mostrar _MENU_ filas por página",
                    zeroRecords: "Ningún resultado según criterio",
                    info: "Mostrando de _PAGE_ a _PAGES_ (_MAX_ totales)",
                    infoEmpty: "No se encontraron resultados",
                    infoFiltered: "(Filtrado desde _MAX_ resultados totales)",
                    search: "Buscar:",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                    },
                    responsive: true,
                    order: [0, "desc"]
                });
               
                console.log("cargado");
                this.terminado = 1;
                });
            }).catch((error) =>{
                console.log(error.response.data.errors);
                this.err_list = error.response.data.errors;
                if (this.err_list.rut != null) {
                    this.server_alert.rut = 'fa fa-exclamation-circle';
                };
                if (this.err_list.correo != null) {
                    this.server_alert.correo = 'fa fa-exclamation-circle';
                };
            });
            
        },
        methods: {
            buscardetalleoc(item, index){
                this.detordencompra = null;
                this.oc = _.cloneDeep(item);
                axios.post('/ordencompra/getdatos', {tipo:'detalleoc', oc: parseInt(this.oc.nrooc)}).then((res) =>{
                    
                    if(res.data!=null){
                        this.detordencompra= res.data;
                        this.$nextTick(function() {
                            if(this.dt2!=null){
                                this.dt2.destroy();
                            }
                            this.dt2 = $("#tabladetalleoc").DataTable({
                                language: {
                                lengthMenu: "Mostrar _MENU_ filas por página",
                                zeroRecords: "Ningún resultado según criterio",
                                info: "Mostrando de _PAGE_ a _PAGES_ (_MAX_ totales)",
                                infoEmpty: "No se encontraron resultados",
                                infoFiltered: "(Filtrado desde _MAX_ resultados totales)",
                                search: "Buscar:",
                                paginate: {
                                    first: "Primero",
                                    last: "Último",
                                    next: "Siguiente",
                                    previous: "Anterior"
                                }
                                },
                                responsive: true
                            });
                        
                            
                        });
                    }
                    console.log(this.detordencompra);
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
    $(document).on('click', '#ulbodega li',function(e){
        if($(this).hasClass('active')){
            console.log("entro al if");
            e.preventDefault();
            return;
        }else{
            console.log("entro al else");
            $("#ulbodega li.active").removeClass('active');
            $(this).addClass('active');
        }
    });
</script>
