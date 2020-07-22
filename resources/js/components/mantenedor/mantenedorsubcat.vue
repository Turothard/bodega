<template>
    <div class="container-fluid">
        <br>
        <div>
            <button class="btn btn-info btn-sm"  data-toggle="modal" data-target="#articulosmodal" @click="cargarcrear()">Agregar SubCategoría</button>
        </div>
        <div>
            <table id="tabladetalle" class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100">
                <thead>
                    <tr>
                        <th class="all">Código Categoría asociada</th>
                        <th class="desktop">Código SubCategoría</th>
                        <th class="desktop">Nombre SubCategoría</th>
                        <th class="desktop">Descripción SubCategoría</th>
                        <th class="all">Funciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item,index) in datamantenedor[3]" :key="index">
                        <td>{{ datamantenedor[2].find( items => items.idcategoria === item.categoria_id ).nombrecat}}</td>
                        <td>{{item.codigosubcat}}</td>
                        <td>{{item.nombresubcat}}</td>
                        <td>{{item.descripcionsubcat}}</td>
                        <td>
                            <button 
                            class="btn btn-info btn-sm" 
                            @click="cargareditar(item)" 
                            data-toggle="modal" 
                            data-target="#articulosmodal">
                                <img style="width:23px;heigth:23px;" src="css/img/editar.png"/>
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <img style="width:23px;heigth:23px;" src="css/img/delete.png"/>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="articulosmodal" tabindex="-1" role="dialog" aria-labelledby="articulomodallabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="tipocat=='nuevacategoria'" class="modal-title" id="exampleModalLabel">Crear nueva SubCategoría</h5>
                        <h5 v-if="tipocat=='editarcategoria'" class="modal-title" id="exampleModalLabel">Actualizar SubCategoría</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="tabladetalle" class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100">
                            <thead>
                                <tr>
                                    <th class="all">Código Categoría asociada (*)</th>
                                    <th class="desktop">Código SubCategoría (*)</th>
                                    <th class="desktop">Nombre SubCategoría (*)</th>
                                    <th class="desktop">Descripción SubCategoría</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select v-model="subcategoriavue.categoria_id" :disabled=disabled class="form-control form-control-sm t-regular w-d text-uppercase">
                                            <option value="">------</option>
                                            <option v-for="(item, index) in datamantenedor[2]" :key="index" :value="item.idcategoria">
                                                {{ item.nombrecat }}
                                            </option>
                                        </select>
                                    </td>
                                    <td ><input type="text" v-model="subcategoriavue.codigosubcat" :disabled=disabled maxlength="3" class="form-control form-control-sm w-s t-regular" :id="'codigocat'" name="codigocat"></td>
                                    <td ><input type="text" v-model="subcategoriavue.nombresubcat" maxlength="3" class="form-control form-control-sm t-regular" :id="'nombrecat'" name="nombrecat"></td>
                                    <td ><input type="text" v-model="subcategoriavue.descripcionsubcat" maxlength="3" class="form-control form-control-sm t-regular" :id="'descripcioncat'" name="descripcioncat"></td>
                                    
                                </tr>
                            </tbody>
                        </table>          
                    </div>
                    <div class="modal-footer">
                        <p>(*) Datos obligatorios</p>
                        <button type="button" class="btn btn-primary" @click="guardararticulo(categoriavue)">
                            Guardar SubCategoría
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
                articulos: [],
                correlativos: [],
                correlativosvue: [],
                correlativox:'',
                tipocat:'',
                marcaaux:'',
                marcas:'',
                lamarca:{},
                ultimamarca:'',
                subcategoriavue: {idsubcategoria:'', categoria_id:'',codigosubcat:'', nombresubcat:'', descripcionsubcat:''},
                letras: ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'] ,
                articuloimagen:'',
                imagenart:'',
                imagenactual:'',
                dt:null,
                file: '',
                showPreview: false,
                imagePreview: '',
                showPreview2 : false,
                imagePreview2 : ''

            }
        },
        created() {
            console.log('Component created.');
            this.ultimamarca = _.findLastKey(this.datamantenedor[11]);
            var nom = _.mapValues(this.datamantenedor[11], function(o) { return o.nombremar; });
            this.marcas =Object.values(nom);
            axios.post('/mantenedores/getdatos', {tipo:'articulos'}).then((res) =>{
                this.articulos = res.data[0];
                this.correlativos= res.data[1];
                //this.cargando=false;
                console.log(this.correlativos);
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
        computed: {
        // a computed getter
        },
        mounted() {
            //alert(" es"+(this.isMobileTablet()).toString());
        },
        methods: {
            isMobileTablet(){
                var check = false;
                (function(a){
                    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) 
                        check = true;
                })(navigator.userAgent||navigator.vendor||window.opera);
                return check;
            },
            guardarcategoria(art){
                if(this.tipocat == 'nuevacategoria'){
                    art.codigoart = this.codigoartvue;
                    art.marca_id = this.datamantenedor[11].find( items => items.nombremar === this.marcaaux).idmarca;
                }
                if(art.codigoart.length<15 || art.proveedorart=='' || art.nombreart=='' || art.descripcionart =='' || art.stockcriticoart=='' || art.indicerotacionart=='' || art.yearart=='' || art.periododevo_id==''){
                    this.$toastr.w("Favor de ingresar datos obligatorios!!");
                    return;
                }
                 
            },
            cargarcrear(){
                this.tipocat = 'nuevacategoria';
                this.subcategoriavue= {idsubcategoria:'', categoria_id:'',codigosubcat:'', nombresubcat:'', descripcionsubcat:''};
                this.disabled = false;
            },
            cargareditar(cate){
                this.tipocat = 'editarcategoria';
                this.subcategoriavue = _.cloneDeep(cate);
                this.disabled = true;
            },
        },
    }
</script>
