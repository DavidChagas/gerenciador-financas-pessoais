<template>
    <div class="componente-home">
        <div class="cabecalho">
            <h1>Dashboard</h1>
            <div class="datas">
                <select class="form-control" name="data" v-model="dataSelecionada" v-on:change="getTotais(dataSelecionada)">
                    <option v-bind:key="data.data" v-bind:value="data.data" v-for="data in datasFormatadas">{{data.descricao}}</option>
                </select>
            </div>
        </div>

        <div class="saldoTotal">
            <small>Saldo em Contas</small><br>
            R$ {{formatPrice(saldo_total)}}
        </div>
        
        <div class="grafico-barras">
            
            <div class="infos">
                <div class="total">
                    <img src="/images/receitas.png">
                    <div>
                        Total de Receitas<br> 
                        <span>R$ {{formatPrice(totalReceitas)}}</span>
                    </div>
                </div>
                <div class="total">
                    <img src="/images/despesas.png">
                    <div>
                        Total de Despesas<br> 
                        <span>R$ {{formatPrice(totalDespesas)}}</span>
                    </div>
                </div>
            </div>
            <div class="grafico" v-bind:class="{ semMovimentacoes: 'desfocar' }">
                <div class="semInfos" v-if="semMovimentacoes">Sem movimentações neste mês</div>
                <canvas id="barChart"></canvas>
            </div>
        </div>
        <div class="grafico-pizza" v-if="!semMovimentacoes">
            <div class="tipo">
                <div class="descricao">
                    Receitas por Categoria
                </div>
                <div class="grafico">
                    <canvas id="categoriaReceitasChart"></canvas>
                </div>
            </div>
            <div class="tipo">
                <div class="descricao">
                    Despesas por Categoria
                </div>
                <div class="grafico">
                    <canvas id="categoriaDespesasChart"></canvas>
                </div>
            </div>
        </div>
        <hr style="margin-bottom: 5px;">
        <div style="text-align: center; width: 100%; margin-bottom: 10px; color: #999"><small>165509 - David Chagas</small></div>
    </div>
</template>

