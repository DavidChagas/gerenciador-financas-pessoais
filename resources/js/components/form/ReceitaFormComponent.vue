<template>
    <div class="componente-receita-form">
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
                        <input class="form-control" type="text" name="valor" v-model="receitaObj.valor" @blur="formatarValor" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Descrição</label>
                        <input class="form-control" type="text" name="descricao" v-model="receitaObj.descricao" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status" v-model="receitaObj.status" required>
                            <option value="pago">Pago</option>
                            <option value="nao-pago">Não Pago</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Conta</label>
                        <select class="form-control" name="conta" v-model="receitaObj.conta_id" required>
                            <option v-bind:value="conta.id" v-for="conta in contasObj" v-bind:key="conta.id">{{conta.descricao}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Categorias</label>
                        <select class="form-control" name="categoria" v-model="receitaObj.categoria_id" required>
                            <option v-bind:value="categoria.id" v-for="categoria in categoriasObj" v-bind:key="categoria.id">{{categoria.descricao}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Data</label>
                        <input class="form-control" type="date" name="data" v-model="receitaObj.data" required>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Observação</label>
                        <textarea class="form-control" type="observacao" rows="5" name="observacao" v-model="receitaObj.observacao"></textarea>
                    </div>
                </div>
            </div>
            <div class="row" v-if="!receitaObj.id">
                <div class="col-sm-12">
                    <div class="painel-receita-fixa">
                        <div class="descricao">Ao informar que é uma receita fixa será cadastrado automaticamente durante a quantidade de meses informadas essa receita.<br>
                        <b>Atenção</b>, após cadastrar um receita fixa só será possível editar as receitas individualmente.
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Receita fixa?</label>
                                    <select class="form-control" name="fixa" v-model="receitaFixa" required>
                                        <option value="sim">Sim</option>
                                        <option value="nao">Não</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Quantidade de meses</label>
                                    <input class="form-control" type="number" name="qtd_meses" min="0" max="12" :disabled="receitaFixa == 'nao'">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    
            </div>
            <button class="btn btn-secondary" type="button" v-on:click="voltar()">Voltar</button>
            <button class="btn btn-success" type="submit">{{receitaObj.id ? 'Editar' : 'Cadastrar'}}</button>
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
            'receita',
            'contas',
            'categoriasReceita'
        ],

        data(){
            return {
                receitaObj: {},
                contasObj: [],
                categoriasObj: [],
                receitaFixa: 'nao'
            }
        },

        created(){
            this.contasObj = JSON.parse(this.contas);
            this.categoriasObj = JSON.parse(this.categoriasReceita);
        },

        methods:{
            voltar(){
                window.history.back();
            },
            formatarValor() {
                this.receitaObj.valor = funcoes.formatarValorInput(this.receitaObj.valor);
            }
        },

        mounted(){
            this.receitaObj = JSON.parse(this.receita);        
        }
    }
</script>

<style lang="scss">
    .componente-receita-form{
        .painel-receita-fixa{
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
