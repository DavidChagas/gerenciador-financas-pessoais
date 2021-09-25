<template>
    <div class="componente-categoria-form">
        <div class="descricao">
            Aqui você poderá cadastrar todas as suas categorias.
        </div>
        <form v-bind:action="action" v-bind:method="method">
            <slot name="method"></slot>
            <input type="hidden" name="_token" v-bind:value="token">
            <div class="form-group">
                <label>Descrição</label>
                <input class="form-control" type="text" name="descricao" v-bind:value="categoria.descricao">
            </div>
            <div class="form-group">
                <label>Tipo</label>
                <input class="form-control" type="text" name="tipo" v-bind:value="categoria.tipo">
            </div>
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
            'categoria',
            'teste'
        ],

        data(){
            return {
                categoria: {}
            }
        },

        mounted(){
            this.categoria = JSON.parse(this.categoria);
        }
    }
</script>

<style lang="scss">
</style>
