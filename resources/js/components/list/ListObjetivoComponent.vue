<template>
    <div class="componente-listagem-conta">
        <table class="table" v-if="list.length">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Data Final</th>
                    <th scope="col" width="100px"></th>
                    <th scope="col" width="100px"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="i in list">
                    <td>{{i.nome}}</td>
                    <td>{{formatPrice(i.valor)}}</td>
                    <td>{{i.data_final}}</td>
                    <td> <a v-bind:href="'/'+model+'/'+i.id+'/edit'" class="btn btn-info btn-sm">Editar</a> </td>
                    <td> 
                        <form v-bind:action="'/'+model+'/'+i.id" method="POST">
                            <slot name="method"></slot>
                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="lista-vazia" v-if="!list.length">
            Ainda não existe objetivos cadastrados :(
        </div>

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
        }
    }
</script>
<style lang="scss">
   .componente-listagem-conta{
        position: relative;

        .lista-vazia{
            margin: 20px 0;
            padding: 50px 0;
            text-align: center;
            
            background-color: #eee;
            border: 2px solid #ddd;
            border-radius: 5px;

            font-size: 20px;
            color: #444;
        }
   }
</style>
