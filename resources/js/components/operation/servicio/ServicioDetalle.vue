<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">


                    <div class="card-body">
                        <table class="table table-striped display table-sm table-bordered table-dark dt-responsive t-regular w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Servicio</th>
                                    <th>Area</th>
                                    <th>Encargado</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                               <tr><td>1</td><td>2021-09-01</td><td>Servicio Parcial 40</td><td>ZAO</td><td>MARCOS ABALLAY</td><td>FINALIZADO</td><td><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#pedidomodal" >
                  <img style="width:23px;heigth:23px;" src="/css/img/moreinfo.png" />
                </button></td></tr>
<tr><td>2</td><td>2021-09-01</td><td>Servicio Parcial 40</td><td>ZAO</td><td>MARCOS ABALLAY</td><td>FINALIZADO</td><td><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#pedidomodal" >
                  <img style="width:23px;heigth:23px;" src="/css/img/moreinfo.png" />
                </button></td></tr>
<tr><td>3</td><td>2021-09-01</td><td>Servicio Parcial 20</td><td>ZAO</td><td>MARCOS ABALLAY</td><td>FINALIZADO</td><td><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#pedidomodal" >
                  <img style="width:23px;heigth:23px;" src="/css/img/moreinfo.png" />
                </button></td></tr>
<tr><td>4</td><td>2021-09-01</td><td>Servicio Total 20</td><td>ZAO</td><td>MARCOS ABALLAY</td><td>FINALIZADO</td><td><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#pedidomodal" >
                  <img style="width:23px;heigth:23px;" src="/css/img/moreinfo.png" />
                </button></td></tr>
<tr><td>5</td><td>2021-09-02</td><td>Servicio Parcial 20</td><td>ZAO</td><td>MARCOS ABALLAY</td><td>FINALIZADO</td><td><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#pedidomodal" >
                  <img style="width:23px;heigth:23px;" src="/css/img/moreinfo.png" />
                </button></td></tr>
<tr><td>6</td><td>2021-09-02</td><td>Servicio Total 20</td><td>ZAO</td><td>MARCOS ABALLAY</td><td>FINALIZADO</td><td><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#pedidomodal" >
                  <img style="width:23px;heigth:23px;" src="/css/img/moreinfo.png" />
                </button></td></tr>
<tr><td>7</td><td>2021-09-02</td><td>Servicio Muestra USDA</td><td>ZAO</td><td>MARCOS ABALLAY</td><td>FINALIZADO</td><td><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#pedidomodal" >
                  <img style="width:23px;heigth:23px;" src="/css/img/moreinfo.png" />
                </button></td></tr>
<tr><td>8</td><td>2021-09-02</td><td>Servicio Personal por Hora</td><td>ZAO</td><td>MARCOS ABALLAY</td><td>FINALIZADO</td><td><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#pedidomodal" >
                  <img style="width:23px;heigth:23px;" src="/css/img/moreinfo.png" />
                </button></td></tr>
<tr><td>9</td><td>2021-09-03</td><td>Servicio Parcial 20 IMO</td><td>ZAO</td><td>MARCOS ABALLAY</td><td>FINALIZADO</td><td><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#pedidomodal" >
                  <img style="width:23px;heigth:23px;" src="/css/img/moreinfo.png" />
                </button></td></tr>
<tr><td>10</td><td>2021-09-03</td><td>Servicio Parcial 20 IMO</td><td>ZAO</td><td>MARCOS ABALLAY</td><td>INICIADO</td><td><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#pedidomodal" >
                  <img style="width:23px;heigth:23px;" src="/css/img/moreinfo.png" />
                </button></td></tr>
<tr><td>11</td><td>2021-09-03</td><td>Servicio Carga Fraccionada IMO</td><td>ZAO</td><td>MARCOS ABALLAY</td><td>INGRESADO</td><td><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#pedidomodal" >
                  <img style="width:23px;heigth:23px;" src="/css/img/moreinfo.png" />
                </button></td></tr>


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
        props: ['dataservicios', 'sectorservicio'],
        data(){
            return{
                detalleservicios:null,
                cargando:true,
            }
        },
        created() {
            axios.post('/operation/servicio/getdatos', {tipo:'servicios',valor:this.sectorservicio}).then((res) =>{
                this.detalleservicios = res.data;
                this.cargando=false;
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
            console.log('Component mounted.')
        }
    }
</script>
