<template>
    <div class="componente-listagem-tabela">
        <div class="filtro">
            <select class="form-control" v-model="filtroSelecionado" v-on:change="selecionarFiltro(filtroSelecionado)">
                <option value="Todos">Todos</option>
                <option value="Receitas">Receitas</option>
                <option value="Despesas">Despesas</option>
            </select>
        </div>
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
                todasCategorias: [],
                visible: false,
                item: '',
                filtroSelecionado: 'Todos'
            }
        },
        methods: {
            abrirModal() {
                this.visible = true;
            },
            selecionarFiltro(){
                switch(this.filtroSelecionado){
                    case 'Todos':
                        this.list = this.todasCategorias;
                    break;
                    case 'Receitas':
                        this.list = this.todasCategorias.filter(categoria => categoria.tipo == 'Receita');
                    break;
                    case 'Despesas':
                        this.list = this.todasCategorias.filter(categoria => categoria.tipo == 'Despesa');
                    break;
                }
            }
        },
        mounted(){
            this.list = JSON.parse(this.infos);
            this.todasCategorias = JSON.parse(this.infos);
        }
    }
</script>
<style lang="scss">
    .componente-listagem-tabela{
        position: relative;

        .filtro{
            position: absolute;
            top: -67px;
            right: 0;
            width: 130px;

            @media(min-width: 768px){
                top: -65px;
                margin-top: 0px;
                width: 200px;
            }

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
