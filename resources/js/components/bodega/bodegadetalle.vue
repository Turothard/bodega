<template>
    <div class="container-fluid">
       <div class="row">
           <div class="col-8">
               <div class="row">
                   <div id="bodegabuttons" class="col-2">
                       <div  v-for="(item,index) in bodega" :key="index" class="btn-group btn-group-vertical pb-1" role="group">
                        <button type="button" class="btn btn-secondary" @click="selectbodega(item.idbodega)">{{item.idbodega}}</button>

                        </div>
                   </div>
                   <div id="estantebuttons" class="col-10">
                       <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div v-for="(item,index) in estantefiltrado" :key="index"  class="btn-group mr-2 pb-1" role="group" aria-label="Third group">
                                <button type="button" @click="selectestante(item.id)" class="btn btn-secondary">{{item.nroestante}}</button>
                            </div>
                        </div>
                   </div>
               </div>
           </div>
           <div class="col-4">
               <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#bodegaingmodal" @click="ingresararticulo()">Ingresar Artículo</button>
           </div>
       </div>
       <div class="container-fluid">
            <div v-show="cargando" class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div v-show="!cargando">
                <table id="tabladetalle" class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100">
                    <thead>
                        <tr>
                            <th class="all">Bodega</th>
                            <th class="all">Estante</th>
                            <th class="all">Sector</th>
                            <th class="all">Nivel</th>
                            <th class="all">Código</th>
                            <th class="desktop">Nombre Art</th>
                            <th class="all">Cantidad</th>
                            <th class="desktop">St Crítico</th>
                            <th class="desktop">Ind Rotación</th>
                            <th class="desktop">Periodo Devo</th>
                            <th class="all">Funciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,index) in bodegafiltrada" :key="index">
                            <td>{{item.bodega_id}}</td>
                            <td>{{item.nroestante}}</td>
                            <td>{{item.sectorpos}}</td>
                            <td>{{item.nivelpos}}</td>
                            <td>{{item.codigoart}}</td>
                            <td>{{item.nombreart}}</td>
                            <td>{{item.cantidadpos}}</td>
                            <td>{{item.stockcriticoart}}</td>
                            <td>{{item.indicerotacionart}}</td>
                            <td>{{item.descripcionper}}</td>
                            <td>
                                <button class="btn btn-info btn-sm" @click="moverarticulo(item)" title="Mover artículos" data-toggle="modal" data-target="#bodegadetmodal"><img style="width:23px;heigth:23px;" src="css/img/mover.png"/></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
       </div>
       <div class="modal fade" id="bodegadetmodal" tabindex="-1" role="dialog" aria-labelledby="bodegadetmodalTitle" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Movimiento Artículos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="detalleart" class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular">
                        <thead>
                            <tr>
                            <th colspan="5">Código</th>
                            <th colspan="5">Nombre Art</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5">{{articulomov.codigoart}}</td>
                                <td colspan="5">{{articulomov.nombreart}}</td>
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
                                <th>Cantidad</th>
                                <th>Bodega</th>
                                <th>Estante</th>
                                <th>Sector</th>
                                <th>Nivel</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>   
                                <td>{{articulomov.bodega_id}}</td>
                                <td>{{articulomov.nroestante}}</td>
                                <td>{{articulomov.sectorpos}}</td>
                                <td>{{articulomov.nivelpos}}</td>
                                <td>{{articulomov.cantidadpos}}</td>
                                <td>
                                    <select class="form-control w-s" v-model="newposicion.bodega_id" >
                                        <option value="">------</option>
                                        <option v-for="(item, index) in bodega" :key="index" :value="item.idbodega">
                                            {{ item.idbodega }}
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control w-s" v-model="newposicion.estante_id" >
                                        <option value="">---</option>
                                        <option v-for="(item, index) in estantefiltradomov" :key="index" :value="item.id">
                                            {{ item.nroestante }}
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control w-xs" v-model="newposicion.sector_id" >
                                        <option value="">---</option>
                                        <option v-for="n in parseInt(sectorfiltradormov)" :key="n" :value="n">
                                            {{ n }}
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control w-xs" v-model="newposicion.nivel_id" >
                                        <option value="">---</option>
                                        <option v-for="n in parseInt(nivelfiltradormov)" :key="n" :value="n">
                                            {{ n }}
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" v-model="newposicion.cantidad" class="form-control w-xs" :id="'cantidadmov'" name="cantidadmov">
                                </td>
                            </tr>
                        </tbody>
                        

                </table>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="realizarmovimiento()" class="btn btn-primary">Realizar Movimiento</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    
                </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="bodegaingmodal" tabindex="-1" role="dialog" aria-labelledby="bodegaingmodalTitle" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Ingreso de Artículos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="detalleart" class="table table-striped table-sm table-bordered table-dark t-regular">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Bodega</th>
                                <th>Estante</th>
                                <th>Sector</th>
                                <th>Nivel</th>
                                <th>Cantidad</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <vue-bootstrap-typeahead 
                                        v-model="newposicion.codigoart"
                                        :minMatchingChars="3"
                                        ref="articulos"
                                        :data="codigos">
                                    </vue-bootstrap-typeahead>
                                </td>
                                <td>
                                    <select class="form-control w-s" v-model="newposicion.bodega_id" >
                                        <option value="">------</option>
                                        <option v-for="(item, index) in bodega" :key="index" :value="item.idbodega">
                                            {{ item.idbodega }}
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control w-s" v-model="newposicion.estante_id" >
                                        <option value="">---</option>
                                        <option v-for="(item, index) in estantefiltradomov" :key="index" :value="item.id">
                                            {{ item.nroestante }}
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control w-xs2" v-model="newposicion.sector_id" >
                                        <option value="">---</option>
                                        <option v-for="n in parseInt(sectorfiltradormov)" :key="n" :value="n">
                                            {{ n }}
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control w-xs2" v-model="newposicion.nivel_id" >
                                        <option value="">---</option>
                                        <option v-for="n in parseInt(nivelfiltradormov)" :key="n" :value="n">
                                            {{ n }}
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" v-model="newposicion.cantidad" class="form-control w-xs" :id="'cantidadmov'" name="cantidadmov">
                                </td>
                                <th>
                                    <button type="button" @click="agregararticulo()" title="Agregar Artículo" class="btn btn-primary">Agregar</button>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <table id="detalleart" class="table table-striped table-sm table-bordered table-dark t-regular">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre Art</th>
                                <th>Bodega</th>
                                <th>Estante</th>
                                <th>Sector</th>
                                <th>Nivel</th>
                                <th>Cantidad</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item,index) in artingreso" :key="index">
                                <td>{{item.codigoart}}</td>
                                <td>{{articulos.find( items => items.codigoart === item.codigoart ).nombreart }}</td>
                                <td>{{item.bodega_id}}</td>
                                <td>{{estantes.find( items => items.id === item.estante_id ).nroestante }}</td>
                                <td>{{item.sector_id}}</td>
                                <td>{{item.nivel_id}}</td>
                                <td>{{item.cantidad}}</td>
                                <td>
                                    <i @click="eliminarcantart(item,index)" class="material-icons pointer">
                                        remove_circle_outline
                                    </i>
                                        <i @click="agregarcantart(item, index)" class="material-icons pointer">
                                        add_circle_outline
                                    </i>
                                    <i @click="eliminarart(item, index)" class="material-icons pointer">
                                        delete_forever
                                    </i>
                                           
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button v-show="artingreso.length>0" type="button" @click="guadaringreso()" class="btn btn-primary">Ingresar Artículos</button>
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
                preestablecidovue:null,
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
                detallebodega:[],
                bodegaselect:'',
                estanteselect:'',
                articulomov:[],
                sectormov:1,
                nivelmov:1,
                newposicion:{
                    codigoart:'',
                    bodega_id:'',
                    estante_id:'',
                    sector_id:'',
                    nivel_id:'',
                    cantidad:0
                },
                artingreso:[],
                user:null,
                dt:null
            }
        },
        computed: {
        // a computed getter
            bodegafiltrada: function () {
                let filtrete=this.detallebodega;
                let flagcete=false;
                if(this.bodegaselect!=''){
                    //let bodegas = this.detallebodega;
                    filtrete= _.filter(filtrete, {'bodega_id':this.bodegaselect});
                }
                if(this.estanteselect!=''){
                    //let bodegas = this.detallebodega;
                    filtrete= _.filter(filtrete, {'estante_id':this.estanteselect});
                }                
                return filtrete;
                
            },
            estantefiltrado: function(){
                if(this.estanteselect!='' || this.bodegaselect!=''){
                  if(this.bodegaselect!=''){
                      let estantes = this.estantes;
                    return _.filter(estantes, {'bodega_id':this.bodegaselect});
                  }             
                  
                }else{
                    return null;
                }
            },
            estantefiltradomov: function(){
                if(this.newposicion.bodega_id!=''){
                    let estantes = this.estantes;
                    return _.filter(estantes, {'bodega_id':this.newposicion.bodega_id});
                }else{
                    return null;
                }
            },
            sectorfiltradormov: function(){
                if(this.newposicion.estante_id!=''){
                    console.log("estante "+this.newposicion.estante_id);
                    let estantes = this.estantes;
                    let est =_.filter(estantes, {'id':this.newposicion.estante_id});
                    console.log(est);
                    return est[0].sectoresest;
                    
                }else{
                    return 1;
                }
            },
            nivelfiltradormov: function(){
                if(this.newposicion.estante_id!=''){
                    console.log("estante "+this.newposicion.estante_id);
                    let estantes = this.estantes;
                    let est =_.filter(estantes, {'id':this.newposicion.estante_id});
                    console.log(est);
                    return est[0].nivelesest;
                    
                }else{
                    return 1;
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
            //this.posiciones = this.databodega[10];
            this.estantes = this.databodega[9];
            console.log('Component created.');
            axios.post('/bodega/getdatos', {tipo:'bodega'}).then((res) =>{
                this.detallebodega = res.data;
                this.cargando=false;
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
                
            });
        },
        mounted() {
            this.$toastr.defaultPosition = "toast-top-left";
        },
        methods: {
            selectbodega(idbodega){
                if($(this).hasClass('btn-secondary')){
                    $(this).removeClass("btn-secondary");
                    $("#bodegabuttons button.btn-primary").addClass("btn-secondary");
                    $("#bodegabuttons button.btn-primary").removeClass("btn-primary");
                    $(this).addClass("btn-primary");
                }else{
                    $(this).removeClass("btn-primary");
                    $(this).addClass("btn-secondary");
                }
                if(this.bodegaselect==idbodega){
                    this.bodegaselect='';
                    return;
                }else{
                    this.estanteselect='';
                    this.bodegaselect=idbodega;
                    $("#estantebuttons button.btn-primary").addClass("btn-secondary");
                    $("#estantebuttons button.btn-primary").removeClass("btn-primary");
                }
                this.dt.destroy();
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
               
            },
            selectestante(idestante){
                if($(this).hasClass('btn-secondary')){
                    $(this).removeClass("btn-secondary");
                    $("#estantebuttons button.btn-primary").addClass("btn-secondary");
                    $("#estantebuttons button.btn-primary").removeClass("btn-primary");
                    $(this).addClass("btn-primary");
                }else{
                    $(this).removeClass("btn-primary");
                    $(this).addClass("btn-secondary");
                }
                if(this.estanteselect==idestante){
                    this.estanteselect='';
                    return
                }else{
                    this.estanteselect=idestante;
                }
                this.dt.destroy();
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
            },
            eliminarcantart(art, index){
                console.log("--cantidad");
                art.cantidad--;
                if(art.cantidad==0){
                    this.artingreso.splice(index,1);
                }

            },
            eliminarart(art, index){
                if(confirm("¿Está seguro de eliminar este árticulo de la lista?")){

                    this.artingreso.splice(index,1);

                }
            },
            agregarcantart(art, index){
                console.log("++cantidad");
                art.cantidad++;
            },
            agregararticulo(){
                let art = this.newposicion;
                console.log(art);
                if(art.cantidad==0 || art.bodega_id=='' || art.estante_id=='' || art.sector_id=='' || art.nivel_id==''){
                    this.$toastr.w("Todos los datos son necesarios, favor revisar");
                    return;
                }
                let code=null;
                 code= _.filter(this.articulos, {'codigoart':art.codigoart});
                
                if(code.length==0){
                    //let bodegas = this.detallebodega;
                    code= _.filter(this.articulos, {'nombreart':art.codigoart});
                }
                art.codigoart=code[0].codigoart;
                this.artingreso.push(art);
                this.newposicion={
                    codigoart:'',
                    bodega_id:'',
                    estante_id:'',
                    sector_id:'',
                    nivel_id:'',
                    cantidad:0
                };
                this.$refs.articulos.inputValue = '';
                art=null;
            },
            ingresararticulo(){

            },
            guadaringreso(){
                if(confirm("¿Está seguro de ingresar estos artículos a bodega?")){
                    axios.post('/bodega/setdatos', {tipo:'ingresararticulos',detalle: this.artingreso})
                    .then((res) =>{
                        console.log(res.data);
                        if(res.data==''){
                            this.$toastr.s("Artículos ingresados con éxito a bodega");
                            
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                                //location.reload();
                            this.artingreso=[];
                            this.newposicion={
                                codigoart:'',
                                bodega_id:'',
                                estante_id:'',
                                sector_id:'',
                                nivel_id:'',
                                cantidad:0
                            };
                            $(".close").click();
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
            moverarticulo(arti){
                this.newposicion={
                    codigoart:'',
                    bodega_id:'',
                    estante_id:'',
                    sector_id:'',
                    nivel_id:'',
                    cantidad:0
                };
                this.articulomov =  _.cloneDeep(arti);
            },
            realizarmovimiento(){
                if(this.newposicion.cantidad==0){
                    this.$toastr.w("La cantidad debe ser mayor a 0");
                    return;
                }
                if(this.newposicion.cantidad>this.articulomov.cantidadpos){
                    this.$toastr.w("La cantidad no puede superar al total de artículos de la posición origen");
                    return;
                }
                axios.post('/bodega/setdatos', {tipo:'guardarmovimiento',origen: this.articulomov, destino: this.newposicion})
                    .then((res) =>{
                    console.log(res.data);
                    if(res.data==''){
                        this.$toastr.s("Movimiento realizado con éxito");
                        
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                            //location.reload();
                        
                        this.newposicion={
                            codigoart:'',
                            bodega_id:'',
                            estante_id:'',
                            sector_id:'',
                            nivel_id:'',
                            cantidad:0
                        };
                        $(".close").click();
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
    }
    $(document).on('click', '#bodegabuttons button', function(){
        //console.log("holi");
        if($(this).hasClass('btn-secondary')){
            $(this).removeClass("btn-secondary");
            $("#bodegabuttons button.btn-primary").addClass("btn-secondary");
            $("#bodegabuttons button.btn-primary").removeClass("btn-primary");
            $(this).addClass("btn-primary");
        }else{
            $(this).removeClass("btn-primary");
            $(this).addClass("btn-secondary");
        }
    });
    $(document).on('click', '#estantebuttons button', function(){
        //console.log("holi");
        if($(this).hasClass('btn-secondary')){
            $(this).removeClass("btn-secondary");
            $("#estantebuttons button.btn-primary").addClass("btn-secondary");
            $("#estantebuttons button.btn-primary").removeClass("btn-primary");
            $(this).addClass("btn-primary");
        }else{
            $(this).removeClass("btn-primary");
            $(this).addClass("btn-secondary");
        }
    });
</script>
