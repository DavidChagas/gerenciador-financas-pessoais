<template>
    <div class="componente-home">
        <h1>Dashboard</h1>

        <div class="datas">
            <select class="form-control" name="data">
                <option v-bind:value="data.data" v-for="data in datasFormatadas">{{data.descricao}}</option>
            </select>
        </div>
        <div class="img-desenvolvimento">
            <img src="/images/construcao.jpg">
            <div class="desenvolvimento">
                Em desenvolvimento

                {{datas}}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props : [
            'datas_receitas',
            'datas_despesas'
        ],

        data(){
            return {
                datas_receitasObj: {},
                datas_despesasObj: {},
                datas: []
            }
        },

        created(){
            this.datas_receitasObj = JSON.parse(this.datas_receitas);
            this.datas_despesasObj = JSON.parse(this.datas_despesas);
            
        },

        methods:{
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
        }
    }
</script>

<style lang="scss">
    .componente-home{
        h1{
            margin: 50px 0 100px 0;
        }
        .img-desenvolvimento{
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

            img{
                width: 420px;
            }

            .desenvolvimento{
                font-size: 20px;
                color: #aaa;
            }
        }
    }
</style>
