<template>
    <div class="componente-lista-vazia">
        <img src="/images/list-empty.png">
        <div class="titulo">
            Nenhum registro cadastrado até o momento.
        </div>
        
    </div>
</template>

<script>
    export default {
        props : [],
        mounted() {
        }
    }
</script>

<style lang="scss">
    @import "../../sass/_variables.scss";
    .componente-lista-vazia{
        position: relative;
        text-align: center;

        img{
            opacity: .5;

            @media(max-width: 767px){
                width: 300px;
            }
        }

        > .titulo{
            // position: absolute;
            // top: 45%;
            // left: 50%;

            // width: 500px;
            // margin-left: -250px;

            font-size: 24px;
            color: #444;
            font-weight: bold;
        }
    }
</style>
