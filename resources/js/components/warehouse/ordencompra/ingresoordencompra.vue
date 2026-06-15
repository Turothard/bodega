<template>
    <div class="container-fluid">
        <div  class="modal fade" id="ordencompramodal" tabindex="-1" role="dialog" aria-labelledby="NofificacionesmodalTitle" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Ingreso Orden de Compra</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" v-if="terminado==1">
                        <div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>OC</th>
                                        <th>Categoría</th>
                                        <th>Proveedor</th>
                                        <th>Fecha</th>
                                        <th>Cant OC</th>
                                        <th>Monto OC</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="number" v-model="newoc.nrooc" class="form-control form-control-sm t-regular p-2 w-xs2" id="nrooc" name="nrooc">
                                        </td>
                                        <td>
                                            <select v-model="newoc.categoria_id" class="form-control form-control-sm t-regular w-d text-uppercase">
                                                <option value="">------</option>
                                                <option v-for="(item, index) in dataordencompra[2]" :key="index" :value="item.idcategoria">
                                                    {{ item.nombrecat }}
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <select v-model="newoc.proveedor_id" class="form-control form-control-sm t-regular w-xl text-uppercase">
                                                <option value="">------</option>
                                                <option v-for="(item, index) in dataordencompra[9]" :key="index" :value="item.rutproveedor">
                                                    {{ item.nombreprov }}
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="date" v-model="newoc.fechaoc" class="form-control form-control-sm t-regular p-2 w-d" id="fechaoc" name="fechaoc">
                                        </td>
                                        <td>
                                            <input type="number" v-model="newoc.cantidadoc" readonly class="form-control form-control-sm t-regular p-2 w-s" id="cantidadoc" name="cantidadoc">
                                        </td>
                                        <td>
                                            <input type="number" v-model="newoc.montooc" readonly class="form-control form-control-sm t-regular p-2 w-s" id="montooc" name="montooc">
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                            <hr>
                            <div class="row" id="infodetoc" >
                                <div class="col-6">
                                    Detalle Artículo:<br>
                                    <vue-bootstrap-typeahead                         
                                        v-model="detoc.articulodetoc"
                                        :inputClass="'upcase form-control form-control-sm'"
                                        @hit="verificardato()"
                                        :minMatchingChars="3"
                                        ref="articulodetoc"
                                        :data="codigos"
                                        >
                                        
                                    </vue-bootstrap-typeahead>
                                    <!-- <input type="text" maxlength="50" v-model="detoc.articulodetoc" class="form-control form-control-sm t-regular p-2 upcase" id="articulodetoc" name="articulodetoc"> -->
                                </div>
                                <div class="col-3" id="lamarca">
                                    Marca <br>
                                    <div class="upcase">
                                        <vue-bootstrap-typeahead 
                                        v-model="marcaaux"
                                        :inputClass="'upcase form-control form-control-sm'"
                                        :minMatchingChars="3"
                                        ref="marcas"
                                        :data="marcas">
                                    </vue-bootstrap-typeahead>
                                    </div>
                                </div>
                                <div class="col-3">
                                    Código Sistema (*)<br>
                                    <input type="text"  class="form-control form-control-sm w-d t-regular" name="codigoart" readonly id="codigoart" v-model="codigoartvue">
                                    
                                </div>
                                <div class="col-3">
                                    Bodega :
                                    <select class="form-control form-control-sm t-regular" v-model="detoc.bodega_id" >
                                        <option value="">------</option>
                                        <option v-for="(item, index) in dataordencompra[14]" :key="index" :value="item.idbodega">
                                            {{ item.idbodega }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    Sector :
                                    <select class="form-control form-control-sm t-regular" v-model="detoc.sector_id" >
                                        <option value="">------</option>
                                        <option v-for="(item, index) in dataordencompra[5]" :key="index" :value="item.idsector">
                                            {{ item.nombresec }}
                                        </option>
                                    </select>
                                </div>                                
                                <div class="col-3">
                                    Color Sis :
                                    <select v-model="detoc.color_id" class="form-control form-control-sm t-regular text-uppercase" >
                                        <option value="">------</option>
                                        <option v-for="(item, index) in dataordencompra[10]" :key="index" :value="item.idcolor">
                                            {{ item.nombrecol }}
                                        </option>
                                    </select>
                                </div>
                                
                                
                                <div class="col-3">
                                    Talla Art :
                                    <select v-model="detoc.unidad_id" class="form-control form-control-sm t-regular" >
                                        <option value="">------</option>
                                        <option v-for="(item, index) in dataordencompra[11]" :key="index" :value="item.idunidad">
                                            {{ item.descripcionunimed }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    Color Art :
                                    <input type="text" v-model="detoc.colordetoc" class="form-control form-control-sm t-regular upcase p-2" id="colordetoc" name="colordetoc">
                                </div>
                                <div class="col-2">
                                    Cantidad:<br>
                                    <input type="number" v-model="detoc.cantidaddetoc" class="form-control form-control-sm w-d t-regular p-2" id="cantidaddetoc" name="cantidaddetoc"
                                        @focus="detoc.cantidaddetoc=quitarcero(detoc.cantidaddetoc)"
                                        @focusout="detoc.cantidaddetoc=ponercero(detoc.cantidaddetoc)"
                                    >
                                </div>
                                <div class="col-2">
                                    Monto:<br>
                                    <input type="number" v-model="detoc.montounitariodetoc" class="form-control form-control-sm w-d t-regular p-2" id="montounitariodetoc" name="montounitariodetoc"
                                        @focus="detoc.montounitariodetoc=quitarcero(detoc.montounitariodetoc)"
                                        @focusout="detoc.montounitariodetoc=ponercero(detoc.montounitariodetoc)"
                                    >
                                </div>
                                <div class="col-2">
                                    Total:<br>
                                    <input type="number" :value="detoc.cantidaddetoc*detoc.montounitariodetoc" readonly class="form-control form-control-sm w-d t-regular p-2" id="montototaldetoc" name="montototaldetoc">
                                </div>
                                <div class="col-3">
                                    <br>
                                   <button type="button" @click="agregararticulo()" class="btn btn-sm btn-primary">Agregar Artículo </button>
                                   <button type="button" @click="resetarticulo()" class="btn btn-sm btn-primary">Limpiar</button>
                                </div>
                                <div class="col-12">
                                    Descripción Artículo
                                    <input type="text" maxlength="100" v-model="detoc.descripcionart" class="form-control form-control-sm t-regular upcase p-2" id="descripcionart" name="descripcionart">
                                </div>
                            </div>
                            <br>
                            <div style="height:220px; overflow:auto;">
                                <table id="newingresooc" class="table table-striped display table-sm table-bordered table-dark t-regular dt-responsive w-100">
                                    <thead>
                                        <tr>
                                            <th class="all">Detalle Art</th>
                                            <th class="desktop">Código Art</th>
                                            <th class="never">Descripcion Art</th>
                                            <th class="desktop">Bodega</th>
                                            <th class="desktop">Sector</th>
                                            <th class="all">Color</th>
                                            <th class="desktop">Color Sis (*)</th>
                                            <th class="all">Marca</th>
                                            <th class="all">Talla</th>
                                            <th class="all">Cantidad</th>
                                            <th class="all">Monto</th>
                                            <th class="all">Total</th>
                                            <th class="all">Funciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item,index) in detnewoc" :key="index">
                                            <td>{{item.articulodetoc}}</td>
                                            <td>{{item.codigoart}}</td>
                                            <td :title="item.descripcionart">{{item.descripcionart}}</td>
                                            <td>{{item.bodega_id}}</td>
                                            <td>{{dataordencompra[5].find( items => items.idsector === item.sector_id ).nombresec}}</td>
                                            <td>{{item.colordetoc}}</td>
                                            <td>{{dataordencompra[10].find( items => items.idcolor === item.color_id ).nombrecol }}</td>
                                            <td>{{allmarcas.find( items => items.idmarca === item.marca_id).nombremar}}</td>
                                            <td>{{dataordencompra[11].find( items => items.idunidad === item.unidad_id).descripcionunimed }}</td>
                                            <td>{{item.cantidaddetoc}}</td>
                                            <td>{{item.montounitariodetoc}}</td>
                                            <td>{{item.montototaldetoc}}</td>
                                            <td>
                                                <button class="btn btn-danger btn-sm">
                                                    <img style="width:23px;heigth:23px;" src="/css/img/delete.png" @click="eliminararticulo(item, index)" title="Eliminar artículo" />
                                                </button>
                                                
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div v-show="terminado!=1" class="container-fluid">
                    <div class="d-flex justify-content-center" v-show="terminado==1">
                        <div class="spinner-border" style="width: 4rem; height: 4rem;" role="status">
                        <span class="sr-only">Loading...</span>
                        </div>
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
    /*import mantart from './mantenedor/mantenedorart.vue';*/
    
    export default {
        props: ['dataordencompra'],
        data(){
            return{
                dtnewoc: null,
                pedido:{},
                codigos:null,
                newoc:{nrooc:'',categoria_id:'',proveedor_id:'',fechaoc:'',cantidadoc:0,montooc:0, user_id:'', estadooc:''},
                detoc:{articulodetoc:'', descripcionart:'', codigoart:'', bodega_id:'',sector_id:'', colordetoc:'', color_id:'', marca_id:'', unidad_id:'', cantidaddetoc:0,montounitariodetoc:0, montototaldetoc:0},
                componenteactual:'',
                detnewoc:[],
                usuarios: [],
                colaboradores: [],
                areas: [],
                flag:0,
                articulo:[],
                correlativoint:'00001',
                allmarcas:null,
                readonly:false,
                marcaaux:'',
                ultimamarca:0,
                ubicaciones: [],
                letras: ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'] ,
                marcas:null,
                sectores: [],
                terminado:0,
                user:null
            }
        },
        computed: {
        // a computed getter
            codigoartvue: function () {
                this.flag;
                if(this.readonly){
                    return this.articulo[0].codigoart;
                }
                let codigoart='';
                let codmarca='';
                let codsubcat='';
                let codcorrel='';
                let codtalla='';
                let codcolor='';
                let art = this.detoc;
                //console.log(art);
                if(this.marcaaux!=''){
                    let marca=_.filter(this.allmarcas, {'nombremar':this.marcaaux.toString().toUpperCase()});
                    //console.log(this.marcaaux.toString().toUpperCase());
                    if(marca.length>0){
                        codmarca=marca[0].idmarca;
                    }else{
                        codmarca =this.newmarca(this.marcaaux.toString().toUpperCase(), 0);
                    }
                    
                }else{
                    codmarca='000';
                }
                /*if(art.subcategoria_id!=''){
                    let subcat=_.filter(this.dataordencompra[3], {'idsubcategoria':art.subcategoria_id});
                    //console.log(subcat);
                    codsubcat=subcat[0].codigosubcat;
                    let correlativoint=_.filter(this.correlativosvue, {'subcategoria_id':art.subcategoria_id});
                    if(correlativoint.length==0){
                        correlativoint=_.filter(this.correlativos, {'subcategoria_id':art.subcategoria_id});
                        
                    }
                    console.log(correlativoint);
                    if(correlativoint.length==0){
                        codcorrel = '00001';
                    }else{
                        codcorrel = (parseInt(correlativoint[0].correlativo)+1).toString();
                        while(codcorrel.length<5){
                            codcorrel ="0"+codcorrel;
                        }
                    }
                    this.correlativox = codcorrel;
                    //console.log("correlativo "+art.marca_id);
                }*/
                
                if(art.color_id!=''){
                    codcolor=art.color_id;
                }
                if(art.unidad_id!=''){
                    codtalla=art.unidad_id;
                }
                codigoart = codmarca+codsubcat+this.correlativoint+codcolor+codtalla;

                //console.log("codigoart "+codigoart);
                //this.correlativoint = codcorrel;
                
                return codigoart;
            }
        },
        created() {
            this.allmarcas = this.dataordencompra[12];
            var nom = _.mapValues(this.dataordencompra[4], function(o) { return o.nombreart; });
            this.codigos =Object.values(nom);
            if (sessionStorage.getItem("newoc")) {
                // Restaura el contenido al campo de texto
                this.newoc = JSON.parse(sessionStorage.getItem("newoc"));
                this.detnewoc = JSON.parse(
                    sessionStorage.getItem("detnewoc")
                );
                this.correlativoint = this.detnewoc.length +1;
                    while(this.correlativoint.toString().length<5){
                        this.correlativoint ='0'+this.correlativoint.toString();
                    }
                //sessionStorage.clear();
                if (sessionStorage.getItem("allmarcas")) {
                    this.allmarcas = JSON.parse(sessionStorage.getItem("allmarcas"));
                    
                }

            }
            
            this.ultimamarca = _.findLastKey(this.allmarcas);
            var marca = _.mapValues(this.allmarcas, function(o) { return o.nombremar; });
            this.marcas = Object.values(marca);
            setTimeout(function(){
                this.terminado=1;
                
            }.bind(this), 1000);
            axios.post('/sistema/getdatoswarehouse', {tipo:'OrdenCompra'}).then((res) =>{
              
            }).catch((error) =>{
                console.log(error.response.data.errors);
                /*this.err_list = error.response.data.errors;
                if (this.err_list.rut != null) {
                    this.server_alert.rut = 'fa fa-exclamation-circle';
                };
                if (this.err_list.correo != null) {
                    this.server_alert.correo = 'fa fa-exclamation-circle';
                };*/
            });
            
        },
        methods: {
            resetarticulo(){
                this.detoc={articulodetoc:'', descripcionart:'', codigoart:'', bodega_id:'',sector_id:'', colordetoc:'', color_id:'', marca_id:'', unidad_id:'', cantidaddetoc:0,montounitariodetoc:0, montototaldetoc:0};
                this.$refs.articulodetoc.inputValue = '';
                this.$refs.marcas.inputValue = '';
                this.readonly= false;
                $("#lamarca input").val('');
                //this.$recompute("codigoartvue")
                this.marcaaux='';
                
                this.flag++;
                this.correlativoint='00001';
                
            },
            agregararticulo(){
                
                let cant = 0;
                $("#infodetoc select, #infodetoc input").each(function(){
                    if($(this).val()==''){
                        cant++;
                    }
                });
                if(cant>0){
                    this.$toastr.w("Favor de ingresar datos obligatorios!!");
                    return;
                }
                this.detoc.codigoart = this.codigoartvue;
                this.readonly= false;
                
                this.detoc.marca_id = this.newmarca(this.marcaaux.toString().toUpperCase(),1);
                
                this.detoc.articulodetoc = this.detoc.articulodetoc.toUpperCase();
                this.detoc.colordetoc = this.detoc.colordetoc.toUpperCase();
                this.detoc.montototaldetoc = parseInt(this.detoc.cantidaddetoc) * parseFloat(this.detoc.montounitariodetoc);
                
                this.newoc.cantidadoc = parseInt(this.newoc.cantidadoc) + parseInt(this.detoc.cantidaddetoc);
                this.newoc.montooc = parseFloat(this.newoc.montooc) + parseInt(this.detoc.montototaldetoc);
                console.log(this.detoc);
                this.detnewoc.push(_.cloneDeep(this.detoc));
                sessionStorage.setItem("newoc",JSON.stringify(this.newoc));
                sessionStorage.setItem("detnewoc",JSON.stringify(this.detnewoc));
                this.$refs.articulodetoc.inputValue = '';
                this.$refs.marcas.inputValue = '';
                $("#lamarca input").val('');
                
                this.detoc={articulodetoc:'', descripcionart:'', codigoart:'', bodega_id:'',sector_id:'', colordetoc:'', color_id:'', marca_id:'', unidad_id:'', cantidaddetoc:0,montounitariodetoc:0, montototaldetoc:0};
                this.marcaaux='';
                let codcorrel = (parseInt(this.correlativoint)+1).toString();
                while(codcorrel.length<5){
                    codcorrel ="0"+codcorrel;
                }
                console.log(this.allmarcas);
                this.correlativoint = codcorrel;
                this.articulo=[];
            },
            verificardato(){
                
                if(this.detoc.articulodetoc.length==0){
                    this.readonly.false;
                    return;
                }
                
                this.articulo=_.filter(this.dataordencompra[4], {'nombreart':this.detoc.articulodetoc.toString().toUpperCase()});
                if(this.articulo.length==0){
                    this.readonly.false;
                    return;
                }
                
                this.readonly = true;
                this.detoc.color_id = this.articulo[0].color_id;
                this.detoc.codigoart = this.articulo[0].codigoart;
                this.detoc.descripcionart = this.articulo[0].descripcionart;
                console.log(this.detoc.articulodetoc.toString().toUpperCase());
                console.log(this.articulo);
                this.marcaaux= this.dataordencompra[12].find( items => items.idmarca === this.articulo[0].marca_id ).nombremar;
                
                console.log(this.marcaaux);
                $("#lamarca input").val(this.marcaaux);
                this.detoc.unidad_id = this.articulo[0].unidad_id;
                
            },
            newmarca(marca, carga){
                let marquita=_.filter(this.allmarcas, {'nombremar':marca});
                let marc ='';
                if(marquita.length>0){
                    return marquita[0].idmarca;
                }else{
                    let ultima = this.allmarcas[this.ultimamarca];
                    let number = ultima.idmarca.toString().substring(1,3);
                    let letra = ultima.idmarca.toString().substring(0,1);
                    if(parseInt(number) == '99'){
                        number = '01';
                        const index = this.letras.findIndex(letrax => letrax === letra);
                        marc = this.letras[index+1].toString()+number;
                    }else{
                        number = parseInt(number)+1;
                        if(number<10){
                            number ='0'+number.toString();
                        }
                        marc = letra+number.toString();
                    }
                    if(carga==1){
                        this.allmarcas.push({'idmarca':marc, 'nombremar':marca});
                        sessionStorage.setItem("allmarcas",JSON.stringify(this.allmarcas));
                        this.ultimamarca++;
                        var marca = _.mapValues(this.allmarcas, function(o) { return o.nombremar; });
                        this.marcas = Object.values(marca);
                    }
                    return marc;
                    //console.log(number);
                }
            },
            eliminararticulo(item, index){
                if(confirm("¿Está seguro de eliminar este producto de la órden de compra?")){
                    this.detnewoc.splice(index,1);
                    this.newoc.cantidadoc = parseInt(this.newoc.cantidadoc) - parseInt(item.cantidaddetoc);
                    this.newoc.montooc = parseInt(this.newoc.montooc) - parseInt(item.montototaldetoc);
                    sessionStorage.setItem("newoc",JSON.stringify(this.newoc));
                    sessionStorage.setItem("detnewoc",JSON.stringify(this.detnewoc));
                }
            },
            guardaroc(){
                if(this.detnewoc.length==0){
                    this.$toastr.w("Debe ingresar mínimo un artículo para guardar una orden de compra!!");
                    return;
                }
                if(confirm("¿Está seguro de guardar esta orden de compra?")){
                    axios.post('/ordencompra/setdatos', {tipo:'guardaroc',oc:this.newoc, detoc: this.detnewoc, marcas:this.allmarcas})
                        .then((res) =>{
                        console.log(res.data);
                        if(res.data==''){
                            this.$toastr.s("Órden de compra "+this.newoc.nrooc+" ingresada en sistema");
                            this.newoc={nrooc:'',categoria_id:'',proveedor_id:'',fechaoc:'',cantidadoc:0,montooc:0, user_id:'', estadooc:''};
                            this.detoc={articulodetoc:'', codigoart:'', bodega_id:'',sector_id:'', colordetoc:'', color_id:'', marca_id:'', unidad_id:'', cantidaddetoc:0,montounitariodetoc:0, montototaldetoc:0};
                            sessionStorage.removeItem("newoc");
                            sessionStorage.removeItem("detnewoc");
                            sessionStorage.removeItem("allmarcas");
                            $(".close").click();
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        }
                        
                        if(res.data=='EXISTE'){
                            this.$toastr.w("Ya existe la órden de compra "+this.newoc.nrooc+", favor de verificar!!");
                            return;
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
                }
            },
            quitarcero(num){
                if(parseInt(num)==0){
                    num='';
                }
                return num;
            },
            ponercero(num){
                //console.log("poner cero 1 "+this.inventario.cantidaddiftotal);
                if(num==''){
                    num=0;
                    
                }
                return num;
                //console.log("poner cero 3 "+this.inventario.cantidaddiftotal);
            },
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
