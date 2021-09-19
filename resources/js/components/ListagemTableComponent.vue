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
<template>
    <div class="componente-listagem-tabela">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Descrição</th>
                    <th scope="col" width="100px">Editar</th>
                    <th scope="col" width="100px">Excluir</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="i in list">
                    <td>{{i.descricao}}</td>
                    <td>edi</td>
                    <td>X</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<style lang="scss">
   
</style>
