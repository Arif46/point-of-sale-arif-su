<template>
  <div>
    <b-row class="mb-3">
      <b-col sm="12">
        <div class="mt-1">
            <p class="mb-2 "  style="font-weight: 600">{{ $t('dealer.actions') }}</p>
            <b-button v-b-modal.payment class="btn-sm" variant="warning">{{ $t('dealer.pay') }}</b-button>&nbsp;
            <b-button class="btn-sm" variant="primary">{{ $t('dealer.receipt') }}</b-button>&nbsp;
            <b-button class="btn-sm" variant="success">{{ $t('dealer.feedback') }}</b-button>&nbsp;
            <b-button v-if="appDetail.type !== 2" @click="enableRenew()" class="btn-sm" variant="info">{{ $t('dealer.renew') }}</b-button>&nbsp;
        </div>
      </b-col>
    </b-row>
    <div>
    <b-modal id="payment" size="lg" :title="$t('dealer.payment')" hide-footer :ok-title="$t('globalTrans.close')" ok-only ok-variant="danger">
      <Payment :application="appDetail" />
    </b-modal>
  </div>
  </div>
</template>
<script>
import Payment from './Payment.vue'
export default {
  props: ['appDetail'],
  name: 'Action',
  components: {
    Payment
  },
  data () {
    return {
      loading: false
    }
  },
  computed: {
  },
  methods: {
    enableRenew () {
      this.$emit('enableRenew')
    }
  }
}
</script>
