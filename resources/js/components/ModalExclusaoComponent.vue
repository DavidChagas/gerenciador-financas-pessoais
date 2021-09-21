<template>
    <div class="componente-modal-exclusao">
        <div class="titulo">
            Tem certeza que seja excluir tal registro?
        </div>
        <div class="botoes">
            <button class="btn btn-sm btn-danger">Cancelar</button>
            <button class="btn btn-sm btn-info">Excluir</button>
        </div>
    </div>
</template>

<script>
    export default {
        props : [
            'item'
        ],
        data(){
            return {
                i: {}
            }
        },
        mounted() {
            console.log(this.item);
            this.i = JSON.parse(this.item);
        }
    }
</script>

<style lang="scss">
    .componente-modal-exclusao{
        position: absolute;
        top: 0;
        left: 50%;

        border: 1px solid #ddd;
        box-shadow: 4px 4px 6px #ddd;

        width: 600px;
        
        margin-left: -300px;
        padding: 50px;

        background-color: white;
        border-radius: 5px;

        text-align: center;

        .titulo{
            margin-bottom: 20px;
            font-size: 23px;
        }
    }
</style>
