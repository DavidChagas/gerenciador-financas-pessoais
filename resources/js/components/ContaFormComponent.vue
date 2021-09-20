<template>
    <div class="componente-conta-form">
        <div class="descricao">
            Aqui você poderá cadastrar todas as suas contas existentes. Exemplos de contas: Poupança, Carteira, Nuconta, etc...
        </div>
        <form v-bind:action="action" v-bind:method="method">
            <slot name="method"></slot>
            <input type="hidden" name="_token" v-bind:value="token">
            <div class="form-group">
                <label>Descrição</label>
                <input class="form-control" type="text" name="descricao" v-bind:value="conta.descricao">
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
            'conta',
            'teste'
        ],

        data(){
            return {
                conta: {}
            }
        },

        mounted(){
            this.conta = JSON.parse(this.conta);
        }
    }
</script>

<style lang="scss">
</style>
