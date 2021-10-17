<template>
    <div class="componente-menu">
        <div class="usuario">
            Olá {{nomeUsuario}}
        </div>
        <div class="acoes">
            <div class="paginas">
                <a class="acao" href="/">Dashboard</a>
                <a class="acao" href="/contas">Contas</a>
                <a class="acao" href="/categorias">Categorias</a>
                <a class="acao" href="/receitas">Receitas</a>
                <a class="acao" href="/despesas">Despesas</a>
                <!-- <a class="acao">Objetivos</a> -->
                <!-- <a class="acao">Investimentos</a> -->
            </div>
            <form action="/logout" method="POST">
                <slot name="method"></slot>
                <button type="submit" class="btn btn-danger btn-sm">Logout</button>
            </form>
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
    @import "../../sass/_variables.scss";
    .componente-menu{
        position: fixed;

        height: 100vh;
        min-width: 280px;

        padding: 30px;

        background-color: $brand-primary;
        box-shadow: 5px 4px 25px #555;
        color: white;

        .usuario{
            margin-bottom: 20px;
            padding-bottom: 20px;

            border-bottom: 1px solid #bbb;
            text-align: center;
        }

        .acoes{
            height: 90%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;

            .paginas{
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

            form{
                display: flex;
                justify-content: center;

                button{
                    padding: 2px;
                    background-color: transparent;
                    color: white;
                    border-left: none;
                    border-right: none;
                    border-top: none;
                    border-bottom: 1px solid #eee;
                    border-radius: 0;
                }
            }
        }
    }
</style>
