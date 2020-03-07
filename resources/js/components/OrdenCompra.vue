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
                            <button class="btn btn-info btn-sm" v-if="item.estadooc=='INGRESADO' || item.estadooc=='RECEPCIÓN IMCOMPLETA'"
                                data-toggle="modal"
                                data-target="#detalleocmodal"
                                @click="recepcionaroc(item,index)"
                                >
                                <img style="width:23px;heigth:23px;" title="Recepcionar OC" src="css/img/recepcionar.png"
                                 />
                            </button>
                            <button class="btn btn-info btn-sm" v-if="item.estadooc=='RECEPCIONADO' || item.estadooc=='RECEPCIÓN IMCOMPLETA'"
                                data-toggle="modal"
                                data-target="#detalleocmodal"
                                @click="ingresaroc(item,index)"
                                >
                                <img style="width:23px;heigth:23px;" title="Ingresar artículos OC" src="css/img/ingresarbodega.png"
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
                                        <th class="all">Cant Total</th>
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
                                <div class="row" v-if="tipomodal =='recepcionaroc'">
                                    <div class="col-8">
                                        <table class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular">
                                            <thead>
                                                <tr>
                                                    <th>TIPO DOC</th>
                                                    <th>NRO DOC</th>
                                                    <th>FOTO DOC</th>
                                                    <td>FUNCIONES</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-show="oc.cantidadoc!=cantidaddetdocs">
                                                    <td>
                                                        <select class="form-control form-control-sm w-d1" name="tipodocumento" id="tipodocumento" v-model="newrecepcion.tipodocumento">
                                                            <option value="">---------------</option>
                                                            <option value="FACTURA">FACTURA</option>
                                                            <option value="GUIA">GUÍA</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm w-s" v-model="newrecepcion.nrodocumento">
                                                    </td>
                                                    <td>
                                                        <button  v-if="newrecepcion.fotodocumento =='' || newrecepcion.fotodocumento ==null" class="btn btn-info btn-sm" @click="$refs.subirnewimage.click()"><img style="width:23px;heigth:23px;" src="css/img/addimage.png"/></button>
                                                        <button  v-if="newrecepcion.fotodocumento !=''" class="btn btn-info btn-sm" @click="eliminarimagen(newrecepcion)"><img style="width:23px;heigth:23px;" src="css/img/delete.png"/></button>
                                                        <input type="file" accept="image/*" ref="subirnewimage" capture="camera" id="newimage" @change="handleFileUpload(newrecepcion)" style="display:none"/>
                                                        
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr v-for="(item,index) in dococ" :key="index">
                                                    <td>{{item.tipodocumento}}</td>
                                                    <td>{{item.nrodocumento}}</td>
                                                    <td>{{item.fotodocumento.name}}</td>
                                                    <td>
                                                        <button @click="eliminardoc(item)" class="btn btn-warning btn-sm">
                                                            <img style="width:23px;heigth:23px;" src="css/img/remover.png" />
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-4">
                                        <div class="row">
                                            <div class="col-5"><img v-bind:src="imagePreview" v-show="showPreview" style="width:100px; height:100px"/></div>
                                            <div class="col-7">
                                                <button  type="button" class="btn btn-primary" @click="agregardoc()">Ingresar Doc</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                
                                <table id="tabladetalleoc" class="table table-striped display table-sm table-bordered table-dark t-regular dt-responsive w-100">
                                    <thead>
                                        <tr>
                                            <th class="all">Detalle Art</th>
                                            <th class="desktop">Código Art</th>
                                            <th class="desktop">Bodega</th>
                                            <th class="desktop">Sector</th>
                                            <th class="all">Color</th>
                                            <th class="desktop">Color Sis (*)</th>
                                            <th class="desktop">Marca</th>
                                            <th class="all">Talla</th>
                                            <th class="all">Cant</th>
                                            <th v-if="tipomodal=='recepcionaroc'" class="all">Recepción</th>
                                            <th class="all">Valor</th>
                                            <th class="all">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item,index) in detordencompra" :key="index" v-show="item.cantidaddetoc - item.cantidadrecoc!=0">
                                            <td>{{item.articulodetoc}}</td>
                                            <td>{{item.codigoart}}</td>
                                            <td>{{item.bodega_id}}</td>
                                            <td>{{dataordencompra[5].find( items => items.idsector === item.sector_id ).nombresec}}</td>
                                            <td>{{item.colordetoc}}</td>
                                            <td>{{dataordencompra[10].find( items => items.idcolor === item.color_id ).nombrecol }}</td>
                                            <td>{{dataordencompra[12].find( items => items.idmarca === item.marca_id ).nombremar}}</td>
                                            <td>{{dataordencompra[11].find( items => items.idunidad === item.unidad_id).descripcionunimed }}</td>
                                            <td>{{item.cantidaddetoc - item.cantidadrecoc}}</td>
                                            <td v-if="tipomodal=='recepcionaroc'">
                                                <input type="number" minlength="0" class="form-control form-control-sm w-xs2" v-model="item.cantvuerec"
                                                @focus="quitarcero(item)"
                                                @focusout="ponercero(item)" />
                                            </td>
                                            <td>{{item.montounitariodetoc}}</td>
                                            <td>{{item.montototaldetoc}}</td>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                                <table id="tabladetalleoc" class="table table-striped display table-sm table-bordered table-dark t-regular dt-responsive w-100"  v-if="tipomodal =='recepcionaroc'">
                                        <thead>
                                            <tr>
                                                <th class="desktop">Documento</th>
                                                <th class="all">Detalle Art</th>
                                                <th class="desktop">Marca</th>
                                                <th class="desktop">Color</th>
                                                <th class="all">Talla</th>
                                                <th class="all">Cant</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,index) in detdococ" :key="index">
                                                <td>{{item.nrodocvue}}</td>
                                                <td>{{item.articulodetoc}}</td>
                                                <td>{{dataordencompra[12].find( items => items.idmarca === item.marca_id ).nombremar}}</td>
                                                <td>{{dataordencompra[10].find( items => items.idcolor === item.color_id ).nombrecol }}</td>
                                                <td>{{dataordencompra[11].find( items => items.idunidad === item.unidad_id).descripcionunimed }}</td>
                                                <td>{{item.cantvuerec}}</td>                                            
                                            </tr>
                                        </tbody>
                                    </table>
                                <div v-if="tipomodal !='ingresaroc'">
                                    
                                    <div v-if="datadococ.length>0">
                                        <h2>Detalle Documentos</h2>
                                        <table  class="table table-striped display table-sm table-bordered table-dark t-regular dt-responsive w-100"
                                        v-for="(item,index) in datadococ" :key="index">
                                            <thead>
                                                <tr>
                                                    <th class="desktop">Tipo Documento</th>
                                                    <th class="all">Nro Documento</th>
                                                    <th class="desktop">Proveedor</th>
                                                    <th class="desktop">Foto</th>
                                                    <th class="all">Usuario</th>
                                                    <th class="all">Ingresado</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{item.tipodocumento}}</td>
                                                    <td>{{item.nrodocumento}}</td>
                                                    <td>{{dataordencompra[9].find( items => items.rutproveedor === item.proveedor_id ).nombreprov}}</td>
                                                    <td>{{item.dctofisico}}</td>
                                                    <td>{{dataordencompra[0].find( items => items.id === item.user_id).name }}</td>
                                                    <td>{{item.created_at}}</td>                                      
                                                </tr>
                                                <tr>
                                                    <td colspan="7">
                                                        <div>
                                                            <table class="table table-striped display table-sm table-bordered table-dark t-regular dt-responsive w-100">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="desktop">Artículo</th>
                                                                        <th class="desktop">Marca</th>
                                                                        <th class="desktop">Color</th>
                                                                        <th class="all">Talla</th>
                                                                        <th class="all">Cant</th>
                                                                        <th class="all">Valor</th>
                                                                        <th class="all">Total</th>
                                                                        
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="(item2,index2) in filteroc(item.id)" :key="index2">
                                                                        <td>{{item2.articulodetoc}}</td>
                                                                        <td>{{dataordencompra[12].find( items => items.idmarca === item2.marca_id ).nombremar}}</td>
                                                                        <td>{{dataordencompra[10].find( items => items.idcolor === item2.color_id ).nombrecol }}</td>
                                                                        <td>{{dataordencompra[11].find( items => items.idunidad === item2.unidad_id).descripcionunimed }}</td>
                                                                        <td>{{item2.cantidaddococ}}</td>                                            
                                                                        <td>{{item2.montounitariodetoc}}</td>  
                                                                        <td>{{item2.montototaldococ}}</td>  
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" v-if="tipomodal=='recepcionaroc'" class="btn btn-primary" @click="ingresarrecepcion()">Ingresar Recepción </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        
                    </div>
                </div>
            </div>
        </div> 
    </div>
