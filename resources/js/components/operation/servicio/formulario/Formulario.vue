<template>
    <div class="col-4">
        <div v-if="dataformulario.tipoformulario=='Numero'  && dataformulario.activo" class="col-4">
            <div v-if="dataformulario.tipovalor=='dato' && dataformulario.valor==''">
                <label for="inputnumero">{{dataformulario.nombre}}</label>
                <input type="number" class="form-control" id="inputnumero" v-model="dataformulario.value" :required="dataformulario.requerido" placeholder="1">
            </div>
            <div v-if="dataformulario.valor=='horastrabajadas()'">
                <label for="inputnumero">{{dataformulario.nombre}}</label>
                <input type="number" class="form-control" id="inputnumero" v-model="dataformulario.value" disabled="true" placeholder="1">
            </div>
            
        </div>
        <div v-if="dataformulario.tipoformulario=='Texto' && dataformulario.activo" class="col-4">
            <div v-if="dataformulario.tipovalor=='dato' && dataformulario.valor==''">
                <label for="inputtexto">{{dataformulario.nombre}}</label>
                <input type="text" class="form-control" id="inputtexto" v-model="dataformulario.value" :required="dataformulario.requerido" placeholder="1">
            </div>
            <div v-if="dataformulario.tipovalor=='Objeto' && dataformulario.tipo=='Selector'">
                <label for="inputtexto">{{dataformulario.nombre}}</label>
                <select v-model="dataformulario.value" id="selecttexto" class="form-control form-control-sm t-regular w-d text-uppercase">
                    <option value="">------</option>
                    <option v-for="(item, index) in busqueda" :key="index" :value="item">
                        {{ item }}
                    </option>
                </select>
            </div>
            <div v-if="dataformulario.tipovalor=='objeto' && dataformulario.tipo=='Buscador'">
                <label for="inputtexto">{{dataformulario.nombre}}</label>
                <vue-bootstrap-typeahead 
                    v-model="dataformulario.value"
                    :minMatchingChars="2"
                    :inputClass="'form-control form-control-sm w-d1'"
                    ref="value"
                    :data="busqueda">
                </vue-bootstrap-typeahead>
            </div>
            <div v-if="dataformulario.tipovalor=='grupo'">
                <label for="selecttexto">{{dataformulario.nombre}}</label>
                <select v-model="dataformulario.value" id="selecttexto" class="form-control form-control-sm t-regular w-d text-uppercase">
                    <option value="">------</option>
                    <option v-for="(item, index) in dataformulario.valor" :key="index" :value="item">
                        {{ item }}
                    </option>
                </select>
            </div>
        </div>
        <div v-if="dataformulario.tipoformulario=='Areatexto'" >
            <label for="areatexto">{{dataformulario.nombre}}</label>
            <textarea name="areatexto" id="areatexto" v-model="dataformulario.value" cols="30" rows="10"></textarea>
        </div>
        <div v-if="dataformulario.tipoformulario=='Hora'" >
            <label for="hora">{{dataformulario.nombre}}</label>
            <input type="datetime-local" class="form-control" id="hora" v-model="dataformulario.value" :required="dataformulario.requerido">
        </div>
        <div v-if="dataformulario.tipoformulario=='Fecha'" >
            <label for="fecha">{{dataformulario.nombre}}</label>
            <input type="date" class="form-control" id="fecha" v-model="dataformulario.value" :required="dataformulario.requerido" >
        </div>
        <div v-if="dataformulario.tipoformulario=='Password'" >
            <label for="password">{{dataformulario.nombre}}</label>
            <input type="password" class="form-control" id="password" v-model="dataformulario.value" :required="dataformulario.requerido" >
        </div>
        <div class="col-4">
    
        </div>
    </div>
</template>

<script>
    export default {
        props: ['dataformulario', 'servicio', 'detalletrabajo'],
        data(){
            return{
                value:null,
                busqueda:null
            }
        },
        created() {
            if(this.dataformulario.tipovalor=='objeto'){
                axios.post('/operation/getdatos', {tipo:this.dataformulario.valor}).then((res) =>{
                    this.busqueda = res.data;
                }).catch((error) =>{
                    console.log(error.response.data.errors);
                    /*this.err_list = error.response.data.errors;
                    if (this.err_list.rut != null) {
                        this.server_alert.rut = 'fa fa-exclamation-circle';
                    };
                    if (this.err_list.correo != null) {
                        this.server_alert.correo = 'fa fa-exclamation-circle';
                    };*/
                });
            }
            if(this.dataformulario.tipovalor=='grupo'){
                this.dataformulario.valor = this.dataformulario.valor.toString().split("|");
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            horastrabajadas(){
                let horas =this.detalletrabajo.termino - this.detalletrabajo.inicio;
                return horas;
            }
        }
    }
</script>
