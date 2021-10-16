<template>
    <div class="componente-titulo-form">
        <h1>{{titulo}}</h1>
    </div>
</template>

<script>
    export default {
        props : [
            'titulo'
        ]
    }
</script>

<style lang="scss">
    .componente-titulo-form{
        width: 100%;
        margin: 50px 0 50px 0;
        text-align: center;
    }
</style>
