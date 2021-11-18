<template>
    <div class="container-fluid">
        <div v-if="terminado==1" class="d-flex flex-row">
            <div class="p-2">
                <ul id="ulservicio" class="list-group">
                    <li v-for="(item,index) in sectores" :key="index" class="list-group-item pointer" @click="cambiacomponente(item['idsector'])" :value="item['idsector']">{{item['nombresec']}}</li>      
                </ul>
            </div>
            <div class="container-fluid p-2">
               <div class="card">
                <div class="card-header">
                    <h1>Servicios</h1>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            Inicio: <input type="date" v-model="filtros.fechai" class="form-control form-control-sm t-regular p-2" id="fechai" name="fechai">
                        </div>
                        <div class="col-3">
                            Fin: <input type="date" v-model="filtros.fechaf" class="form-control form-control-sm t-regular p-2 " id="fechaf" name="fechaf">
                        </div>
                        <div class="col-3">
                            Estado:
                            <select v-model="filtros.estado" class="form-control form-control-sm t-regular  text-uppercase">
                                <option value="">------</option>
                                <option value="CARGADO">CARGADO</option>
                                <option value="EN PROCESO">EN PROCESO</option>
                                <option value="FINALIZADO">FINALIZADO</option>
                                <option value="ANULADO">ANULADO</option>
                                <option value="CANCELADO">CANCELADO</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-info btn-sm">
                                <img style="width:40px;heigth:40px;" src="/css/img/buscar.png"  title="Buscar Servicios" />
                            </button>
                            <button class="btn btn-success btn-sm">
                                <img style="width:40px;heigth:40px;" src="/css/img/agregar.png" @click="componente='nuevo_servicio'" data-toggle="modal" data-target="#ingresoserviciomodal" title="Crear Servicio" />
                            </button>
                        </div>
                        <div class="p-2 col-12">
                        <!-- <li v-for="n  in 20 " :key="n">{{n}}</li>!-->
                            <component v-bind:is="componenteactual" :dataservicios="dataservicios" :sectorservicio="sectorservicio" ></component>
                        </div>
                    </div>
                </div>
            </div>
                
            </div>
        </div>
        <div v-else class="container-fluid">
            <div class="d-flex justify-content-center">
                <div class="spinner-border" style="width: 4rem; height: 4rem;" role="status">
                <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <component v-bind:is="componente" :dataservicios="dataservicios" ></component>
    </div>
    
</template>

<script>
    import servicios_detalle from '../operation/servicio/ServicioDetalle.vue';
    import nuevo_servicio from '../operation/servicio/NuevoServicio.vue';
    export default {
        components: {
            servicios_detalle,
            nuevo_servicio
        },
        data(){
            return{
                dt: null,
                dataservicios:null,
                pedido:{},
                componenteactualvue:'',
                filtros:{fechai:'',fechaf:'',estado:''},
                componenteactual:'',
                sectorservicio:'',
                servicios: [],
                terminado:0,
                usuarios: [],
                colaboradores: [],
                sectores: [],
                ubicaciones: [],
                componente: null,
                terminado:0,
                user:null
            }
        },
        watch: {
            'componenteactual':function(val, oldVal){
                if(val!=''){
                    //this.componenteactualvue= val;
                    sessionStorage.setItem("componenteactualvue",(val));
                     $("#ulservicio li.active").removeClass('active');
                    $("#li_"+val).addClass('active');
                }
            }
        },
        created() {
            axios.post('/sistema/getdatosoperation', {tipo:'Servicio'}).then((res) =>{
                    this.dataservicios = res.data;
                    this.servicios = this.dataservicios[6];
                    this.sectores = this.dataservicios[2];
                    if (sessionStorage.getItem("componenteactualvue")) {
                    // Restaura el contenido al campo de texto
                        this.componenteactual = sessionStorage.getItem("componenteactualvue");
                        switch (this.componenteactual) {
                            case 'RDA':
                                $("#ulservicio li:nth-child(1)").addClass("active");
                                break;
                            case 'ZAO':
                                $("#ulservicio li:nth-child(2)").addClass("active");
                                break;
                            case 'Z-serv':
                                $("#ulservicio li:nth-child(3)").addClass("active");
                                break;
                            default:
                                break;
                        }
                        //sessionStorage.clear();
                    }
                    this.user = this.dataservicios[0];
                 this.terminado=1;
                console.log(this.servicios);
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
            cambiacomponente(sector){
                this.sectorservicio=sector;
                this.componenteactual='servicios_detalle';
            }
        }
    }
    $(document).on('click', '#ulservicio li',function(e){
        if($(this).hasClass('active')){
            console.log("entro al if");
            e.preventDefault();
            return;
        }else{
            console.log("entro al else");
            $("#ulservicio li.active").removeClass('active');
            $(this).addClass('active');
        }
    });
</script>
