<template>
    <div class="componente-home">
        <h1>Dashboard</h1>

        <div class="datas">
            <select class="form-control" name="data">
                <option v-bind:value="data.data" v-for="data in datasFormatadas">{{data.descricao}}</option>
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
            'datas_despesas'
        ],

        data(){
            return {
                datas_receitasObj: {},
                datas_despesasObj: {},
                datas: [],
                datasFormatadas: [],
                totalReceitas: '',
                totalDespesas: ''
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

            getTotais(firstDay, lastDay){
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
                let dataFormatada = data[1]+'-'+data[0];
                if( !this.datas.includes(dataFormatada) ){
                    this.datas.push(dataFormatada);
                }
            });

            this.datas_despesasObj.forEach(despesa =>{
                let data = despesa.data.split('-');
                let dataFormatada = data[1]+'-'+data[0];

                if( !this.datas.includes(dataFormatada) ){
                    this.datas.push(dataFormatada)
                }
            });
            
            this.datasFormatadas = this.datas.map(data =>{
                return {data: data, descricao: this.retornaNomeMes(data.split('-')[0])+' '+data.split('-')[1]}
            })

            const firstDay = moment().startOf('month').format('YYYY-MM-DD');
            const lastDay   = moment().endOf('month').format('YYYY-MM-DD');

            this.getTotais(firstDay, lastDay);
        }
    }
</script>

<style lang="scss">
    .componente-home{
        h1{
            margin: 50px 0 100px 0;
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
