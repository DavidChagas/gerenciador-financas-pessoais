export default {
    formatPrice(value) {
        let valueClean = value.toString().replace('.', "").replace(/,/g, "").replace(/\D/g, "");
        
        let arrayValue = Array.from( valueClean.toString() );
        
        if(arrayValue.length > 2){
            arrayValue.reverse();
            arrayValue.splice(2, 0, ",");
            arrayValue.reverse();
        }
               
        return arrayValue.join('');
    },
    formatarValorInput(valor){
        let valueClean = valor.toString().replace('.', "").replace(/,/g, "").replace(/\D/g, "");
        let arrayValue = Array.from( valueClean );
        
        arrayValue.reverse();
        arrayValue.splice(2, 0, ".");
        arrayValue.reverse();
        let stringValue = arrayValue.join('');
        
        return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(stringValue);
    },
    formatarValorGraficos(value){
        let valueClean = value.toString().replace('.', "").replace(/,/g, "").replace(/\D/g, "");
        
        let arrayValue = Array.from( valueClean.toString() );
        
        if(arrayValue.length > 2){
            arrayValue.reverse();
            arrayValue.splice(2, 0, ".");
            arrayValue.reverse();
        }
               
        return arrayValue.join('');
    }
}