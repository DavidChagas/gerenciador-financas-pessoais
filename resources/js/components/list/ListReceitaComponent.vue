<template>
    <div class="componente-listagem-receita">
        <div class="datas">
            <div class="d-print-block" style="display:none">
                Referente à {{this.retornaNomeMes(dataSelecionada.split('-')[1])+' '+dataSelecionada.split('-')[0]}}
            </div>
            <select class="form-control d-print-none" name="data" v-model="dataSelecionada" v-on:change="mostrarReceitas(dataSelecionada)">
                <option v-bind:key="data.data" v-bind:value="data.data" v-for="data in datasFormatadas">{{data.descricao}}</option>
            </select>
            <button class="btn btn-info d-print-none" onclick="window.print()">
                <i class="fas fa-print"></i>
            </button>
        </div>
        <table class="table" v-if="receitas.length">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Valor</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Conta</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Data</th>
                    <th scope="col">Status</th>
                    <th scope="col" width="50px" class="d-print-none">Editar</th>
                    <th scope="col" width="50px" class="d-print-none">Excluir</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="i in receitas" v-bind:key="i.id">
                    <td>R$ {{formatPrice(i.valor)}}</td>
                    <td>{{i.descricao}}</td>
                    <td>{{i.conta}}</td>
                    <td>{{i.categoria}}</td>
                    <td>{{formatDate(i.data)}}</td>
                    <td>{{i.status == 'pago' ? 'Recebido' : 'Não Recebido'}}</td>
                    <td style="text-align: center;" class="d-print-none"> <a v-bind:href="'/'+model+'/'+i.id+'/edit'" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></a> </td>
                    <td style="text-align: center;" class="d-print-none"> 
                        <form v-bind:action="'/'+model+'/'+i.id" method="POST">
                            <slot name="method"></slot>
                            <button type="submit" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>

        <lista-vazia-component v-if="!receitas.length"></lista-vazia-component>

        <modal-exclusao-component v-if="visible"></modal-exclusao-component>
    </div>
</template>

<script>
    import moment from 'moment';
    import funcoes from "../../funcoes"

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
                return funcoes.formatPrice(value);
            },
            formatDate(value){
                return moment(String(value)).format('DD/MM/YYYY');
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
            const mesAtual = moment().format('YYYY-MM');

            this.list = JSON.parse(this.infos);
            this.datas_receitasObj = JSON.parse(this.datas_receitas);

            this.datas_receitasObj.forEach(receita =>{
                let data = receita.data.split('-');
                let dataFormatada = data[0]+'-'+data[1];
                if( !this.datas.includes(dataFormatada) ){
                    this.datas.push(dataFormatada);
                }
            });

            if(!this.datas.includes(mesAtual)) this.datas.unshift(mesAtual);
            
            this.datasFormatadas = this.datas.map(data =>{
                return {data: data, descricao: this.retornaNomeMes(data.split('-')[1])+' '+data.split('-')[0]}
            })

            this.dataSelecionada = mesAtual;

            this.mostrarReceitas(mesAtual);
        }
    }
</script>
<style lang="scss">
   .componente-listagem-receita{
        position: relative;

        .datas{
            position: absolute;
            right: 50px;
            width: 200px;
            margin-bottom: 30px;
            margin-top: -70px;

            display: grid;
            grid-template-columns: auto auto;

            button{
                margin-left: 10px;
                color: white;
            }

            select{
                width: 200px;
                
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
