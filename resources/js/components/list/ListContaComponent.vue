<template>
    <div class="componente-listagem-conta">
        <select class="form-control select-contas" v-model="mostrarContas" v-if="list.length">
            <option value="0">Contas Ativos</option>
            <option value="1">Contas Arquivados</option>
        </select>
        <table v-bind:class="dispositivo == 'desktop' ? 'table' : 'table table-responsive'" v-if="list.length">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Descrição</th>
                    <th scope="col">Valor</th>
                    <th scope="col" width="50px" style="text-align: center;" v-if="mostrarContas == 0">Editar</th>
                    <th scope="col" width="50px" style="text-align: center;" v-if="mostrarContas == 0">Arquivar</th>
                    <th scope="col" width="50px" style="text-align: center;" v-if="mostrarContas == 1">Reativar</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="i in list" v-bind:key="i.id" v-if="i.arquivado == mostrarContas">
                    <td>{{i.descricao}}</td>
                    <td>R$ {{formatPrice(i.valor)}}</td>
                    <td style="text-align: center;" v-if="mostrarContas == 0"> <a v-bind:href="'/'+model+'/'+i.id+'/edit'" class="btn btn-primary btn-sm" style="padding: 6px; line-height: 1;"><i class="fas fa-pencil-alt"></i></a> </td>
                    <td style="text-align: center;" v-if="mostrarContas == 0"> 
                        <form v-bind:action="'/'+model+'/'+i.id" method="POST">
                            <slot name="method"></slot>
                            <button type="submit" class="btn btn-danger btn-sm" style="padding: 6px; line-height: 1;"><i class="far fa-folder-open"></i></button>
                        </form>
                    </td>
                    <td style="text-align: center;" v-if="mostrarContas == 1">
                        <buttom class="btn btn-success btn-sm" v-on:click="reativarConta(i.id)" style="padding: 6px; line-height: 1;"><i class="far fa-folder"></i></buttom>
                    </td>
                </tr>
            </tbody>
        </table>

        <lista-vazia-component v-if="!list.length"></lista-vazia-component>
    </div>
</template>

<script>
    import funcoes from "../../funcoes"

    export default {
        props : [
            'infos',
            'model'
        ],

        data(){
            return {
                list: [],
                item: '',
                mostrarContas: 0,
                dispositivo: 'desktop'
            }
        },
        methods: {
            formatPrice(value) {
                return funcoes.formatPrice(value);
            },
            verificarDispositivo(){
                if (screen.width < 640 || screen.height < 480) {
                    this.dispositivo = 'mobile';
                }else{
                    this.dispositivo = 'desktop';
                }
            },
            reativarConta(id){
                this.$http.get(`/api/reativarConta?idConta=${id}`).then(() => {
                   window.location.reload();
                }, err => {
                    console.log('err: ');
                });
            }
        },
        mounted(){
            this.list = JSON.parse(this.infos);
            this.verificarDispositivo();
        }
    }
</script>
<style lang="scss">
   .componente-listagem-conta{
        position: relative;

        .select-contas{
            position: absolute;
            top: -59px;
            right: 0;
            width: 160px;
            
            border-top: none;
            border-left: none;
            border-right: none;
            border-radius: 0px;

            height: 30px;
            padding: 5px;

            @media(min-width: 768px){
                width: 200px;
            }

            &:focus{
                border-color: transparent;
                outline: none;
                box-shadow: none;
            }
        }
   }
</style>
