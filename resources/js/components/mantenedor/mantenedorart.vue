<template>
    <div class="container-fluid">
        <br>
        <div>
            <button class="btn btn-info btn-sm"  data-toggle="modal" data-target="#articulosmodal" @click="cargarcrear()">Agregar Artículos</button>
        </div>
        <div>
            <table id="tabladetalle" class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100">
                <thead>
                    <tr>
                        <th class="all">Código Art</th>
                        <th class="desktop">Categoría</th>
                        <th class="desktop">Sub Cate</th>
                        <th class="all">Nombre Art</th>
                        <th class="desktop">Color</th>
                        <th class="desktop">Talla</th>
                        <th class="desktop">Marca</th>
                        <th class="all">Imagen</th>
                        <th class="none">Per Devo</th>
                        <th class="none">St Crít</th>
                        <th class="none">Ind Rot</th>
                        <th class="all">Funciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item,index) in articulos" :key="index">
                        <td>{{item.codigoart}}</td>
                        <td :title="item.nombrecat">{{item.codigocat}}</td>
                        <td :title="item.nombresubcat">{{item.codigosubcat}}</td>
                        <td>{{item.nombreart}}</td>
                        <td :title="item.nombrecol">{{item.color_id}}</td>
                        <td :title="item.nombretipounimed+' '+item.codigounimed">{{item.codigounimed}}</td>
                        <td>{{item.nombremar}}</td>
                        <td v-if="item.image!=null">
                            <button 
                            class="btn btn-info btn-sm" 
                            @click.capture="imagenart = item.image, imagenactual='imagenvue', articuloimagen=item,imagePreview2 = item.image,showPreview2 = true" 
                            data-toggle="modal" 
                            data-target="#imagemodal">
                                <img style="width:23px;heigth:23px;" src="css/img/verimage.png"/>
                            </button>
                        </td>
                        <td v-else>
                            <button 
                            class="btn btn-info btn-sm" 
                            @click.capture="imagenart = item.image, imagenactual='imagenvue', articuloimagen=item,imagePreview2 = '',showPreview2 = false" 
                            data-toggle="modal" 
                            data-target="#imagemodal" >
                                <img style="width:23px;heigth:23px;" src="css/img/addimage.png"/>
                            </button>
                        </td>
                        <td :title="item.descripcionper">{{item.periododevo}}</td>
                        <td>{{item.stockcriticoart}}</td>
                        <td>{{item.indicerotacionart}}</td>
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
                        <h5 v-if="tipoarticulo=='nuevoarticulo'" class="modal-title" id="exampleModalLabel">Crear nuevo Artículo</h5>
                        <h5 v-if="tipoarticulo=='editararticulo'" class="modal-title" id="exampleModalLabel">Actualizar Artículo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <dir class="row">
                            <div class="col-3">
                                Código (*)<br>
                                <input v-if="tipoarticulo=='nuevoarticulo'" type="text"  class="form-control form-control-sm w-d" name="codigoart" readonly id="codigoart" v-model="codigoartvue">
                                <input v-if="tipoarticulo=='editararticulo'" type="text"  class="form-control form-control-sm w-d" name="codigoart" readonly id="codigoart" v-model="articulovue.codigoart">
                            </div>
                            <div class="col-3">
                                Categoría (*)<br>
                                <select v-model="articulovue.categoria_id" :disabled=disabled class="form-control form-control-sm t-regular w-d text-uppercase">
                                    <option value="">------</option>
                                    <option v-for="(item, index) in datamantenedor[2]" :key="index" :value="item.idcategoria">
                                        {{ item.nombrecat }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-3">
                                SubCategoría (*) <br>
                                <select v-model="articulovue.subcategoria_id" :disabled=disabled class="form-control form-control-sm t-regular w-l">
                                    <option value="">------</option>
                                    <option v-for="(item, index) in filteredsubcat" :key="index" :value="item.idsubcategoria">
                                        {{ item.nombresubcat }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-3" id="lamarca">
                                Marca (*) <br>
                                <vue-bootstrap-typeahead 
                                    v-model="marcaaux"
                                    :inputClass="'upcase form-control form-control-sm'"
                                    :minMatchingChars="3"
                                    ref="marcas"
                                    :data="marcas">
                                </vue-bootstrap-typeahead>
                                <!-- <select v-model="articulovue.marca_id" :disabled=disabled class="form-control form-control-sm t-regular w-d">
                                    <option value="">------</option>
                                    <option v-for="(item, index) in datamantenedor[11]" :key="index" :value="item.idmarca">
                                        {{ item.nombremar }}
                                    </option>
                                </select> -->
                            </div>
                            <div class="col-4">
                                Proveedor (*) <br>
                                <select v-model="articulovue.proveedorart" :disabled=disabled class="form-control form-control-sm t-regular">
                                    <option value="">------</option>
                                    <option v-for="(item, index) in datamantenedor[8]" :key="index" :value="item.rutproveedor">
                                        {{ item.nombreprov }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-5">
                                Nombre (*) <br>
                                <textarea v-model="articulovue.nombreart" maxlength="40" class="form-control form-control-sm text-uppercase" rows="1" id="nombreart"></textarea>
                            </div>
                            <div class="col-3">
                                Color (*) <br>
                                <select v-model="articulovue.color_id" :disabled=disabled class="form-control form-control-sm t-regular w-d text-uppercase">
                                    <option value="">------</option>
                                    <option v-for="(item, index) in datamantenedor[9]" :key="index" :value="item.idcolor">
                                        {{ item.nombrecol }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-3">
                                Talla (*)<br>
                                <select v-model="articulovue.unidad_id" :disabled=disabled class="form-control form-control-sm t-regular w-d">
                                    <option value="">------</option>
                                    <option v-for="(item, index) in datamantenedor[10]" :key="index" :value="item.idunidad">
                                        {{ item.descripcionunimed }}
                                    </option>
                                </select>
                            </div>
                            
                            <div class="col-2">
                                Stock Crítico (*) <br>
                                <input type="text" v-model="articulovue.stockcriticoart" class="form-control form-control-sm w-s" :id="'stockcritico'" name="stockcritico">
                            </div>
                            <div class="col-2">
                                Índice Rotación (*) <br>
                                <input type="text" v-model="articulovue.indicerotacionart" class="form-control form-control-sm w-s" :id="'indicerotacion'" name="indicerotacion">
                            </div>
                            <div class="col-2">
                                Año Ingreso (*) <br>
                                <input type="text" v-model="articulovue.yearart" :disabled=disabled class="form-control form-control-sm w-s" :id="'yearart'" name="yearart">
                            </div>
                            <div class="col-3">
                                Periodo Devolución (*) <br>
                                <select class="form-control form-control-sm t-regular w-d" v-model="articulovue.periododevo_id" >
                                    <option value="">------</option>
                                    <option v-for="(item, index) in datamantenedor[12]" :key="index" :value="item.idperiodo">
                                        {{ item.descripcionper }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-8">
                                Descripción Artículo <br>
                                <textarea v-model="articulovue.descripcionart" maxlength="100" class="form-control form-control-sm text-uppercase" rows="2" id="nombreart"></textarea>
                            </div>
                            <div class="col-4">
                                <button  v-if="articulovue.image =='' || articulovue.image ==null" class="btn btn-info btn-sm" @click="$refs.subirnewimage.click()"><img style="width:23px;heigth:23px;" src="css/img/addimage.png"/></button>
                                <input type="file" accept="image/*" ref="subirnewimage" capture="camera" id="newimage" @change="handleFileUpload()" style="display:none"/>
                                 <img v-bind:src="imagePreview" v-show="showPreview" style="width:100px; height:100px"/>
                            </div>
                        </dir>                        
                    </div>
                    <div class="modal-footer">
                        <p>(*) Datos obligatorios</p>
                        <button type="button" class="btn btn-primary" @click="guardararticulo(articulovue)">
                            Guardar Artículo
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        
                    </div>
                    </div>
                </div>
            </div>
           <!--  <component v-bind:is="imagenactual" :imagen="imagenart" :articulo="articuloimagen" ></component>
           <imagenvue :imagen="imagenart" :articulo="articuloimagen" />!-->
           <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Imagen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <table class="table table-striped table-sm table-bordered table-dark t-regular">
                            <thead>
                                <tr>
                                    <th>Código Artículo</th>
                                    <th>Nombre Artículo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{articuloimagen.codigoart}}</td>
                                    <td>{{articuloimagen.nombreart}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                     <button v-if="articuloimagen.image ==null"  class="btn btn-info btn-sm" @click="$refs.subirnewimageold.click()"><img style="width:23px;heigth:23px;" src="css/img/addimage.png"/></button>
                     <button  v-if="articuloimagen.image !=null" class="btn btn-info btn-sm" @click="eliminarimagen(articuloimagen)"><img style="width:23px;heigth:23px;" src="css/img/delete.png"/></button>
                        <input type="file" accept="image/*" ref="subirnewimageold" capture="camera" id="subirnewimageold" @change="handleFileUpload2()" style="display:none"/> 
                        
                    <div v-if="imagenart!=null">
                        
                        <img v-bind:src="imagePreview2" v-show="showPreview2" class="img-fluid" alt="Responsive image"/>
                    </div>
                    <div v-if="imagenart==null">
                        
                        <img v-bind:src="imagePreview2" v-show="showPreview2" class="img-fluid" alt="Responsive image"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="guardararticulo2()">Subir Imagen</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
        </div>
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
                tipoarticulo:'',
                marcaaux:'',
                marcas:'',
                lamarca:{},
                ultimamarca:'',
                articulovue:
                    {codigoart: '', codigoalternativoart: '', categoria_id: '', subcategoria_id: '', 
                    nombreart: '', proveedorart: '', descripcionart: '', color_id: '', unidad_id: '', 
                    marca_id: '', stockcriticoart: 1, indicerotacionart: 180, yearart: new Date().getFullYear(), 
                    periododevo_id: 1, image: ''},
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
            filteredsubcat: function () {
               if(this.articulovue.categoria_id!=null){
                   let subcat = this.datamantenedor[3];
                   return _.filter(subcat, {'categoria_id':this.articulovue.categoria_id});
               }else{
                   return null;
               }
            },
            codigoartvue: function () {
                
                let codigoart='';
                let codmarca='';
                let codsubcat='';
                let codcorrel='';
                let codtalla='';
                let codcolor='';
                let art = this.articulovue;
                //console.log(art);
                if(this.marcaaux!=''){
                    let lemarc = this.datamantenedor[11].find( items => items.nombremar === this.marcaaux);
                    //console.log(lemarc);
                    //return;
                    if(!_.isUndefined(lemarc)){
                        codmarca=lemarc.idmarca;
                    }else{
                        codmarca =this.newmarca(this.marcaaux.toString().toUpperCase(), 0);
                    }
                }
                /*if(art.marca_id!=''){
                    console.log("marca "+art.marca_id);
                    codmarca=art.marca_id;
                }*/
                if(art.subcategoria_id!=''){
                    let subcat=_.filter(this.datamantenedor[3], {'idsubcategoria':art.subcategoria_id});
                    //console.log(subcat);
                    codsubcat=subcat[0].codigosubcat;
                    let correlativoint=_.filter(this.correlativosvue, {'subcategoria_id':art.subcategoria_id});
                    if(correlativoint.length==0){
                        correlativoint=_.filter(this.correlativos, {'subcategoria_id':art.subcategoria_id});
                        
                    }
                    console.log(correlativoint);
                    if(correlativoint.length==0){
                        codcorrel = '00001';
                    }else{
                        codcorrel = (parseInt(correlativoint[0].correlativo)+1).toString();
                        while(codcorrel.length<5){
                            codcorrel ="0"+codcorrel;
                        }
                    }
                    this.correlativox = codcorrel;
                    //console.log("correlativo "+art.marca_id);
                }
                if(art.color_id!=''){
                    codcolor=art.color_id;
                }
                if(art.unidad_id!=''){
                    codtalla=art.unidad_id;
                }
                codigoart = codmarca+codsubcat+codcorrel+codcolor+codtalla;
                return codigoart;
            }
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
            handleFileUpload2(){
                this.file = this.$refs.subirnewimageold.files[0];
                let reader  = new FileReader();
                this.articuloimagen.image = this.file.name;
                reader.addEventListener("load", function () {
                    this.showPreview2 = true;
                    this.imagePreview2 = reader.result;
                }.bind(this), false);
                if( this.file ){
                    if ( /\.(jpe?g|png|gif)$/i.test( this.file.name ) ) {
                        reader.readAsDataURL( this.file );
                    }
                }
            },
            newmarca(marca, carga){
                let marquita=_.filter(this.datamantenedor[11], {'nombremar':marca});
                let marc ='';
                if(marquita.length>0){
                    this.lamarca ={};
                    return marquita[0].idmarca;
                }else{
                    let ultima = this.datamantenedor[11][this.ultimamarca];
                    let number = ultima.idmarca.toString().substring(1,3);
                    let letra = ultima.idmarca.toString().substring(0,1);
                    if(parseInt(number) == '99'){
                        number = '01';
                        const index = this.letras.findIndex(letrax => letrax === letra);
                        marc = this.letras[index+1].toString()+number;
                    }else{
                        number = parseInt(number)+1;
                        if(number<10){
                            number ='0'+number.toString();
                        }
                        marc = letra+number.toString();
                    }
                    this.lamarca ={idmarca: marca, nombremar: marc};
                    return marc;
                    //console.log(number);
                }
            },
            eliminarimagen(doc){
                doc.image=null;
                this.showPreview2 = false;
                this.imagePreview2 = '';
                this.$refs.subirnewimageold.value=null;
            },
            guardararticulo2(){
                let file = this.$refs.subirnewimageold.files[0];
                if(typeof file !=='undefined' && file !=null ){
                    console.log("entro a guardar imagen");
                    let formData = new FormData();
                    formData.append('image',file);
                    formData.append('nombre',this.articuloimagen.codigoart);
                    formData.append('tipo','actualizarprod');
                    axios.post('/sistema/uploadimage', formData, {
                        headers: {
                        'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        console.log(response.data.message, 'success');
                        axios.post('/mantenedores/getdatos', {tipo:'articulos'}).then((res) =>{
                            this.articulos = res.data[0];
                            this.correlativos= res.data[1];
                            this.showPreview2 = false;
                            this.$refs.subirnewimageold.value='';
                            this.imagePreview2 = '';
                            //this.cargando=false;
                            console.log(this.correlativos);
                            this.$nextTick(function () {
                                this.dt.destroy();
                                this.dt =null;
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
                        $(".close").click();
                    })
                    .catch(function (error) {
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
            handleFileUpload(){
                this.file = this.$refs.subirnewimage.files[0];
                let reader  = new FileReader();
                reader.addEventListener("load", function () {
                    this.showPreview = true;
                    this.imagePreview = reader.result;
                }.bind(this), false);
                if( this.file ){
                    if ( /\.(jpe?g|png|gif)$/i.test( this.file.name ) ) {
                        reader.readAsDataURL( this.file );
                    }
                }
            },
            guardararticulo(art){
                if(this.tipoarticulo == 'nuevoarticulo'){
                    art.codigoart = this.codigoartvue;
                    art.marca_id = this.datamantenedor[11].find( items => items.nombremar === this.marcaaux).idmarca;
                }
                if(art.codigoart.length<15 || art.proveedorart=='' || art.nombreart=='' || art.descripcionart =='' || art.stockcriticoart=='' || art.indicerotacionart=='' || art.yearart=='' || art.periododevo_id==''){
                    this.$toastr.w("Favor de ingresar datos obligatorios!!");
                    return;
                }
                 axios.post('/mantenedores/setdatos', {tipo:this.tipoarticulo,detalle: art, correlativo: this.correlativox})
                    .then((res) =>{
                        console.log(res.data);
                        if(res.data==''){
                            let file = this.$refs.subirnewimage.files[0];
                            if(typeof file !=='undefined' && file !=null ){
                                console.log("entro a guardar imagen");
                                let formData = new FormData();
                                formData.append('image',file);
                                formData.append('nombre',art.codigoart);
                                formData.append('tipo','actualizarprod');
                                axios.post('/sistema/uploadimage', formData, {
                                    headers: {
                                    'Content-Type': 'multipart/form-data'
                                    }
                                })
                                .then(response => {
                                    console.log(response.data.message, 'success');
                                })
                                .catch(function (error) {
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
                            this.$toastr.s("Artículo "+art.codigoart+" creado con éxito");
                            this.articulovue= {codigoart: '', codigoalternativoart: '', categoria_id: '', subcategoria_id: '', 
                            nombreart: '', proveedorart: '', descripcionart: '', color_id: '', unidad_id: '', 
                            marca_id: '', stockcriticoart: 1, indicerotacionart: 180, yearart: new Date().getFullYear(), 
                            periododevo_id: 1, image: ''};
                            this.$refs.subirnewimage.value="";
                            axios.post('/mantenedores/getdatos', {tipo:'articulos'}).then((res) =>{
                                this.articulos = res.data[0];
                                this.correlativos= res.data[1];
                                //this.cargando=false;
                                console.log(this.correlativos);
                                this.$nextTick(function () {
                                    this.dt.destroy();
                                    this.dt =null;
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
                            $(".close").click();
                        }
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
            cargarcrear(){
                this.tipoarticulo = 'nuevoarticulo';
                this.articulovue= {codigoart: '', codigoalternativoart: '', categoria_id: '', subcategoria_id: '', 
                            nombreart: '', proveedorart: '', descripcionart: '', color_id: '', unidad_id: '', 
                            marca_id: '', stockcriticoart: 1, indicerotacionart: 180, yearart: new Date().getFullYear(), 
                            periododevo_id: 1, image: ''};
                this.disabled = false;
                
                this.marcaaux ='';
                $("#lamarca input").val('');
                $("#lamarca input").removeAttr("readonly");
            },
            cargareditar(arti){
                this.tipoarticulo = 'editararticulo';
                this.articulovue = _.cloneDeep(arti);
                this.marcaaux = this.datamantenedor[11].find( items => items.idmarca === this.articulovue.marca_id).nombremar;
                $("#lamarca input").val(this.marcaaux);
                $("#lamarca input").attr("readonly", "true");
                this.disabled = true;
            },
        },
    }
</script>
