<template>
    <div class="container-fluid">
        <div v-show="!cargando" class="container-fluid">
        <div>
            <div class="btn-group" role="group" aria-label="Generar Inventario">
                <button
                type="button"
                class="btn btn-info"
                data-toggle="modal"
                data-target="#inventariomodal"
                @click="tableresp('ingresar',null)" 
                v-if="flaginventario"
                >Continuar inventario</button>
                <button
                type="button"
                class="btn btn-info"
                data-toggle="modal"
                data-target="#inventariomodal"
                @click="tableresp('ingresar',null)" 
                v-else
                >Generar inventario</button>
            </div><br><br>
            <table class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo Inventario</th>
                        <th>Bodega</th>
                        <th>Estante</th>
                        <th>Usuario</th>
                        <th>Cant Sistema</th>
                        <th>Cant Inventario</th>
                        <th>Diferencia</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Funciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item,index) in detalleinventarios" :key="index">
                        <td>{{item.id}}</td>
                        <td>{{item.tipoinv}}</td>
                        <td>{{item.bodega_id}}</td>
                        <td v-if="item.estante_id!=null">{{ estantes.find( items => items.id === parseInt(item.estante_id) ).nroestante }}</td>
                         <td v-else>--------</td>
                        <td>{{item.nombrecortocolab}}</td>
                        <td>{{item.cantidadbodtotal}}</td>
                        <td>{{item.cantidadinvtotal}}</td>
                        <td>{{item.cantidaddiftotal}}</td>
                        <td>{{item.fechainv}}</td>
                        <td>{{item.estadoinv}}</td>
                        <td>
                            <button class="btn btn-info btn-sm"
                                data-toggle="modal"
                                data-target="#inventariomodal"
                                @click="tableresp('detalle',item)" >
                                <img style="width:23px;heigth:23px;" src="css/img/moreinfo.png" />
                            </button>
                            <button class="btn btn-info btn-sm" 
                                v-if="item.estadoinv=='FINALIZADO'"
                                data-toggle="modal"
                                data-target="#inventariomodal"
                                @click="tableresp('detalleajuste',item)">
                                <img style="width:23px;heigth:23px;" src="css/img/ajuste.png"  />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="inventariomodal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 v-if="tipoinventario=='ingresar'" class="modal-title">Generar Inventario</h5>
                    <h5 v-else class="modal-title">Detalle Inventario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Bodega</th>
                                    <th>Tipo Inventario</th>
                                    <th v-show="inventario.tipoinv=='ESTANTE'">Estante</th>
                                    <th v-show="newinventario.length==0">
                                        
                                    </th>
                                    <th v-show="newinventario.length>0">Total Artículos</th>
                                    <th v-show="newinventario.length>0">Total Inventario</th>
                                    <th v-show="newinventario.length>0">Total Diferencia</th>
                                    
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select class="form-control form-control-sm t-regular" :disabled=disableinv v-model="inventario.bodega_id" required>
                                            <option value="">------</option>
                                            <option v-for="(item, index) in bodega" :key="index" :value="item.idbodega">
                                                {{ item.nombrebod }}
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control form-control-sm t-regular" :disabled=disableinv v-model="inventario.tipoinv" required>
                                            <option value="">------</option>
                                            <option value="BODEGA COMPLETA">Bodega Completa</option>
                                            <option value="ESTANTE">Estante</option>
                                        </select>
                                    </td>
                                    <td v-show="inventario.tipoinv=='ESTANTE'">
                                        <select class="form-control form-control-sm t-regular" :disabled=disabledestante v-model="inventario.estante_id" required>
                                            <option value="">------</option>
                                            <option v-for="(item, index) in estantefiltrado" :key="index" :value="item.id">
                                                {{ item.nroestante }}
                                            </option>
                                        </select>
                                    </td>
                                    <th v-show="newinventario.length==0">
                                        <button class="btn btn-primary" @click="generarinventario()">Generar Inventario</button>
                                    </th>
                                    <td v-show="newinventario.length>0">
                                        <input type="number" v-model="inventario.cantidadbodtotal" readonly class="form-control p-2 w-xs2" id="cantidadbodtotaliculos" name="cantidadbodtotaliculos">
                                    </td>
                                    <td v-show="newinventario.length>0">
                                        <input type="number" v-model="inventario.cantidadinvtotal"  readonly class="form-control p-2 w-xs2" id="cantidadinvtotalentario" name="cantidadinvtotalentario">
                                    </td>
                                    <td v-show="newinventario.length>0">
                                        <input type="number" v-model="inventario.cantidaddiftotal"  readonly class="form-control p-2 w-xs2" id="cantidaddiftotalerencia" name="cantidaddiftotalerencia">
                                    </td>
                                    <td v-show="newinventario.length>0">
                                        <button v-show="inventario.estadoinv=='GENERADO'" type="button" @click="eliminarinventario()" class="btn btn-primary">Eliminar Inventario</button>
                                    </td>
                                    <td v-show="inventario.estadoinv=='GENERADO'">
                                        <span class="label label-warning">(*) Recuerde que este inventario no ha sido guardado!</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div id="tablainv" style="display:none">
                        <table id="newinventario" class="table table-striped display table-sm table-bordered table-dark dt-responsive w-100">
                            <thead>
                                <tr>
                                    <th>Bodega</th>
                                    <th>Estante</th>
                                    <th>Sector,Nivel</th>
                                    <th>Artículo</th>
                                    <th>Nombre</th>
                                    <th>Cant Pos</th>
                                    <th>Inventario</th>
                                    <th>Dif</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item,index) in newinventario" :key="index">
                                    <td :title="item.nombrebod">{{item.bodega_id}}</td>
                                    <td>EST{{item.nroestante}}</td>
                                    <td>{{item.sectorinv}}, {{item.nivelinv}}</td>
                                    <td>{{item.codigoart}}</td>
                                    <td>{{item.nombreart}}</td>
                                    <td>{{item.cantidadbod}}</td>
                                    <td v-if="tipoinventario=='ingresar' || tipoinventario=='detalleajuste'">
                                        <input type="number" class="form-control p-2 w-xs2 cantidades"
                                        style="height: calc(1.1em + 0.75rem + 2px) !important;"
                                        @keyup.enter="onSubmit(item, index)" 
                                        v-model="item.cantidadinv" 
                                         :id="'cantidadinv_'+index"
                                         
                                         @focus="quitarcero(item)"
                                         @focusout="ponercero(item)"
                                          name="cantidadmov">
                                    </td>
                                    <td v-else>{{item.cantidadinv}}</td>
                                    <td>
                                        {{item.cantidaddif}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="tablacargando">
                        <div class="d-flex justify-content-center">
                        <div class="spinner-border" style="width: 4rem; height: 4rem;" role="status">
                        <span class="sr-only">Loading...</span>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    
                    <button v-if="tipoinventario=='ingresar'" type="button" class="btn btn-primary" @click="guardaravance()" v-show="newinventario.length>0">Guardar Avance</button>
                    <button v-if="tipoinventario=='detalleajuste' && inventario.estadoinv=='FINALIZADO'" v-show="newinventario.length>0" type="button" class="btn btn-primary" @click="guardaravance()">Actualizar Inventario</button>
                    <button v-if="tipoinventario=='ingresar'" type="button" class="btn btn-primary" @click="finalizarinventario()" v-show="newinventario.length>0">Finalizar Inventario</button>
                    <button v-if="tipoinventario=='detalleajuste' && user=='ADMIN'"  type="button" class="btn btn-primary" @click="ajusteinventario()" v-show="newinventario.length>0">Ajustar Inventario a bodega</button>
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
                detalleinventarios:[],
                newinventario:[],
                bodegaselect:'',
                estanteselect:'',
                tipoinventario:'',
                flaginventario:false,
                inventario:{id:'',bodega_id:'', tipoinv:'',estante_id:'', cantidadbodtotal: 0, cantidadinvtotal: 0,
                    cantidaddiftotal: 0,observacioninv:'', estadoinv:''},
                dt:null,
                dt2:null
            }
        },
        computed: {
        // a computed getter
            estantefiltrado: function(){
                if(this.inventario.bodega_id!=''){
                  
                      let estantex = this.estantes;
                    return _.filter(estantex, {'bodega_id':this.inventario.bodega_id});
                              
                  
                }else{
                    return null;
                }
            },
            disabledestante: function(){
                if(this.inventario.tipoinv=='ESTANTE'){
                    return false;
                }else{
                    return true;
                }
            },
            disableinv: function(){
                if(this.inventario.estadoinv==''){
                    return false;
                }else{
                    return true;
                }
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
            this.user = this.databodega[11];
            //this.posiciones = this.databodega[10];
            this.estantes = this.databodega[9];
            $("#tablacargando").show();
                $("#tablainv").hide();
            console.log('Component created.');
            axios.post('/bodega/getdatos', {tipo:'inventarios'}).then((res) =>{
                console.log(res.data);
                this.detalleinventarios = res.data[0];
                if(this.detalleinventarios.length>0){
                    console.log(this.detalleinventarios);
                // this.cargando=false;
                    setTimeout(function(){
                        this.$nextTick(function () {
                        
                            this.dt2 = $('#newinventario').DataTable({
                                    "scrollY":        "300px",
                                    "scrollCollapse": true,
                                    "paging":         false,
                                    "searching": false,
                                    "pageLength": 50000         
                                })
                            this.cargando=false;
                            $("#tablacargando").hide();
                            $("#tablainv").show();
                        });
                    }.bind(this), 500);
                }else{
                    this.cargando=false;
                }
                console.log(res.data[1]);
                if(res.data[1]!=null){
                    this.inventario = res.data[1];
                    this.newinventario = res.data[2];
                    this.tipoinventario ='ingresar';
                    if (sessionStorage.getItem("inventario")) {
                        sessionStorage.removeItem("inventario");
                        sessionStorage.removeItem("newinventario");
                    }
                    sessionStorage.setItem("inventario",JSON.stringify(this.inventario));
                    sessionStorage.setItem("newinventario",JSON.stringify(this.newinventario));
                   setTimeout(function(){
                        this.$nextTick(function () {
                        
                            this.dt2 = $('#newinventario').DataTable({
                                    "scrollY":        "300px",
                                    "scrollCollapse": true,
                                    "paging":         false,
                                    "searching": false,
                                    "pageLength": 50000         
                                })
                            this.cargando=false;
                            $("#tablacargando").hide();
                            $("#tablainv").show();
                        });
                        }.bind(this), 500);
                    this.flaginventario = true;
                }else{
                    if (sessionStorage.getItem("inventario")) {
                        // Restaura el contenido al campo de texto
                        
                        this.inventario = JSON.parse(sessionStorage.getItem("inventario"));
                        this.newinventario = JSON.parse(sessionStorage.getItem("newinventario"));
                        this.tipoinventario ='ingresar';
                        this.flaginventario = true;
                        setTimeout(function(){
                        this.$nextTick(function () {
                        
                            this.dt2 = $('#newinventario').DataTable({
                                    "scrollY":        "300px",
                                    "scrollCollapse": true,
                                    "paging":         false,
                                    "searching": false,
                                    "pageLength": 50000         
                                })
                            this.cargando=false;
                            $("#tablacargando").hide();
                            $("#tablainv").show();
                        });
                        }.bind(this), 500);
                        //sessionStorage.clear();
                    }
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
            console.log('Component mounted.');
            this.$toastr.defaultPosition = "toast-top-left";
        },
        methods: {
            onSubmit(art, index){
                if(art.cantidadinv!=''){
                    /*art.cantidaddif = parseInt(art.cantidadbod)-parseInt(art.cantidadinv);
                    this.inventario.cantidadinvtotal=_.sumBy(this.newinventario, function(o) { return parseInt(o.cantidadinv); });
                    this.inventario.cantidaddiftotal=_.sumBy(this.newinventario, function(o) { return parseInt(o.cantidaddif); });
                    sessionStorage.setItem("inventario",JSON.stringify(this.inventario));
                    sessionStorage.setItem("newinventario",JSON.stringify(this.newinventario));*/
                    if($("#cantidadinv_"+(parseInt(index)+1)).length>0){
                        $("#cantidadinv_"+(parseInt(index)+1)).focus();
                    }
                }
                console.log("on submit");
            },
            tableresp(tipo,inv){
                this.tipoinventario=tipo;
                console.log(this.dt2);
                $("#tablacargando").show();
                $("#tablainv").hide();
                
                switch (tipo) {
                    case 'detalle':
                        this.inventario = inv;
                        axios.post('/bodega/getdatos', {tipo:'inventarios',detalle:inv.id}).then((res) =>{
                            console.log(res.data);
                            this.newinventario =res.data[0];
                           
                            if(this.dt2!=null){
                                this.dt2.destroy();
                            }
                             setTimeout(function(){
                                this.$nextTick(function () {
                                
                                    this.dt2 = $('#newinventario').DataTable({
                                            "scrollY":        "300px",
                                            "scrollCollapse": true,
                                            "paging":         false,
                                            "searching": false,
                                            "pageLength": 50000         
                                        })
                                    this.cargando=false;
                                    $("#tablacargando").hide();
                                    $("#tablainv").show();
                                });
                            }.bind(this), 500);

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
                        break;
                    case 'ingresar':
                        if (sessionStorage.getItem("inventario")) {
                            // Restaura el contenido al campo de texto
                            
                            this.inventario = JSON.parse(sessionStorage.getItem("inventario"));
                            this.newinventario = JSON.parse(sessionStorage.getItem("newinventario"));
                            this.tipoinventario ='ingresar';
                            
                            //sessionStorage.clear();
                        }else{
                            this.inventario={id:'',bodega_id:'', tipoinv:'',estante_id:'', cantidadbodtotal: 0, cantidadinvtotal: 0,
                            cantidaddiftotal: 0,observacioninv:'', estadoinv:''};
                        this.newinventario=[];
                        }
                        if(this.newinventario.length>0){
                            if(this.dt2!=null){
                                this.dt2.destroy();
                            }
                            setTimeout(function(){
                                this.$nextTick(function () {
                                
                                    this.dt2 = $('#newinventario').DataTable({
                                            "scrollY":        "300px",
                                            "scrollCollapse": true,
                                            "paging":         false,
                                            "searching": false,
                                            "pageLength": 50000         
                                        })
                                    this.cargando=false;
                                    $("#tablacargando").hide();
                                    $("#tablainv").show();
                                });
                            }.bind(this), 500);
                             
                        }
                        break;
                    case 'detalleajuste':
                        this.inventario = inv;
                        axios.post('/bodega/getdatos', {tipo:'inventariosajuste',detalle:inv.id}).then((res) =>{
                            console.log(res.data);
                            this.newinventario =res.data[0];
                            if(this.dt2!=null){
                                this.dt2.destroy();
                            }
                            setTimeout(function(){
                                this.$nextTick(function () {
                                
                                    this.dt2 = $('#newinventario').DataTable({
                                            "scrollY":        "300px",
                                            "scrollCollapse": true,
                                            "paging":         false,
                                            "searching": false,
                                            "pageLength": 50000         
                                        })
                                    this.cargando=false;
                                    $("#tablacargando").hide();
                                    $("#tablainv").show();
                                });
                            }.bind(this), 500);
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
                        break;
                    default:
                        break;
                }
                               
            },
            eliminarinventario(){
                if(confirm("¿Está seguro de eliminar este inventario?")){
                    $(".close").click();
                    sessionStorage.removeItem("inventario");
                    sessionStorage.removeItem("newinventario");
                    this.inventario={id:'',bodega_id:'', tipoinv:'',estante_id:'', cantidadbodtotal: 0, cantidadinvtotal: 0,
                        cantidaddiftotal: 0,observacioninv:'', estadoinv:''};
                    this.newinventario=[];
                    this.tipoinventario='';
                    this.dt2.destroy();
                    this.flaginventario = false;
                    this.$toastr.s("Inventario eliminado con éxito");
                }
            },
            quitarcero(item){
                if(parseInt(item.cantidadinv)==0){
                    item.cantidadinv='';
                }
            },
            ponercero(art){
                //console.log("poner cero 1 "+this.inventario.cantidaddiftotal);
                if(art.cantidadinv==''){
                    art.cantidadinv=0;
                    art.cantidaddif=parseInt(art.cantidadbod);
                }else{
                    art.cantidaddif = parseInt(art.cantidadbod)-parseInt(art.cantidadinv);
                    //console.log("poner cero 2 "+_.sumBy(this.newinventario, function(o) { return parseInt(o.cantidadbod); }));
                    this.inventario.cantidadinvtotal=_.sumBy(this.newinventario, function(o) { return parseInt(o.cantidadinv); });
                    this.inventario.cantidaddiftotal=_.sumBy(this.newinventario, function(o) { return parseInt(o.cantidaddif); });
                    sessionStorage.setItem("inventario",JSON.stringify(this.inventario));
                    sessionStorage.setItem("newinventario",JSON.stringify(this.newinventario));
                }
                //console.log("poner cero 3 "+this.inventario.cantidaddiftotal);
            },
            generarinventario(){
                let inv = this.inventario;
                console.log(inv);
                if(confirm("¿Está seguro de generar este Inventario?")){
                    if(inv.bodega_id=='' || inv.tipoinv==''){
                        this.$toastr.w("La Bodega y el Tipo de inventario son obligatorios, favor revisar");
                        return;
                    }else{
                        if(inv.tipoinv=='ESTANTE'){
                            if(inv.estante_id==''){
                                this.$toastr.w(`El Estante el obligatorio para el Tipo de Inventario "Estante", favor revisar`);
                                return;
                            }
                        }
                    }
                    axios.post('/bodega/getdatos', {tipo:'generarinventario',detalle:inv}).then((res) =>{
                        this.newinventario = res.data;
                        console.log(res.data);
                        if(this.newinventario.length>0){
                            console.log(this.newinventario);
                            this.inventario.cantidadbodtotal=_.sumBy(this.newinventario, function(o) { return parseInt(o.cantidadbod); });
                            this.inventario.cantidaddiftotal=_.sumBy(this.newinventario, function(o) { return parseInt(o.cantidadbod); });
                            this.inventario.estadoinv ='GENERADO';
                            sessionStorage.setItem("inventario",JSON.stringify(this.inventario));
                            sessionStorage.setItem("newinventario",JSON.stringify(this.newinventario));
                            
                            this.$toastr.s("Inventario Generado con éxito");
                            this.flaginventario = true;
                        // this.cargando=false;
                            if(this.dt2!=null){
                                this.dt2.destroy();
                            }
                            setTimeout(function(){
                                this.$nextTick(function () {
                                
                                    this.dt2 = $('#newinventario').DataTable({
                                            "scrollY":        "300px",
                                            "scrollCollapse": true,
                                            "paging":         false,
                                            "searching": false,
                                            "pageLength": 50000         
                                        })
                                    this.cargando=false;
                                    $("#tablacargando").hide();
                                    $("#tablainv").show();
                                });
                            }.bind(this), 500);
                        }else{
                            this.$toastr.e("Ya existe un inventario en proceso, para poder generar un nuevo pedido debe finalizar el que se encuentra en proceso");
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
                }
            },
            guardaravance(){
                this.inventario.estadoinv='PROCESO';
                axios.post('/bodega/setdatos', {tipo:'guardaravance',inventario:this.inventario,detalle:this.newinventario }).then((res) =>{
                    console.log(res.data);
                    this.inventario.id = res.data;
                    this.$toastr.s("Avance de inventario guardado con éxito");
                    if (sessionStorage.getItem("inventario")) {
                        sessionStorage.removeItem("inventario");
                        sessionStorage.removeItem("newinventario");
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
            finalizarinventario(){
                this.inventario.estadoinv='FINALIZADO';
                axios.post('/bodega/setdatos', {tipo:'finalizarinventario',inventario:this.inventario,detalle:this.newinventario }).then((res) =>{
                    console.log(res.data);
                    this.$toastr.s("Inventario Finalizado con éxito");
                    if (sessionStorage.getItem("inventario")) {
                        sessionStorage.removeItem("inventario");
                        sessionStorage.removeItem("newinventario");
                    }
                    this.inventario={id:'',bodega_id:'', tipoinv:'',estante_id:'', cantidadbodtotal: 0, cantidadinvtotal: 0,
                        cantidaddiftotal: 0,observacioninv:'', estadoinv:''};
                    this.newinventario=[];
                    $(".close").click();
                    setTimeout(function(){
                        location.reload();
                    }.bind(this), 300);
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
            ,
            ajusteinventario(){
                console.log(this.inventario.id);
                if(confirm("¿Está seguro de realizar el ajuste de este Inventario?. Recordar que este proceso no puede ser revertido.")){
                    
                    axios.post('/bodega/setdatos', {tipo:'ajustarinventario',detalle:this.inventario.id}).then((res) =>{
                        //this.newinventario = res.data;
                        console.log(res.data);
                        if(parseInt(res.data)==0){
                            this.$toastr.s("Inventario ajustado a bodega con éxito");
                            $(".close").click();
                            setTimeout(function(){
                            location.reload();
                        }.bind(this), 1000);
                        }else{
                            this.$toastr.e("Inventario no ha podido ser ajustado, favor de contactarse con el desarrollador del sistema");
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
                }
            }
        },
    }
   
</script>
