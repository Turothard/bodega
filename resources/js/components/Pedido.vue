<template>
  <div class="container-fluid">
    <div v-show="terminado==1" class="container-fluid">
      <div v-if="user!='BODEGA'" class="btn-group" role="group" aria-label="Basic example">
        <button
          type="button"
          class="btn btn-info"
          data-toggle="modal"
          data-target="#pedidomodal"
          @click="generarpedido()"
        >Generar Pedido</button>
      </div>
      <div>
        <table
          id="tablapedidos"
          class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100"
        >
          <thead>
            <tr>
              <th class="all">ID</th>
              <th class="desktop">Tipo Pedido</th>
              <th class="all">Usuario</th>
              <th class="desktop">Sector</th>
              <th class="all">Área</th>
              <th class="all">Ubicación</th>
              <th class="desktop">Autorizado</th>
              <th class="desktop">Bodeguero</th>
              <th class="desktop">Receptor</th>
              <th class="all">Cant</th>
              <th class="all">Fecha</th>
              <th class="all">Estado</th>
              <th class="all">Funciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item,index) in pedidos" :key="index"  v-bind:class="clasepedido(item.estadoped)">
              <td>{{ item.id }}</td>
              <td>{{ item.tipopedido }}</td>
              <td
                v-if="item.user_id!=null"
              >{{ usuarios.find( items => items.id === item.user_id ).name }}</td>
              <td v-else>---------</td>
              <td
                v-if="item.sector_id!=null"
                data-label="Sector"
              >{{ sectores.find( items => items.idsector === item.sector_id ).nombresec }}</td>
              <td v-else>---------</td>
              <td
                v-if="item.area_id!=null"
                data-label="Area"
              >{{ areas.find( items => items.idarea === item.area_id ).nombrearea }}</td>
              <td v-else>---------</td>
              <td
                v-if="item.ubicacion_id!=null"
                data-label="Ubicación"
              >{{ ubicaciones.find( items => items.idubicacion === item.ubicacion_id ).nombreubi}}</td>
              <td v-else>---------</td>
              <td
                v-if="item.autorizado_id!=null"
                data-label="Autorizado por"
              >{{ colaboradores.find( items => items.rutcolaborador === item.autorizado_id ).nombrecortocolab}}</td>
              <td v-else>---------</td>
              <td
                v-if="item.bodeguero_id!=null"
                data-label="Trabajado Por"
              >{{ colaboradores.find( items => items.rutcolaborador === item.bodeguero_id ).nombrecortocolab}}</td>
              <td v-else>---------</td>
              <td
                v-if="item.receptor_id!=null"
                data-label="Entregado a"
              >{{ colaboradores.find( items => items.rutcolaborador === item.receptor_id ).nombrecortocolab}}</td>
              <td v-else>---------</td>
              <td>{{ item.cantidadped }}</td>
              <td>{{ item.fechaped }}</td>
              <td>{{ item.estadoped }}</td>
              <td>
                <button
                  class="btn btn-sm" style="background-color:#20964D;"
                  v-if="item.estadoped=='PENDIENTE' && ( user=='ADMIN' ||  user=='SUPERVISORES')"
                  @click="aceptarpedido(item,item.id)"
                >
                  <img style="width:23px;heigth:23px;" src="css/img/aceptar.png" />
                </button>
                <button
                  class="btn btn-danger btn-sm"
                  v-if="(item.estadoped=='PENDIENTE' || item.estadoped=='INGRESADO') && ( user=='ADMIN' ||  user=='SUPERVISORES')"
                  @click="cancelarpedido(item,item.id)"
                >
                  <img style="width:23px;heigth:23px;" src="css/img/cancelar.png" />
                </button>
                <button v-if="item.estadoped=='INGRESADO'" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#pedidomodal" @click="detallepedidos(item,item.id)" >
                  <img style="width:23px;heigth:23px;" src="css/img/moreinfo.png" />
                </button>
                <button v-else-if="item.estadoped=='PENDIENTE'" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#pedidomodal" @click="detallepedidos(item,item.id)" >
                  <img style="width:23px;heigth:23px;" src="css/img/moreinfo.png" />
                </button>
                <button v-else-if="item.estadoped=='PROCESADO'" class="btn btn-success btn-sm" data-toggle="modal" data-target="#pedidomodal" @click="detallepedidos(item,item.id)" >
                  <img style="width:23px;heigth:23px;" src="css/img/moreinfo.png" />
                </button>
                <button v-else-if="item.estadoped=='ENTREGADO'" class="btn btn-info btn-sm" data-toggle="modal" data-target="#pedidomodal" @click="detallepedidos(item,item.id)" >
                  <img style="width:23px;heigth:23px;" src="css/img/moreinfo.png" />
                </button>
                <button v-else-if="item.estadoped=='FINALIZADO'" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#pedidomodal" @click="detallepedidos(item,item.id)" >
                  <img style="width:23px;heigth:23px;" src="css/img/moreinfo.png" />
                </button>
                <button v-else-if="item.estadoped=='CANCELADO'" class="btn btn-sm" style="background-color:#EA8512" data-toggle="modal" data-target="#pedidomodal" @click="detallepedidos(item,item.id)" >
                  <img style="width:23px;heigth:23px;" src="css/img/moreinfo.png" />
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div
        class="modal fade"
        id="pedidomodal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="pedidomodallabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5
                v-if="componenteactual=='pedido_generar'"
                class="modal-title"
                id="exampleModalLabel"
              >Generar Pedido</h5>
              <h5
                v-if="componenteactual=='pedido_detalle'"
                class="modal-title"
                id="exampleModalLabel"
              >Actualizar Pedido</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div v-show="componenteactual==''" class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
              </div>
              <component
                v-bind:is="componenteactual"
                :datapedido="datapedido"
                :pedido="pedido"
                :detallepedido="detallepedido"
              ></component>
            </div>
            <div class="modal-footer">
              <select
                v-if="componenteactual=='pedido_detalle' && pedido.estadoped=='PROCESADO' && user=='BODEGA'"
                class="form-control form-control-sm t-regular w-s"
                v-model="sectorvue"
                required
              >
                <option value>------</option>
                <option
                  v-for="(itemxx, indexx) in sector"
                  :key="indexx"
                  :value="itemxx.sectorcolab"
                >{{ itemxx.sectorcolab }}</option>
              </select>
              <select
                v-if="componenteactual=='pedido_detalle' && pedido.estadoped=='PROCESADO' && user=='BODEGA'"
                class="form-control form-control-sm t-regular w-l"
                v-model="pedido.receptor_id"
                required
              >
                <option value>------</option>
                <option
                  v-for="(itemxx, indexx) in colabs"
                  :key="indexx"
                  :value="itemxx.rutcolaborador"
                >{{ itemxx.nombrecortocolab }}</option>
              </select>
              <button
                v-if="componenteactual=='pedido_generar'"
                type="button"
                class="btn btn-primary"
                @click="guardarpedido()"
                v-show="pedido.cantidad>0"
              >Guardar Pedido</button>

              <button
                v-if="componenteactual=='pedido_detalle' && pedido.estadoped!='FINALIZADO' && pedido.estadoped!='PENDIENTE' && user=='BODEGA'"
                type="button"
                class="btn btn-primary"
                @click="modificarpedido(pedido)"
              >
                <label v-if="pedido.estadoped=='INGRESADO'" for>Procesar Pedido</label>
                <label v-else-if="pedido.estadoped=='PROCESADO'" for>Entregar Pedido</label>
                <label v-else-if="pedido.estadoped=='ENTREGADO'" for>Ingresar Devoluciones</label>
              </button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-show="terminado!=1" class="container-fluid">
      <div class="d-flex justify-content-center">
        <div class="spinner-border" style="width: 4rem; height: 4rem;" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import pedido_generar from "./pedidos/pedidogenerar.vue";
