<template>
    <div class="componente-listagem-tabela">
        <select class="form-control select-categorias" v-model="mostrarCategorias">
            <option value="0">Ativas</option>
            <option value="1">Arquivadas</option>
        </select>
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
                    <th scope="col" width="50px" style="text-align: center;" v-if="mostrarCategorias == 0">Editar</th>
                    <th scope="col" width="50px" style="text-align: center;" v-if="mostrarCategorias == 0">Arquivar</th>
                    <th scope="col" width="50px" style="text-align: center;" v-if="mostrarCategorias == 1">Reativar</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="i in list" v-bind:key="i.id" v-if="i.arquivado == mostrarCategorias">
                    <td>{{i.descricao}}</td>
                    <td>{{i.tipo}}</td>
                    <td style="text-align: center;" v-if="mostrarCategorias == 0"> <a v-bind:href="'/'+model+'/'+i.id+'/edit'" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt" style="color:white"></i></a> </td>
                    <td style="text-align: center;" v-if="mostrarCategorias == 0"> 
                        <form v-bind:action="'/'+model+'/'+i.id" method="POST">
                            <slot name="method"></slot>
                            <button type="submit" class="btn btn-danger btn-sm"><i class="far fa-folder-open"></i></button>
                        </form>
                    </td>
                    <td style="text-align: center;" v-if="mostrarCategorias == 1">
                        <buttom class="btn btn-success btn-sm" v-on:click="reativarCategoria(i.id)"><i class="far fa-folder"></i></buttom>
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
                filtroSelecionado: 'Todos',
                mostrarCategorias: 0
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
            },
            reativarCategoria(id){
                this.$http.get(`/api/reativarCategoria?idCategoria=${id}`).then(() => {
                   window.location.reload();
                }, err => {
                    console.log('err: ');
                });
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

        .select-categorias{
            position: absolute;
            top: -30px;
            right: 0px;
            width: 130px;
            
            border-top: none;
            border-left: none;
            border-right: none;
            border-radius: 0px;

            height: 30px;
            padding: 0.375rem 0.75rem;

            @media(min-width: 768px){
                width: 200px;
                top: -59px;
                right: 220px;
            }

            &:focus{
                border-color: transparent;
                outline: none;
                box-shadow: none;
            }
        }

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
