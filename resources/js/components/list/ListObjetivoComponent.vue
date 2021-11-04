<template>
    <div class="componente-listagem-conta" v-bind:class="{ active: modalAberto }">
        <div class="overlay" v-bind:class="{ active: modalAberto }"></div>
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
                        <!-- <a v-bind:href="'/'+model+'/'+i.id+'/edit'" class="btn btn-info btn-sm">Editar</a> -->
                        <buttom class="btn btn-info btn-sm" style="margin-left: 10px">Ver Detalhes</buttom>
                    </div>
                    <div>
                        <buttom class="btn btn-success btn-sm" v-on:click="abrirModal(i.id)">Adicionar Aporte</buttom>
                    </div>
                </div>
            </div>
        </div>

        <lista-vazia-component v-if="!list.length"></lista-vazia-component>

        <div class="modal-aporte" v-bind:class="{ active: modalAberto }">
            <form action="/objetivo-aportes" method="POST">
                <input type="hidden" name="_token" v-bind:value="token">
                
                <div class="form-group">
                    <label>Valor</label>
                    <input class="form-control" type="text" name="valor">
                </div>

                <div class="form-group">
                    <input class="form-control" type="hidden" name="objetivo_id" v-bind:value="objetivoIdAporte">
                </div>
                <div class="form-group">
                    <input class="form-control" type="hidden" name="data" v-bind:value="dataAporte">
                </div>
               
                    
                <button class="btn btn-danger" type="button" @click="modalAberto = false">Cancelar</button>
                <button class="btn btn-primary" type="submit">Aportar</button>
            </form>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        props : [
            'infos',
            'model',
            'token'
        ],
        data(){
            return {
                list: [],
                visible: false,
                item: '',
                modalAberto: false,
                objetivoIdAporte: 0,
                dataAporte: ''
            }
        },
        methods: {
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            abrirModal(idObjetivo){
                this.modalAberto = true;
                this.objetivoIdAporte = idObjetivo;
            }
        },
        mounted(){
            this.list = JSON.parse(this.infos);
            this.dataAporte =  moment().format('YYYY-MM-DD');
        }
    }
</script>
<style lang="scss">
   .componente-listagem-conta{
        position: relative;

        .overlay{
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.15);
            z-index: 1;

            &.active{
                display: block; 
            }
        }
        
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

        .modal-aporte{
            position: absolute;
            top: 0px;
            left: 50%;

            display: none;

            width: 300px;
            margin-left: -150px;
            padding: 30px;

            text-align: center;

            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 5px 4px 5px #ccc;

            &.active{
                display: block;
                z-index: 2;
            }

            form{
                text-align: center;
            }
        }
   }
</style>
