<template>
    <div class="componente-listagem-despesa">
        <div class="datas">
            <div class="d-print-block" style="display:none">
                Referente à {{this.retornaNomeMes(dataSelecionada.split('-')[1])+' '+dataSelecionada.split('-')[0]}}
            </div>
            <select class="form-control d-print-none" name="data" v-model="dataSelecionada" v-on:change="mostrarDespesas(dataSelecionada)">
                <option v-bind:key="data.data" v-bind:value="data.data" v-for="data in datasFormatadas">{{data.descricao}}</option>
            </select>
            <button class="btn btn-secondary btn-sm d-print-none" onclick="window.print()">
                <i class="fas fa-print"></i>
            </button>
        </div>
        <table v-bind:class="dispositivo == 'desktop' ? 'table' : 'table table-responsive'" v-if="despesas.length">
            <thead class="thead-light">
                <tr>
                    <th scope="col" v-on:click="ordenar('valor')"> Valor <i v-if="ordenacaoSelecionada == 'valor'" class="fas fa-sort-down"></i></th>
                    <th scope="col" v-on:click="ordenar('descricao')"> Descrição <i v-if="ordenacaoSelecionada == 'descricao'" class="fas fa-sort-down"></i></th>
                    <th scope="col" v-on:click="ordenar('conta')"> Conta <i v-if="ordenacaoSelecionada == 'conta'" class="fas fa-sort-down"></i></th>
                    <th scope="col" v-on:click="ordenar('categoria')"> Categoria <i v-if="ordenacaoSelecionada == 'categoria'" class="fas fa-sort-down"></i></th>
                    <th scope="col" v-on:click="ordenar('data')"> Data <i v-if="ordenacaoSelecionada == 'data'" class="fas fa-sort-down"></i></th>
                    <th scope="col" v-on:click="ordenar('status')"> Status <i v-if="ordenacaoSelecionada == 'status'" class="fas fa-sort-down"></i></th>
                    <th scope="col" width="50px" style="text-align: center;" class="d-print-none">Editar</th>
                    <th scope="col" width="50px" style="text-align: center;" class="d-print-none">Excluir</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(i, index) in despesas" v-bind:key="i.id">
                    <td>R$ {{formatPrice(i.valor)}}</td>
                    <td>{{i.descricao}}</td>
                    <td>{{i.conta}}</td>
                    <td>{{i.categoria}}</td>
                    <td>{{formatDate(i.data)}}</td>
                    <td>{{i.status == 'pago' ? 'Pago' : 'Não Pago'}}</td>
                    <td style="text-align: center;" class="d-print-none"> <a v-bind:href="'/'+model+'/'+i.id+'/edit'" class="btn btn-primary btn-sm" style="padding: 6px; line-height: 1;"><i class="fas fa-pencil-alt"></i></a> </td>
                    <td style="text-align: center;" class="d-print-none"> 
                        <form>
                            <!-- <slot name="method"></slot> -->
                            <button type="button" class="btn btn-danger btn-sm" v-on:click="excluirDespesa(i.id, index)" style="padding: 6px; line-height: 1;"><i class="far fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>

        <lista-vazia-component v-if="!despesas.length"></lista-vazia-component>

        <modal-exclusao-component v-if="visible"></modal-exclusao-component>
    </div>
</template>

<script>
    import moment from 'moment';
    import swal from 'sweetalert';
    import funcoes from "../../funcoes"
    
    export default {
        props : [
            'datas_despesas',
            'infos',
            'model'
        ],

        data(){
            return {
                datas_despesasObj: {},
                list: [],
                despesas: [],
                datas: [],
                datasFormatadas: [],
                visible: false,
                item: '',
                dataSelecionada: '',
                ordenacaoSelecionada: 'data',
                dispositivo: 'desktop'
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
            excluirDespesa(id, index){
                swal({
                title: "Deseja realmente excluir essa despesa?",
                text: "Essa ação é irreversível!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        axios.post(`/despesas/delete/${id}`).then(response => {
                            this.despesas.splice(index, 1);
                            this.list.forEach((item, indexItem) =>{
                                if(item.id == id){
                                    this.list.splice(indexItem, 1);
                                }
                            })
                            swal("Despesa deletada com sucesso!", {
                            icon: "success",
                            });
                        },err =>{
                            console.log('err', err);
                            swal("Algo de errado aconteceu...", {
                            icon: "warning",
                            });
                        });
                    }
                });
            },
            mostrarDespesas(mesSelecionado){
                this.despesas = this.list.filter(despesa =>{
                    let dataArray = despesa.data.split('-');
                    dataArray.pop();
                    let data = dataArray.join('-')
                    
                    if(data == mesSelecionado) return despesa;
                })
            },
            ordenar(ordem){
                this.ordenacaoSelecionada = ordem;
                this.despesas.sort(function(a, b) {
                    return a[ordem].toString().localeCompare(b[ordem].toString())
                });
            },
            verificarDispositivo(){
                if (screen.width < 640 || screen.height < 480) {
                    this.dispositivo = 'mobile';
                }else{
                    this.dispositivo = 'desktop';
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
        mounted(){
            const mesAtual = moment().format('YYYY-MM');

            this.list = JSON.parse(this.infos);
            this.datas_despesasObj = JSON.parse(this.datas_despesas);

            this.datas_despesasObj.forEach(despesa =>{
                let data = despesa.data.split('-');
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

            this.mostrarDespesas(mesAtual);
            this.ordenar('data');
            this.verificarDispositivo();
        }
    }
</script>
<style lang="scss">
   .componente-listagem-despesa{
        position: relative;

        .datas{
            position: absolute;
            right: 50px;
            width: 200px;
            margin-bottom: 30px;
            margin-top: -35px;

            display: grid;
            grid-template-columns: auto auto;

            @media(min-width: 768px){
                margin-top: -70px;
            }

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

                height: 30px;
                padding: 5px;

                &:focus{
                    border-color: transparent;
                    outline: none;
                    box-shadow: none;
                }
            }
        }
   }

   @media(max-width: 767px){
        td, th{
            padding: 5px 10px;
            white-space: nowrap
        }
    } 
</style>
