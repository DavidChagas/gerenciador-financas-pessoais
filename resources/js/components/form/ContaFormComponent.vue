<template>
    <div class="componente-conta-form">
        <div class="descricao">
            <b>Aqui você poderá cadastrar todas as suas contas existentes.</b><br> 
            Exemplos de contas: Poupança, Carteira, Nuconta, etc...<br> <br> <br>
        </div>
        <form v-bind:action="action" v-bind:method="method">
            <slot name="method"></slot>
            <input type="hidden" name="_token" v-bind:value="token">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Descrição</label>
                        <input class="form-control" type="text" name="descricao" v-bind:value="conta.descricao">
                    </div>
                </div>
                <div class="col-sm-6" v-if="!conta.usuario_id">
                    <div class="form-group">
                        <label>Valor Inicial</label>{{conta.usuario_id}}
                        <input class="form-control" type="text" name="valor" v-bind:value="conta.valor">
                    </div>
                </div>
            </div>
            <div class="botoes">
                <!-- <button class="btn btn-danger voltar" type="button" v-on:click="voltar()">Voltar</button> -->
                <button class="btn btn-primary cadastrar" type="submit">Cadastrar</button>
            </div> 
        </form>
    </div>
</template>

<script>
    export default {
        props: [
            'action',
            'method',
            'token',
            'conta',
            'teste'
        ],

        data(){
            return {
                conta: {}
            }
        },

        methods:{
            voltar(){
                window.history.back();
            }
        },

        mounted(){
            this.conta = JSON.parse(this.conta);
        }
    }
</script>

<style lang="scss">
    .componente-conta-form{
        .descricao{
            color: #444;
            b{
                font-size: 18px;
            }
        }

        .botoes{
            display: flex;
            justify-content: flex-end;

            .cadastrar{
                margin-left: 10px;
                width: 300px;
            }
        }
    }
</style>
