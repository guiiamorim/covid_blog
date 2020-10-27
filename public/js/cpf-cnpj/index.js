import cpf from './cpf.js';
import cnpj from './cnpj.js';
export { cpf, cnpj };
export const validator = joi => ({
    type: 'document',
    base: joi.string(),
    messages: {
        'document.cpf': 'CPF inválido',
        'document.cnpj': 'CNPJ inválido'
    },
    rules: {
        cpf: {
            validate(value, helpers, args, options) {
                if (!cpf.isValid(value)) {
                    return helpers.error('document.cpf');
                }
                return value;
            }
        },
        cnpj: {
            validate(value, helpers, args, options) {
                if (!cnpj.isValid(value)) {
                    return helpers.error('document.cnpj');
                }
                return value;
            }
        }
    }
});
export default validator;
