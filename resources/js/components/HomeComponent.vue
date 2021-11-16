<template>
    <div class="componente-home">
        <h1>Dashboard</h1>

        <div class="saldoTotal">
            <small>Saldo em Contas</small><br>
            R$ {{formatPrice(saldo_total)}}
        </div>
        <div class="datas">
            <select class="form-control" name="data" v-model="dataSelecionada" v-on:change="getTotais(dataSelecionada)">
                <option v-bind:key="data.data" v-bind:value="data.data" v-for="data in datasFormatadas">{{data.descricao}}</option>
            </select>
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
            <div class="grafico">
                <canvas id="barChart"></canvas>
            </div>
        </div>
        <div class="grafico-pizza">
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
    </div>
</template>

<script>
    import moment from 'moment';
    
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
                dataSelecionada: ''
            }
        },

        created(){
            this.datas_receitasObj = JSON.parse(this.datas_receitas);
            this.datas_despesasObj = JSON.parse(this.datas_despesas);
            
        },

        methods:{
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },

            getTotais(dataSelecionada){
                const firstDay = dataSelecionada+'-01';
                const lastDay = dataSelecionada+'-31';

                this.$http.get(`/api/teste?first=${firstDay}&last=${lastDay}`).then(response => {
                   
                    this.totalReceitas = response.body[0].total_receitas;
                    this.totalDespesas = response.body[1].total_despesas;

                    this.montarGraficoBarra();
                    this.montarGraficoPizzaReceitas();
                    this.montarGraficoPizzaDespesas();
                }, err => {
                    console.log('err: ');
                });
            },

            montarGraficoBarra(){
                console.log('teste', this.totalReceitas)
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
                var barChart = new Chart(
                    document.getElementById('barChart'),config
                );
            },

            montarGraficoPizzaReceitas(){
                const data = {
                    labels: [
                        'Red',
                        'Blue',
                        'Yellow'
                    ],
                    datasets: [{
                        label: 'My First Dataset',
                        data: [300, 50, 100],
                        backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                        ],
                        hoverOffset: 4
                    }]
                };
                const config = {
                    type: 'doughnut',
                    data: data,
                };
                var categoriaReceitasChart = new Chart(
                    document.getElementById('categoriaReceitasChart'),config
                );
            },

            montarGraficoPizzaDespesas(){
                const data = {
                    labels: [
                        'green',
                        'black',
                        'purple'
                    ],
                    datasets: [{
                        label: 'My First Dataset',
                        data: [300, 50, 100],
                        backgroundColor: [
                        'green',
                        'black',
                        'purple'
                        ],
                        hoverOffset: 4
                    }]
                };
                const config = {
                    type: 'doughnut',
                    data: data,
                };
                
                var categoriaDespesasChart = new Chart(
                    document.getElementById('categoriaDespesasChart'),config
                );
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

        h1{
            margin: 50px 0 10px 0;
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
        .datas{
            width: 200px;
            margin: 0 auto 40px;

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
            }

            .infos{
                padding: 30px 20px;
                display: flex;
                flex-direction: column;
                justify-content: space-around;

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
                margin: 0 auto;

                @media(min-width: 992px){
                    width: 500px;
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
