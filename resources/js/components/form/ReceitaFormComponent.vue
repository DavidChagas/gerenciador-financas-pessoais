<template>
    <div class="componente-receita-form">
        <div class="descricao">
            <b>Aqui você poderá cadastrar todas as suas receitas.</b>
        </div>
        <form v-bind:action="action" v-bind:method="method" autocomplete="off">
            <slot name="method"></slot>
            <input type="hidden" name="_token" v-model="token">

            <div class="row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Valor</label>
                        <input class="form-control" type="text" name="valor" v-model="receitaObj.valor" @blur="formatarValor" required>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Descrição</label>
                        <input class="form-control" type="text" name="descricao" v-model="receitaObj.descricao" required>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status" v-model="receitaObj.status" required>
                            <option value="pago">Pago</option>
                            <option value="nao-pago">Não Pago</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Data</label>
                        <input class="form-control" type="date" name="data" v-model="receitaObj.data" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Receita Fixa?</label>
                        <select class="form-control" name="fixa" v-model="receitaObj.receita_fixa" required>
                            <option value="sim">Sim</option>
                            <option value="nao">Não</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Conta</label>
                        <select class="form-control" name="conta" required>
                            <option v-bind:value="conta.id" v-for="conta in contasObj" v-bind:key="conta.id">{{conta.descricao}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
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
                        <textarea class="form-control" type="observacao" rows="5" name="observacao" v-model="receitaObj.observacao"></textarea>
                    </div>
                </div>
            </div>
            <button class="btn btn-danger" type="button" v-on:click="voltar()">Voltar</button>
            <button class="btn btn-primary" type="submit">{{receitaObj.id ? 'Editar' : 'Cadastrar'}}</button>
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
                categoriasObj: []
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
</style>
