<template>
    <div class="container-fluid">
            <div class="d-flex flex-row">
            <div class="p-2 col-2">
                <ul id="ulinformes" class="list-group">
                    <li class="list-group-item pointer" @click="componenteactual='infstock'">Stock</li>
                    <li class="list-group-item pointer" @click="componenteactual='infstockcrit'">Stock Crítico</li>
                    <li class="list-group-item pointer" @click="componenteactual='infinv'">Inventario</li>
                    <li class="list-group-item pointer" @click="componenteactual='inffrecoc'">Frecuencia OC</li>
                    <li class="list-group-item pointer" @click="componenteactual='inffreccaja'">Frecuencia Caja Chica</li>
                    <li class="list-group-item pointer" @click="componenteactual='infentart'">Entrega Por Artículos</li>
                    <li class="list-group-item pointer" @click="componenteactual='infentcol'">Entrega Por Colaborador</li>
                    <li class="list-group-item pointer" @click="componenteactual='infcost'">Costos</li>
                </ul>
            </div>
            <div class="p-2 col-10">
              <!-- <li v-for="n  in 20 " :key="n">{{n}}</li>!-->
                <component v-bind:is="componenteactual" :datainformes="datainformes" ></component>
            </div>
            </div>
    </div>
</template>

<script>
    import infstock from '../warehouse/informes/informesstock.vue';

    import infstockcrit from '../warehouse/informes/informesstockcrit.vue';
    import infinv from '../warehouse/informes/informesinv.vue';
    import inffrecoc from '../warehouse/informes/informesfrecoc.vue';
    import inffreccaja from '../warehouse/informes/informesfreccaja.vue';
    import infentart from '../warehouse/informes/informesentart.vue';
    import infentcol from '../warehouse/informes/informesentcol.vue';
    import infcost from '../warehouse/informes/informescost.vue';

    export default {
        components: {
            inffreccaja, 
            infstockcrit,
            infstock,
            infinv,
            inffrecoc,
            infentart,
            infentcol,
            infcost
        },
        data(){
            return{
                dt: null,
                datainformes:null,
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
            axios.post('/sistema/getdatoswarehouse', {tipo:'informes'}).then((res) =>{
                    this.datainformes = res.data;
                    this.usuarios = this.datainformes[0];
                    this.colaboradores = this.datainformes[1];
                    this.sectores = this.datainformes[5];
                    this.areas = this.datainformes[6];
                    this.ubicaciones = this.datainformes[7];
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
    $(document).on('click', '#ulinformes li',function(e){
        if($(this).hasClass('active')){
            //console.log("entro al if");
            e.preventDefault();
            return;
        }else{
            //console.log("entro al else");
            $("#ulinformes li.active").removeClass('active');
            $(this).addClass('active');
        }
    });
</script>
