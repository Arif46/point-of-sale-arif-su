<template>
  <b-col md="10" lg="10" sm="12" offset-md="1">
    <b-overlay :show="loading">
      <table class="table table-striped table-hover table-sm table-bordered">
        <tbody>
          <tr>
              <th>{{ $t('dealer.fee_name') }}</th>
              <th>{{ $t('globalTrans.amount') }}</th>
          </tr>
          <tr v-for="(item, index) in payments" :key="index">
            <td>
              {{ $i18n.locale === 'bn' ? item.text_bn : item.text_en }}
            </td>
            <td>
              {{ $n( item.amount) }}
            </td>
          </tr>
        </tbody>
      </table>
      <div class="row mt-3">
          <div class="col-md-12 text-right">
              <b-button variant="primary" class="mr-1 mt-3 btn-sm" @click="saveFormData()">{{ $t('dealer.payment') }}</b-button>
              <b-button variant="danger" class="mr-1 mt-3 btn-sm" @click="$bvModal.hide('payment')">{{ $t('globalTrans.cancel') }}</b-button>
          </div>
      </div>
    </b-overlay>
  </b-col>
</template>
<script>
import RestApi, { licenseRegistrationServiceBaseUrl } from '@/config/api_config'
import { paymentStore } from '../api/routes'
export default {
  props: ['payments'],
  name: 'PaymentOnline',
  components: {
  },
  data () {
    return {
      loading: false
    }
  },
  created () {
  },
  methods: {
    async saveFormData (type, transId = '') {
          let result = null
          this.loading = true
          result = await RestApi.postData(licenseRegistrationServiceBaseUrl, paymentStore, this.payments)
          this.loading = false
          this.$bvModal.hide('modal-payment')
          if (result.success) {
            if (result.success === 2) {
              this.$toast.success({
                title: 'Success',
                message: result.message
              })
            } else {
              window.location = result.url
            }
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