<script>
    import moment from 'moment';
    import funcoes from "../funcoes"
    
    export default {
        props : [
            'datas_receitas',
            'datas_despesas',
            'saldo_total'
        ],

        data(){
            return {
                datas_receitasObj: {},
                datas_despesasObj: {},
                datas: [],
                datasFormatadas: [],
                totalReceitas: '',
                totalDespesas: '',
                dataSelecionada: '',
                semMovimentacoes: false,
                primeiroCarregamentoBar: true,
                primeiroCarregamentoReceitas: true,
                primeiroCarregamentoDespesas: true,
            }
        },

        created(){
            this.datas_receitasObj = JSON.parse(this.datas_receitas);
            this.datas_despesasObj = JSON.parse(this.datas_despesas);
            
        },

        methods:{
            formatPrice(value) {
                return funcoes.formatPrice(value);
            },

            getTotais(dataSelecionada){
                const firstDay = dataSelecionada+'-01';
                const lastDay = dataSelecionada+'-31';

                this.$http.get(`/api/getTotais?first=${firstDay}&last=${lastDay}`).then(response => {
                   
                    this.totalReceitas = response.body[0].total_receitas == null ? 0 : funcoes.formatarValorGraficos(response.body[0].total_receitas);
                    // if( this.totalReceitas == null ) this.totalReceitas = 0;
                    this.totalDespesas = response.body[1].total_despesas == null ? 0 : funcoes.formatarValorGraficos(response.body[1].total_despesas);
                    // if( this.totalDespesas == null ) this.totalDespesas = 0;

                    this.semMovimentacoes = !this.totalReceitas && !this.totalDespesas;

                    this.montarGraficoBarra();

                    if(!this.semMovimentacoes){
                        this.$http.get(`/api/getTotaisCategorias?first=${firstDay}&last=${lastDay}`).then(response => {
                            this.totalCategoriasReceitas = response.body[0];
                            this.totalCategoriasDespesas = response.body[1];

                            this.montarGraficoPizzaReceitas(this.totalCategoriasReceitas);
                            this.montarGraficoPizzaDespesas(this.totalCategoriasDespesas);
                        }, err => {
                            console.log('err: ');
                        });
                    }
                }, err => {
                    console.log('err: ');
                });
            },

            montarGraficoBarra(){               
                const labels = ['Total Receitas','Total Despesas'];
                const data = {
                    labels: labels,
                    datasets: [{
                        label: 'Total Receitas',
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        data: [this.totalReceitas, this.totalDespesas],
                        backgroundColor: [
                            '#00800087',
                            '#ff000087'
                        ],
                        borderColor: [
                            'green',
                            'red'
                        ],
                        borderWidth: 1,
                        hoverOffset: 4
                    }]
                };
                const config = {
                    type: 'bar',
                    data: data,
                    options: {}
                };
                
                if(this.primeiroCarregamentoBar){
                    this.barChart = new Chart(
                        document.getElementById('barChart'),config
                    );
                    this.primeiroCarregamentoBar = false;
                }else{
                    this.barChart.data.datasets[0].data[0] = this.totalReceitas;
                    this.barChart.data.datasets[0].data[1] = this.totalDespesas;
                    this.barChart.update();
                }
            },

            montarGraficoPizzaReceitas(totalCategoriasReceitas){
                const labels = totalCategoriasReceitas.map(categoria => categoria.descricao);
                const valores = totalCategoriasReceitas.map(categoria => funcoes.formatarValorGraficos(categoria.soma));

                const data = {
                    labels: labels,
                    datasets: [{
                        label: 'My First Dataset',
                        data: valores,
                        backgroundColor: [
                        '#009900',
                        '#00CC00',
                        '#00FF00',
                        '#33FF33',
                        '#66FF66',
                        '#99FF99',
                        ],
                        hoverOffset: 4
                    }]
                };
                const config = {
                    type: 'doughnut',
                    data: data,
                };
                
                if(this.primeiroCarregamentoReceitas){
                    this.categoriaReceitasChart = new Chart(
                        document.getElementById('categoriaReceitasChart'),config
                    );
                    this.primeiroCarregamentoReceitas = false;
                }else{
                    this.categoriaReceitasChart.data.labels = labels;
                    this.categoriaReceitasChart.data.datasets[0].data = valores;
                    this.categoriaReceitasChart.update();
                }
            },

            montarGraficoPizzaDespesas(totalCategoriasDespesas){
                const labels = totalCategoriasDespesas.map(categoria => categoria.descricao);
                const valores = totalCategoriasDespesas.map(categoria => funcoes.formatarValorGraficos(categoria.soma));

                const data = {
                    labels: labels,
                    datasets: [{
                        label: 'My First Dataset',
                        data: valores,
                        backgroundColor: [
                        '#990000',
                        '#CC0000',
                        '#FF0000',
                        '#FF3333',
                        '#FF6666',
                        '#FF9999',
                        ],
                        hoverOffset: 4
                    }]
                };
                const config = {
                    type: 'doughnut',
                    data: data,
                };
                
                if(this.primeiroCarregamentoDespesas){
                    this.categoriaDespesasChart = new Chart(
                        document.getElementById('categoriaDespesasChart'),config
                    );
                    this.primeiroCarregamentoDespesas = false;
                }else{
                    this.categoriaDespesasChart.data.labels = labels;
                    this.categoriaDespesasChart.data.datasets[0].data = valores;
                    this.categoriaDespesasChart.update();
                }
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

            this.datas_receitasObj.forEach(receita =>{
                let data = receita.data.split('-');
                let dataFormatada = data[0]+'-'+data[1];
                if( !this.datas.includes(dataFormatada) ){
                    this.datas.push(dataFormatada);
                }
            });

            this.datas_despesasObj.forEach(despesa =>{
                let data = despesa.data.split('-');
                let dataFormatada = data[0]+'-'+data[1];

                if( !this.datas.includes(dataFormatada) ){
                    this.datas.push(dataFormatada)
                }
            });

            if(!this.datas.includes(mesAtual)) this.datas.unshift(mesAtual);

            localStorage.setItem("datasFormatadas", this.datasFormatadas);
            
            this.datasFormatadas = this.datas.map(data =>{
                return {data: data, descricao: this.retornaNomeMes(data.split('-')[1])+' '+data.split('-')[0]}
            })

            this.dataSelecionada = mesAtual;

            this.getTotais(mesAtual);

        }
    }
</script>

<style lang="scss">
    .componente-home{
        max-width: 1200px;
        margin: 0 auto;

        .cabecalho{
            display: flex;
            flex-direction: column;
            align-items: center;

            margin: 50px 0 10px 0;

            @media(min-width: 768px){
                flex-direction: row;
                justify-content: space-between;
            }

            .datas{
                width: 200px;

                @media(max-width: 767px){
                    margin-top: 20px;
                }

                select{
                    border-top: none;
                    border-left: none;
                    border-right: none;
                    border-radius: 0px;

                    &:focus{
                        border-color: transparent;
                        outline: none;
                        box-shadow: none;
                    }
                }
            }
        }
        
        .saldoTotal{
            margin-bottom: 30px;
            
            text-align: center;
            font-size: 30px;
            font-weight: bold;
            color: #444;

            small{
                font-size: 15px;
            }
        }

        .totais{
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-column-gap: 10px;
            
            .total{
                height: 100px;
                background-color: #eee;
                box-shadow: 3px 3px 5px #aaa;
                border-radius: 5px;

                display: flex;
                justify-content: center;
                align-items: center;
            }
        }

        .grafico-barras{
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            width: 100%;

            @media(min-width: 992px){
                grid-template-columns: repeat(2, 1fr);
                grid-column-gap: 30px;
            }

            .infos{
                padding: 30px 20px;
                display: flex;
                flex-direction: column;
                justify-content: space-around;
                box-shadow: 0 0 10px #ddd;
                border-radius: 5px;

                @media(min-width: 768px){
                    flex-direction: row;
                }
                @media(min-width: 992px){
                    flex-direction: column;
                }
                

                .total{
                    display: flex;
                    justify-content: center;

                    img{
                        width: 50px;
                        height: 50px;

                        margin-right: 20px;
                    }
                    span{
                        font-size: 24px;
                        font-weight: bold;
                        color: #444;
                    }
                }
            }

            .grafico{
                position: relative;
                margin: 0 auto;

                box-shadow: 0 0 10px #ddd;
                border-radius: 5px;

                @media(min-width: 992px){
                    width: 486px;
                    padding: 20px;
                }

                .semInfos{
                    position: absolute;
                    top: 0;
                    left: 0;

                    width: 100%;
                    height: 100%;

                    display: flex;
                    justify-content: center;
                    align-items: center;

                    backdrop-filter: blur(3px);
                    color: black;
                    font-size: 18px;
                }
            }
        }

        .grafico-pizza{
            margin-bottom: 50px;
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            width: 100%;

            @media(min-width: 992px){
                grid-template-columns: repeat(2, 1fr);
            }

            .tipo{
                width: 300px;
                margin: 50px auto 0 auto;
                .descricao{
                    font-weight: bold;
                    font-size: 24px;
                    text-align: center;
                    color: #444;
                }
            }
        }
    }
</style>
