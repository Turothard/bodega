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
                <div v-if="etapa==5" class="row">
                    <div class="col-1">
                        Folio Interno:
                        <input type="text" v-model="newservicio.foliointerno" class="form-control form-control-sm t-regular p-2" id="foliointerno" name="foliointerno">
                    </div>
                    <div class="col-1">
                        Folio Externo:
                        <input type="text" v-model="newservicio.folioexterno" class="form-control form-control-sm t-regular p-2" id="folioexterno" name="folioexterno">
                    </div>
                    <div class="col-2">
                        Identificador:
                        <input type="text" v-model="newservicio.digitoidentificador" class="form-control form-control-sm t-regular p-2" id="digitoidentificador" name="digitoidentificador">
                    </div>
                    <div class="col-2">
                        Agencia:
                        <vue-bootstrap-typeahead                         
                            v-model="agencianame"
                            :inputClass="'upcase form-control form-control-sm'"
                            @hit="verificaragencia()"
                            :minMatchingChars="3"
                            ref="agencia_id"
                            :data="agencias"
                            >
                        </vue-bootstrap-typeahead>
                    </div>
                   
                    <div class="col-2">
                        Contenido:
                        <vue-bootstrap-typeahead                         
                            v-model="contenidoname"
                            :inputClass="'upcase form-control form-control-sm'"
                            @hit="verificarcontenido()"
                            :minMatchingChars="3"
                            ref="contenido_id"
                            :data="contenidos"
                            >
                        </vue-bootstrap-typeahead>
                    </div>
                    <div class="col-1">
                        Operarios: <input type="text" class="form-control form-control-sm t-regular p-2 w-xs" id="foliointerno" name="foliointerno">
                        
                    </div>
                    <div class="col-1">
                        <button type="button" class="btn btn-primary" >Colaboradores</button>
                    </div>
                </div>
                 <hr>   
                <div v-if="etapa==5" class="row">
                        <div class="col-12">
                            <h1>Parcial 40</h1>
                        </div>
                        
                        <div class="col-3">Inicio Trabajo: <input type="date" class="form-control form-control-sm t-regular p-2" id="fechai" name="fechai"></div>
                        <div class="col-1">
                            <button  class="btn btn-info btn-sm"><img style="width:23px;heigth:23px;" src="/css/img/addimage.png"/></button>
                                                            
                        </div>
                        <div class="col-3">Fin Trabajo: <input type="date" class="form-control form-control-sm t-regular p-2" id="fechaf" name="fechaf"></div>
                        <div class="col-1">
                            <button  class="btn btn-info btn-sm"><img style="width:23px;heigth:23px;" src="/css/img/addimage.png"/></button> 
                        </div>
                         <div class="col-4">

                         </div>
                         <br>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Observación</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                 <button type="button" class="btn btn-primary" >Guardar Servicio</button>
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
                sectores:null,
                areas:null,
                ubicaciones:null,
                servicios:null,
                trabajos:null,
                agencias:null,
                contenidos:null,
                idsector:null,
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
                    estado:''
                },
                etapa: 1,
               
            }
        },
        created() {
           this.sectores=this.dataservicios[2];
           var nom = _.mapValues(this.dataservicios[5], function(o) { return o.nombre; });
           this.agencias =Object.values(nom);
           var nom2 = _.mapValues(this.dataservicios[9], function(o) { return o.nombre; });
           this.contenidos =Object.values(nom);
           if(this.sectorservicio){
               this.etapa=2;
               this.sectorname= _.filter(this.dataservicios[2], {'idsector':this.sectorservicio})[0].nombresec;
               this.areas = _.filter(this.dataservicios[3], {'sector_id':this.sectorservicio});
               
           }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            mostrartrabajoservicio(){
                if(this.mostrando=='Trabajos'){
                    this.servicios=null;
                    this.trabajos = _.filter(this.dataservicios[7], {'sector_id':this.idsector});
                    this.mostrando='Servicios';
                    this.tipomostrando='Trabajos';
                }else{
                    this.trabajos=null
                    this.servicios = _.filter(this.dataservicios[6], {'sector_id':this.idsector});
                    this.mostrando='Trabajos';
                    this.tipomostrando='Servicios';
                }
            },
            verificaragencia(){
                let agencia=_.filter(this.dataservicios[5], {'nombre':this.agencianame.toString().toUpperCase()});
                if(agencia.length==0){
                    this.newservicio.agencia_id = agencia[0].id;
                    return;
                }
            },
            verificarcontenido(){
                let contenido=_.filter(this.dataservicios[8], {'nombre':this.contenidoname.toString().toUpperCase()});
                if(contenido.length==0){
                    this.newservicio.contenido_id = contenido[0].id;
                    return;
                }
            },
            volver(fase){
                console.log(this.ubicacion);
                switch (fase) {
                    case 1:    
                        this.sectorname='';
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
                        break;
                    case 4:
                            this.idservicio=null;
                            this.idtrabajo=null;
                            this.servicioname = '';
                            this.trabajoname = '';
                            this.etapa=4;
                        
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
                    console.log(this.ubicaciones, this.area,this.ubicaciones.length);
                    $("#area_"+areasel).removeClass("btn-primary");
                    $("#area_"+areasel).addClass("btn-secondary");
                    if(this.ubicaciones.length!=0){
                        this.etapa=3;
                    }else{
                        this.servicios = _.filter(this.dataservicios[6], {'sector_id':this.idsector});
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
                    console.log(this.ubicacion, this.idubicacion);
                    $("#ubi_"+ubicacionsel).removeClass("btn-primary");
                    $("#ubi_"+ubicacionsel).addClass("btn-secondary");
                    this.servicios = _.filter(this.dataservicios[6], {'sector_id':this.idsector});
                    this.etapa=4;
                }, 500);
            },
            seleccionarservicio(serviciosel){
                $("#ser_"+serviciosel).removeClass("btn-secondary");
                $("#ser_"+serviciosel).addClass("btn-primary");
                setTimeout(() => {
                    this.servicioname = _.filter(this.dataservicios[6], {'id':serviciosel})[0].nombre;
                    this.idservicio=serviciosel;
                    this.serviciotrabajo = _.filter(this.dataservicios[8], {'servicio_id':this.idservicio});
                    console.log(this.servicio);
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
                    this.serviciotrabajo = _.filter(this.dataservicios[7], {'trabajo_id':this.idservicio});
                    this.idtrabajo=trabajosel;
                    console.log(this.trabajo);
                    $("#tra_"+trabajosel).removeClass("btn-primary");
                    $("#tra_"+trabajosel).addClass("btn-secondary");
                    //this.servicios = _.filter(this.dataservicios[5], {'sector_id':this.idsector});
                    this.etapa=5;
                }, 500);
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
