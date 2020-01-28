

<template>
    <div class="container">
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
                                    <td>{{articulo.codigoart}}</td>
                                    <td>{{articulo.nombreart}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                     <button class="btn btn-info btn-sm" @click="$refs.subirnewimageold.click()"><img style="width:23px;heigth:23px;" src="css/img/addimage.png"/></button>
                        <input type="file" accept="image/*" ref="subirnewimageold" capture="camera" id="newimage" @change="handleFileUpload()" style="display:none"/> 
                    <div v-if="imagen!=null">
                        
                        <img v-bind:src="imagePreview" v-show="showPreview" class="img-fluid" alt="Responsive image"/>
                    </div>
                    <div v-if="imagen==null">
                        
                        <img v-bind:src="imagePreview" v-show="showPreview" class="img-fluid" alt="Responsive image"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Subir Imagen</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['articulo', 'imagen'],
        data(){
            return{
                showPreview : false,
                imagePreview : ''
            }
        },
        created() {
            if(this.imagen !=null){
                this.imagePreview = this.imagen;
                this.showPreview = true;
            }
        },
        mounted() {
            console.log(this.imagen);
            console.log('Component mounted.')
        },
        methods: {
            handleFileUpload(){
                this.file = this.$refs.subirnewimageold.files[0];
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
            guardararticulo(){
                let file = this.$refs.subirnewimageold.files[0];
                if(typeof file !=='undefined' && file !=null ){
                    console.log("entro a guardar imagen");
                    let formData = new FormData();
                    formData.append('image',file);
                    formData.append('nombre',articulo.codigoart);
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
            }
        },
    }

</script>
