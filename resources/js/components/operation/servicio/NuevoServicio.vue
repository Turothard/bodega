<template>
    <div class="container-fluid">
        <div class="modal fade" id="ingresoserviciomodal" tabindex="-1" role="dialog" aria-labelledby="ingresoserviciomodal" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Ingreso Nuevo Servicio</h5>
                <div>
                    <button v-show="sectorname!=''" type="button" class="btn btn-primary btn-sm ml-1" @click="volver(1)">{{sectorname}} <img style="width:20px;heigth:20px;" src="/css/img/atras.png" /></button>
                    <button v-show="areaname!=''" type="button" class="btn btn-warning btn-sm ml-1" @click="volver(2)">{{areaname}} <img style="width:20px;heigth:20px;" src="/css/img/atras.png" /></button>
                    <button v-show="ubicacionname!=''" type="button" class="btn btn-secondary btn-sm ml-1" @click="volver(3)">{{ubicacionname}} <img style="width:20px;heigth:20px;" src="/css/img/atras.png" /></button>
                    <button v-show="servicioname!=''" type="button" class="btn btn-light border-primary btn-sm ml-1" @click="volver(4)">{{servicioname}} <img style="width:20px;heigth:20px;" src="/css/img/atras.png" /></button>
                    <button v-show="trabajoname!=''" type="button" class="btn btn-light border-danger btn-sm ml-1" @click="volver(4)">{{trabajoname}} <img style="width:20px;heigth:20px;" src="/css/img/atras.png" /></button>
                </div>
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div v-if="etapa==1">
                    <h1>Selección Sector</h1>
                    <button type="button" v-for="(item,index) in sectores" :key="index" @click="seleccionarsector(item['idsector'])"  :id="'sec_' + item['idsector']" class="btn btn-secondary btn-lg btn-block">{{item['nombresec']}}</button>
                </div>
                <div v-if="etapa==2">
                    <h1>Seleción Areas</h1>
                    <button type="button" v-for="(item,index) in areas" :key="index" @click="seleccionaraera(item['idarea'])"  :id="'area_' + item['idarea']" class="btn btn-secondary btn-lg m-1">{{item['nombrearea']}}</button>
                </div>
                <div v-if="etapa==3">
                    <h1>Selección Ubicación</h1>
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div v-for="(item,index) in ubicaciones" :key="index"  class="btn-group mr-2 pb-1" role="group" aria-label="Third group">
                            <button type="button" @click="seleccionarubicacion(item.idubicacion)" :id="'ubi_' + item['idubicacion']" class="btn btn-secondary">{{item.nombreubi}}</button>
                        </div>
                    </div>
                </div>
                <div v-if="etapa==4" class="row">
                    <div class="col-8"><h1>Selección {{tipomostrando}}</h1></div>
                    <div class="col-4">
                        <button type="button" class="btn btn-dark ml-1" @click="mostrartrabajoservicio()">{{mostrando}} <img style="width:20px;heigth:20px;" src="/css/img/mover.png" /></button>
                    </div>
                    
                    <div v-for="(item,index) in servicios" :key="index" class="col-4">
                        <button type="button" @click="seleccionarservicio(item['id'])"  :id="'ser_' + item['id']" class="btn btn-secondary btn-lg btn-block m-1">{{item['nombre']}}</button>
                    </div>
                    <div v-for="(item,index) in trabajos" :key="index" class="col-4">
                        <button type="button" @click="seleccionartrabajo(item['id'])"  :id="'tra_' + item['id']" class="btn btn-secondary btn-lg btn-block m-1">{{item['nombre']}}</button>
                    </div>
                </div>
                <div v-if="etapa>=5" class="row">
                    <div class="col-2 col-md-1"  v-if="servicioactivo.camposervicios[0].activo == true">
                        Folio Interno:
                        <input type="text" v-model="newservicio.foliointerno" class="form-control form-control-sm t-regular p-2" id="foliointerno" name="foliointerno">
                    </div>
                    <div class="col-2 col-md-1" v-if="servicioactivo.camposervicios[1].activo == true">
                        Folio Externo:
                        <input type="text" v-model="newservicio.folioexterno" class="form-control form-control-sm t-regular p-2" id="folioexterno" name="folioexterno">
                    </div>
                    <div class="col-3 col-md-2" v-if="servicioactivo.camposervicios[3].activo == true">
                        Identificador:
                        <input type="text" v-model="newservicio.digitoidentificador" class="form-control form-control-sm t-regular p-2" id="digitoidentificador" name="digitoidentificador">
                    </div>
                    <div class="col-3 col-md-2"  v-if="servicioactivo.camposervicios[2].activo == true">
                        Agencia:
                        <vue-bootstrap-typeahead v-model="agencianame" :inputClass="'upcase form-control form-control-sm'" @hit="verificaragencia()" :minMatchingChars="3" ref="agencias_id" :data="agencias" >
                        </vue-bootstrap-typeahead>
                    </div>
                   
                    <div class="col-3 col-md-2"  v-if="servicioactivo.camposervicios[4].activo == true">
                        Contenido:
                        <vue-bootstrap-typeahead  v-model="contenidoname" :inputClass="'upcase form-control form-control-sm'" @hit="verificarcontenido()" :minMatchingChars="3" ref="contenidos_id" :data="contenidos">
                        </vue-bootstrap-typeahead>
                    </div>
                    <div class="col-3 col-md-2">
                        Operarios: <input type="text" readonly="" class="form-control form-control-sm t-regular p-2 w-xs" id="foliointerno" :value="newservicio.colaboradoresservicio.length" name="foliointerno">
                        
                    </div>
                    <div class="col-4 col-md-2">
                        <button type="button" class="btn btn-primary" @click="mostrarcolabservicio=!mostrarcolabservicio">Colaboradores Servicio</button><br><br>
                        <button type="button" v-if="etapa==5" @click="seleccionarlistatrabajo()" class="btn btn-info">Seleccionar trabajos</button>
                    </div>
                    <div class="col-5 col-md-5">
                        Observación Servicio
                        <textarea name="observacionservicio" class="form-control" v-model="newservicio.observacionservicio" id="observacion" cols="30" rows="4"></textarea>
                    </div>
                    <div v-show="mostrarcolabservicio" class="col-12" >
                        
                            <table v-if="newservicio.colaboradoresservicio.length>0" class="table table-striped display table-sm table-bordered table-dark t-regular dt-responsive w-100">
                                <thead>
                                    <tr>
                                        <th class="desktop">Nombre</th>
                                        <th class="desktop">Trabajo</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(itemcol,indexcol) in newservicio.colaboradoresservicio" :key="indexcol">
                                         <td>{{itemcol.nombrescolab}} {{itemcol.apellidoscolab}}</td>
                                         <td>{{itemcol.nombretrabajo}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
                <hr>   
                <div v-if="etapa==5" class="row container-fluid" id="listadetrabajos">
                    <div v-for="(item,index) in serviciotrabajo" :key="index" class="col-4 col-md-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" :value="index" :id="'check'+index" :name="'check'+index">
                            <label class="custom-control-label"  :for="'check'+index">{{item.trabajo.nombre}}</label>
                        </div>
                        
                    </div>
                    
                </div>
                <div v-if="etapa==6" class="container-fluid">
                    <div class="row container-fluid" v-for="(item,index) in trabajosselecionados" :key="index">
                        <div class="col-12"><h2>{{item.trabajo.nombre}}</h2></div>
                        <div class="col-4">
                            <label for="inputtexto">Observación tabulada</label>
                            <select v-model="item.trabajo.detalletrabajo.observaciontabulada_id" id="selecttexto" class="form-control form-control-sm t-regular w-d text-uppercase">
                                <option value="">------</option>
                                <option v-for="(item,index) in observacionestabuladas" :key="index" :value="item.id">
                                    {{item.nombre}}
                                </option>
                            </select>
                        </div>
                        <div class="col-2">
                            <label for="inputtexto">Foto Inicio</label>
                            <button v-if="item.trabajo.detalletrabajo.fotoinicio =='' || item.trabajo.detalletrabajo.fotoinicio ==null" class="btn btn-info btn-sm" @click="$refs.subirnewfile[index].click()"><img style="width:23px;heigth:23px;" src="/css/img/addimage.png"/></button>
                            <button v-if="item.trabajo.detalletrabajo.fotoinicio !=''" class="btn btn-info btn-sm" @click="eliminarfile(1, index)"><img style="width:23px;heigth:23px;" src="/css/img/delete.png"/></button>
                            <label v-if="item.trabajo.detalletrabajo.fotoinicio !=''">{{item.trabajo.detalletrabajo.fotoinicio}}</label>
                            <input type="file" accept="image/*" ref="subirnewfile" :id="'subirnewfile'+index" @change="handleFileUploadAny(1,index)" style="display:none" />
                        </div>
                        <div class="col-2">
                            <label for="inputtexto">Foto Termino</label>
                            <button v-if="item.trabajo.detalletrabajo.fototermino =='' || item.trabajo.detalletrabajo.fototermino ==null" class="btn btn-info btn-sm" @click="$refs.subirnewfile2[index].click()"><img style="width:23px;heigth:23px;" src="/css/img/addimage.png"/></button>
                            <button v-if="item.trabajo.detalletrabajo.fototermino !=''" class="btn btn-info btn-sm" @click="eliminarfile(2,index)"><img style="width:23px;heigth:23px;" src="/css/img/delete.png"/></button>
                            <label v-if="item.trabajo.detalletrabajo.fototermino !=''">{{item.trabajo.detalletrabajo.fototermino}}</label>
                            <input type="file" accept="image/*" ref="subirnewfile2" :id="'subirnewfile2'+index" @change="handleFileUploadAny(2,index)" style="display:none" />
                        </div>
                        <div class="col-3">
                            Colaboradores Trabajo
                            <vue-bootstrap-typeahead                         
                            :id="'colaborador'+index"
                            :inputClass="'upcase form-control form-control-sm'"
                            :minMatchingChars="3"
                            ref="colaborador"
                            :data="colaboradores"
                            ></vue-bootstrap-typeahead>
                            <button type="button" @click="colaboradortrabajo(index, 'colaborador'+index)" class="btn btn-primary">+</button>
                            <button type="button" v-if="item.trabajo.detalletrabajo.colaboradores.length>0" @click="item.trabajo.detalletrabajo.mostrarcolab= !item.trabajo.detalletrabajo.mostrarcolab" class="btn btn-primary">
                               <label for="" style="margin-bottom:0px" v-if="item.trabajo.detalletrabajo.mostrarcolab == false">Ver Colaboradores</label> 
                                <label for="" style="margin-bottom:0px" v-else>Ocultar Colaboradores</label> 
                                </button>
                        </div>
                        <Formulario-vue v-for="(item2,index2) in item.trabajo.campotrabajo" :key="index2"
                          :dataformulario="item2.campoformularios" :sectorservicio="sectorservicio" ></Formulario-vue>
                        <div v-show="item.trabajo.detalletrabajo.mostrarcolab" class="col-12" >
                            <table v-if="item.trabajo.detalletrabajo.colaboradores.length>0" class="table table-striped display table-sm table-bordered table-dark t-regular dt-responsive w-100">
                                <thead>
                                    <tr>
                                        <th class="desktop">Nombre</th>
                                        <th></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(itemcol,indexcol) in item.trabajo.detalletrabajo.colaboradores" :key="indexcol">
                                         <td>{{itemcol.nombrescolab}} {{itemcol.apellidoscolab}}</td>
                                         <td>
                                             <button class="btn btn-danger btn-sm" @click="eliminarcolabtrabajo(item.trabajo.detalletrabajo.colaboradores, indexcol)">            
                                                <img style="width:23px;heigth:23px;" src="/css/img/delete.png"/>
                                            </button>
                                         </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-left" v-if="storage" @click="limpiarstorage()" >Borrar avance</button>
                <button type="button" class="btn btn-primary" @click="guardarservicio()" >Guardar Servicio</button>
                <button type="button" class="btn btn-primary" @click="guardaravance()" >Guardar Avance</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
        </div>
    </div>
    
</template>

<script>
    export default {
        props: ['dataservicios', 'sectorservicio'],
        data(){
            return{
                cargando:true,
                usuarios: [],
                mostrando:'Trabajos',
                tipomostrando:'Servicios',
                colaboradores:[],
                sectores:null,
                areas:null,
                ubicaciones:null,
                servicioactivo:null,
                servicios:null,
                trabajos:null,
                trabajoactivo:null,
                agencias:null,
                contenidos:null,
                idsector:null,
                valorformulario:null,
                idarea:null,
                idubicacion:null,
                idservicio:null,
                idtrabajo:null,
                sectorname:'',
                areaname:'',
                ubicacionname:'',
                servicioname:'',
                trabajoname:'',
                agencianame:'',
                contenidoname:'',
                trabajosselecionados: [],
                newtrabajos: [],
                mostrarcolabservicio:false,
                observacionestabuladas:[],
                newservicio:{
                    servicio_id:'', 
                    fechaactivacion:'', 
                    foliointerno:'', 
                    folioexterno:'', 
                    agencia_id:'', 
                    responsable_id:'', 
                    user_id:'', 
                    area_id:'', 
                    ubicacion_id:'', 
                    digitoidentificador:'', 
                    contenido_id:'', 
                    valorinicial:'', 
                    valoragregado:'', 
                    obsvaloragregado:'', 
                    valorfinal:'', 
                    inicio:'', 
                    fotoinicio:'', 
                    termino:'', 
                    fototermino:'', 
                    observacionservicio:'', 
                    fotoobservacion:'', 
                    asistentes:'', 
                    colaboradoresservicio:[],
                    estado:''
                    
                },
                showPreview: false,
                imagePreview: '',
                etapa: 1,
                storage: false,
               
            }
        },
        created() {
           this.sectores=this.dataservicios[2];
           this.observacionestabuladas=this.dataservicios[10];
           var nom = _.mapValues(this.dataservicios[5], function(o) { return o.nombre; });
           this.agencias = Object.values(nom);
           var nom2 = _.mapValues(this.dataservicios[9], function(o) { return o.nombre; });
           this.contenidos = Object.values(nom2);
           var nom3 = _.mapValues(this.dataservicios[1], function(o) { return o.nombrescolab+" "+o.apellidoscolab; });
           this.colaboradores = Object.values(nom3);
           if(this.sectorservicio){
                this.etapa = 2;
                this.sectorname = _.filter(this.dataservicios[2], {'idsector':this.sectorservicio})[0].nombresec;
                this.areas = _.filter(this.dataservicios[3], {'sector_id':this.sectorservicio});
                this.idsector = this.sectorservicio;
                console.log(this.areas, this.sector);
                $("#sec_"+this.sectorservicio).removeClass("btn-primary");
                $("#sec_"+this.sectorservicio).addClass("btn-secondary");
                this.etapa = 2;
           }
           if(sessionStorage.getItem("newservetapa")){
                this.storage = true;
                this.etapa = JSON.parse(sessionStorage.getItem('newservetapa'));
                this.trabajosselecionados = JSON.parse(sessionStorage.getItem('newservtrabajosselecionados'));
                this.areas = JSON.parse(sessionStorage.getItem('newservareas'));
                this.sectorname = JSON.parse(sessionStorage.getItem('newservsectorname'));
                this.idsector = JSON.parse(sessionStorage.getItem('newservidsector'));
                this.ubicaciones = JSON.parse(sessionStorage.getItem('newservubicaciones'));
                this.areaname = JSON.parse(sessionStorage.getItem('newservareaname'));
                this.idarea = JSON.parse(sessionStorage.getItem('newservidarea'));
                this.ubicacionname = JSON.parse(sessionStorage.getItem('newservubicacionname'));
                this.idubicacion = JSON.parse(sessionStorage.getItem('newservidubicacion'));
                this.servicioname = JSON.parse(sessionStorage.getItem('newservservicioname'));
                this.servicioactivo = JSON.parse(sessionStorage.getItem('newservservicioactivo'));
                this.idservicio = JSON.parse(sessionStorage.getItem('newservidservicio'));
                this.serviciotrabajo = JSON.parse(sessionStorage.getItem('newservserviciotrabajo'));
                this.trabajoname = JSON.parse(sessionStorage.getItem('newservtrabajoname'));
                this.servicioactivo = JSON.parse(sessionStorage.getItem('newservservicioactivo'));
                this.trabajoactivo = JSON.parse(sessionStorage.getItem('newservtrabajoactivo'));
                this.serviciotrabajo = JSON.parse(sessionStorage.getItem('newservserviciotrabajo'));
                this.idtrabajo = JSON.parse(sessionStorage.getItem('newservidtrabajo'));
                this.newservicio = JSON.parse(sessionStorage.getItem('newservnewservicio'));
                
                
           }else{
               var currentdate = new Date(); 
                var datetime = "" + currentdate.getFullYear() + "-"
                + ((currentdate.getMonth()+1)>9 ? (currentdate.getMonth()+1) : "0" + (currentdate.getMonth()+1)) + "-" 
                + (currentdate.getDate()>9 ? currentdate.getDate(): "0"+currentdate.getDate()) + " "  
                + (currentdate.getHours() > 9 ? currentdate.getHours() : "0" + currentdate.getHours()) + ":"  
                + (currentdate.getMinutes() > 9 ? currentdate.getMinutes() : "0" + currentdate.getMinutes()) + ":" 
                + (currentdate.getSeconds() > 9 ? currentdate.getSeconds() :"0" +currentdate.getSeconds());
                this.newservicio.inicio = datetime;
           }
        },
        mounted() {
            if(this.newservicio.agencia_id!=''){
                let filtro= _.find(this.dataservicios[5], {'id':this.newservicio.agencia_id});
                console.log(filtro,this.newservicio.agencia_id);
                this.$refs.agencias_id.inputValue = filtro.nombre;
            }
            if(this.newservicio.contenido_id!=''){
                let filtro2 = _.find(this.dataservicios[9], {'id':this.newservicio.contenido_id});
                console.log(filtro2,this.newservicio.contenido_id);
                this.$refs.contenidos_id.inputValue = filtro2.nombre;                
            }
        },
        methods: {
            handleFileUploadAny(tipo,index){
                var file;
                if(tipo==1){
                    file = this.$refs.subirnewfile[index].files[0];
                    this.trabajosselecionados[index].trabajo.detalletrabajo.fotoinicio= file.name;
                    this.trabajosselecionados[index].trabajo.detalletrabajo.filefotoinicio= file;
                }else{
                    file = this.$refs.subirnewfile2[index].files[0];
                    this.trabajosselecionados[index].trabajo.detalletrabajo.fototermino= file.name;
                    this.trabajosselecionados[index].trabajo.detalletrabajo.filefototermino= file;
                }
                let reader  = new FileReader();
                reader.addEventListener("load", function () {
                    //this.showPreview1 = true;
                    //this.imagePreview1 = reader.result;
                }.bind(this), false);
                if( file ){
                    if ( /\.(jpe?g|png|gif)$/i.test( file.name ) ) {
                        reader.readAsDataURL( file);
                    }
                    
                }

            },
            eliminarfile(tipo,index){
                if(tipo==1){
                    this.$refs.subirnewfile[index].inputValue='';
                    this.trabajosselecionados[index].trabajo.detalletrabajo.fotoinicio= "";
                    this.trabajosselecionados[index].trabajo.detalletrabajo.filefotoinicio= null;
                }else{
                    this.$refs.subirnewfile2[index].inputValue='';
                    this.trabajosselecionados[index].trabajo.detalletrabajo.fototermino= "";
                    this.trabajosselecionados[index].trabajo.detalletrabajo.filefototermino= file;
                }
                
            },
            mostrartrabajoservicio(){
                if(this.mostrando=='Trabajos'){
                    this.servicios=null;
                    this.trabajos = _.filter(this.dataservicios[7], {'sector_id':this.idsector});
                    this.mostrando='Servicios';
                    this.tipomostrando='Trabajos';
                }else{
                    this.trabajos=null
                    this.servicios = _.filter(this.dataservicios[6], {'sector_id':this.idsector});
                    this.servicios = _.filter(this.servicios, function(o) { return o.codigo!="DUMMY"; });
                    this.mostrando='Trabajos';
                    this.tipomostrando='Servicios';
                }
            },
            verificaragencia(){
                console.log("entro a agencia");
                let agencia=_.filter(this.dataservicios[5], {'nombre':this.agencianame.toString().toUpperCase()});
                if(agencia.length!=0){
                    this.newservicio.agencia_id = agencia[0].id;
                    return;
                }
            },
            verificarcontenido(){
                console.log("entro a contenido", this.contenidoname);
                let contenido=_.filter(this.dataservicios[9], {'nombre':this.contenidoname});
                if(contenido.length!=0){
                    this.newservicio.contenido_id = contenido[0].id;
                    return;
                }
            },
            volver(fase){
                console.log(this.ubicacion);
                switch (fase) {
                    case 1:
                        if(this.sectorservicio==""){
                            if(this.sectorservicio==this.idsector){
                                this.sectorname='';
                                this.idsector=null;
                                this.etapa=1;
                            }else{
                                this.sectorname='';
                                this.idsector=null;
                                this.etapa=1;
                                /*this.sectorname = _.filter(this.dataservicios[2], {'idsector':this.sectorservicio})[0].nombresec;
                                this.areas = _.filter(this.dataservicios[3], {'sector_id':this.sectorservicio});
                                this.idsector = this.sectorservicio;
                                console.log(this.areas, this.sector);
                                $("#sec_"+this.sectorservicio).removeClass("btn-primary");
                                $("#sec_"+this.sectorservicio).addClass("btn-secondary");
                                this.etapa = 2;*/
                            }
                            
                        }else{
                            this.$toastr.w("No puede seleccionar otro sector");
                                return;
                        }
                        
                        this.areas=null;
                        this.areaname='';
                        this.ubicaciones=null;
                        this.idsector=null;
                        this.idarea=null;
                        this.idubicacion=null;
                        this.idservicio=null;
                        this.idtrabajo=null;
                        this.ubicacionname='';
                        this.servicios = null;
                        this.servicioname = '';
                        this.trabajos = null;
                        this.trabajoname = '';
                        this.etapa=1;
                        this.trabajosselecionados=[];
                        this.newtrabajos=[];
                        break;
                    case 2:
                        this.idarea=null;
                        this.idubicacion=null;
                        this.idservicio=null;
                        this.idtrabajo=null;
                        this.areaname='';
                        this.ubicaciones=null;
                        this.ubicacionname='';
                        this.servicios = null;
                        this.servicioname = '';
                        this.trabajos = null;
                        this.trabajoname = '';
                        this.etapa=2;
                        this.trabajosselecionados=[];
                        this.newtrabajos=[];
                        break;
                    case 3:
                        this.idubicacion=null;
                        this.idservicio=null;
                        this.idtrabajo=null;
                        this.ubicacionname='';
                        this.servicios = null;
                        this.servicioname = '';
                        this.trabajos = null;
                        this.trabajoname = '';
                        this.etapa=3;
                        this.trabajosselecionados=[];
                        this.newtrabajos=[];
                        break;
                    case 4:
                        if(this.trabajosselecionados.length>0){
                            if(!confirm("Tiene trabajos seleccionados ¿Está seguro de salir de este servicio/trabajo?")){
                                return;
                            }
                        }
                        
                        this.idservicio=null;
                        this.idtrabajo=null;
                        this.servicioname = '';
                        this.trabajoname = '';
                        this.etapa=4;
                        this.trabajosselecionados=[];
                        this.newtrabajos=[];
                        this.newservicio={
                            servicio_id:'', 
                            fechaactivacion:'', 
                            foliointerno:'', 
                            folioexterno:'', 
                            agencia_id:'', 
                            responsable_id:'', 
                            user_id:'', 
                            area_id:'', 
                            ubicacion_id:'', 
                            digitoidentificador:'', 
                            contenido_id:'', 
                            valorinicial:'', 
                            valoragregado:'', 
                            obsvaloragregado:'', 
                            valorfinal:'', 
                            inicio:'', 
                            fotoinicio:'', 
                            termino:'', 
                            fototermino:'', 
                            observacionservicio:'', 
                            fotoobservacion:'', 
                            asistentes:'', 
                            colaboradoresservicio:[],
                            estado:''
                            
                        };
                        break;
                    default:
                        break;
                }
            },
            seleccionarsector(sectorsel){
                $("#sec_"+sectorsel).removeClass("btn-secondary");
                $("#sec_"+sectorsel).addClass("btn-primary");
                setTimeout(() => {
                    this.areas = _.filter(this.dataservicios[3], {'sector_id':sectorsel});
                    this.sectorname= _.filter(this.dataservicios[2], {'idsector':sectorsel})[0].nombresec;
                    this.idsector= sectorsel;
                    console.log(this.areas, this.sector);
                    $("#sec_"+sectorsel).removeClass("btn-primary");
                    $("#sec_"+sectorsel).addClass("btn-secondary");
                    this.etapa=2;
                }, 500);
                
            },
            seleccionaraera(areasel){
                $("#area_"+areasel).removeClass("btn-secondary");
                $("#area_"+areasel).addClass("btn-primary");
                setTimeout(() => {  
                    this.ubicaciones = _.filter(this.dataservicios[4], {'area_id':areasel});
                    this.areaname= _.filter(this.dataservicios[3], {'idarea':areasel})[0].nombrearea;
                    this.idarea = areasel;
                    this.newservicio.area_id=this.idarea;
                    console.log(this.ubicaciones, this.area,this.ubicaciones.length);
                    $("#area_"+areasel).removeClass("btn-primary");
                    $("#area_"+areasel).addClass("btn-secondary");
                    if(this.ubicaciones.length!=0){
                        this.etapa=3;
                    }else{
                        this.servicios = _.filter(this.dataservicios[6], {'sector_id':this.idsector});
                        this.servicios = _.filter(this.servicios, function(o) { return o.codigo!="DUMMY"; });
                        this.etapa=4;
                    }
                }, 500);
            },
            seleccionarubicacion(ubicacionsel){
                $("#ubi_"+ubicacionsel).removeClass("btn-secondary");
                $("#ubi_"+ubicacionsel).addClass("btn-primary");
                setTimeout(() => {
                    this.ubicacionname= _.filter(this.dataservicios[4], {'idubicacion':ubicacionsel})[0].nombreubi;
                    this.idubicacion=ubicacionsel;
                    this.newservicio.ubicacion_id=this.idubicacion;
                    console.log(this.ubicacion, this.idubicacion);
                    $("#ubi_"+ubicacionsel).removeClass("btn-primary");
                    $("#ubi_"+ubicacionsel).addClass("btn-secondary");
                    this.servicios = _.filter(this.dataservicios[6], {'sector_id':this.idsector});
                    this.servicios = _.filter(this.servicios, function(o) { return o.codigo!="DUMMY"; });
                    this.etapa=4;
                }, 500);
            },
            seleccionarservicio(serviciosel){
                $("#ser_"+serviciosel).removeClass("btn-secondary");
                $("#ser_"+serviciosel).addClass("btn-primary");
                setTimeout(() => {
                    this.servicioname = _.filter(this.dataservicios[6], {'id':serviciosel})[0].nombre;
                    this.servicioactivo = _.filter(this.dataservicios[6], {'id':serviciosel})[0];
                    this.idservicio=serviciosel;
                    this.serviciotrabajo = _.filter(this.dataservicios[8], {'servicio_id':this.idservicio});
                    this.newservicio.servicio_id= this.idservicio;
                    console.log(this.servicioactivo,this.serviciotrabajo);
                    $("#ser_"+serviciosel).removeClass("btn-primary");
                    $("#ser_"+serviciosel).addClass("btn-secondary");
                    //this.servicios = _.filter(this.dataservicios[5], {'sector_id':this.idsector});
                    this.etapa=5;
                }, 500);
            },
            seleccionartrabajo(trabajosel){
                $("#tra_"+trabajosel).removeClass("btn-secondary");
                $("#tra_"+trabajosel).addClass("btn-primary");
                setTimeout(() => {
                    this.trabajoname = _.filter(this.dataservicios[7], {'id':trabajosel})[0].nombre;
                    this.servicioactivo = _.filter(this.dataservicios[6], {'codigo':'DUMMY', 'sector_id':this.idsector})[0];
                    this.newservicio.servicio_id= this.servicioactivo.id;
                    this.trabajoactivo = _.filter(this.dataservicios[7], {'id':trabajosel})[0];
                    this.serviciotrabajo = _.filter(this.dataservicios[8], {'servicio_id':this.servicioactivo.id, 'trabajo_id':trabajosel});
                    this.idtrabajo=trabajosel;
                    console.log(this.servicioactivo, this.trabajoactivo, this.serviciotrabajo);
                    $("#tra_"+trabajosel).removeClass("btn-primary");
                    $("#tra_"+trabajosel).addClass("btn-secondary");
                    //this.servicios = _.filter(this.dataservicios[5], {'sector_id':this.idsector});
                    Vue.set(this.serviciotrabajo[0].trabajo,"detalletrabajo", {
                        serviciotrabajo_id: this.serviciotrabajo.id, 
                        inicio: null,
                        fotoinicio: "",
                        filefotoinicio:"",
                        termino: null,
                        fototermino: "",
                        filefototermino:"",
                        asistentes: 0,
                        colaboradores: [],
                        mostrarcolab: false,
                        observaciontabulada_id:null,
                        obsvaloragregado: null
                        });
                    //this.newtrabajos.push(dettrabajos);
                    this.trabajosselecionados = this.serviciotrabajo;
                    this.etapa=6;
                }, 500);
            },
            seleccionarlistatrabajo(){
                let trabajos = [];
                let trabajossi = [];
                var currentdate = new Date(); 
                var datetime = "" + currentdate.getFullYear() + "-"
                + ((currentdate.getMonth()+1)>9 ? (currentdate.getMonth()+1) : "0" + (currentdate.getMonth()+1)) + "-" 
                + (currentdate.getDate()>9 ? currentdate.getDate(): "0"+currentdate.getDate()) + " "  
                + (currentdate.getHours() > 9 ? currentdate.getHours() : "0" + currentdate.getHours()) + ":"  
                + (currentdate.getMinutes() > 9 ? currentdate.getMinutes() : "0" + currentdate.getMinutes()) + ":" 
                + (currentdate.getSeconds() > 9 ? currentdate.getSeconds() :"0" +currentdate.getSeconds());
                console.log(datetime);
                this.newservicio.fechaactivacion = datetime;
                $("#listadetrabajos input:checkbox").each(function(){
                    if(!$(this).is(':checked')){
                        trabajos.push($(this).val());  
                    }else{
                        trabajossi.push($(this).val());
                    }
                    
                });
                console.log(trabajos.length);
                if(trabajossi.length==0){
                    this.$toastr.w("Favor de seleccionar un trabajo");
                    return;
                }
                let trabajosx = this.serviciotrabajo;
                trabajos.forEach(element => {
                    let id = this.serviciotrabajo[element].id;
                    trabajosx =_.filter(trabajosx, function(o) { return o.id!= id; });

                });
                
                
                trabajosx.forEach(element => {
                    element.trabajo.campotrabajo.forEach(element2 => {
                            element2.campoformularios["value"] = ""; 
                    });
                    Vue.set(element.trabajo, "detalletrabajo", {
                        serviciotrabajo_id: element.id, 
                        inicio: null,
                        fotoinicio: "",
                        filefotoinicio:"",
                        termino: null,
                        fototermino: "",
                        filefototermino:"",
                        asistentes: 0,
                        colaboradores: [],
                        mostrarcolab: false,
                        observaciontabulada_id:null,
                        obsvaloragregado: null
                        });
                    
                });
                
                console.log(trabajos,trabajosx);
                this.trabajosselecionados = trabajosx;
                this.etapa=6;
            },
            colaboradortrabajo(index, id){
                console.log(this.dataservicios[1], id);
                var name=this.$refs.colaborador[index].inputValue;
                var colabs = null;
                colabs = _.filter(this.dataservicios[1],function(o) { return o.nombrescolab+" "+o.apellidoscolab == name; });
                console.log(colabs);
                if(colabs.length==0){
                    this.$toastr.w("Nombre ingresado no concuerda con un colaborador, favor de revisar");
                    return;
                }
                var existe = _.filter(this.trabajosselecionados[index].trabajo.detalletrabajo.colaboradores,{"rutcolaborador":colabs[0].rutcolaborador });
                console.log(existe);
                if(existe.length!=0){
                    this.$toastr.w("Colaborador ya asignado a este trabajo, favor de revisar");
                    return;
                }
                this.trabajosselecionados[index].trabajo.detalletrabajo.colaboradores.push(colabs[0]);
                Vue.set(colabs[0], "nombretrabajo", this.trabajosselecionados[index].trabajo.nombre);
                this.newservicio.colaboradoresservicio.push(colabs[0]);
                console.log(this.trabajosselecionados);
                this.$refs.colaborador[index].inputValue="";
                return;
            },
            eliminarcolabtrabajo(colaboradores, index){
                colaboradores.splice(index,1);
            //agregar eliminacion de lista principal
            },
            guardaravance(){
                sessionStorage.clear();
                sessionStorage.setItem('newservetapa',JSON.stringify(this.etapa));
                sessionStorage.setItem('newservtrabajosselecionados',JSON.stringify(this.trabajosselecionados));
                sessionStorage.setItem('newservareas',JSON.stringify(this.areas));
                sessionStorage.setItem('newservsectorname',JSON.stringify(this.sectorname));
                sessionStorage.setItem('newservidsector',JSON.stringify(this.idsector));
                sessionStorage.setItem('newservubicaciones',JSON.stringify(this.ubicaciones));
                sessionStorage.setItem('newservareaname',JSON.stringify(this.areaname));
                sessionStorage.setItem('newservidarea',JSON.stringify(this.idarea));
                sessionStorage.setItem('newservubicacionname',JSON.stringify(this.ubicacionname));
                sessionStorage.setItem('newservidubicacion',JSON.stringify(this.idubicacion));
                sessionStorage.setItem('newservservicioname',JSON.stringify(this.servicioname));
                sessionStorage.setItem('newservservicioactivo',JSON.stringify(this.servicioactivo));
                sessionStorage.setItem('newservidservicio',JSON.stringify(this.idservicio));
                sessionStorage.setItem('newservserviciotrabajo',JSON.stringify(this.serviciotrabajo));
                sessionStorage.setItem('newservtrabajoname',JSON.stringify(this.trabajoname));
                sessionStorage.setItem('newservservicioactivo',JSON.stringify(this.servicioactivo));
                sessionStorage.setItem('newservtrabajoactivo',JSON.stringify(this.trabajoactivo));
                sessionStorage.setItem('newservserviciotrabajo',JSON.stringify(this.serviciotrabajo));
                sessionStorage.setItem('newservidtrabajo',JSON.stringify(this.idtrabajo));
                sessionStorage.setItem('newservnewservicio',JSON.stringify(this.newservicio));
                this.$toastr.s("Informacion de avance guardada con éxito");
            },
            limpiarstorage(){
                if(confirm("¿Está seguro de eliminar la información guardada como avance?")){
                    sessionStorage.clear();
                    setTimeout(function() {
                                location.reload();
                            }, 1000);
                }
            },
            guardarservicio(){
                console.log(this.newservicio, this.trabajosselecionados);
                let flagcolaboradores = false;
                if(confirm("¿Está seguro de guardar este servicio?")){
                    this.trabajosselecionados.forEach(element => {
                        if(element.trabajo.detalletrabajo.colaboradores.length==0){
                            flagcolaboradores = true;
                        }
                    });
                    if(flagcolaboradores){
                        this.$toastr.w("Los trabajos deben tener al menos un colaborador asociado, favor revisar");
                        return;
                    }
                    console.log(this.trabajosselecionados[0].trabajo.detalletrabajo.filefotoinicio);
                    axios.post('/operation/setdatos', {tipo:'nuevoservicio',newservicio:this.newservicio, detalletrabajo: this.trabajosselecionados})
                        .then((res) =>{
                        console.log(res.data);
                        if(res.data==''){
                            this.trabajosselecionados.forEach(element => {
                                let formData = new FormData();
                                if(element.trabajo.detalletrabajo.filefotoinicio!=""){
                                    formData.append('image',element.trabajo.detalletrabajo.filefotoinicio);
                                    formData.append('nombre',element.trabajo.detalletrabajo.fotoinicio);
                                    formData.append('tipo','imagentrabajoinicio');
                                    formData.append('id',element.id);
                                    console.log(formData);
                                    axios.post('/sistema/uploadimage', formData, {
                                        headers: {
                                        'Content-Type': 'multipart/form-data'
                                        }
                                    })
                                    .then(response => {
                                        console.log(response.data.message, 'success');
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
                                if(element.trabajo.detalletrabajo.filefototermino!=""){
                                    formData.append('image',element.trabajo.detalletrabajo.filefototermino);
                                    formData.append('nombre',element.trabajo.detalletrabajo.fototermino);
                                    formData.append('tipo','imagentrabajotermino');
                                    formData.append('id',element.id);
                                    console.log(formData);
                                    axios.post('/sistema/uploadimage', formData, {
                                        headers: {
                                        'Content-Type': 'multipart/form-data'
                                        }
                                    })
                                    .then(response => {
                                        console.log(response.data.message, 'success');
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
                            });
                            this.$toastr.s("Servicio "+servicioname+trabajoname+" ingresado en sistema");
                            sessionStorage.clear();
                            $(".close").click();
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
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
