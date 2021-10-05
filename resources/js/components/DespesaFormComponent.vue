<template>
    <div class="componente-despesa-form">
        <div class="descricao">
            Aqui você poderá cadastrar todas as suas despesas.
        </div>
        <form v-bind:action="action" v-bind:method="method">
            <slot name="method"></slot>
            <input type="hidden" name="_token" v-bind:value="token">

            <div class="row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Valor</label>
                        <input class="form-control" type="text" name="valor" v-bind:value="despesaObj.valor">
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Descrição</label>
                        <input class="form-control" type="text" name="descricao" v-bind:value="despesaObj.descricao">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status" v-bind:value="despesaObj.status">
                            <option value="pago">Pago</option>
                            <option value="nao-pago">Não Pago</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Data</label>
                        <input class="form-control" type="date" name="data" v-bind:value="despesaObj.data">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Despesa Fixa?</label>
                        <select class="form-control" name="fixa" v-bind:value="despesaObj.despesa_fixa">
                            <option value="sim">Sim</option>
                            <option value="nao">Não</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Conta</label>
                        <select class="form-control" name="conta">
                            <option v-bind:value="conta.id" v-for="conta in contasObj">{{conta.descricao}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Categorias</label>
                        <select class="form-control" name="categoria">
                            <option v-bind:value="categoria.id" v-for="categoria in categoriasObj">{{categoria.descricao}}</option>
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
            <button class="btn btn-danger" type="button" v-on:click="voltar()">Voltar</button>
            <button class="btn btn-primary" type="submit">Cadastrar</button>
        </form>
    </div>
</template>

<script>
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
            }
        },

        mounted(){
            this.despesaObj = JSON.parse(this.despesa);
            console.log(this.despesaObj.data);
        }
    }
</script>

<style lang="scss">
</style>
