<template>
  <b-container fluid>
    <b-overlay :show="saveloading">
      <b-col md="12" lg="12" sm="12">
          <ValidationObserver ref="from" v-slot="{ handleSubmit }">
            <b-form  @submit.prevent="handleSubmit(saveFormData)" >
              <div v-if="payments.length">
                <div v-for="(item, key) in payments" :key="key" class="row">
                  <div class="col-md-12">
                    <table class="table table-bordered table-sm">
                      <tbody>
                        <tr>
                            <th>{{ $t('fee_name.fee_name') }}</th>
                            <th>{{ $t('globalTrans.amount') }}</th>
                            <th>{{ $t('globalTrans.vat') }} (%) </th>
                            <th>{{ $t('globalTrans.tax') }} (%) </th>
                        </tr>
                        <tr>
                          <td>{{ $i18n.locale === 'en' ? item.text_en : item.text_bn }}</td>
                          <td>{{ $n(item.amount) }}</td>
                          <td>({{ $n(item.vat) }}%) = {{ $n(item.amount_vat) }}</td>
                          <td>({{ $n(item.tax) }}%) = {{ $n(item.amount_tax) }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-12">
                    <h6 class="mt-3 mb-2"><b>{{ $i18n.locale === 'en' ? item.text_en : item.text_bn }} : ({{ $n(item.amount) }})</b></h6>
                    <div class="row">
                      <div class="col-md-6">
                        <ValidationProvider name="Challan No" :vid="`challan_no`" :rules="`required`">
                            <b-form-group
                                class="row"
                                label-cols-sm="3"
                                label-for="challan_no"
                                slot-scope="{ valid, errors }"
                                style="font-size: 13px"
                            >
                                <template v-slot:label>
                                    {{ $t('dealer.challan_no') }} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    id="challan_no"
                                    v-model="item.challan_no"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                            </b-form-group>
                          </ValidationProvider>
                      </div>
                      <div class="col-md-6">
                        <ValidationProvider name="Date" :vid="`pay_date`" :rules="`required`">
                            <b-form-group
                                class="row"
                                label-cols-sm="3"
                                label-for="pay_date"
                                slot-scope="{ valid, errors }"
                                style="font-size: 13px"
                            >
                                <template v-slot:label>
                                    {{ $t('globalTrans.date') }} <span class="text-danger">*</span>
                                </template>
                                <b-form-datepicker b-form-datepicker
                                    id="pay_date"
                                    v-model="item.pay_date"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-datepicker>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                            </b-form-group>
                          </ValidationProvider>
                      </div>
                      <div class="col-md-6">
                        <ValidationProvider name="Bank Name" :vid="`bank_name`" :rules="`required`">
                            <b-form-group
                                class="row"
                                label-cols-sm="3"
                                label-for="bank_name"
                                slot-scope="{ valid, errors }"
                                style="font-size: 13px"
                            >
                                <template v-slot:label>
                                    {{ $t('dealer.bank_name') }} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    id="bank_name"
                                    v-model="item.bank_name"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                            </b-form-group>
                          </ValidationProvider>
                      </div>
                      <div class="col-md-6">
                        <ValidationProvider name="Branch Name" :vid="`branch_name`" :rules="`required`">
                            <b-form-group
                                class="row"
                                label-cols-sm="3"
                                label-for="branch_name"
                                slot-scope="{ valid, errors }"
                                style="font-size: 13px"
                            >
                                <template v-slot:label>
                                    {{ $t('dealer.branch_name') }} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    id="branch_name"
                                    v-model="item.branch_name"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                            </b-form-group>
                          </ValidationProvider>
                      </div>
                      <div class="col-md-6">
                        <ValidationProvider name="Attachment" :vid="`attachment`" :rules="`required`">
                            <b-form-group
                                class="row"
                                label-cols-sm="3"
                                label-for="attachment"
                                slot-scope="{ valid, errors }"
                                style="font-size: 13px"
                            >
                                <template v-slot:label>
                                    {{ $t('globalTrans.attachment') }} <span class="text-danger">*</span>
                                </template>
                                <b-form-file
                                    @change="onChangeAttachment($event, item, key)"
                                    v-model="item.attachment"
                                    :id="'attachment' + key"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-file>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                            </b-form-group>
                          </ValidationProvider>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12" v-if="item.vat">
                    <h6 class="mt-3 mb-2"><b>{{ $i18n.locale === 'en' ? item.text_en : item.text_bn }} ({{ $t('globalTrans.vat') }}) : ({{ $n(item.amount_vat) }})</b></h6>
                    <div class="row">
                      <div class="col-md-6">
                        <ValidationProvider name="Challan No" :vid="`challan_no_vat`" :rules="`required`">
                            <b-form-group
                                class="row"
                                label-cols-sm="3"
                                label-for="challan_no_vat"
                                slot-scope="{ valid, errors }"
                                style="font-size: 13px"
                            >
                                <template v-slot:label>
                                    {{ $t('dealer.challan_no') }} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    id="challan_no_vat"
                                    v-model="item.challan_no_vat"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                            </b-form-group>
                          </ValidationProvider>
                      </div>
                      <div class="col-md-6">
                        <ValidationProvider name="Date" :vid="`pay_date_vat`" :rules="`required`">
                            <b-form-group
                                class="row"
                                label-cols-sm="3"
                                label-for="pay_date_vat"
                                slot-scope="{ valid, errors }"
                                style="font-size: 13px"
                            >
                                <template v-slot:label>
                                    {{ $t('globalTrans.date') }} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    id="pay_date_vat"
                                    class="datepic"
                                    v-model="item.pay_date_vat"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                            </b-form-group>
                          </ValidationProvider>
                      </div>
                      <div class="col-md-6">
                        <ValidationProvider name="Bank Name" :vid="`bank_name_vat`" :rules="`required`">
                            <b-form-group
                                class="row"
                                label-cols-sm="3"
                                label-for="bank_name_vat"
                                slot-scope="{ valid, errors }"
                                style="font-size: 13px"
                            >
                                <template v-slot:label>
                                    {{ $t('dealer.bank_name') }} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    id="bank_name_vat"
                                    v-model="item.bank_name_vat"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                            </b-form-group>
                          </ValidationProvider>
                      </div>
                      <div class="col-md-6">
                        <ValidationProvider name="Branch Name" :vid="`branch_name_vat`" :rules="`required`">
                            <b-form-group
                                class="row"
                                label-cols-sm="3"
                                label-for="branch_name_vat"
                                slot-scope="{ valid, errors }"
                                style="font-size: 13px"
                            >
                                <template v-slot:label>
                                    {{ $t('dealer.branch_name') }} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    id="branch_name_vat"
                                    v-model="item.branch_name_vat"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                            </b-form-group>
                          </ValidationProvider>
                      </div>
                      <div class="col-md-6">
                        <ValidationProvider name="Attachment" :vid="`attachment_vat`" :rules="`required`">
                            <b-form-group
                                class="row"
                                label-cols-sm="3"
                                label-for="attachment_vat"
                                slot-scope="{ valid, errors }"
                                style="font-size: 13px"
                            >
                                <template v-slot:label>
                                    {{ $t('globalTrans.attachment') }} <span class="text-danger">*</span>
                                </template>
                                <b-form-file
                                    :id="'attachment_vat'+key"
                                    @change="onChangeAttachmentVat($event, item, key)"
                                    v-model="item.attachment_vat"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-file>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                            </b-form-group>
                          </ValidationProvider>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12" v-if="item.tax">
                    <h6 class="mt-3 mb-2"><b>{{ $i18n.locale === 'en' ? item.text_en : item.text_bn }} ({{ $t('globalTrans.tax') }}) : ({{ (item.amount_tax) }})</b></h6>
                    <div class="row">
                      <div class="col-md-6">
                        <ValidationProvider name="Challan No" :vid="`challan_no_tax`" :rules="`required`">
                            <b-form-group
                                class="row"
                                label-cols-sm="3"
                                label-for="challan_no_tax"
                                slot-scope="{ valid, errors }"
                                style="font-size: 13px"
                            >
                                <template v-slot:label>
                                    {{ $t('dealer.challan_no') }} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    id="challan_no_tax"
                                    v-model="item.challan_no_tax"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                            </b-form-group>
                          </ValidationProvider>
                      </div>
                      <div class="col-md-6">
                        <ValidationProvider name="Date" :vid="`pay_date_tax`" :rules="`required`">
                            <b-form-group
                                class="row"
                                label-cols-sm="3"
                                label-for="pay_date_tax"
                                slot-scope="{ valid, errors }"
                                style="font-size: 13px"
                            >
                                <template v-slot:label>
                                    {{ $t('globalTrans.date') }} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    id="pay_date_tax"
                                    class="datepic"
                                    v-model="item.pay_date_tax"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                            </b-form-group>
                          </ValidationProvider>
                      </div>
                      <div class="col-md-6">
                        <ValidationProvider name="Bank Name" :vid="`bank_name_tax`" :rules="`required`">
                            <b-form-group
                                class="row"
                                label-cols-sm="3"
                                label-for="bank_name_tax"
                                slot-scope="{ valid, errors }"
                                style="font-size: 13px"
                            >
                                <template v-slot:label>
                                    {{ $t('dealer.bank_name') }} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    id="bank_name_tax"
                                    v-model="item.bank_name_tax"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                            </b-form-group>
                          </ValidationProvider>
                      </div>
                      <div class="col-md-6">
                        <ValidationProvider name="Branch Name" :vid="`branch_name_tax`" :rules="`required`">
                            <b-form-group
                                class="row"
                                label-cols-sm="3"
                                label-for="branch_name_tax"
                                slot-scope="{ valid, errors }"
                                style="font-size: 13px"
                            >
                                <template v-slot:label>
                                    {{ $t('dealer.branch_name') }} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    id="branch_name_tax"
                                    v-model="item.branch_name_tax"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                            </b-form-group>
                          </ValidationProvider>
                      </div>
                      <div class="col-md-6">
                        <ValidationProvider name="Branch Name" :vid="`branch_name_tax`" :rules="`required`">
                            <b-form-group
                                class="row"
                                label-cols-sm="3"
                                label-for="branch_name_tax"
                                slot-scope="{ valid, errors }"
                                style="font-size: 13px"
                            >
                                <template v-slot:label>
                                    {{ $t('dealer.branch_name') }} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    id="branch_name_tax"
                                    v-model="item.branch_name_tax"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                            </b-form-group>
                          </ValidationProvider>
                      </div>
                      <div class="col-md-6">
                        <ValidationProvider name="Attachment" :vid="`attachment_tax`" :rules="`required`">
                            <b-form-group
                                class="row"
                                label-cols-sm="3"
                                label-for="attachment_tax"
                                slot-scope="{ valid, errors }"
                                style="font-size: 13px"
                            >
                                <template v-slot:label>
                                    {{ $t('globalTrans.attachment') }} <span class="text-danger">*</span>
                                </template>
                                <b-form-file
                                    :id="'attachment_tax'+key"
                                    @change="onChangeAttachmentTax($event, item, key)"
                                    v-model="item.attachment_tax"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-file>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                            </b-form-group>
                          </ValidationProvider>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row mt-3">
                  <div class="col-md-12 text-right">
                      <b-button type="submit" variant="primary" class="mr-2 btn-sm">{{ $t('dealer.payment') }}</b-button>
                      <b-button variant="danger" class="mr-1 btn-sm" @click="$bvModal.hide(payment.application_type === 1 ? `modal-payment` : `modal-payment-renew`)">{{ $t('globalTrans.cancel') }}</b-button>
                  </div>
              </div>
            </b-form>
          </ValidationObserver>
        </b-col>
    </b-overlay>
  </b-container>
</template>
<script>
import RestApi, { licenseRegistrationServiceBaseUrl } from '@/config/api_config'
import { paymentStoreOffline } from '../api/routes'

export default {
  props: ['payments'],
  data () {
    return {
        saveloading: false
    }
  },
  created () {
  },
  methods: {
      onChangeAttachment (e, item, index) {
          this.getBase64(e.target.files[0]).then(res => {
            this.payments[index].attachment = res
          })
      },
      onChangeAttachmentVat (e, item, index) {
          this.getBase64(e.target.files[0]).then(res => {
              this.payments[index].attachment_vat = res
          })
      },
      onChangeAttachmentTax (e, item, index) {
          this.getBase64(e.target.files[0]).then(res => {
              this.payments[index].attachment_tax = res
          })
      },
      async saveFormData () {
          let result = null
          this.saveloading = true
          result = await RestApi.postData(licenseRegistrationServiceBaseUrl, paymentStoreOffline, this.payments)
          this.saveloading = false
          this.$store.dispatch('ExternalLrcpn/setLaodList', { listLoad: true })
          if (result.success) {
            this.$toast.success({
              title: 'Success',
              message: result.message
            })
            this.$bvModal.hide(this.payment.application_type === 1 ? 'modal-payment' : 'modal-payment-renew')
          } else {
            this.$refs.form.setErrors(result.errors)
            this.$toast.error({
              title: 'Error',
              message: result.message
            })
          }
      }
  }
}
</script>
