<template>
    <div class="componente-receita-form">
        <div class="descricao">
            Aqui você poderá cadastrar todas as suas receitas.
        </div>
        <form v-bind:action="action" v-bind:method="method">
            <slot name="method"></slot>
            <input type="hidden" name="_token" v-bind:value="token">
            <div class="form-group">
                <label>Descrição</label>
                <input class="form-control" type="text" name="descricao" v-bind:value="receitaObj.descricao">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status" v-bind:value="receitaObj.status">
                    <option value="pago">Pago</option>
                    <option value="nao-pago">Não Pago</option>
                </select>
            </div>
            <div class="form-group">
                <label>Data</label>
                <input class="form-control" type="date" name="data" v-bind:value="receitaObj.data">
            </div>
            <div class="form-group">
                <label>Receita Fixa?</label>
                <select class="form-control" name="fixa" v-bind:value="receitaObj.receita_fixa">
                    <option value="sim">Sim</option>
                    <option value="nao">Não</option>
                </select>
            </div>
            <div class="form-group">
                <label>Conta</label>
                <select class="form-control" name="conta">
                    <option v-bind:value="conta.id" v-for="conta in contasObj">{{conta.descricao}}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Categorias</label>
                <select class="form-control" name="categoria">
                    <option v-bind:value="categoria.id" v-for="categoria in categoriasObj">{{categoria.descricao}}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Observação</label>
                <textarea class="form-control" type="observacao" rows="5" name="observacao" v-bind:value="receitaObj.observacao"></textarea>
            </div>
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

        mounted(){
            this.receitaObj = JSON.parse(this.receita);
            console.log(this.receitaObj.data);
        }
    }
</script>

<style lang="scss">
</style>
