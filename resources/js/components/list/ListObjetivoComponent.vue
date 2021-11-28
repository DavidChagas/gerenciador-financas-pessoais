<template>
    <div class="componente-listagem-objetivo" v-bind:class="{ active: modalAberto }">
        <div class="overlay" v-bind:class="{ active: modalAberto }"></div>
        <div class="objetivos-grid">
            <div class="objetivo" v-for="i in list" v-bind:key="i.id">
                <div class="nome">
                    {{i.nome}}<br>
                    <small>{{formatDate(i.data_final)}}</small>
                </div>
                <hr>
                <div class="valores" v-if="!i.concluido && !i.fail">
                    <div class="valor">
                        <small>Valor Atual</small>
                        R$ {{formatPrice(i.total_aportado)}}
                    </div>
                    <div class="valor">
                        <small>Objetivo</small>
                        R$ {{formatPrice(i.valor)}}
                    </div>
                </div>
                <div class="progress" v-if="!i.concluido && !i.fail">
                    <div class="progress-bar" role="progressbar" v-bind:style="{ width: i.porcentagem+'%'}" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="porcentagem" >
                        Você já alcançou {{i.porcentagem}}% do seu objetivo 
                    </div>
                </div>

                <!-- OBJETIVO CONCLUIDO -->
                <div class="objetivo-concluido" v-if="i.concluido">
                    <img src="/images/objetivo-concluido.png">
                    <div class="descricao">
                        <b>Parabéns! Você concluiu o objetivo.</b>
                    </div>
                    Valor atingido: R$ {{formatPrice(i.valor)}}
                </div>

                <!-- OBJETIVO FAIL -->
                <div class="objetivo-concluido" v-if="i.fail">
                    <img src="/images/objetivo-fail.png">
                    <div class="descricao">
                        <b>Que pena, você não conseguiu alcançar o objetivo.</b>
                    </div>
                    <div style="line-height: 1.2; font-size: 12px">Faltou R$ {{formatPrice(i.valor - i.total_aportado)}} para alcançar o objetivo de R$ {{formatPrice(i.valor)}}</div>
                </div>

                <div class="estimativa" v-if="!i.concluido && !i.fail">
                    Voce precisa poupar <b>R$ {{formatPrice(i.qtdPoupar)}}</b> por mês para alcançar seu objetivo
                </div>
                <div class="botoes">
                    <div class="editar">
                        <form v-bind:action="'/'+model+'/'+i.id" method="POST">
                            <slot name="method"></slot>
                            <button type="submit" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                        </form>
                        <a v-bind:href="'/'+model+'/'+i.id+'/edit'" class="btn btn-info btn-sm"><i class="far fa-edit"></i></a>
                        <buttom class="btn btn-outline-info btn-sm" style="margin-left: 10px" v-on:click="verDetalhesObjetivo(i.id)">Ver Detalhes</buttom>
                    </div>
                    <div>
                        <buttom class="btn btn-success btn-sm" v-on:click="abrirModalCadastro(i.id, i.maxAporte)" v-if="!i.concluido && !i.fail">Adicionar Aporte</buttom>
                    </div>
                </div>
            </div>
        </div>

        <lista-vazia-component v-if="!list.length"></lista-vazia-component>

        <div class="modal-aporte" v-bind:class="{ active: modalAberto }">
            <form action="/objetivoAportes" method="POST">
                <input type="hidden" name="_token" v-bind:value="token">
                
                <div class="form-group">
                    <label>Valor</label>
                    <input class="form-control" type="text" name="valor" v-model="objetivoValorAporte" @blur="formatarValor">
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

        <div class="modal-detalhes" v-bind:class="{ active: modalDetalhesAberto }">
            <button class="btn btn-xs btn-danger" type="button" @click="modalDetalhesAberto = false">x</button>
            <div class="titulo">Aportes</div>
            <div class="cabecalho">
                <div class="item">Data</div>
                <div class="item">Valor</div>
                <div class="item"></div>
                <div class="item"></div>
            </div>
            <div class="aportes">
                <div class="aporte" v-for="aporte in aportesObjetivo" v-bind:key="aporte.id">
                    <div class="item">{{formatDate(aporte.data)}}</div>
                    <div class="item">{{formatPrice(aporte.valor)}}</div>
                    <div class="item">
                        <form v-bind:action="'/objetivoAportes/'+aporte.id" method="POST">
                            <slot name="method"></slot>
                            <button type="submit" class="btn btn-outline-danger btn-sm" style="margin-top: -7px; padding: 1px 5px;"><i class="far fa-trash-alt"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import funcoes from "../../funcoes"
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
                aportesObjetivo: [],
                visible: false,
                item: '',
                modalAberto: false,
                modalDetalhesAberto: false,
                objetivoIdAporte: 0,
                objetivoValorAporte: 0,
                dataAporte: '',
                maxAporte: 0
            }
        },
        methods: {
            formatPrice(value) {
                return funcoes.formatPrice(value);
            },
            formatarValor() {
                this.objetivoValorAporte = funcoes.formatarValorInput(this.objetivoValorAporte);
            },
            formatDate(value){
                return moment(String(value)).format('DD/MM/YYYY');
            },
            abrirModalCadastro(idObjetivo, maxAporte){
                this.modalAberto = true;
                this.objetivoIdAporte = idObjetivo;
                this.maxAporte = maxAporte;
            },
            monthDiff(d1, d2) {
                let months;
                months = (d2.getFullYear() - d1.getFullYear()) * 12;
                months -= d1.getMonth();
                months += d2.getMonth();
                return months <= 0 ? 0 : months;
            },
            verDetalhesObjetivo(idObjetivo){
                this.$http.get(`/api/aportes?idObjetivo=${idObjetivo}`).then(response => {
                   this.aportesObjetivo = response.body;
                   this.modalDetalhesAberto = true;
                }, err => {
                    console.log('err: ');
                });
            }
        },
        mounted(){
            console.log('this.infos', this.infos)
            this.list = JSON.parse(this.infos);
            this.list.forEach(objetivo => {
                console.log('objetivo.total_aportado', objetivo.total_aportado)
                if(objetivo.total_aportado == null) objetivo.total_aportado = 0
                objetivo.porcentagem = ((objetivo.total_aportado * 100) / objetivo.valor).toFixed(2);
                objetivo.maxAporte = objetivo.valor - objetivo.total_aportado;
                objetivo.concluido = objetivo.porcentagem >= 100 ? true : false;
                objetivo.fail = false;

                const dia = objetivo.data_final.split('-')[2];
                const mes = objetivo.data_final.split('-')[1];
                const ano = objetivo.data_final.split('-')[0];
                const diaAtual = moment().format('DD');
                const mesAtual = moment().format('MM');
                const anoAtual = moment().format('YYYY');

                let diff = this.monthDiff( new Date(anoAtual, mesAtual, diaAtual), new Date(ano, mes, dia));

                if((ano <= anoAtual) && (mes <= mesAtual) && (dia < diaAtual) && !objetivo.concluido){
                    objetivo.fail = true;
                }
                
                if(diff == 0){
                    objetivo.qtdPoupar = parseInt( objetivo.valor - objetivo.total_aportado );
                }else{
                    objetivo.qtdPoupar = parseInt( (objetivo.valor - objetivo.total_aportado) / diff );
                }
            });
            this.dataAporte =  moment().format('YYYY-MM-DD');
        }
    }
