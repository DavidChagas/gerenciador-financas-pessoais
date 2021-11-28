<template>
    <div class="componente-listagem-conta">
        <table class="table" v-if="list.length">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Descrição</th>
                    <th scope="col">Valor</th>
                    <th scope="col" width="50px" style="text-align: center;">Editar</th>
                    <th scope="col" width="50px" style="text-align: center;">Excluir</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="i in list" v-bind:key="i.id">
                    <td>{{i.descricao}}</td>
                    <td>{{formatPrice(i.valor)}}</td>
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

        <lista-vazia-component v-if="!list.length"></lista-vazia-component>

        <modal-exclusao-component v-if="visible"></modal-exclusao-component>
    </div>
</template>

<script>
    import funcoes from "../../funcoes"

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
                return funcoes.formatPrice(value);
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
   }
</style>
