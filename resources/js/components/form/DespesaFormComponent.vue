<template>
    <div class="componente-despesa-form">
        <div class="descricao">
            <b>Aqui você poderá cadastrar todas as suas receitas.</b>
        </div>
        <form v-bind:action="action" v-bind:method="method" autocomplete="off">
            <slot name="method"></slot>
            <input type="hidden" name="_token" v-model="token">

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Valor</label>
                        <input class="form-control" type="text" name="valor" v-model="despesaObj.valor" @blur="formatarValor" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Descrição</label>
                        <input class="form-control" type="text" name="descricao" v-model="despesaObj.descricao" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status" v-model="despesaObj.status" required>
                            <option value="pago">Pago</option>
                            <option value="nao-pago">Não Pago</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Data</label>
                        <input class="form-control" type="date" name="data" v-model="despesaObj.data" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Conta</label>
                        <select class="form-control" name="conta" required>
                            <option v-bind:value="conta.id" v-for="conta in contasObj" v-bind:key="conta.id">{{conta.descricao}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Categorias</label>
                        <select class="form-control" name="categoria" required>
                            <option v-bind:value="categoria.id" v-for="categoria in categoriasObj" v-bind:key="categoria.id">{{categoria.descricao}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Observação</label>
                        <textarea class="form-control" type="observacao" rows="5" name="observacao" v-bind:value="despesaObj.observacao"></textarea>
                    </div>
                </div>
            </div>
            <div class="row" v-if="!despesaObj.id">
                <div class="col-sm-12">
                    <div class="painel-despesa-fixa">
                        <div class="descricao">Ao informar que é uma despesa fixa será cadastrado automaticamente durante a quantidade de meses informadas essa despesa.<br>
                        <b>Atenção</b>, após cadastrar um despesa fixa só será possível editar as despesas individualmente.
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Despesa fixa?</label>
                                    <select class="form-control" name="fixa" required>
                                        <option value="sim">Sim</option>
                                        <option value="nao">Não</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Quantidade de meses</label>
                                    <input class="form-control" type="number" name="qtd_meses" min="0" max="12">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    
            </div>
            <button class="btn btn-secondary" type="button" v-on:click="voltar()">Voltar</button>
            <button class="btn btn-success" type="submit">{{despesaObj.id ? 'Editar' : 'Cadastrar'}}</button>
        </form>
    </div>
</template>

<script>
    import funcoes from "../../funcoes"

    export default {
        props: [
            'action',
            'method',
            'token',
            'despesa',
            'contas',
            'categoriasDespesa'
        ],

        data(){
            return {
                despesaObj: {},
                contasObj: [],
                categoriasObj: []
            }
        },

        created(){
            this.contasObj = JSON.parse(this.contas);
            this.categoriasObj = JSON.parse(this.categoriasDespesa);
        },

        methods:{
            voltar(){
                window.history.back();
            },
            formatarValor() {
                this.despesaObj.valor = funcoes.formatarValorInput(this.despesaObj.valor);
            }
        },

        mounted(){
            this.despesaObj = JSON.parse(this.despesa);
        }
    }
</script>

<style lang="scss">
    .componente-despesa-form{
        .painel-despesa-fixa{
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: whitesmoke;
            border-radius: 5px;

            .descricao{
                margin-bottom: 10px;
                font-size: 12px;
            }
        }
    }
</style>
