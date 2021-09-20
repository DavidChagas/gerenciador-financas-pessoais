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
                    <td> <a href="" class="btn btn-danger btn-sm">Excluir</a> </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props : [
            'infos'
        ],

        data(){
            return {
                list: []
            }
        },

        mounted(){
            this.list = JSON.parse(this.infos)
        }
    }
</script>
<style lang="scss">
   
</style>
