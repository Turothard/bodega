<template>
    <div class="container-fluid">
        <div class="d-flex flex-row">
            <div class="p-2">
                <ul id="ulbodega" class="list-group">
                    <li class="list-group-item pointer" @click="componenteactual='bodega_detalle'">Bodega</li>
                    <li class="list-group-item pointer">Movimientos</li>
                    <li class="list-group-item pointer" @click="componenteactual='pedido'">Pedidos</li>
                    <li class="list-group-item pointer">Inventario</li>
                </ul>
            </div>
            <div class="p-2">
               
                <component v-bind:is="componenteactual" :menupedidos="'bodega'" :databodega="databodega" ></component>
            </div>
        </div>
    </div>
</template>

<script>
    import bodega_detalle from './bodega/bodegadetalle.vue';
    /*import pedido_detalle from './pedidos/pedidodetalle.vue';*/
    import pedido from './Pedido.vue';
    export default {
        components: {
            pedido, 
            bodega_detalle
        },
        data(){
            return{
                dt: null,
                databodega:null,
                pedido:{},
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
        created() {
            axios.post('/sistema/getdatos', {tipo:'Bodega'}).then((res) =>{
                    this.databodega = res.data;
                    this.pedidos = this.databodega[8];
                    this.usuarios = this.databodega[0];
                    this.colaboradores = this.databodega[1];
                    this.sectores = this.databodega[5];
                    this.areas = this.databodega[6];
                    this.ubicaciones = this.databodega[7];
                    
                    if(this.databodega[9]!=null){
                        this.pedido.id = parseInt(this.databodega[9])+1;
                    }
                    this.user = this.databodega[11];
                    this.$nextTick(function () {
                    
                    this.dt = $('#tablapedidos').DataTable({
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
                    
                    
                    console.log('cargado');
                    this.terminado=1;
                });
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
