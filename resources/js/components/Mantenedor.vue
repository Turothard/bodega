<template>
    <div class="container-fluid">

            <div class="w-75">
                <ul id="ulbodega" class="list-group list-group-horizontal-sm">
                    <li class="list-group-item pointer" @click="componenteactual='mantart'">Artículos</li>
                    <li class="list-group-item pointer" @click="componenteactual='mantcat'">Categorías</li>
                    <li class="list-group-item pointer" @click="componenteactual='mantsubcat'">Subcategorías</li>
                    <li class="list-group-item pointer" @click="componenteactual='mantcol'">Colores</li>
                    <li class="list-group-item pointer" @click="componenteactual='mantprov'">Proveedores</li>
                </ul>
            </div>
            <div class="container-fluid">
              <!-- <li v-for="n  in 20 " :key="n">{{n}}</li>!-->
                <component v-bind:is="componenteactual" :datamantenedor="datamantenedor" ></component>
            </div>

    </div>
</template>

<script>
    import mantart from './mantenedor/mantenedorart.vue';

    import mantcat from './mantenedor/mantenedorcat.vue';
    import mantprov from './mantenedor/mantenedorprov.vue'
    import mantsubcat from './mantenedor/mantenedorsubcat.vue';
    import mantcol from './mantenedor/mantenedorcol.vue';
   /* import bodega_detalle from './mantenedor/mantenedorsubcat.vue';
    import bodega_detalle from './mantenedor/mantenedorcol.vue';
    import bodega_detalle from './mantenedor/mantenedormar.vue';
    import bodega_detalle from './mantenedor/mantenedorart.vue';
    import bodega_detalle from './mantenedor/mantenedorart.vue';
    import bodega_detalle from './mantenedor/mantenedorart.vue';
    */
    export default {
        components: {
            mantart, 
            mantcat,
            mantprov,
            mantsubcat,
            mantcol
        },
        data(){
            return{
                dt: null,
                datamantenedor:null,
                pedido:{},
                detallepedido:[],
                componenteactual:'',
                infopedido:[],
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
            axios.post('/sistema/getdatos', {tipo:'Mantenedores'}).then((res) =>{
                    this.datamantenedor = res.data;
                    this.usuarios = this.datamantenedor[0];
                    this.colaboradores = this.datamantenedor[1];
                    this.sectores = this.datamantenedor[5];
                    this.areas = this.datamantenedor[6];
                    this.ubicaciones = this.datamantenedor[7];
                    
                    
                    
                    console.log('cargado');
                    this.terminado=1;
               
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
