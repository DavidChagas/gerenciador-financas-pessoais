<template>
    <div class="componente-home">
        <h1>Dashboard</h1>

        <div class="saldoTotal">
            <small>Saldo em Contas</small><br>
            R${{formatPrice(saldo_total)}}
        </div>
        <div class="datas">
            <select class="form-control" name="data" v-model="dataSelecionada" v-on:change="getTotais(dataSelecionada)">
                <option v-bind:key="data.data" v-bind:value="data.data" v-for="data in datasFormatadas">{{data.descricao}}</option>
            </select>
        </div>
        <div class="totais">
            <div class="total">
                Total de Receitas R${{formatPrice(totalReceitas)}}
            </div>
            <div class="total">
                Total de Despesas R${{formatPrice(totalDespesas)}}
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
            
            this.datasFormatadas = this.datas.map(data =>{
                return {data: data, descricao: this.retornaNomeMes(data.split('-')[1])+' '+data.split('-')[0]}
            })

            const mesAtual = moment().format('YYYY-MM');
            this.dataSelecionada = mesAtual;

            this.getTotais(mesAtual);
        }
    }
</script>

<style lang="scss">
    .componente-home{
        h1{
            margin: 50px 0 50px 0;
        }

        .saldoTotal{
            margin-bottom: 30px;
            
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: #444;
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
    }
</style>
