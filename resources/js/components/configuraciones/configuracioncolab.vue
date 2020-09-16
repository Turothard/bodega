<template>
    <div class="container-fluid">
        <br>
        <div>
            <button class="btn btn-info btn-sm"  data-toggle="modal" data-target="#configuracioncolabmodal" @click="cargarcrear()">Agregar colaborador</button>
        </div>
        <br>
        <div>
            <table id="tablacolaboradores" class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100">
                <thead>
                    <tr>
                        <th class="all">Rut</th>
                        <th class="all">Nombre</th>
                        <th class="all">Apellido</th>
                        <th class="desktop">Nombre Corto</th>
                        <th class="desktop">Departamento</th>
                        <th class="desktop">Sector</th>
                        <th class="desktop">Cargo</th>
                        <th class="all">Fecha Ingreso</th>
                        <th class="all">Fecha Salida</th>
                        <th class="all">Activo</th>
                        <th class="all">Funciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item,index) in dataconfiguracion[1]" :key="index">
                        <td>{{item.rutcolaborador}}</td>
                        <td>{{item.nombrescolab}}</td>
                        <td>{{item.apellidoscolab}}</td>
                        <td>{{item.nombrecortocolab}}</td>
                        <td>{{item.deptocolab}}</td>
                        <td>{{item.sectorcolab}}</td>
                        <td>{{item.cargocolab}}</td>
                        <td>{{item.fechaingresocolab}}</td>
                        <td>{{item.fechasalidacolab}}</td>
                        <td v-if="item.estadocolab">Activo</td>
                        <td v-else>Inactivo</td>
                        <td>
                            <button 
                            class="btn btn-info btn-sm" 
                            @click="cargareditar(item)" 
                            data-toggle="modal" 
                            data-target="#configuracioncolabmodal">
                                <img style="width:23px;heigth:23px;" src="css/img/editar.png"/>
                            </button>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="configuracioncolabmodal" tabindex="-1" role="dialog" aria-labelledby="configuracioncolabmodal" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="tipocol=='nuevocolaborador'" class="modal-title" id="exampleModalLabel">Crear nuevo colaborador</h5>
                        <h5 v-if="tipocol=='editarcolaborador'" class="modal-title" id="exampleModalLabel">Actualizar colaborador</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-2">
                                Rut (*) <br>
                                <input type="text" v-model="colaboradorvue.rutcolaborador" :disabled=disabled class="form-control form-control-sm w-s t-regular" :id="'rutcolaborador'" name="rutcolaborador">
                            </div>
                            <div class="col-3">
                                Nombre (*) <br>
                                <input type="text" v-model="colaboradorvue.nombrescolab" class="form-control form-control-sm t-regular" :id="'nombrescolab'" name="nombrescolab">
                            </div>
                            <div class="col-3">
                                Apellido (*) <br>
                                <input type="text" v-model="colaboradorvue.apellidoscolab" class="form-control form-control-sm t-regular" :id="'apellidoscolab'" name="apellidoscolab">
                            </div>
                            <div class="col-4">
                                Nombre Corto (*)<br>
                                <input type="text" v-model="colaboradorvue.nombrecortocolab" class="form-control form-control-sm t-regular" :id="'nombrecortocolab'" name="nombrecortocolab">
                            </div>
                            <div class="col-3">
                                Departamento (*) <br>
                                <select name="deptocolab" class="form-control form-control-sm t-regular" id="deptocolab" v-model="colaboradorvue.deptocolab">
                                    <option value="">-----</option>
                                    <option value="TRABAJADORES">TRABAJADORES</option>
                                    <option value="SUPERVISION">SUPERVISIÓN</option>
                                    <option value="CAPATAZ">CAPATAZ</option>
                                    <option value="BODEGA">BODEGA</option>
                                    <option value="ADMINISTRACION">ADMINISTRACIÓN</option>
                                </select>
                            </div>
                            <div class="col-3">
                                Sector (*) <br>
                                <select name="sectorcolab" class="form-control form-control-sm t-regular" id="sectorcolab" v-model="colaboradorvue.sectorcolab">
                                    <option value="">------</option>
                                    <option value="RDA">RDA</option>
                                    <option value="ZAO">ZAO</option>
                                    <option value="ADM">ADM</option>
                                </select>
                            </div>
                            <div class="col-5">
                                Cargo (*) <br>
                                <input type="text" v-model="colaboradorvue.cargocolab"  class="form-control form-control-sm t-regular" :id="'cargocolab'" name="cargocolab">
                            </div>
                            <div class="col-3">
                                Fecha Ingreso (*) <br>
                                <input type="date" v-model="colaboradorvue.fechaingresocolab" class="form-control form-control-sm t-regular" :id="'girocol'" name="girocol">
                            </div>
                            <div class="col-3">
                                Fecha Salida <br>
                                <input type="date" v-model="colaboradorvue.fechasalidacolab" class="form-control form-control-sm t-regular" :id="'girocol'" name="girocol">
                            </div>
                            <div class="col-3">
                                Activo<br>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="presshowflag" name="example1" v-model="colaboradorvue.estadocolab">
                                    <label class="custom-control-label" for="presshowflag"></label>
                                </div>
                            </div>
                        </div>          
                    </div>
                    <div class="modal-footer">
                        <p>(*) Datos obligatorios</p>
                        <button type="button" class="btn btn-primary" @click="guardarcolaborador(colaboradorvue)">
                            Guardar colaborador
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
        props: ['dataconfiguracion'],
        data(){
            return{
                preestablecidovue:null,
                cargando:true,
                disabled:false,
                tipocol:'',
                colaboradorvue: {rutcolaborador:'',nombrescolab:'', apellidoscolab:'', nombrecortocolab:'', deptocolab:''
                , sectorcolab:'', cargocolab:'', fechaingresocolab:'', fechasalidacolab:'',estadocolab:true},
                dt:null,

            }
        },
        created() {
            console.log('Component created.');
            this.$nextTick(function () {
                /*this.dt.destroy();
                this.dt =null;*/
                this.dt = $('#tablacolaboradores').DataTable({
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
            isMobileTablet(){
                var check = false;
                (function(a){
                    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) 
                        check = true;
                })(navigator.userAgent||navigator.vendor||window.opera);
                return check;
            },
            cargarcrear(){
                this.tipocol = 'nuevocolaborador';
                this.colaboradorvue= {rutcolaborador:'',nombrescolab:'', apellidoscolab:'', nombrecortocolab:'', deptocolab:''
                , sectorcolab:'', cargocolab:'', fechaingresocolab:'', fechasalidacolab:'',estadocolab:true};
                this.disabled = false;
            },
            cargareditar(col){
                this.tipocol = 'editarcolaborador';
                this.colaboradorvue = _.cloneDeep(col);
                this.disabled = true;
            },
            guardarcolaborador(col){
                //console.log(Fn.validaRut(col.rutcolaborador));
                if(!Fn.validaRut(col.rutcolaborador)){
                    this.$toastr.w("Rut invalido, favor revisar");
                    return;
                }
                if(col.rutcolaborador=='' || col.nombrescolab=='' || col.apellidoscolab=='' || col.nombrecortocolab=='' || col.deptocolab=='' || sectorcolab=='' || col.cargocolab=='' || col.fechaingresocolab==''){
                    this.$toastr.w("Faltan datos obligatorios por ingresar");
                    return;
                }
                
                console.log(col);
                if(confirm("¿Está seguro de ingresar este nuevo colaborador?")){
                    axios.post('/configuraciones/setdatos', {tipo:this.tipocol,detalle:col})
                        .then((res) =>{
                        let resp = res.data;
                        console.log(res.data);
                        if(parseInt(resp)==1){
                            this.$toastr.w("Rut ingresado ya esta asociado a un colaborador, favor revisar");
                            return;
                        }
                        if(parseInt(resp)==2){
                            this.$toastr.w("Nombre Corto ingresado ya esta asociado a un colaborador, favor revisar");
                            return;
                        }
                        if(parseInt(resp)==0){
                            if(this.tipocol=='nuevocolaborador'){
                                this.$toastr.s("Colaborador ingresado con éxito");
                            
                            }else{
                                this.$toastr.s("Colaborador actualizado con éxito");
                            
                            }
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        
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
                }
            }
        },
    }
    var Fn = {
	// Valida el rut con su cadena completa "XXXXXXXX-X"
	validaRut : function (rutCompleto) {
		if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test( rutCompleto ))
			return false;
		var tmp 	= rutCompleto.split('-');
		var digv	= tmp[1]; 
		var rut 	= tmp[0];
		if ( digv == 'K' ) digv = 'k' ;
		return (Fn.dv(rut) == digv );
	},
	dv : function(T){
		var M=0,S=1;
		for(;T;T=Math.floor(T/10))
			S=(S+T%10*(9-M++%6))%11;
		return S?S-1:'k';
	}
}
</script>
