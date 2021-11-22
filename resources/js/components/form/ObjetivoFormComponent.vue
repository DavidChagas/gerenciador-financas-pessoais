<template>
    <div class="componente-objetivo-form">
        <div class="descricao">
            Aqui você poderá cadastrar todos os seus objetivos.
        </div>
        <form v-bind:action="action" v-bind:method="method">
            <slot name="method"></slot>
            <input type="hidden" name="_token" v-model="token">

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Nome</label>
                        <input class="form-control" type="text" name="nome" v-model="objetivoObj.nome" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Descrição</label>
                        <input class="form-control" type="text" name="descricao" v-model="objetivoObj.descricao">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Valor</label>
                        <input class="form-control" type="text" name="valor" v-model="objetivoObj.valor" @blur="formatarValor" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Data Final</label>
                        <input class="form-control" type="date" name="data_final" v-model="objetivoObj.data_final" required>
                    </div>
                </div>
            </div>
            <button class="btn btn-danger" type="button" v-on:click="voltar()">Voltar</button>
            <button class="btn btn-primary" type="submit">Cadastrar</button>
        </form>
    </div>
</template>

<script>
    import funcoes from "../../funcoes"

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
            },
            formatarValor() {
                this.objetivoObj.valor = funcoes.formatarValorInput(this.objetivoObj.valor);
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
