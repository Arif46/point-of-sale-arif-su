<template>
  <div class="inner-section">
      <card>
        <body-card>
            <template v-slot:headerTitle>
              <h4 class="card-title">{{ $t('dealer.application_form') }}</h4>
            </template>
            <template v-slot:body>
              <div v-if="loading">
                <Loading />
              </div>
              <div v-else>
                <Action :appDetail="appDetail" @enableRenew="onEnableRenew()" />
                <div v-if="(appDetail && appDetail.save_status === 1) || enable_renew">
                  <Form @submitForm="onSubmitForm()" :appDetail="appDetail" :isRenew="enable_renew" />
                </div>
                <div v-else>
                  <Detail :appDetail="appDetail" />
                </div>
              </div>
            </template>
        </body-card>
      </card>
  </div>
</template>
<script>
import RestApi, { licenseRegistrationServiceBaseUrl } from '@/config/api_config'
import { applicationList } from '../../api/routes'
import Form from './Form.vue'
import Loading from '../../../../../license-registration-service/license-management/components/loading/Details.vue'
import Detail from './Details.vue'
import Action from './Action.vue'
export default {
  name: 'List',
  components: {
    Form,
    Detail,
    Loading,
    Action
  },
  data () {
    return {
      loading: false,
      enable_renew: false,
      appDetail: {
        org_id: 0,
        region_id: 0,
        applicant_name: '',
        applicant_name_bn: '',
        fasp_name: '',
        fasp_name_bn: '',
        mobile: '',
        other_family_license: false,
        other_dealer_name: '',
        other_dealer_name_bn: '',
        other_company_name: '',
        other_company_name_bn: '',
        other_company_division_id: 0,
        other_company_district_id: 0,
        other_company_upazilla_id: 0,
        company_name: '',
        company_name_bn: '',
        company_division_id: 0,
        company_district_id: 0,
        company_upazilla_id: 0,
        office_id: 0,
        division_id: 0,
        district_id: 0,
        upazilla_id: 0,
        union_id: 0,
        village: '',
        village_bn: '',
        dob: '',
        nid_no: '',
        marital_status: 1,
        father_nid_no: '',
        spouse_nid_no: '',
        email: '',
        tin_no: '',
        applicant_image: [],
        trade_license: [],
        bank_solvency: [],
        nid: [],
        tin: [],
        shop_document: [],
        vat_certificate: [],
        citizen_certificate: [],
        save_status: 2,
        type: 1
      }
    }
  },
  created () {
    this.appDetail = this.getAppDetail()
  },
  watch: {
  },
  computed: {
  },
  methods: {
    async getAppDetail () {
        this.loading = true
        const result = await RestApi.getData(licenseRegistrationServiceBaseUrl, applicationList, {})
        if (result.success) {
          this.appDetail = result.data
        }
        this.loading = false
    },
    onSubmitForm () {
      this.appDetail = this.getAppDetail()
    },
    onEnableRenew () {
      this.enable_renew = true
    }
  }
}
</script>
