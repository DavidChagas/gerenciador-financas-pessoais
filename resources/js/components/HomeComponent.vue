<template>
    <div class="componente-home">
        <h1>Dashboard</h1>
        <div class="img-desenvolvimento">
            <img src="/images/construcao.jpg">
            <div class="desenvolvimento">
                Em desenvolvimento
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props : [
            'nomeUsuario'
        ],
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style lang="scss">
    .componente-home{
        h1{
            margin: 50px 0 100px 0;
        }
        .img-desenvolvimento{
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

            img{
                width: 420px;
            }

            .desenvolvimento{
                font-size: 20px;
                color: #aaa;
            }
        }
    }
</style>
