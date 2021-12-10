<template>
    <div class="componente-receita-form">
        <form v-bind:action="action" v-bind:method="method" autocomplete="off">
            <slot name="method"></slot>
            <input type="hidden" name="_token" v-bind:value="token">

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Nome</label>
                        <input class="form-control" type="text" name="nome" v-bind:value="usuarioObj.nome">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>E-mail</label>
                        <input class="form-control" type="text" name="email" v-bind:value="usuarioObj.email">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Nova Senha</label>
                        <input class="form-control" type="password" name="senha" v-model="novaSenha" minlength="3">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label style="width: 100%">Repita a senha <small v-if="senhaIncorreta && novaSenha != ''"><b style="color: red; float: right; margin-top: 4px">As senhas não conferem</b></small></label>
                        <input class="form-control" type="password" v-model="confereSenha" @input="conferirSenha()">
                    </div>
                </div>
            </div>
            <button class="btn btn-secondary" type="button" v-on:click="voltar()">Voltar</button>
            <button class="btn btn-success" type="submit" :disabled="senhaIncorreta && novaSenha != ''" style="min-width: 70px">Alterar</button>
        </form>
    </div>
</template>

<script>
    export default {
        props: [
            'action',
            'method',
            'token',
            'usuario'
        ],

        data(){
            return {
                usuarioObj: {},
                novaSenha: '',
                confereSenha: '',
                senhaIncorreta: false
            }
        },

        created(){
            
        },

        methods:{
            voltar(){
                window.history.back();
            },
            conferirSenha(){
                this.senhaIncorreta = this.novaSenha != this.confereSenha ? true : false;
            }
        },

        mounted(){
            this.usuarioObj = JSON.parse(this.usuario);
        }
    }
</script>

<style lang="scss">
</style>
