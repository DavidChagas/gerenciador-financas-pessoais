<template>
    <div class="componente-categoria-form">
        <div class="descricao">
            <b>Aqui você poderá cadastrar todas as suas categorias.</b><br> 
            Exemplos de categorias: Alimentação, Transporte, Lazer, etc...<br> <br> <br>
        </div>
        <form v-bind:action="action" v-bind:method="method">
            <slot name="method"></slot>
            <input type="hidden" name="_token" v-bind:value="token">

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Descrição</label>
                        <input class="form-control" type="text" name="descricao" v-bind:value="categoria.descricao" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Tipo</label>
                        <select class="form-control" name="tipo" v-bind:value="categoria.tipo" required>
                            <option value="Receita">Receita</option>
                            <option value="Despesa">Despesa</option>
                        </select>
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
            'categoria',
            'teste'
        ],

        data(){
            return {
                categoria: {}
            }
        },

        methods:{
            voltar(){
                window.history.back();
            }
        },

        mounted(){
            this.categoria = JSON.parse(this.categoria);
        }
    }
</script>

<style lang="scss">
    .componente-categoria-form{
        .descricao{
            color: #444;
            b{
                font-size: 18px;
            }
        }   
    }
</style>
