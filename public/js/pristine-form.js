import Pristine from "https://unpkg.com/pristinejs@0.1.9/src/pristine.js?module"
import { cpf, cnpj } from "/public/js/cpf-cnpj/index.js"

export default class PristineForm {
    constructor(form, {
        rules = null,
        messages = null,
        pristine = {},
        live = true,
        silent = false,
        onSubmit = null,
        onInvalid = null
    } = {}) {

        this.form = form instanceof HTMLElement ? form : document.querySelector(form)
        this.rules = rules
        this.messages = messages
        this.onSubmit = onSubmit
        this.onInvalid = onInvalid
        this.customValidators = []
        this.defaultRules = [
            'required',
            'email',
            'number',
            'integer',
            'minlength',
            'maxlength',
            'min',
            'max',
            'pattern',
            'cpfcnpj',
            'phone'
        ]

        this.setValidators()
        this.addExtendedValidators()
        this.initForm(pristine, live || true)
        this.setCustomValidators()
        this.bindSubmitEvent(silent)
    }

    initForm(config, live) {
        this.pristine = new Pristine(this.form, config, live)
    }

    addExtendedValidators() {
        Pristine.addValidator('phone', function (value) {
            return new RegExp(/(\(\d{2}\))\s(\d{5})-(\d{4})/).test(value) || new RegExp(/(\(\d{2}\))\s(\d{4})-(\d{4})/).test(value)
        }, 'Telefone inválido.')

        Pristine.addValidator('cpfcnpj', function (value) {
            return cpf.isValid(value) || cnpj.isValid(value)
        }, 'CPF / CNPJ inválido.')

        Pristine.addValidator('equalto', function (value, otherInput) {
            const compareTo = this.form.querySelector(`[name="${otherInput}"], #${otherInput}`).value
            return value == compareTo
        }, 'Os valores devem ser iguais.')
    }

    setValidators() {
        if (this.rules) {
            for (const input in this.rules) {
                const id = this.form.id ? `#${this.form.id}` : 'form'
                const inputElement = document.querySelector(`${id} input[name="${input}"], ${id} select[name="${input}"], ${id} textarea[name="${input}"]`)
                const inputRules = this.rules[input];

                for (const rule in inputRules) {
                    let ruleData, ruleMessage
                    if (rule === 'email' || rule === 'number' || rule === 'integer') {
                        ruleData = {'name': 'pristineType', 'value': rule}
                    } else {
                        if (typeof inputRules[rule] === 'function') {
                            let message = (this.messages[input] && this.messages[input][rule]) ? this.messages[input][rule] : 'Valor inválido.'
                            this.customValidators.push({args: [inputElement, inputRules[rule], message]})
                        }
                        ruleData = {
                            'name': `pristine${rule.toLowerCase().replace(/^[a-zA-Z]/, c => c.toUpperCase())}`,
                            'value': inputRules[rule]
                        }
                    }

                    if ((this.messages && this.messages[input] && this.messages[input][rule]) && !(typeof inputRules[rule] === 'function')) {
                        ruleMessage = {
                            'name': `pristine${rule.toLowerCase().replace(/^[a-zA-z]/, c => c.toUpperCase())}Message`,
                            'value': this.messages[input][rule]
                        }
                        inputElement.dataset[ruleMessage.name] = ruleMessage.value
                    }

                    inputElement.dataset[ruleData.name] = ruleData.value
                }
            }
        }
    }

    bindSubmitEvent(silent) {
        this.form.addEventListener('submit', evt => {
            if (!this.pristine.validate(silent)) {
                evt.preventDefault()
                if (typeof this.onInvalid === 'function') this.onInvalid.call(this.pristine, this.form)

                return
            }

            if (typeof this.onSubmit === 'function') {
                evt.preventDefault()
                this.onSubmit.call(this.pristine, this.form)
            }
        })
    }

    setCustomValidators() {
        this.customValidators.forEach(custom => {
            this.pristine.addValidator(...custom.args)
        })
    }
}
