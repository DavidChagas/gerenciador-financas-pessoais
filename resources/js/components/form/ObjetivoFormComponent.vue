<template>
    <div class="componente-objetivo-form">
        <div class="descricao">
            Aqui você poderá cadastrar todos os seus objetivos.
        </div>
        <form v-bind:action="action" v-bind:method="method">
            <slot name="method"></slot>
            <input type="hidden" name="_token" v-bind:value="token">

            <div class="row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Nome</label>
                        <input class="form-control" type="text" name="nome" v-bind:value="objetivoObj.nome">
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Descrição</label>
                        <input class="form-control" type="text" name="descricao" v-bind:value="objetivoObj.descricao">
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Valor</label>
                        <input class="form-control" type="text" name="valor" v-bind:value="objetivoObj.valor">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Data Inicial</label>
                        <input class="form-control" type="date" name="data_inicial" v-bind:value="objetivoObj.data_inicial">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Data Final</label>
                        <input class="form-control" type="date" name="data_final" v-bind:value="objetivoObj.data_final">
                    </div>
                </div>
            </div>
            <button class="btn btn-danger" type="button" v-on:click="voltar()">Voltar</button>
            <button class="btn btn-primary" type="submit">Cadastrar</button>
        </form>
    </div>
</template>

<script>
    export default {
        props: [
            'action',
            'method',
            'token',
            'objetivo'
        ],

        data(){
            return {
                objetivoObj: {}
            }
        },

        methods:{
            voltar(){
                window.history.back();
            }
        },

        mounted(){
            console.log(this.objetivo);
            this.objetivoObj = JSON.parse(this.objetivo);
        }
    }
</script>

<style lang="scss">
</style>
