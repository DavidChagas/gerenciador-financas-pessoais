<template>
    <div class="componente-menu">
        <div class="usuario">
            Olá {{nomeUsuario}}
        </div>
        <div class="acoes">
            <div class="paginas">
                <a class="acao" href="/"><i class="fas fa-chart-pie" style="margin-right: 7px"></i> Dashboard</a>
                <a class="acao" href="/contas"><i class="fas fa-wallet" style="margin-right: 7px"></i> Contas</a>
                <a class="acao" href="/categorias"><i class="fas fa-bookmark" style="margin-right: 7px"></i> Categorias</a>
                <a class="acao" href="/receitas"><i class="fas fa-chart-line" style="margin-right: 7px"></i> Receitas</a>
                <a class="acao" href="/despesas"><i class="fas fa-chart-line" style="margin-right: 7px; transform: rotate(180deg)"></i> Despesas</a>
                <a class="acao" href="/objetivos"><i class="fas fa-chart-line" style="margin-right: 7px; transform: rotate(180deg)"></i> Objetivos</a>
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
