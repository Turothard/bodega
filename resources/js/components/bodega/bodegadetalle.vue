<template>
    <div class="container-fluid">
       <div class="row">
           <div class="col-8">
               <div class="row">
                   <div id="bodegabuttons" class="col-2">
                       <div  v-for="(item,index) in bodega" :key="index" class="btn-group btn-group-vertical pb-1" role="group">
                        <button type="button" class="btn btn-secondary" @click="selectbodega(item.idbodega)">{{item.idbodega}}</button>

                        </div>
                   </div>
                   <div id="estantebuttons" class="col-10">
                       <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div v-for="(item,index) in estantefiltrado" :key="index"  class="btn-group mr-2 pb-1" role="group" aria-label="Third group">
                                <button type="button" @click="selectestante(item.id)" class="btn btn-secondary">{{item.nroestante}}</button>
                            </div>
                        </div>
                   </div>
               </div>
           </div>
           <div class="col-4">

           </div>
       </div>
       <div class="container-fluid">
            <div v-show="cargando" class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div v-show="!cargando">
                <table id="tabladetalle" class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100">
                    <thead>
                        <tr>
                            <th class="all">Bodega</th>
                            <th class="all">Estante</th>
                            <th class="all">Sector</th>
                            <th class="all">Nivel</th>
                            <th class="all">Código</th>
                            <th class="desktop">Nombre Art</th>
                            <th class="all">Cantidad</th>
                            <th class="desktop">St Crítico</th>
                            <th class="desktop">Ind Rotación</th>
                            <th class="desktop">Periodo Devo</th>
                            <th class="all">Funciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,index) in bodegafiltrada" :key="index">
                            <td>{{item.bodega_id}}</td>
                            <td>{{item.nroestante}}</td>
                            <td>{{item.sectorpos}}</td>
                            <td>{{item.nivelpos}}</td>
                            <td>{{item.codigoart}}</td>
                            <td>{{item.nombreart}}</td>
                            <td>{{item.cantidadpos}}</td>
                            <td>{{item.stockcriticoart}}</td>
                            <td>{{item.indicerotacionart}}</td>
                            <td>{{item.descripcionper}}</td>
                            <td>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
       </div>
    </div>
</template>

<script>
    export default {
        props: ['databodega'],
        data(){
            return{
                preestablecidovue:null,
                cargando:true,
                usuarios: [],
                colaboradores: [],
                areas: [],
                bodega: [],
                posiciones: [],
                sectores: [],
                articulos: [],
                estantes:[],
                detallebodega:[],
                bodegaselect:'',
                estanteselect:'',
                user:null,
                dt:null
            }
        },
        computed: {
        // a computed getter
            bodegafiltrada: function () {
                let filtrete=this.detallebodega;
                let flagcete=false;
                if(this.bodegaselect!=''){
                    //let bodegas = this.detallebodega;
                    filtrete= _.filter(filtrete, {'bodega_id':this.bodegaselect});
                }
                if(this.estanteselect!=''){
                    //let bodegas = this.detallebodega;
                    filtrete= _.filter(filtrete, {'estante_id':this.estanteselect});
                }
                
                    return filtrete;
                
            },
            estantefiltrado: function(){
                if(this.estanteselect!='' || this.bodegaselect!=''){
                  if(this.bodegaselect!=''){
                      let estantes = this.estantes;
                    return _.filter(estantes, {'bodega_id':this.bodegaselect});
                  }             
                  
                }else{
                    return null;
                }
            }
        },
        created() {
            this.bodega = this.databodega[8];
            this.usuarios = this.databodega[0];
            this.colaboradores = this.databodega[1];
            this.sectores = this.databodega[5];
            this.areas = this.databodega[6];
            this.articulos = this.databodega[4];
            //this.posiciones = this.databodega[10];
            this.estantes = this.databodega[9];
            console.log('Component created.');
            axios.post('/bodega/getdatos', {tipo:'bodega'}).then((res) =>{
                this.detallebodega = res.data;
                //this.cargando=false;
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
                    });
                    this.cargando=false;
                });  
                
            });
        },
        mounted() {
            
            
        },
        methods: {
            selectbodega(idbodega){
                if($(this).hasClass('btn-secondary')){
                    $(this).removeClass("btn-secondary");
                    $("#bodegabuttons button.btn-primary").addClass("btn-secondary");
                    $("#bodegabuttons button.btn-primary").removeClass("btn-primary");
                    $(this).addClass("btn-primary");
                }else{
                    $(this).removeClass("btn-primary");
                    $(this).addClass("btn-secondary");
                }
                if(this.bodegaselect==idbodega){
                    this.bodegaselect='';
                    
                }else{
                    this.estanteselect='';
                    this.bodegaselect=idbodega;
                    $("#estantebuttons button.btn-primary").addClass("btn-secondary");
                    $("#estantebuttons button.btn-primary").removeClass("btn-primary");
                }
                
                this.dt.draw(true);
            },
            selectestante(idestante){
                if($(this).hasClass('btn-secondary')){
                    $(this).removeClass("btn-secondary");
                    $("#estantebuttons button.btn-primary").addClass("btn-secondary");
                    $("#estantebuttons button.btn-primary").removeClass("btn-primary");
                    $(this).addClass("btn-primary");
                }else{
                    $(this).removeClass("btn-primary");
                    $(this).addClass("btn-secondary");
                }
                if(this.estanteselect==idestante){
                    this.estanteselect='';
                }else{
                    this.estanteselect=idestante;
                }
                this.dt.draw(true);
            }
        },
    }
    $(document).on('click', '#bodegabuttons button', function(){
        //console.log("holi");
        if($(this).hasClass('btn-secondary')){
            $(this).removeClass("btn-secondary");
            $("#bodegabuttons button.btn-primary").addClass("btn-secondary");
            $("#bodegabuttons button.btn-primary").removeClass("btn-primary");
            $(this).addClass("btn-primary");
        }else{
            $(this).removeClass("btn-primary");
            $(this).addClass("btn-secondary");
        }
    });
    $(document).on('click', '#estantebuttons button', function(){
        //console.log("holi");
        if($(this).hasClass('btn-secondary')){
            $(this).removeClass("btn-secondary");
            $("#estantebuttons button.btn-primary").addClass("btn-secondary");
            $("#estantebuttons button.btn-primary").removeClass("btn-primary");
            $(this).addClass("btn-primary");
        }else{
            $(this).removeClass("btn-primary");
            $(this).addClass("btn-secondary");
        }
    });
</script>