import pedido_detalle from "./pedidos/pedidodetalle.vue";
export default {
  name: "Pedido",
  components: {
    pedido_generar,
    pedido_detalle
  },
  props: ["menupedido"],
  data() {
    return {
      dt: null,
      datapedido: null,
      pedido: {
        id: 1,
        sector: "",
        area: "",
        ubicacion: "",
        tipopedido: "",
        preestablecido: "",
        cantidad: 0
      },
      detallepedido: [],
      componenteactual: "",
      infopedido: [],
      pedidos: [],
      pedidoactivo: [],
      usuarios: [],
      colaboradores: [],
      colaboradores2: [],
      sector:'',
      sectorvue:'',
      areas: [],
      ubicaciones: [],
      sectores: [],
      terminado: 0,
      user: null
    };
  },
  created() {
    axios
      .post("/sistema/getdatos", { tipo: "Pedido" })
      .then(res => {
        this.datapedido = res.data;
        this.pedidos = this.datapedido[8];
        this.usuarios = this.datapedido[0];
        this.colaboradores = this.datapedido[1];
        this.colaboradores2 = this.datapedido[14];
        this.sector = this.datapedido[15];
        this.sectores = this.datapedido[5];
        this.areas = this.datapedido[6];
        this.ubicaciones = this.datapedido[7];
        console.log(this.colaboradores);
        if (this.datapedido[9] != null) {
          this.pedido.id = parseInt(this.datapedido[9]) + 1;
        }
        this.user = this.datapedido[11];
        this.$nextTick(function() {
          this.dt = $("#tablapedidos").DataTable({
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
          if (sessionStorage.getItem("pedido")) {
            // Restaura el contenido al campo de texto
            this.pedido = JSON.parse(sessionStorage.getItem("pedido"));
            this.detallepedido = JSON.parse(
              sessionStorage.getItem("detallepedido")
            );
            //sessionStorage.clear();
          }

          console.log("cargado");
          this.terminado = 1;
        });
        console.log(this.pedidos);
      })
      .catch(error => {
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
  mounted() {},
  computed:{
      colabs: function () {
        console.log(this.colaboradores2);
          let filtrete=this.colaboradores2;
          let flagcete=false;
          if(this.sectorvue!=''){
              //let bodegas = this.detallebodega;
              filtrete= _.filter(filtrete, {'sectorcolab':this.sectorvue});
          }                
          return _.orderBy(filtrete, ['nombrecortocolab']);
          
      },
  },
  methods: {
    clasepedido(estado){
      switch (estado) {
        case 'PENDIENTE':
          return 'pendiente';
          break;
        case 'INGRESADO':
          return 'ingresado';
          break;
        case 'PROCESADO':
          return 'procesado';
          break;
        case 'ENTREGADO':
          return 'entregado';
          break;
        case 'FINALIZADO':
          return 'finalizado';
          break;
        case 'CANCELADO':
          return 'cancelado';
          break;
        default:
        return 'default';
          break;
      }
    },
    generarpedido() {
      this.componenteactual = "pedido_generar";
    },
    detallepedidos(ped, id) {
      console.log(ped, id);
      axios
        .post("/pedidos/getdatos", { tipo: "detallepedido", id: id })
        .then(res => {
          this.pedido = ped;
          this.detallepedido = res.data;
          console.log(res.data); //return;
          this.componenteactual = "pedido_detalle";
        })
        .catch(function(error) {
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
    guardarpedido() {
      console.log(this.pedido, this.detallepedido);
      if (confirm("¿Está seguro de guardar este pedido?")) {
        axios
          .post("/pedidos/store", {
            tipo: "guardarpedido",
            ped: this.pedido,
            det: this.detallepedido
          })
          .then(res => {
            //console.log(res.data);return;
			$(".close").click();
			this.$toastr.s("Pedido ingresado exitosamente");
            this.detallepedido = [];
            this.pedido = {
              id: parseInt(res.data.id) + 1,
              sector: "",
              area: "",
              ubicacion: "",
              tipopedido: "",
              preestablecido: "",
              cantidad: 0
            };
            sessionStorage.clear();
            this.pedidos.push(res.data);
			this.componenteactual = "";
			setTimeout(function() {
              $(".close").click();
              location.reload();
            }, 2000);
            console.log(res.data);
          })
          .catch(function(error) {
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
    aceptarpedido(ped, id) {
      if (
        confirm("¿Está seguro de confirmar este pedido para ser procesado?")
      ) {
        axios
          .post("/pedidos/store", { tipo: "aceptarpedido", id: id })
          .then(res => {
            ped.estadoped = "INGRESADO";
          })
          .catch(function(error) {
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
    cancelarpedido(ped,id){
      if (
        confirm("¿Está seguro de cancelar este pedido?")
      ) {
        axios
          .post("/pedidos/store", { tipo: "cancelarpedido", id: id })
          .then(res => {
            ped.estadoped = "CANCELADO";
            this.$toastr.s("Pedido cancelado con éxito");
            $(".close").click();
          })
          .catch(function(error) {
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
    modificarpedido(pedido) {
      let flag = false;
      if (pedido.estadoped == "INGRESADO") {
        this.detallepedido.forEach(element => {
          if (
            element.cantidadprodetped == "" ||
            element.cantidadprodetped == null
          ) {
            flag = true;
          }
        });
        if (flag) {
          this.$toastr.w("Debe procesar todos los árticulos");
          return;
        }
        console.log(this.detallepedido);
        //return;
        axios
          .post("/pedidos/store", {
            tipo: "procesarpedido",
            id: pedido.id,
            detalle: this.detallepedido
          })
          .then(res => {
            console.log(res.data);
            pedido.estadoped = "PROCESADO";
            this.$toastr.s("Pedido procesado con éxito");
            $(".close").click();
          })
          .catch(function(error) {
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
      if (pedido.estadoped == "PROCESADO") {
        console.log(pedido, this.detallepedido);
        //return;
        axios
          .post("/pedidos/store", {
            tipo: "entregarpedido",
            pedido: pedido,
            detalle: this.detallepedido
          })
          .then(res => {
            //console.log(res.data);return;
            pedido.estadoped = "ENTREGADO";
            this.$toastr.s("Pedido entregado con éxito");
            setTimeout(function() {
              $(".close").click();
              window.open("imprimir/"+pedido.id);
              location.reload();
            }, 1500);
            //location.reload();
          })
          .catch(function(error) {
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
      if (pedido.estadoped == "ENTREGADO") {
        if(!confirm("¿Está seguro de ingresar la recepción de este pedido?")){
          return;
        }
        console.log(pedido,this.detallepedido)
        axios
          .post("/pedidos/store", {
            tipo: "ingresardevolucion",
            pedido: pedido,
            detalle: this.detallepedido
          })
          .then(res => {
            //console.log(res.data);return;
            pedido.estadoped = "FINALIZADO";
            setTimeout(function() {
              $(".close").click();
              location.reload();
            }, 1500);
            //location.reload();
          })
          .catch(function(error) {
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
  }
};
</script>
<style >
  #tablapedidos tr td{
    background-color: #907C5F;
    font-weight: 600;
  }
  #tablapedidos .finalizado td{
    background-color: #416041;
    font-weight: 600;
  }
  #tablapedidos .cancelado td{
    background-color: #6B6B6B;
    font-weight: 600;
  }
  #tablapedidos .ingresado td,#tablapedidos .pendiente td{
    background-color: #49647D;
    font-weight: 600;
  }
</style>