<template>
    <div class="container-fluid">
        <div class="d-flex flex-row">
            <div class="p-2">
                <ul id="ulbodega" class="list-group">
                    <li class="list-group-item pointer" id="li_bodega_detalle" @click="componenteactual='bodega_detalle'">Bodega</li>
                    <li class="list-group-item pointer" id="li_pedido" @click="componenteactual='pedido'">Pedidos</li>
                    <li class="list-group-item pointer" id="li_bodega_ingresos" @click="componenteactual='bodega_ingresos'">Ingresos</li>
                    <li class="list-group-item pointer" id="li_bodega_movimientos" @click="componenteactual='bodega_movimientos'">Movimientos</li>
                    <li class="list-group-item pointer" id="li_bodega_inventarios" @click="componenteactual='bodega_inventarios'">Inventario</li>
                </ul>
            </div>
            <div class="p-2">
               
                <component v-bind:is="componenteactual" :menupedidos="'bodega'" :databodega="databodega" ></component>
            </div>
        </div>
    </div>
</template>

<script>
    import bodega_detalle from '../warehouse/bodega/bodegadetalle.vue';
    import bodega_ingresos from '../warehouse/bodega/bodeingresos.vue';
    import bodega_movimientos from '../warehouse/bodega/bodemovimientos.vue';
    import bodega_inventarios from '../warehouse/bodega/bodeinventarios.vue';
    /*import bodega_detalle from './bodega/bodegadetalle.vue';
    import pedido_detalle from './pedidos/pedidodetalle.vue';*/
    import pedido from '../warehouse/Pedido.vue';
    export default {
        components: {
            pedido, 
            bodega_detalle,
            bodega_ingresos,
            bodega_movimientos,
            bodega_inventarios
        },
        data(){
            return{
                dt: null,
                databodega:null,
                pedido:{},
                componenteactualvue:'',
                detallepedido:[],
                componenteactual:'',
                infopedido:[],
                pedidos: [],
                pedidoactivo:[],
                usuarios: [],
                colaboradores: [],
                areas: [],
                ubicaciones: [],
                sectores: [],
                terminado:0,
                user:null
            }
        },
        watch: {
            'componenteactual':function(val, oldVal){
                if(val!=''){
                    //this.componenteactualvue= val;
                    sessionStorage.setItem("componenteactualvue",(val));
                     $("#ulbodega li.active").removeClass('active');
                    $("#li_"+val).addClass('active');
                }
            }
        },
        created() {
            axios.post('/sistema/getdatoswarehouse', {tipo:'Bodega'}).then((res) =>{
                    this.databodega = res.data;
                    this.pedidos = this.databodega[8];
                    this.usuarios = this.databodega[0];
                    this.colaboradores = this.databodega[1];
                    this.sectores = this.databodega[5];
                    this.areas = this.databodega[6];
                    this.ubicaciones = this.databodega[7];
                    if (sessionStorage.getItem("componenteactualvue")) {
                    // Restaura el contenido al campo de texto
                        this.componenteactual = sessionStorage.getItem("componenteactualvue");
                        switch (this.componenteactual) {
                            case 'pedido':
                                $("#ulbodega li:nth-child(2)").addClass("active");
                                break;
                            case 'bodega_detalle':
                                $("#ulbodega li:nth-child(1)").addClass("active");
                                break;
                            default:
                                break;
                        }
                        //sessionStorage.clear();
                    }
                    if(this.databodega[9]!=null){
                        this.pedido.id = parseInt(this.databodega[9])+1;
                    }
                    this.user = this.databodega[11];
                 
                console.log(this.pedidos);
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
            
        }
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
