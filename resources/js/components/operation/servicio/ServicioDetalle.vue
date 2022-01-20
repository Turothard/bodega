<template>
    <div class="container-fluid">
        <div class="modal fade" id="serviciodetallemodal" tabindex="-1" role="dialog" aria-labelledby="serviciodetallemodal" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Detalle servicio {{servicioelegido!=null ? servicioelegido.id +" - "+dataservicios[6].find(items => items.id === servicioelegido.servicio_id).nombre: ""}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-sm table-bordered table-dark dt-responsive t-regular w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Servicio</th>
                                <th>Area</th>
                                <th>Ubicación</th>
                                <th>Inicio</th>
                                <th>Termino</th>
                                <th>Encargado</th>
                                <th>Asistentes</th>
                                <th v-if="user=='ADMIN'">Valor</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="servicioelegido!=null">
                                <td>{{servicioelegido.id}}</td>
                                <td>{{dataservicios[6].find(items => items.id === servicioelegido.servicio_id).nombre}}</td>
                                <td>{{dataservicios[3].find(items => items.idarea === servicioelegido.area_id).nombrearea}}</td>
                                <td>{{servicioelegido.area_id!=null ? dataservicios[4].find(items => items.idubicacion === servicioelegido.ubicacion_id).nombreubi : ""}}</td>
                                <td>{{servicioelegido.inicio}}</td>
                                <td>{{servicioelegido.termino}}</td>
                                <td>{{dataservicios[0].find(items => items.id === servicioelegido.responsable_id).name}}</td>
                                <td>{{servicioelegido.asistentes}}</td>
                                <td v-if="user=='ADMIN'">{{servicioelegido.valorfinal}}</td>
                                <td>{{servicioelegido.estado}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100">
                        <thead>
                            <tr>
                                <th>Folio Interno</th>
                                <th>Folio Externo</th>
                                <th>Identificador</th>
                                <th>Agencia</th>
                                <th>Contenido</th>
                                <th style="max-width:300px">Observación Servicio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="servicioelegido!=null">
                                <td>{{servicioelegido.foliointerno}}</td>
                                <td>{{servicioelegido.folioexterno}}</td>
                                <td>{{servicioelegido.digitoidentificador}}</td>
                                <td>{{dataservicios[5].find(items => items.id === servicioelegido.agencia_id).nombre}}</td>
                                <td>{{dataservicios[9].find(items => items.id === servicioelegido.contenido_id).nombre}}</td>
                                <td style="max-width:300px">{{servicioelegido.observacionservicio}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <h1>Trabajos</h1>
                    <div v-if="servicioelegido!=null" class="row container-fluid">
                        <div class="col-12" v-for="(item,index) in servicioelegido.detalletrabajos" :key="index" >
                            <h3>{{dataservicios[8].find(items => items.id === item.serviciotrabajo_id).trabajo.nombre}}</h3>
                            <table class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100">
                                <thead>
                                    <tr>
                                        <th>Código Trabajo</th>
                                        <th>Trabajo</th>
                                        <th>Foto Inicio</th>
                                        <th>Foto Termino</th>
                                        <th>Asistentes</th>
                                        <th v-if="user=='ADMIN'">Valor</th>
                                        <th colspan="2">Observación tabulada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{dataservicios[8].find(items => items.id === item.serviciotrabajo_id).trabajo.codigo}}</td>
                                        <td>{{dataservicios[8].find(items => items.id === item.serviciotrabajo_id).trabajo.nombre}}</td>
                                        <td v-if="item.fotoinicio != null">
                                            <a target="_blank" :href="'/'+item.fotoinicio">
                                            <button class="btn btn-info btn-sm" >
                                                
                                                <img style="width:23px;heigth:23px;" src="/css/img/verimage.png"/>
                                            </button></a>
                                        </td>
                                        <td v-else>
                                            ----------
                                        </td>
                                        <td v-if="item.fototermino != null">
                                            <a target="_blank" :href="'/'+item.fototermino">
                                            <button class="btn btn-info btn-sm" >
                                                
                                                <img style="width:23px;heigth:23px;" src="/css/img/verimage.png"/>
                                            </button></a>
                                        </td>
                                        <td v-else>
                                            ----------
                                        </td>
                                        <td>{{item.asistentes}}</td>
                                        <td v-if="user=='ADMIN'">{{item.valorfinal}}</td>
                                        <td colspan="2">{{dataservicios[10].find(items => items.id === item.observaciontabulada_id).nombre}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-3" v-for="(itemcampo,indexcampo) in item.detalletrabajocampos" :key="indexcampo">
                                    <table class="table table-striped display table-sm table-bordered table-dark t-regular dt-responsive w-100">
                                        <thead>
                                            <tr>
                                                <th class="desktop">{{itemcampo.campotrabajo.campoformularios.nombre}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{itemcampo.valor}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <table v-if="item.colaboradortrabajos.length>0" class="table table-striped display table-sm table-bordered table-dark t-regular dt-responsive w-100">
                                <thead>
                                    <tr>
                                        <th class="desktop">Rut</th>
                                        <th class="desktop">Nombre</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(itemcol,indexcol) in item.colaboradortrabajos" :key="indexcol">
                                        <td>{{itemcol.colaborador_id}}</td>
                                        <td>{{dataservicios[1].find(items => items.rutcolaborador === itemcol.colaborador_id).nombrecortocolab}}</td>
                                         
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['dataservicios', 'sectorservicio', 'servicioelegido'],
        data(){
            return{
                detalleservicios:null,
                cargando:true,
                sectorname:null,
                user:null,
            }
        },
        created() {
            if(this.sectorservicio!=""){
                this.sectorname = _.filter(this.dataservicios[2], {'idsector':this.sectorservicio});
                //console.log("_",this.sectorservicio);return;
                
            }
            this.user = this.dataservicios[11];
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
