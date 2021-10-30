<template>
    <div class="componente-listagem-conta">
        <div class="objetivos-grid">
            <div class="objetivo" v-for="i in list" v-bind:key="i.id">
                <div class="nome">{{i.nome}}</div>
                <hr>
                <div class="valores">
                    <div class="valor">
                        <small>Valor Atual</small>
                        R$ 100,00
                    </div>
                    <div class="valor">
                        <small>Objetivo</small>
                        R$ 200,00
                    </div>
                </div>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="porcentagem">
                        Você já alcançou 25% do seu objetivo
                    </div>
                </div>
                <div class="estimativa">
                    Voce precisa poupar <b>R$20,00</b> por mês para alcançar seu objetivo
                </div>
                <div class="botoes">
                    <div class="editar">
                        <form v-bind:action="'/'+model+'/'+i.id" method="POST">
                            <slot name="method"></slot>
                            <button type="submit" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                        </form>
                        <a v-bind:href="'/'+model+'/'+i.id+'/edit'" class="btn btn-info btn-sm">Editar</a>
                    </div>
                    <div>
                        <a v-bind:href="'#'" class="btn btn-success btn-sm">Adicionar Aporte</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="lista-vazia" v-if="!list.length">
            Ainda não existe objetivos cadastrados :(
        </div>

        <modal-exclusao-component v-if="visible"></modal-exclusao-component>
    </div>
</template>

<script>
    export default {
        props : [
            'infos',
            'model'
        ],

        data(){
            return {
                list: [],
                visible: false,
                item: ''
            }
        },
        methods: {
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            abrirModal() {
                this.visible = true;
            }
        },
        mounted(){
            this.list = JSON.parse(this.infos);
        }
    }
</script>
<style lang="scss">
   .componente-listagem-conta{
        position: relative;

        .lista-vazia{
            margin: 20px 0;
            padding: 50px 0;
            text-align: center;
            
            background-color: #eee;
            border: 2px solid #ddd;
            border-radius: 5px;

            font-size: 20px;
            color: #444;
        }

        .objetivos-grid{
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 20px;

            .objetivo{
                padding: 20px 15px;

                border-radius: 5px;
                border: 1px solid #ddd;

                .nome{
                    font-size: 18px;
                    font-weight: bold;
                    color: #444;
                    text-align: center;
                }

                .valores{
                    margin: 15px 0;

                    display: grid;
                    grid-template-columns: repeat(2, 1fr);

                    .valor{
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        text-align: center;
                    }
                }

                .progress{
                    position: relative;
                    height: 20px;
                    border: 1px solid #3490dc;

                    .porcentagem{
                        position: absolute;
                        left: 50%;
                        top: 10px;

                        width: 200px;
                        margin-left: -100px;

                        font-weight: bold;
                    }
                }
            }

            .estimativa{
                margin-top: 15px;
                font-size: 12px;
                line-height: 1;
                text-align: center;
            }

            .botoes{
                margin-top: 30px;
                display: flex;
                justify-content: space-between;

                .editar{
                    display: flex;
                }
                a{
                    margin-left: 5px;
                }
            }
        }
   }
</style>
