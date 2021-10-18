<template>
    <div class="componente-listagem-tabela">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Valor</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Conta</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Status</th>
                    <th scope="col" width="50px">Editar</th>
                    <th scope="col" width="50px">Excluir</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="i in list">
                    <td>R$ {{formatPrice(i.valor)}}</td>
                    <td>{{i.descricao}}</td>
                    <td>{{i.conta}}</td>
                    <td>{{i.categoria}}</td>
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
    export default {
        props : [
            'infos',
            'model'
        ],

        data(){
            return {
                list: [],
                visible: false,
                item: ''
            }
        },
        methods: {
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            abrirModal() {
                this.visible = true;
            }
        },
        mounted(){
            this.list = JSON.parse(this.infos);
            console.log(this.list)
        }
    }
</script>
<style lang="scss">
   .componente-listagem-tabela{
    position: relative;
   }
</style>
