<template>
    <div class="componente-menu">
        <div class="usuario">
            Olá {{nomeUsuario}}
        </div>
        <div class="acoes">
            <a class="acao" href="/contas">Contas</a>
            <a class="acao" href="/receitas">Receitas</a>
            <a class="acao">Despesas</a>
            <a class="acao" href="/categorias">Categorias</a>
            <a class="acao">Objetivos</a>
            <a class="acao">Investimentos</a>
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
    .componente-menu{
        height: 100vh;

        padding: 30px;

        background-color: #212120;
        box-shadow: 5px 4px 25px #555;
        color: white;

        .usuario{
            margin-bottom: 20px;
            padding-bottom: 20px;

            border-bottom: 1px solid #bbb;
            text-align: center;
        }

        .acoes{
            display: flex;
            flex-direction: column;

            .acao{
                margin: 5px 0;
                padding: 5px 0;

                color: white;
                text-decoration: none;
                
                &:hover{
                    cursor: pointer;
                    color: #ddd;
                } 
            }
        }
    }
</style>