</script>
<style lang="scss">
   .componente-listagem-objetivo{
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
            grid-template-columns: repeat(1, 1fr);
            grid-gap: 20px;

            @media(min-width: 768px){
                grid-template-columns: repeat(3, 1fr);
            }

            .objetivo{
                position: relative;
                padding: 20px 15px;

                border-radius: 5px;
                border: 1px solid #ddd;
                transition: all .1s;

                &:hover{
                    box-shadow: 0px 0px 5px #ddd;
                }

                @media(max-width: 767px){
                    box-shadow: 0px 0px 5px #ddd;
                }

                > .nome{
                    font-size: 18px;
                    font-weight: bold;
                    color: #444;
                    text-align: center;
                    line-height: 1;

                    small{
                        font-size: 12px;
                    }
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

                    .progress-bar{
                        &.concluido{
                            background-color: green;
                        }
                    }
                    .porcentagem{
                        position: absolute;
                        left: 50%;
                        top: 10px;

                        width: 200px;
                        margin-left: -100px;

                        font-weight: bold;
                    }
                }

                .objetivo-concluido{
                    text-align: center;

                    .descricao{
                        margin: 10px 0 15px 0;
                        font-size: 16px;
                        line-height: 1;
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

                    >form >button{
                        position: absolute;
                        top: 5px;
                        right: 5px;

                        background-color: transparent;
                        color: red;
                        border: none;
                        padding: 0;
                        font-size: 15px;
                        line-height: 0;

                        &:hover{
                            color: rgb(162, 0, 0);
                        }
                    }
                }
                a{
                    position: absolute;
                    top: 5px;
                    right: 25px;

                    background-color: transparent;
                    color: rgb(46, 46, 228);
                    border: none;

                    padding: 0;
                    font-size: 15px;
                    line-height: 0;

                    &:hover{
                        color: rgb(22, 22, 102);
                    }
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
            padding: 15px;

            text-align: center;

            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 5px 4px 5px #ccc;

            @media(min-width: 768px){
                padding: 30px;
            }

            &.active{
                display: block;
                z-index: 2;
            }

            form{
                text-align: center;
            }
        }

        .modal-detalhes{
            position: absolute;
            top: -65px;
            left: 50%;

            display: none;

            width: 300px;
            max-height: 400px;
            margin-left: -150px;
            padding: 15px;

            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0px 0px 22px #a1a1a1;

            @media(min-width: 768px){
                width: 500px;
                margin-left: -250px;
                padding: 30px;
            }

            &.active{
                display: block;
                z-index: 2;
            }

            > button{
                float: right;
                padding: 0px 5px 3px;
                line-height: 1;
                font-weight: bold;
            }

            > .titulo{
                font-size: 20px;
                font-weight: bold;
                color: #444;

                text-align: center;
                margin-bottom: 20px;
            }

            > .cabecalho{
                display: grid;
                grid-template-columns: 40% 40% 20%;
                border-bottom: 2px solid #ddd;
                
                font-weight: bold;
                
                > .item{
                    text-align: center;
                }
            }

            > .aportes{
                max-height: 280px;
                overflow-y: auto;

                > .aporte{
                    padding: 5px 0;

                    display: grid;
                    grid-template-columns: 40% 40% 20%;

                    > .item{
                        text-align: center;
                        border-bottom: 1px solid #eee;
                    }
                }
            }
        }
   }
</style>
