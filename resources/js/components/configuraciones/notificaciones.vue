<template>
    <div class="container">
       <div class="modal fade" id="notificacionesmodal" tabindex="-1" role="dialog" aria-labelledby="NofificacionesmodalTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Notificaciones</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     <table class="table table-striped table-dark table-sm t-regular">
                           <thead>
                               <tr>
                                   <th scope="col" >Tipo</th>
                                   <th scope="col" >Usuario</th>
                                   <th scope="col" >Mansaje</th>
                                   <th scope="col" >Funciones</th>
                               </tr>
                           </thead>
                           <tbody>
                               <tr v-for="(item,index) in notificaciones" :key="index">
                                    <td data-label="Codigo">{{ item.tipo }}</td>
                                    <td data-label="Tipo Pedido">{{ usuarios.find( items => items.id === item.userproceso_id ).name }}</td>
                                    <td data-label="Codigo" v-html="item.mensaje"></td>
                                    <td>
                                        <button class="btn btn-secondary btn-sm" title="Abrir Enlace" @click="abrirnotificacion(item,1)">
                                            <img style="width:23px;heigth:23px;" src="css/img/abrirsobre.png"/>
                                        </button>
                                        <button class="btn btn-secondary btn-sm" title="Marcar como leída" @click="leernotificacion(item,1)">
                                            <img style="width:23px;heigth:23px;" src="css/img/notileer.png"/>
                                        </button>
                                    </td>
                               </tr>
                           </tbody>
                       </table>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="leertodas(notificaciones,null)" class="btn btn-primary">Leer Todas</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                inicio: false,
                notificaciones:[],
                audio:null,
                usuarios: [],
                colaboradores: []

            }
         },
        created() {
            console.log('Notificaciones Montada.');
            axios.post('/sistema/getdatos').then((res) =>{
                this.usuarios = res.data[0];
                this.colaboradores = res.data[1];
            });
            //$(".close").click();
            this.audio = new Audio("audio/notificacion.ogg");
            //this.audio.play();
            /*this.audio.muted = true; // Turn off silent state
            this.audio.play();
            this.audio.muted = false;*/
            
            $(document).click(function(e){
                if(this.inicio==false){
                    this.inicio=true;
                    console.log('detecto mouseover');
                    setTimeout(function(){
                        this.buscarnotificaciones('first');
                    }.bind(this), 2000);
                    
                    setInterval(function(){
                        this.buscarnotificaciones();
                    }.bind(this), 15000);
                }
            }.bind(this));

            window.addEventListener('touchstart', function() {
                if(this.inicio==false){
                    this.inicio=true;
                    console.log('detecto mouseover');
                    setTimeout(function(){
                        this.buscarnotificaciones('first');
                    }.bind(this), 2000);
                    setInterval(function(){
                        this.buscarnotificaciones();
                    }.bind(this), 15000);
                }
            }.bind(this));
            $(document).keydown(function(e){
                if(this.inicio==false){
                    this.inicio=true;
                    console.log('detecto keydown');
                    setTimeout(function(){
                        this.buscarnotificaciones('first');
                    }.bind(this), 2000);
                    setInterval(function(){
                        this.buscarnotificaciones();
                    }.bind(this), 15000);
                }
            }.bind(this));
        },
        beforeMount(){           
            
        },
        methods: {
            buscarnotificaciones(tipo){
                if(!this.inicio){
                    return;
                }
                 axios.post('/sistema/getdatos', {tipo:'notificaciones'}).then((res) =>{
                let notif = res.data;
                //console.log(notif);
                if(notif.length==0){
                    this.notificaciones=[];
                    return;
                    $("#notificacionesa").fadeOut();
                    $("#notifcant").hide();
                }else{
                    //console.log('Entro al else');
                    this.notificaciones = notif;
                    //console.log(this.notificaciones);
                    $("#notifcant").show();
                    $("#notifcant").html(notif.length);
                    $("#notificacionesa").fadeIn();
                    
                    let notifil= _.filter(notif, {'estado':'INGRESADO'});
                    
                    if(notifil.length>0){

                        console.log(notifil.length);
                        if(notif.length>1){
                            this.$toastr.Add({
                                name: "Notificacion",
                                title: "Notificaciones",
                                msg: "Tiene "+notif.length+"  sin leer",
                                position: "toast-top-left",
                                type: "info",
                                timeout: 5000,
                                progressbar: true,
                                //progressBarValue:"", // if you want set progressbar value
                                style:{},
                                classNames: ["animated", "zoomInUp"],
                                closeOnHover: true,
                                clickClose: true,
                                onCreated: ()=>{
                                    var promise =this.audio.play();
                                    if (promise) {
                                        //Older browsers may not return a promise, according to the MDN website
                                        promise.catch(function(error) { console.error(error); });
                                    }
                                    this.notificacionenviadas(notif, null);
                                },
                                onClicked: ()=>{},
                                onClosed: ()=>{},
                                onMouseOver: ()=>{},
                                onMouseOut: ()=>{},
                            });
                        }else{
                            this.$toastr.Add({
                                name: "Notificacion",
                                title: notif[0].tipo,
                                msg: notif[0].mensaje,
                                position: "toast-top-left",
                                type: "info",
                                timeout: 5000,
                                progressbar: true,
                                //progressBarValue:"", // if you want set progressbar value
                                style:{},
                                classNames: ["animated", "zoomInUp"],
                                closeOnHover: true,
                                clickClose: false,
                                onCreated: ()=>{
                                    var promise =this.audio.play();
                                    if (promise) {
                                        //Older browsers may not return a promise, according to the MDN website
                                        promise.catch(function(error) { console.error(error); });
                                    }
                                    this.notificacionenviadas(notifil,null);
                                    notifil[0].estado='ENVIADA';
                                },
                                onClicked: ()=>{
                                    axios.post('/sistema/setdatos', {tipo:'notificacionleida', notis:notifil, cant:null})
                                    .then((res) =>{
                                            window.location.href = notif[0].destino;
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
                            });
                        }
                    }else{
                        if(tipo=='first'){
                            
                            this.$toastr.Add({
                                name: "Notificacion",
                                title: "Notificaciones",
                                msg: "Tiene "+notif.length+" sin leer",
                                position: "toast-top-left",
                                type: "info",
                                timeout: 5000,
                                progressbar: true,
                                //progressBarValue:"", // if you want set progressbar value
                                style:{},
                                classNames: ["animated", "zoomInUp"],
                                closeOnHover: true,
                                clickClose: true,
                                onCreated: ()=>{
                                    var promise =this.audio.play();
                                    if (promise) {
                                        //Older browsers may not return a promise, according to the MDN website
                                        promise.catch(function(error) { console.error(error); });
                                    }
                                },
                                onClicked: ()=>{
                                    $("#notificacionesa").click();
                                },
                                onClosed: ()=>{},
                                onMouseOver: ()=>{},
                                onMouseOut: ()=>{},
                            });
                        }
                        
                    }
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
            notificacionenviadas(notif,cant){
                console.log(notif, cant);
                axios.post('/sistema/setdatos', {tipo:'notificacionesenviadas', notis:notif,cant:cant }).then((res) =>{
                    if(cant==null){
                        notif.forEach(element => {
                            element.estado='ENVIADA';
                        });
                    }else{
                        notif.estado ='ENVIADA';
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
            abrirnotificacion(notif, cant){
                console.log(notif, cant);
               axios.post('/sistema/setdatos', {tipo:'notificacionleida', notis:notif, cant:cant}).then((res) =>{
                   console.log(res.data);
                    var destino = notif.destino;
                    let index = _.findIndex(this.notificaciones, function(o) { return o.id == notif.id; });
                    this.notificaciones.splice(index,1);
                    window.location.href = destino;
                   
                    });
            },
            leernotificacion(notif, cant){
                console.log(notif, cant);
                axios.post('/sistema/setdatos', {tipo:'notificacionleida', notis:notif, cant:cant }).then((res) =>{
                    console.log(res.data);
                       //this.buscarnotificaciones(); 
                });
            }   
        },
    }
</script>
