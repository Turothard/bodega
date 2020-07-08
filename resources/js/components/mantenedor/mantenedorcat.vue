<template>
    <div class="container-fluid">
        <br>
        <div>
            <button class="btn btn-info btn-sm"  data-toggle="modal" data-target="#categoriasmodal" @click="cargarcrear()">Agregar Categoría</button>
        </div>
        <div>
            <table id="tabladetalle" class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100">
                <thead>
                    <tr>
                        <th class="all">Código Categoría</th>
                        <th class="desktop">Nombre Categoría</th>
                        <th class="desktop">Descripción Categoría</th>
                        <th class="all">Funciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item,index) in categorias" :key="index">
                        <td>{{item.codigocat}}</td>
                        <td>{{item.nombrecat}}</td>
                        <td>{{item.descripcioncat}}</td>
                        <td>
                            <button 
                            class="btn btn-info btn-sm" 
                            @click="cargareditar(item)" 
                            data-toggle="modal" 
                            data-target="#categoriasmodal">
                                <img style="width:23px;heigth:23px;" src="css/img/editar.png"/>
                            </button>
                            <button @click="eliminar(item, index)"  class="btn btn-danger btn-sm">
                                <img style="width:23px;heigth:23px;" src="css/img/delete.png"/>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="categoriasmodal" tabindex="-1" role="dialog" aria-labelledby="categoriamodallabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="tipocat=='nuevacategoria'" class="modal-title" id="exampleModalLabel">Crear nueva Categoría</h5>
                        <h5 v-if="tipocat=='editarcategoria'" class="modal-title" id="exampleModalLabel">Actualizar Categoría</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="tabladetalle" class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100">
                            <thead>
                                <tr>
                                    <th class="all">Código Categoría</th>
                                    <th class="desktop">Nombre Categoría</th>
                                    <th class="desktop">Descripción Categoría</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td ><input type="text" v-model="categoriavue.codigocat" maxlength="2" :disabled="disabled" class="form-control form-control-sm w-s t-regular" :id="'codigocat'" name="codigocat"></td>
                                    <td ><input type="text" v-model="categoriavue.nombrecat" maxlength="20" class="form-control form-control-sm w-d t-regular" :id="'nombrecat'" name="nombrecat"></td>
                                    <td ><input type="text" v-model="categoriavue.descripcioncat" maxlength="100" class="form-control form-control-sm t-regular" :id="'descripcioncat'" name="descripcioncat"></td>
                                    
                                </tr>
                            </tbody>
                        </table>          
                    </div>
                    <div class="modal-footer">
                        <p>(*) Datos obligatorios</p>
                        <button type="button" class="btn btn-primary" @click="guardarcategoria(categoriavue)">
                            Guardar Categoría
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        
                    </div>
                    </div>
                </div>
            </div>
           <!--  <component v-bind:is="imagenactual" :imagen="imagenart" :categoria="categoriaimagen" ></component>
           <imagenvue :imagen="imagenart" :categoria="categoriaimagen" />!-->
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
                categorias: [],
                correlativos: [],
                correlativosvue: [],
                correlativox:'',
                tipocat:'',
                categoriavue: {idcategoria:'',codigocat:'', nombrecat:'', descripcioncat:''},
                dt:null,
            }
        },
        created() {
            this.categorias= this.datamantenedor[2];
            console.log('Component created.');
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
           
        },
        computed: {
        // a computed getter
        },
        mounted() {
            //alert(" es"+(this.isMobileTablet()).toString());
        },
        methods: {

            guardarcategoria(cat){
                let mensaje;
                if(cat.codigocat=='' || cat.nombrecat=='' || cat.descripcioncat ==''){
                    this.$toastr.w("Favor de ingresar datos obligatorios!!");
                    return;
                }
                if(this.tipocat == 'nuevacategoria'){
                    mensaje="¿Está seguro de guardar esta nueva Categoría?";
                }else{
                    mensaje="¿Está seguro de modificar esta Categoría?";
                }
                if(confirm(mensaje)){
                    axios.post('/mantenedores/setdatos', {tipo:this.tipocat, detalle:cat})
                    .then((res) =>{
                        console.log(res.data);
                        if(this.tipocat == 'nuevacategoria'){
                            switch (parseInt(res.data)) {
                                case 0:
                                    this.$toastr.s("Nueva Categoría ingresada con éxito!!");
                                    this.categoria.push(cat);
                                    this.dt.destroy();
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
                                    this.dt.columns.adjust().draw();
                                    break;
                                case 1:
                                    this.$toastr.w("Código de Categoría ya existe, favor revisar!!");
                                    return;
                                    break;
                                case 2:
                                    this.$toastr.w("Nombre de Categoría ya existe, favor revisar!!");
                                    break;
                                default:
                                    break;
                            }
                            
                        }else{
                            this.$toastr.s("Categoría actualizada con éxito!!");
                            switch (parseInt(res.data)) {
                                case 0:
                                    this.$toastr.s("Categoría actualizada con éxito!!");

                                case 1:
                                    this.$toastr.w("Nombre de Categoría ya existe, favor revisar!!");
                                    return;
                                    break;

                                default:
                                    break;
                            }
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
            eliminar(item, index){
                if(confirm("¿Está seguro de eliminar este Categoría?")){
                    axios.post('/mantenedores/setdatos', {tipo:'eliminarcategoria', detalle:item})
                    .then((res) =>{
                        console.log(res.data);
                        if(parseInt(res.data)==0){
                            this.$toastr.s("Categoría eliminada con éxito!!");
                            this.categorias.splice(index,1);
                            this.dt.columns.adjust().draw();
                        }else{
                            this.$toastr.e("Categoría no puede ser eliminada porque tiene artículos o subcategorías asociados!!");
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
                this.tipocat = 'nuevacategoria';
                this.categoriavue= {idcategoria:'',codigocat:'', nombrecat:'', descripcioncat:''};
                this.disabled = false;
            },
            cargareditar(cate){
                this.tipocat = 'editarcategoria';
                this.categoriavue = _.cloneDeep(cate);
                this.disabled = true;
            },
        },
    }
</script>
