<template>
    <div class="componente-receita-form">
        <form v-bind:action="action" v-bind:method="method">
            <slot name="method"></slot>
            <input type="hidden" name="_token" v-bind:value="token">

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Nome</label>
                        <input class="form-control" type="text" name="nome" v-bind:value="usuarioObj.nome">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>E-mail</label>
                        <input class="form-control" type="text" name="email" v-bind:value="usuarioObj.email">
                    </div>
                </div>
            </div>
            <button class="btn btn-danger" type="button" v-on:click="voltar()">Voltar</button>
            <button class="btn btn-primary" type="submit">Alterar</button>
        </form>
    </div>
</template>

<script>
    export default {
        props: [
            'action',
            'method',
            'token',
            'usuario'
        ],

        data(){
            return {
                usuarioObj: {}
            }
        },

        created(){
            
        },

        methods:{
            voltar(){
                window.history.back();
            }
        },

        mounted(){
            this.usuarioObj = JSON.parse(this.usuario);
        }
    }
</script>

<style lang="scss">
</style>
