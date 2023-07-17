export const method = {
    getColumnName (list, field, groupId) {
        const obj = list.find(item => item[field] === groupId)
        if (typeof obj !== 'undefined') {
            if (this.$i18n.locale === 'bn') {
            return obj.text_bn
            } else {
            return obj.text_en
            }
        } else {
            return ''
        }
    }
}
