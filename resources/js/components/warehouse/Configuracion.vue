<template>
    <div class="container-fluid">

        <div class="w-75">
                <ul id="ulconfiguracion" class="list-group  list-group-horizontal-sm">
                    <li class="list-group-item pointer" @click="componenteactual='confcolab'">Mantenedor Colaboradores</li>
                    <li class="list-group-item pointer" @click="componenteactual='confuser'">Mantenedor Usuarios</li>
                    

                </ul>
        </div>
            <div class="container-fluid">
              <!-- <li v-for="n  in 20 " :key="n">{{n}}</li>!-->
                <component v-bind:is="componenteactual" :dataconfiguracion="dataconfiguracion" ></component>
                
            </div>
            </div>
    </div>
</template>

<script>
    import confcolab from '../configuraciones/configuracioncolab.vue';
    import confuser from '../configuraciones/configuracionuser.vue';

    //import confstockcrit from './configuracion/configuracionstockcrit.vue';


    export default {
        components: {
            confcolab, 
            confuser
        },
        data(){
            return{
                dt: null,
                dataconfiguracion:null,
                pedido:{},
                detallepedido:[],
                componenteactual:'',
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
            axios.post('/sistema/getdatoswarehouse', {tipo:'Mantenedores'}).then((res) =>{
                this.dataconfiguracion = res.data;
                this.usuarios = this.dataconfiguracion[0];
                this.colaboradores = this.dataconfiguracion[14];
                this.sectores = this.dataconfiguracion[5];
                this.areas = this.dataconfiguracion[6];
                this.ubicaciones = this.dataconfiguracion[7];
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
    $(document).on('click', '#ulconfiguracion li',function(e){
        if($(this).hasClass('active')){
            //console.log("entro al if");
            e.preventDefault();
            return;
        }else{
            //console.log("entro al else");
            $("#ulconfiguracion li.active").removeClass('active');
            $(this).addClass('active');
        }
    });
</script>
