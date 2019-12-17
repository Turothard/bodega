<template>
    <div class="container">
       <div class="modal fade" id="notificacionesmodal" tabindex="-1" role="dialog" aria-labelledby="NofificacionesmodalTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
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
                                        <i class="material-icons pointer pr-4 md-36">
                                            drafts
                                        </i>
                                        <i class="material-icons pointer pr-4 md-36">
                                            mobile_friendly
                                        </i>
                                    </td>
                               </tr>
                           </tbody>
                       </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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
            
        },
        beforeMount(){
            
            setTimeout(function(){
               this.buscarnotificaciones('first');
            }.bind(this), 5000);
            setInterval(function(){
               this.buscarnotificaciones();
            }.bind(this), 15000);
            
        },
        methods: {
            buscarnotificaciones(tipo){
                 axios.post('/sistema/getdatos', {tipo:'notificaciones'}).then((res) =>{
                let notif = res.data;
                console.log(notif);
                if(notif.length==0){
                    this.notificaciones=[];
                    return;
                }else{
                    //console.log('Entro al else');
                    this.notificaciones = notif;
                    console.log(this.notificaciones);
                    $("#notificacionesa").show();
                    let notifil= _.filter(notif, {'estado':'INGRESADO'});
                    
                    if(notifil.length>0){
                        
                        if(notif.length>1){
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
                                clickClose: false,
                                onCreated: ()=>{
                                    this.notificacionenviadas(notif);
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
                                    this.notificacionenviadas(notif);
                                },
                                onClicked: ()=>{
                                    axios.post('/sistema/setdatos', {tipo:'notificacionleida', notis:notifil })
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
                                clickClose: false,
                                onCreated: ()=>{
                                    this.audio.play();
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
            notificacionenviadas(notif){
                axios.post('/sistema/setdatos', {tipo:'notificacionesenviadas', notis:notif })
                .then((res) =>{
                    this.audio.play();
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
