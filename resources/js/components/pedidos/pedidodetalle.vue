<template>
    <div class="container-fluid">
       <div>
           <table class="table table-striped table-sm table-bordered table-dark table-responsive-md t-regular w-100">
               <thead>
                   <tr>
                        <th class="all">ID</th>
                        <th>Tipo Pedido</th>
                        <th>Usuario</th>
                        <th>Sector</th>
                        <th>Área</th>
                        <th>Ubicación</th>
                        <th>Autorizado</th>
                        <th>Bodeguero</th>
                        <th>Receptor</th>
                        <th>Cant</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                   </tr>
               </thead>
               <tbody>
                   <tr>
                       <td data-label="Id">{{ pedido.id }}</td>
                        <td >{{ pedido.tipopedido }}</td>
                        <td v-if="pedido.user_id!=null" >{{ usuarios.find( items => items.id === pedido.user_id ).name }}</td>
                        <td v-else >---------</td>
                        <td v-if="pedido.sector_id!=null" >{{ sectores.find( items => items.idsector === pedido.sector_id ).nombresec }}</td>
                        <td v-else >---------</td>
                        <td v-if="pedido.area_id!=null">{{ areas.find( items => items.idarea === pedido.area_id ).nombrearea }}</td>
                        <td v-else >---------</td>
                        <td v-if="pedido.ubicacion_id!=null" >{{ ubicaciones.find( items => items.idubicacion === pedido.ubicacion_id ).nombreubi}}</td>
                        <td v-else >---------</td>
                        <td v-if="pedido.autorizado_id!=null">{{ colaboradores.find( items => items.rutcolaborador === pedido.autorizado_id ).nombrecortocolab}}</td>
                        <td v-else >---------</td>
                        <td v-if="pedido.bodeguero_id!=null" >{{ colaboradores.find( items => items.rutcolaborador === pedido.bodeguero_id ).nombrecortocolab}}</td>
                        <td v-else >---------</td>
                        <td v-if="pedido.receptor_id!=null">{{ colaboradores.find( items => items.rutcolaborador === pedido.receptor_id ).nombrecortocolab}}</td>
                        <td v-else >---------</td>
                        <td>{{ pedido.cantidadped }}</td>
                        <td>{{ pedido.fechaped }}</td>
                        <td>{{ pedido.estadoped }}</td>
                   </tr>
               </tbody>
           </table>
       </div>
       <div class="container-fluid">
           <table id="tabladetalle" class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100">
               <thead>
                   <tr>
                       <th>Árticulo</th>
                       <th>Tipo entrega</th>
                       <th>Nombre Art</th>
                       <th v-if=" pedido.estadoped!='PENDIENTE'">Bodega</th>
                       <th v-if="pedido.estadoped=='INGRESADO' && user=='BODEGA'">Est</th>
                       <th v-if="pedido.estadoped=='INGRESADO' && user=='BODEGA'">Sec</th>
                       <th v-if="pedido.estadoped=='INGRESADO' && user=='BODEGA'">nil</th>
                       <th>Solicitados</th>
                       <th>Procesado</th>
                       <th>Receptor</th>
                       <th>Devuelto</th>
                   </tr>
               </thead>
               <tbody>
                   <tr v-for="(item,index) in detallepedido" :key="index">
                       <td>{{item.codigoart}}</td>
                       <td>{{item.tipodetped}}</td>
                       <td>{{articulos.find( items => items.codigoart === item.codigoart ).nombreart}}</td>
                       <td v-if="pedido.estadoped!='PENDIENTE'">{{item.bodega_id}}</td>
                       <td v-if="pedido.estadoped=='INGRESADO' && user=='BODEGA'">{{item.nroestante}}</td>
                       <td v-if="pedido.estadoped=='INGRESADO' && user=='BODEGA'">{{item.sectorpos}}</td>
                       <td v-if="pedido.estadoped=='INGRESADO' && user=='BODEGA'">{{item.nivelpos}}</td>
                        <!-- cantidadpedido --> 
                       <td v-if="pedido.estadoped=='INGRESADO' || pedido.estadoped=='PENDIENTE' || pedido.estadoped=='ANULADO'">{{item.cantidaddetped}}</td>
                       <td v-if="pedido.estadoped=='PROCESADO' || pedido.estadoped=='ENTREGADO' || pedido.estadoped=='FINALIZADO'">{{item.cantidadpedido}}</td>
                        <!-- cantidadproceso --> 
                       <td v-if="pedido.estadoped=='PENDIENTE' || pedido.estadoped=='ANULADO'">-----</td>
                       <td v-else-if="pedido.estadoped=='INGRESADO'">
                           <input v-if="user=='BODEGA'" type="number" min="0" v-model="item.cantidadprodetped" class="form-control form-control-sm w-s">
                           
                       </td>
                       <td v-else-if="pedido.estadoped!='INGRESADO' && pedido.estadoped!='PENDIENTE' && pedido.estadoped!='ANULADO'">{{item.cantidadproceso}}</td>
                        <!-- receptor --> 
                        <td v-if="pedido.estadoped=='INGRESADO' || pedido.estadoped=='PENDIENTE' || pedido.estadoped=='ANULADO'">-----</td>
                       <td v-else-if="pedido.estadoped=='PROCESADO' && user=='BODEGA' && item.tipodetped=='INDIVIDUAL' && item.receptor_prod==null">
                           <select class="form-control form-control-sm t-regular" v-model="item.receptor_vue" required>
                            <option value="">------</option>
                            <option v-for="(itemx, index) in colaboradores" :key="index" :value="itemx.rutcolaborador">
                                {{ itemx.nombrecortocolab }}
                            </option>
                        </select>
                       </td>
                        <td v-else-if="item.receptor_prod!=null">{{colaboradores.find( items => items.rutcolaborador === item.receptor_prod ).nombrecortocolab}} </td>
                        <td v-else>-------</td>
                        <!-- cantidaddevolucion --> 
                       <td v-if="pedido.estadoped=='INGRESADO' || pedido.estadoped=='PENDIENTE' || pedido.estadoped=='ANULADO'"></td>
                       <td v-else-if="pedido.estadoped=='ENTREGADO' && user=='BODEGA' && articulos.find(items => items.codigoart === item.codigoart ).periododevo_id>1">
                           <input type="number" min="0" v-model="item.cantidaddevolucion" readonly class="form-control form-control-sm w-s">
                       </td>
                       <td v-else>-------</td>
                   </tr>
               </tbody>
           </table>
       </div>
    </div>
</template>

<script>
    export default {
        props: ['datapedido','infopedido','pedido','detallepedido'],
        data(){
            return{
                preestablecidovue:null,
                codigos:null,
                usuarios: [],
                colaboradores: [],
                areas: [],
                ubicaciones: [],
                sectores: [],
                articulos: [],
                periododevo:[],
                pressaveflag:false,
                presshowflag:false,
                user:null,
                dt:null
            }
        },
        created(){
            this.pedidos = this.datapedido[8];
            this.usuarios = this.datapedido[0];
            this.colaboradores = this.datapedido[1];
            this.sectores = this.datapedido[5];
            this.areas = this.datapedido[6];
            this.ubicaciones = this.datapedido[7];
            this.articulos = this.datapedido[4];
            this.user = this.datapedido[11];
            this.periododevo = this.datapedido[12];
            console.log(this.user);
        },
        mounted() {
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
                    paging: false
                });
            });
        }
    }
</script>
