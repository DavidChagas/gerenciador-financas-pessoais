<template>
    <div class="componente-conta-form">
        <div class="descricao">
            <b>Aqui você poderá cadastrar todas as suas contas existentes.</b><br> 
            Exemplos de contas: Poupança, Carteira, Nuconta, etc.<br> <br> <br>
        </div>
        <form v-bind:action="action" v-bind:method="method" autocomplete="off">
            <slot name="method"></slot>
            <input type="hidden" name="_token" v-bind:value="token">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Descrição</label>
                        <input class="form-control" type="text" name="descricao" v-model="contaObj.descricao" required>
                    </div>
                </div>
                <div class="col-sm-6" v-if="!contaObj.usuario_id">
                    <div class="form-group">
                        <label>Valor Inicial</label>
                        <input class="form-control" type="text" name="valor" v-model="contaObj.valor" @blur="formatarValor" required>
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
    import funcoes from "../../funcoes";

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
                contaObj: {}
            }
        },

        methods:{
            voltar(){
                window.history.back();
            },
            formatarValor() {
                this.contaObj.valor = funcoes.formatarValorInput(this.contaObj.valor);
            }
        },

        mounted(){
            this.contaObj = JSON.parse(this.conta);
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
