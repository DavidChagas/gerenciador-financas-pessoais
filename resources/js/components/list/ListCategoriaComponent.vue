<template>
    <div class="componente-listagem-tabela">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Descrição</th>
                    <th scope="col">Tipo</th>
                    <th scope="col" width="100px"></th>
                    <th scope="col" width="100px"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="i in list" v-bind:key="i.id">
                    <td>{{i.descricao}}</td>
                    <td>{{i.tipo}}</td>
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
   .componente-listagem-tabela{
    position: relative;
   }
</style>
