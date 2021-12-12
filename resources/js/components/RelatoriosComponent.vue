<template>
    <div class="componente-relatorios">
        <small class="d-print-block" style="display:none; position: absolute; top: 10px; right: 10px;">
            Relatório referente à {{this.retornaNomeMes(dataSelecionada.split('-')[1])+' '+dataSelecionada.split('-')[0]}}
        </small>
        <div v-switch="relatorioSelecionado" class="titulo d-print-block" style="display:none;">
            <h1 v-case="'balanco-mensal'">Balanço Mensal</h1>
            <h1 v-case="'despesas-por-categoria'">Total de despesas por categoria</h1>
            <h1 v-case="'receitas-por-categoria'">Total de receitas por categoria</h1>
            <h1 v-case="'despesas-por-conta'">Total de despesas por conta</h1>
            <h1 v-case="'receitas-por-conta'">Total de receitas por conta</h1>
        </div>
        <div class="titulo d-print-none"><h1>Relatórios</h1></div>
        <div class="selects d-print-none">
            <div class="datas">
                <small>Escolha um relatório</small>
                <select class="form-control" v-model="relatorioSelecionado" v-on:change="getRelatorio(relatorioSelecionado, dataSelecionada)">
                    <option value="balanco-mensal">Balanço Mensal</option>
                    <option value="despesas-por-categoria">Total de despesas por categoria</option>
                    <option value="receitas-por-categoria">Total de receitas por categoria</option>
                    <option value="despesas-por-conta">Total de despesas por conta</option>
                    <option value="receitas-por-conta">Total de receitas por conta</option>
                </select>
            </div>
            <div class="datas">
                <small>Selecione um mês</small>
                <select class="form-control" name="data" v-model="dataSelecionada" v-on:change="getRelatorio(relatorioSelecionado, dataSelecionada)">
                    <option v-bind:key="data.data" v-bind:value="data.data" v-for="data in datasFormatadas">{{data.descricao}}</option>
                </select>
            </div>
        </div>
        <table class="table table-sm">
            <thead class="thead-light">
                <tr>
                    <th scope="col" v-for="coluna in relatorioColunas" v-bind:key="coluna">{{coluna}}</th>
                </tr>
            </thead>
            <tbody v-if="relatorioSelecionado == 'despesas-por-categoria' || relatorioSelecionado == 'receitas-por-categoria'">
                <tr v-for="linha in relatorioLinhas" v-bind:key="linha">
                    <td>{{linha.Categoria}}</td>
                    <td>R$ {{formatPrice(linha.Total)}}</td>
                </tr>
            </tbody>
            <tbody v-if="relatorioSelecionado == 'despesas-por-conta' || relatorioSelecionado == 'receitas-por-conta'">
                <tr v-for="linha in relatorioLinhas" v-bind:key="linha">
                    <td>{{linha.Conta}}</td>
                    <td>R$ {{formatPrice(linha.Total)}}</td>
                </tr>
            </tbody>
            <tbody v-if="relatorioSelecionado == 'balanco-mensal'">
                <tr>
                    <td v-for="linha in relatorioLinhas" v-bind:key="linha">
                        R$ {{formatPrice(linha.Total)}}
                    </td>
                    <!-- <td>R$ {{formatPrice(linha.Total_Receitas)}}</td>
                    <td>R$ {{formatPrice(linha.Total_Despesas)}}</td> -->
                </tr>
            </tbody>
        </table>
        <div class="aviso-selecionar-relatorio d-print-none" v-if="relatorioSelecionado == ''">
            <img src="/images/selecione-relatorio.jpg" style="opacity: .7;">
            <br>
            <span>Selecione um relatório</span>
        </div>
        <button class="btn btn-info btn-sm d-print-none" onclick="window.print()" style="float: right" v-if="relatorioSelecionado != ''">
            <i class="fas fa-print"></i> Imprimir
        </button>
        <img src="/images/img-relatorio.jpg" class="d-print-block" style="display:none; opacity: .2; position: absolute; bottom: 0px; left: 0px;">
    </div>
</template>

<script>
    import moment from 'moment';
    import funcoes from "../funcoes"

    export default {
        props : [
            
        ],
        data(){
            return {
               dataSelecionada: '',
               datasFormatadas: [],
               relatorioColunas: [],
               relatorioLinhas: [],
               relatorioSelecionado: ''
            }
        },
        methods:{
            formatPrice(value) {
                return funcoes.formatPrice(value);
            },
            getRelatorio(relatorioSelecionado, dataSelecionada){
                this.relatorioLinhas = [];
                this.relatorioColunas = [];

                const firstDay = dataSelecionada+'-01';
                const lastDay = dataSelecionada+'-31';

                this.$http.get(`/getRelatorios?relatorio=${relatorioSelecionado}&first=${firstDay}&last=${lastDay}`).then(response => {
                   this.relatorioLinhas = response.body[0];
                   console.log(this.relatorioLinhas);
                   this.relatorioColunas = response.body[1];
                   console.log(this.relatorioColunas);
                }, err => {
                    console.log('err: ');
                });
            },
            retornaNomeMes(mesNumero){
                let mes = '';
                switch(mesNumero){
                    case '01':
                        mes = 'Janeiro';
                        break;
                    case '02':
                        mes = 'Fevereiro';
                        break;
                    case '03':
                        mes = 'Março';
                        break;
                    case '04':
                        mes = 'Abril';
                        break;
                    case '05':
                        mes = 'Maio';
                        break;
                    case '06':
                        mes = 'Junho';
                        break;
                    case '07':
                        mes = 'Julho';
                        break;
                    case '08':
                        mes = 'Agosto';
                        break;
                    case '09':
                        mes = 'Setembro';
                        break;
                    case '10':
                        mes = 'Outubro';
                        break;
                    case '11':
                        mes = 'Novembro';
                        break;
                    case '12':
                        mes = 'Dezembro';
                        break;
                }

                return mes;
            }
        },
        mounted() {
            const mesAtual = moment().format('YYYY-MM');
            let datas = localStorage.getItem("datas").split(',');
            
            this.datasFormatadas = datas.map(data =>{
                return {data: data, descricao: this.retornaNomeMes(data.split('-')[1])+' '+data.split('-')[0]}
            })

            if(datas.includes(mesAtual)) datas.unshift(mesAtual);
            this.dataSelecionada = mesAtual;
        }
    }
</script>

<style lang="scss">
    
    .componente-relatorios{
        .titulo{
            width: 100%;
            margin: 50px 0 50px 0;
            text-align: center;
        }
        
        .selects{
            margin-bottom: 30px;
            display: flex;
            justify-content: space-around;

            .datas{
                width: 300px;

                @media(max-width: 767px){
                    margin-top: 20px;
                }

                select{
                    border-top: none;
                    border-left: none;
                    border-right: none;
                    border-radius: 0px;

                    font-size: 16px;

                    &:focus{
                        border-color: transparent;
                        outline: none;
                        box-shadow: none;
                    }
                }
            }
        } 

        .aviso-selecionar-relatorio{
            position: relative;
            margin-top: 50px;
            text-align: center;

            span{
                position: absolute;
                width: 300px;
                left: calc(50% - 150px);
                bottom: 0%;

                font-weight: bold;
                font-size: 25px;
                color: #444;
            }
        }
    }
</style>
