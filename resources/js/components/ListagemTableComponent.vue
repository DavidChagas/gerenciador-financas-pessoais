<template>
    <div class="componente-listagem-tabela">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Descrição</th>
                    <th scope="col" width="100px"></th>
                    <th scope="col" width="100px"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="i in list">
                    <td>{{i.descricao}}</td>
                    <td> <a v-bind:href="'/contas/'+i.id+'/edit'" class="btn btn-info btn-sm">Editar</a> </td>
                    <td> <button class="btn btn-danger btn-sm" v-on:click="abrirModal('sss')">Excluir</button> </td>
                </tr>
            </tbody>
        </table>

        <modal-exclusao-component v-if="visible"></modal-exclusao-component>
    </div>
</template>

<script>
    export default {
        props : [
            'infos'
        ],

        data(){
            return {
                list: [],
                visible: false,
                item: ''
            }
        },

        methods: {
            abrirModal(item) {
                this.visible = true;
                console.log('itemm'. item)
            }
        },

        mounted(){
            this.list = JSON.parse(this.infos);
        }
    }
</script>
<style lang="scss">
   .componente-listagem-tabela{
    position: relative;
   }
</style>
