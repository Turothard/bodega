<template>
    <div class="container-fluid">
        <br>
        <div>
            <button class="btn btn-info btn-sm"  data-toggle="modal" data-target="#colormodal" @click="cargarcrear()">Agregar Color</button>
        </div><br>
        <div>
            <table id="tabladetalle" class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100">
                <thead>
                    <tr>
                        <th class="all">Código color</th>
                        <th class="desktop">Nombre Color</th>
                        <th class="desktop">Hexadecimal Color</th>
                        <th class="all">Funciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item,index) in colores" :key="index">
                        <td>{{item.idcolor}}</td>
                        <td>{{item.nombrecol}}</td>
                        <td>{{item.hexcol}}</td>
                        <td>
                            <button @click="eliminarcolor(item, index)" class="btn btn-danger btn-sm">
                                <img style="width:23px;heigth:23px;" src="css/img/delete.png"/>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="colormodal" tabindex="-1" role="dialog" aria-labelledby="articulomodallabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="tipocol=='nuevocolor'" class="modal-title" id="exampleModalLabel">Crear nuevo Color</h5>
                        <h5 v-if="tipocol=='editarcolor'" class="modal-title" id="exampleModalLabel">Actualizar Color</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100">
                            <thead>
                                <tr>
                                    <th class="all">Código Color</th>
                                    <th class="desktop">Nombre Color</th>
                                    <th class="desktop">Hexadecimal Color</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td ><input type="number" v-model="colorvue.idcolor" maxlength="3" readonly="" class="form-control form-control-sm w-s t-regular" :id="'idcolor'" name="idcolor"></td>
                                    <td ><input type="text" v-model="colorvue.nombrecol" maxlength="20" class="form-control form-control-sm w-d t-regular" :id="'nombrecol'" name="nombrecol"></td>
                                    <td ><input type="color" v-model="colorvue.hexcol"  class="form-control form-control-sm t-regular" :id="'hexcol'" name="hexcol"></td>
                                </tr>
                            </tbody>
                        </table>          
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="guardarcolor(colorvue)">
                            Guardar Color
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                    </div>
                </div>
            </div>
           <!--  <component v-bind:is="imagenactual" :imagen="imagenart" :articulo="articuloimagen" ></component>
           <imagenvue :imagen="imagenart" :articulo="articuloimagen" />!-->
    </div>
</template>

<script>

    export default {
        props: ['datamantenedor'],
        data(){
            return{
                preestablecidovue:null,
                cargando:true,
                disabled:false,
                colores: [],
                correlativos: [],
                correlativosvue: [],
                correlativox:'',
                tipocol:'',
                colorvue: {idcolor:'',nombrecol:'', hexcol:''},
                dt:null,
            }
        },
        created() {
            console.log('Component created.');
            this.colores =this. datamantenedor[9];
            this.$nextTick(function () {
                /*this.dt.destroy();
                this.dt =null;*/
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
        },
        computed: {
        // a computed getter
        },
        mounted() {
            //alert(" es"+(this.isMobileTablet()).toString());
        },
        methods: {
            
            guardarcolor(col){
                let mensaje ='';
                if(this.tipocol == 'nuevocolor'){
                    mensaje="¿Está seguro de guardar este nuevo Color?";
                }else{
                    mensaje="¿Está seguro de modificar este Color?";
                }
                if(col.idcolor=='' || col.nombrecol=='' || col.hexcol=='' ){
                    this.$toastr.w("Favor de ingresar datos obligatorios!!");
                    return;
                }
                if(confirm(mensaje)){
                    axios.post('/mantenedores/setdatos', {tipo:this.tipocol, detalle:col})
                    .then((res) =>{
                        console.log(res.data);
                        if(this.tipocol == 'nuevocolor'){
                            this.$toastr.s("Nuevo Color ingresado con éxito!!");
                            this.colores.push(col);
                            this.dt.columns.adjust().draw();
                        }else{
                            this.$toastr.s("Color Actualizado con éxito!!");
                        }
                        $(".close").click();

                    }).catch(function (error) {
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
                        console.log('Error', error.message);
                        }
                    });
                }
                 
            },
            eliminarcolor(col, index){
                if(confirm("¿Está seguro de eliminar este Color?")){
                    axios.post('/mantenedores/setdatos', {tipo:'eliminarcolor', detalle:col})
                    .then((res) =>{
                        console.log(res.data);
                        if(parseInt(res.data)==0){
                            this.$toastr.s("Color eliminado con éxito!!");
                            this.colores.splice(index,1);
                            this.dt.columns.adjust().draw();
                        }else{
                            this.$toastr.e("Color no puede ser eliminado porque tiene artículos asociados!!");
                        }
                        $(".close").click();

                    }).catch(function (error) {
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
                        console.log('Error', error.message);
                        }
                    });
                }
            },
            cargarcrear(){
                axios.post('/mantenedores/getdatos', {tipo:'colores'})
                    .then((res) =>{
                    console.log(res.data);
                    this.tipocol = 'nuevocolor';
                    this.colorvue= {idcolor:(parseInt(res.data)+1),nombrecol:'', hexcol:''};
                    this.disabled = false;
                    
                }).catch(function (error) {
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
                    console.log('Error', error.message);
                    }
                });
                
            },
            cargareditar(color){
                this.tipocol = 'editarcolor';
                this.colorvue = _.cloneDeep(color);
                this.disabled = true;
            },
        },
    }
</script>
