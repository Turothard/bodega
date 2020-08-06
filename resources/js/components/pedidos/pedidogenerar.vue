<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-3 col-sm-12">
                <div class="row justify-content-center">
                    <div class="col-md-4">Id:</div>
                    <div class="col-md-8">
                        <input type="number" min="0" v-model="pedido.id" readonly class="form-control form-control-sm">
                    </div>
                    <div class="col-md-4">Sector:</div>
                    <div class="col-md-8">
                        <select class="form-control form-control-sm t-regular" v-model="pedido.sector" required>
                            <option value="">------</option>
                            <option v-for="(item, index) in datapedido[5]" :key="index" :value="item.idsector">
                                {{ item.nombresec }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4">Área:</div>
                    <div class="col-md-8">
                        <select class="form-control form-control-sm t-regular" v-model="pedido.area" required>
                            <option value="">------</option>
                            <option v-for="(item, index) in filteredareas" :key="index" :value="item.idarea">
                                {{ item.nombrearea }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4">Ubicación:</div>
                    <div class="col-md-8">
                        <select class="form-control form-control-sm t-regular" v-model="pedido.ubicacion" required>
                            <option value="">------</option>
                            <option v-for="(item, index) in filteredubicaciones" :key="index" :value="item.idubicacion">
                                {{ item.nombreubi }}
                            </option>
                        </select>
                    </div>
                    
                    <div class="col-md-4">Cantidad:</div>
                    <div class="col-md-8">
                        <input type="number" min="0" v-model="pedido.cantidad" readonly class="form-control form-control-sm">
                    </div>
                </div>
                <div class="row align-items-start">
                    <div class="col-md-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="presshowflag" name="example1" @click="presshowflag= !presshowflag">
                            <label class="custom-control-label" for="presshowflag">Cargar Pre</label>
                        </div>
                    </div>
                    <div v-show="presshowflag" class="col-md-8">
                        <select v-if="datapedido[10]!=null" class="form-control form-control-sm t-regular" v-model="pedido.preestablecido" required>
                            <option value="">------</option>
                            <option  v-for="(item, index) in datapedido[10]" :key="index" :value="item.id">
                                {{ item.nombretipoped }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row align-items-start">
                    <div class="col-md-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" v-model="preestablecidovue" id="pressaveflag" @click="pressaveflag= !pressaveflag" name="example1">
                            <label class="custom-control-label" for="pressaveflag">Guardar Pre</label>
                        </div>
                    </div>
                    <div v-show="pressaveflag" class="col-md-8">
                        <input type="text" v-model="pedido.preestablecido" class="form-control form-control-sm">
                    </div>
                    </div>
                
            </div>
            <div class="col-lg-8 col-md-9 col-sm-12">
               <div class="row">
                   <div class="col-md-6">
                       Artículo:
                       <vue-bootstrap-typeahead 
                            v-model="newarticulo.codigo"
                            :inputClass="'upcase form-control form-control-sm'"
                            :minMatchingChars="3"
                            ref="articulos"
                            :data="codigos">
                        </vue-bootstrap-typeahead>
                       
                   </div>
                   <div class="col-md-3">
                       Cantidad
                       <input type="number" min="0" v-model="newarticulo.cantidad" class="form-control form-control-sm">
                   </div>
                   <div class="col-md-3">
                       <button class="btn btn-primary" @click="agregararticulo(newarticulo)">Agregar</button>
                   </div>
                   <div class="col-md-12">
                       <br>
                       <table class="table table-striped table-dark table-sm t-regular">
                           <thead>
                               <tr>
                                   <th scope="col" >Artículo</th>
                                   <th scope="col" >Descripción</th>
                                   <th scope="col" >Cantidad</th>
                                   <th scope="col" >Funciones</th>
                               </tr>
                           </thead>
                           <tbody>
                               <tr v-for="(item,index) in detallepedido" :key="index">
                                    <td data-label="Codigo">{{ item.codigoart }}</td>
                                    <td data-label="Tipo Pedido">{{ item.nombreart }}</td>
                                    <td data-label="Codigo">{{ item.cantidad }}</td>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" v-model="item.tipo" class="custom-control-input" :id="'tipo'+-index" name="example1">
                                            <label class="custom-control-label" :for="'tipo'+-index"></label>
                                            
                                           <button @click="eliminarcantart(item,index)" class="btn btn-warning btn-sm">
                                                <img style="width:23px;heigth:23px;" src="css/img/remover.png" />
                                            </button>
                                            <button @click="agregarcantart(item,index)" class="btn btn-success btn-sm">
                                                <img style="width:23px;heigth:23px;" src="css/img/agregar.png" />
                                            </button>
                                            <button @click="eliminarart(item,index)" class="btn btn-danger btn-sm">
                                                <img style="width:23px;heigth:23px;" src="css/img/delete.png" />
                                            </button>
                                        </div>
                                        
                                    </td>
                               </tr>
                           </tbody>
                       </table>
                   </div>
               </div> 
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['datapedido','infopedido','pedido','detallepedido'],
         data(){
            return{
                preestablecidovue:null,
                newarticulo:{codigo:'', cantidad:null},
                codigos:null,
                usuarios: [],
                colaboradores: [],
                areas: [],
                ubicaciones: [],
                sectores: [],
                articulos: [],
                pressaveflag:false,
                presshowflag:false
            }
         },
        
        computed: {
        // a computed getter
            filteredareas: function () {
               if(this.pedido.sector!=null){
                   let areas = this.datapedido[6];
                   return _.filter(areas, {'sector_id':this.pedido.sector});
               }else{
                   return null
               }
            },
            filteredubicaciones: function () {
               if(this.pedido.area!=null){
                   let areas = this.datapedido[7];
                   return _.filter(areas, {'area_id':this.pedido.area});
               }else{
                   return null
               }
            }
        },
        created() {
            this.articulos = this.datapedido[4];
            //this.pedido.id= this.datapedido[9];
            var cod =_.mapValues(this.datapedido[13], function(o) { return o.codigoart; });
            var nom = _.mapValues(this.datapedido[13], function(o) { return o.nombreart; });
            this.codigos =Object.values(cod).concat(Object.values(nom));
            console.log('lele',this.articulos);
            this.$toastr.defaultPosition = "toast-top-left";
        }
        ,methods: {
            agregararticulo(newart){
                if(newart.codigo=='' || newart.cantidad==0){
                    this.$toastr.w("Código y cantidad son obligatorios");
                    return;
                }
                let art =this.articulos.find( items => items.codigoart === newart.codigo );
                if(art==null){
                    art =this.articulos.find( items => items.nombreart === newart.codigo );
                }
                newart.codigo= art.codigoart;
                if(art==null){
                    this.$toastr.w("Artículo no encontrado, favor revisar");
                    return;
                }
                let detped=null;
                if(this.detallepedido.length>0){
                    detped=this.detallepedido.find( items => items.codigoart === newart.codigo );
                }
                let cantidadx = newart.cantidad;
                let cantidad = newart.cantidad;
                if(detped!=null){
                    cantidad =parseInt(cantidad)+parseInt(detped.cantidad);
                }
                
                //return;
                axios.post('/pedidos/getdatos', {tipo:'stockarticulo',codigo:newart.codigo, cantidad:cantidad})
                    .then((res) =>{
                    let resp = res.data;
                    if(resp[0]==1){
                        if(detped!=null){
                            this.pedido.cantidad = parseInt(this.pedido.cantidad)+parseInt(cantidadx);
                            detped.cantidad = cantidad;
                            
                        }else{
                            this.detallepedido.push({codigoart:art.codigoart, nombreart:art.nombreart,cantidad:cantidad, tipo:false});
                            this.pedido.cantidad = parseInt(this.pedido.cantidad)+parseInt(cantidad);
                        }
                        
                        this.newarticulo={codigo:'', cantidad:null};
                        sessionStorage.setItem("pedido",JSON.stringify(this.pedido));
                        sessionStorage.setItem("detallepedido",JSON.stringify(this.detallepedido));
                    }else{
                        if(detped!=null){
                            this.$toastr.w("Artículo ya se encuentra en pedido, pero la cantidad total supera al stock actual<br>Stock Actual: "+resp[1]+"<br>Solicitado: "+cantidad+"");
                        }else{
                            this.$toastr.w("La cantidad solicitada supera al stock<br>Stock Actual: "+resp[1]+"<br>Solicitado: "+cantidad+"");
                        }
                    }
                    this.$refs.articulos.inputValue = '';
                }).catch(function (error) {
                    if (error.response) {
                    // Request made and server responde
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
                //
            },
            eliminarcantart(art, index){
                console.log("--cantidad");
                art.cantidad--;
                this.pedido.cantidad--;
                sessionStorage.setItem("pedido",JSON.stringify(this.pedido));
                        sessionStorage.setItem("detallepedido",JSON.stringify(this.detallepedido));
            },
            eliminarart(art, index){
                if(confirm("¿Está seguro de eliminar este árticulo del pedido?")){
                    this.pedido.cantidad = parseInt(this.pedido.cantidad)- parseInt(art.cantidad);
                    this.detallepedido.splice(index,1);
                    sessionStorage.setItem("pedido",JSON.stringify(this.pedido));
                    sessionStorage.setItem("detallepedido",JSON.stringify(this.detallepedido));
                }
            },
            agregarcantart(art, index){
                console.log("++cantidad");
                axios.post('/pedidos/getdatos', {tipo:'stockarticulo',codigo:art.codigoart, cantidad:(parseInt(art.cantidad)+1)})
                    .then((res) =>{
                    let resp = res.data;
                    console.log(resp);
                    if(resp[0]==1){
                        this.detallepedido[index].cantidad++;
                        this.pedido.cantidad++;
                        sessionStorage.setItem("pedido",JSON.stringify(this.pedido));
                        sessionStorage.setItem("detallepedido",JSON.stringify(this.detallepedido));
                    }else{
                        
                        this.$toastr.w("La cantidad solicitada supera al stock<br>Stock Actual: "+resp[1]+"<br>Solicitado: "+(parseInt(art.cantidad)+1)+"");
                        
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
        },
    }
</script>
