<template>
    <div class="componente-conta-form">
        <div class="descricao">
            Aqui você poderá cadastrar todas as suas contas existentes. Exemplos de contas: Poupança, Carteira, Nuconta, etc...
        </div>
        <form action="/conta" method="POST">
            <input type="hidden" name="_token" v-bind:value="token">
            <div class="form-group">
                <label>Descrição</label>
                <input class="form-control" type="text" name="descricao">
            </div>
            <button class="btn btn-primary" type="submit">Cadastrar</button>
        </form>
    </div>
</template>

<script>
    export default {
        props: [
            'token'
        ]
    }
</script>

<style lang="scss">
</style>
