<template>
    <div class="container-fluid">
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
    /*import mantart from './mantenedor/mantenedorart.vue';*/
    
    export default {
        props: ['dataordencompra'],
        data(){
            return{
                dt: null,
                pedido:{},
                newoc:{nrooc:'',categoria_id:'',proveedor_id:'',fechaoc:'',cantidadoc:0,montooc:0, user_id:'', estadooc:''},
                detoc:{articulodetoc:'', codigoart:'', bodega_id:'',sector_id:'', colordetoc:'', color_id:'', marca_id:'', unidad_id:'', cantidaddetoc:0,montounitariodetoc:0, montototaldetoc:0},
                componenteactual:'',
                detnewoc:[],
                usuarios: [],
                colaboradores: [],
                areas: [],
                correlativoint:'00001',
                allmarcas:null,
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
            axios.post('/sistema/getdatos', {tipo:'OrdenCompra'}).then((res) =>{
              
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
                this.detoc.marca_id = this.newmarca(this.marcaaux.toString().toUpperCase(),1);
                this.detoc.codigoart = this.codigoartvue;
                this.detoc.articulodetoc = this.detoc.articulodetoc.toUpperCase();
                this.detoc.colordetoc = this.detoc.colordetoc.toUpperCase();
                this.detoc.montototaldetoc = parseInt(this.detoc.cantidaddetoc) * parseInt(this.detoc.montounitariodetoc);
                
                this.newoc.cantidadoc = parseInt(this.newoc.cantidadoc) + parseInt(this.detoc.cantidaddetoc);
                this.newoc.montooc = parseInt(this.newoc.montooc) + parseInt(this.detoc.montototaldetoc);
                console.log(this.detoc);
                this.detnewoc.push(_.cloneDeep(this.detoc));
                sessionStorage.setItem("newoc",JSON.stringify(this.newoc));
                sessionStorage.setItem("detnewoc",JSON.stringify(this.detnewoc));
                this.$refs.marcas.inputValue = '';
                this.detoc={articulodetoc:'', codigoart:'', bodega_id:'',sector_id:'', colordetoc:'', color_id:'', marca_id:'', unidad_id:'', cantidaddetoc:0,montounitariodetoc:0, montototaldetoc:0};
                this.marcaaux='';
                let codcorrel = (parseInt(this.correlativoint)+1).toString();
                while(codcorrel.length<5){
                    codcorrel ="0"+codcorrel;
                }
                console.log(this.allmarcas);
                this.correlativoint = codcorrel;
                
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
