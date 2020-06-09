import { extend, configure } from 'vee-validate'
import * as rules from 'vee-validate/dist/rules'
// import isURL from 'validator/lib/isURL'
import i18n from '@/i18n/i18n'

configure({
  defaultMessage: (field, values) => {
    // override the field name.
    //values._field_ = i18n.t(`fields.${field}`)
    values._field_ = i18n.t(field)

    return i18n.t(`validation.${values._rule_}`, values)
  }
})

Object.keys(rules).forEach(rule => {
  extend(rule, rules[rule])
})