</template>

<script>
    import ingresooc from './ordencompra/ingresoordencompra.vue';
    import recepcionoc from './ordencompra/recepcionoc.vue';

    export default {
        components: {
            ingresooc,
            recepcionoc
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
                datadococ:[],
                datarecepoc:[],
                detdococ: [],
                dococ:[],
                oc :[],
                usuarios: [],
                colaboradores: [],
                newrecepcion:{tipodocumento:'', nrodocumento:'', fotodocumento:''},
                areas: [],
                categorias: [],
                sectores: [],
                tipomodal: '',
                proveedores: [],
                terminado:0,
                cantidaddetdocs:0,
                file: '',
                showPreview: false,
                imagePreview: '',
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
            filteroc(item){
                let data= _.filter(this.datarecepoc, ['doc_id', item]);
                console.log(data);
                return data;
            },
            buscardetalleoc(item, index){
                this.detordencompra = null;
                this.tipomodal ='detalleoc';
                this.oc = _.cloneDeep(item);
                axios.post('/ordencompra/getdatos', {tipo:'detalleoc', oc: parseInt(this.oc.nrooc)}).then((res) =>{
                    
                    if(res.data!=null){
                        this.detordencompra= res.data[0];
                        this.datadococ = res.data[1];
                        this.datarecepoc = res.data[2];
                        console.log(this.datadococ);
                        this.$nextTick(function() {
                            if(this.dt2!=null){
                                this.dt2.destroy();
                            }
                            this.dt2 = $("#tabladetalleoc").DataTable({
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
                                "info":false,
                                "paging": false,
                                "searching": false
                            });
                        
                            
                        });
                    }
                   // console.log(this.detordencompra);
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
            recepcionaroc(item, index){
                this.detordencompra = null;
                this.tipomodal ='recepcionaroc';
                this.oc = _.cloneDeep(item);
                axios.post('/ordencompra/getdatos', {tipo:'recepcionaroc', oc: parseInt(this.oc.nrooc)}).then((res) =>{
                    
                    if(res.data!=null){
                        this.detordencompra= res.data;
                        this.$nextTick(function() {
                            if(this.dt2!=null){
                                this.dt2.destroy();
                            }
                            this.dt2 = $("#tabladetalleoc").DataTable({
                                "paging": false,
                                "searching": false
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
            },
            ingresaroc(item, index){
                this.detordencompra = null;
                this.tipomodal ='ingresaroc';
                this.oc = _.cloneDeep(item);
                axios.post('/ordencompra/getdatos', {tipo:'detalleoc', oc: parseInt(this.oc.nrooc)}).then((res) =>{
                    if(res.data!=null){
                        this.detordencompra= res.data[0];
                        this.$nextTick(function() {
                            if(this.dt2!=null){
                                this.dt2.destroy();
                            }
                            this.dt2 = $("#tabladetalleoc").DataTable({
                                "paging":         false,
                                "searching": false
                            });
                        
                            
                        });
                    }
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
            quitarcero(item){
                if(parseInt(item.cantvuerec)==0){
                    item.cantvuerec='';
                }
            },
            ponercero(art){
                //console.log("poner cero 1 "+this.inventario.cantidaddiftotal);
                if(art.cantvuerec==''){
                    art.cantvuerec=0;
                }
            },
            handleFileUpload(doc){
                this.file = this.$refs.subirnewimage.files[0];
                doc.fotodocumento = this.file;
                let reader  = new FileReader();
                reader.addEventListener("load", function () {
                    this.showPreview = true;
                    this.imagePreview = reader.result;
                }.bind(this), false);
                if( this.file ){
                    if ( /\.(jpe?g|png|gif)$/i.test( this.file.name ) ) {
                        reader.readAsDataURL( this.file );
                    }
                }
            },
            eliminarimagen(doc){
                doc.fotodocumento='';
                this.showPreview = false;
                this.imagePreview = '';
                //this.$refs.subirnewimage='';
            },
            eliminardoc(doc){
                let index;
                let indexs;
                let dets =_.filter(this.detdococ, ['nrodocvue', doc.nrodocumento]);
                dets.forEach(det => {
                    
                    this.detordencompra.find( items => items.iddetalleoc === det.iddetalleoc ).cantidaddetoc +=parseInt(det.cantidadrecoc);
                    console.log(doc.nrodocumento+""+det.iddetalleoc);
                    this.cantidaddetdocs = this.cantidaddetdocs - parseInt(det.cantidadrecoc);
                    indexs=this.detdococ.findIndex(docs=>docs.iddocvue === doc.nrodocumento+""+det.iddetalleoc);
                    this.detdococ.splice(indexs,1);
                });
                index =this.dococ.findIndex(docs=>docs.nrodocumento === doc.nrodocumento);
                this.dococ.splice(index,1);
                
                console.log(index);
                console.log(indexs);

            },
            agregardoc(){
                let cont=0;
                if(this.newrecepcion.tipodocumento=='' || this.newrecepcion.nrodocumento==''){
                    this.$toastr.w("Tipo Documento y Nro de Documento son obligatorios");
                    return;
                }
                let dets =_.filter(this.dococ, {'nrodocumento': this.newrecepcion.nrodocumento, 'tipodocumento' :this.newrecepcion.tipodocumento });
                if(dets.length>0){
                    this.$toastr.w("Este documento ya ha sido asociado a esta orden de compra, favor revisar");
                    return;
                }
                this.detordencompra.forEach(data => {
                    console.log(data);
                    if(data.cantvuerec>0){
                        cont++;
                        //data.cantidaddetoc = data.cantidaddetoc - data.cantvuerec;
                        data.nrodocvue = this.newrecepcion.nrodocumento;
                        data.iddocvue = this.newrecepcion.nrodocumento+""+data.iddetalleoc;
                        data.cantidadrecoc =  data.cantidadrecoc +parseInt(data.cantvuerec);
                        this.cantidaddetdocs = this.cantidaddetdocs + parseInt(data.cantvuerec);
                        this.detdococ.push(_.cloneDeep(data));
                        data.cantvuerec=0;
                    }
                });
                if(cont==0){
                    this.$toastr.w("Para agregar el documento debe asociar mínimo un producto");
                    return;
                }
                this.dococ.push(_.cloneDeep(this.newrecepcion));
                this.newrecepcion={tipodocumento:'', nrodocumento:'', fotodocumento:''};
                this.showPreview = false;
                this.imagePreview = '';
                console.log(this.dococ);
                console.log(this.detdococ);
            },
            ingresarrecepcion(){
                let porcentaje ='';
                if(this.detdococ.length==0 || this.dococ.length==0){
                    this.$toastr.w("Para ingresar una recepción debe ingresar mínimo un documento asociado");
                    return;
                }
                if(this.oc.cantidadoc!=this.cantidaddetdocs){
                    if(!confirm("¿No ha completado el 100% de la orden de compra, esta seguro de ingresar una recepción parcial?")){
                        return
                    }else{
                        porcentaje='incompleto';
                    }
                }else{
                    porcentaje='completo';
                }

                axios.post('/ordencompra/setdatos', {tipo:'guardarrecepcion',documentos: this.dococ, articulos:this.detdococ, oc: this.oc.nrooc, porcentaje:porcentaje})
                    .then((res) =>{
                        let resp = res.data;
                        console.log(resp);
                        this.dococ.forEach(dato => {
                            if(typeof dato.fotodocumento !=='undefined' && dato.fotodocumento !=null ){
                                console.log("entro a guardar imagen");
                                let formData = new FormData();
                                formData.append('image',dato.fotodocumento);
                                formData.append('nombre',this.oc.nrooc+"_"+dato.nrodocumento);
                                formData.append('tipo','documentooc');
                                axios.post('/sistema/uploadimage', formData, {
                                    headers: {
                                    'Content-Type': 'multipart/form-data'
                                    }
                                })
                                .then(response => {
                                    console.log(response.data.message, 'success');
                                })
                                .catch(function (error) {
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
                        });
                              
                        
                            setTimeout(function() {
                                 $(".close").click();
                                location.reload();
                            }, 2000);                     
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
