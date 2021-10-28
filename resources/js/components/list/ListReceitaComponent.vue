<template>
    <div class="componente-listagem-tabela">
        <div class="datas">
            <select class="form-control" name="data" v-model="dataSelecionada" v-on:change="mostrarReceitas(dataSelecionada)">
                <option v-bind:key="data.data" v-bind:value="data.data" v-for="data in datasFormatadas">{{data.descricao}}</option>
            </select>
        </div>
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Valor</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Conta</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Data</th>
                    <th scope="col">Status</th>
                    <th scope="col" width="50px">Editar</th>
                    <th scope="col" width="50px">Excluir</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="i in receitas" v-bind:key="i.id">
                    <td>R$ {{formatPrice(i.valor)}}</td>
                    <td>{{i.descricao}}</td>
                    <td>{{i.conta}}</td>
                    <td>{{i.categoria}}</td>
                    <td>{{i.data}}</td>
                    <td>{{i.status == 'pago' ? 'Recebido' : 'Não Recebido'}}</td>
                    <td style="text-align: center;"> <a v-bind:href="'/'+model+'/'+i.id+'/edit'" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></a> </td>
                    <td style="text-align: center;"> 
                        <form v-bind:action="'/'+model+'/'+i.id" method="POST">
                            <slot name="method"></slot>
                            <button type="submit" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>

        <modal-exclusao-component v-if="visible"></modal-exclusao-component>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        props : [
            'datas_receitas',
            'infos',
            'model'
        ],

        data(){
            return {
                datas_receitasObj: {},
                list: [],
                receitas: [],
                datas: [],
                datasFormatadas: [],
                visible: false,
                item: '',
                dataSelecionada: ''
            }
        },
        methods: {
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            abrirModal() {
                this.visible = true;
            },
            mostrarReceitas(mesSelecionado){
                this.receitas = this.list.filter(receita =>{
                    let dataArray = receita.data.split('-');
                    dataArray.pop();
                    let data = dataArray.join('-')
                    
                    if(data == mesSelecionado) return receita;
                })

                this.receitas.forEach(receita => receita.data = moment(receita.data).format('DD/MM/YYYY'));
                console.log('sss', this.receitas)
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
        mounted(){
            this.list = JSON.parse(this.infos);
            this.datas_receitasObj = JSON.parse(this.datas_receitas);

            this.datas_receitasObj.forEach(receita =>{
                let data = receita.data.split('-');
                let dataFormatada = data[0]+'-'+data[1];
                if( !this.datas.includes(dataFormatada) ){
                    this.datas.push(dataFormatada);
                }
            });
            
            this.datasFormatadas = this.datas.map(data =>{
                return {data: data, descricao: this.retornaNomeMes(data.split('-')[1])+' '+data.split('-')[0]}
            })

            const mesAtual = moment().format('YYYY-MM');
            this.dataSelecionada = mesAtual;

            this.mostrarReceitas(mesAtual);
        }
    }
</script>
<style lang="scss">
   .componente-listagem-tabela{
        position: relative;

        .datas{
            width: 200px;
            float: right;
            margin-bottom: 30px;
            margin-top: -70px;

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
</style>
