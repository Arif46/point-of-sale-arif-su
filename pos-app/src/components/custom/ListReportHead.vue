<template>
  <div>
      <b-overlay :show="loadingState">
        <div class="container-fluid">
          <div class="row justify-content-md-center">
            <div class="col col-lg-2 text-right">
              <b-img width='50px' :src="'data:image/jpeg;base64,' + leftLogo" fluid alt="Left Logo"></b-img>
            </div>
            <div class="col-md-auto col-lg-7 text-center" v-if="this.$i18n.locale === 'en'">
              <h3 class="text-bold" style="font-size:19px;">{{ $t('globalTrans.government_republic_of_bangladesh') }}</h3>
              <h5 class="org-name">{{ orgName }} </h5>
              <h6 class="org-address">{{ address }}</h6>
            </div>
            <div class="col-md-auto col-lg-4 text-center" v-if="this.$i18n.locale === 'bn'">
              <h3 class="text-bold" style="font-size:19px;">{{ $t('globalTrans.government_republic_of_bangladesh') }}</h3>
              <h5 class="org-name">{{ orgName }} </h5>
              <h6 class="org-address">{{ address }}</h6>
            </div>
            <div class="col col-lg-2 text-left">
              <b-img width='50px' :src="'data:image/jpeg;base64,' + rightLogo" fluid alt="Right Logo"></b-img>
            </div>
          </div>
          <div class="row justify-content-md-center">
            <div class="col-md-auto text-center">
              <h6 class="org-address" v-if="projectName">{{ projectName }}</h6>
              <div class="report-title"><slot>{{ $i18n.locale === 'en' ? 'Report' : 'প্রতিবেদন' }}</slot></div>
            </div>
          </div>
        </div>
      </b-overlay>
  </div>
</template>

<script>
import RestApi from '@/config/api_config'

export default {
  props: {
    baseUrl: String,
    params: Object,
    uri: String,
    orgId: Number,
    loadingState: Boolean
  },
  data () {
    return {
      orgName: '',
      leftLogo: '',
      rightLogo: '',
      address: '',
      projectName: ''
    }
  },
  computed: {
    langChange () {
      return this.$i18n.locale
    },
    getParams () {
        const defaultParam = { leftPath: 'uploads/config/left-logo/original/', rightPath: 'uploads/config/right-logo/original/' }
        if (this.params && typeof this.params !== 'undefined' && Object.keys(this.params).length > 0) {
            return this.params
        } else {
            return defaultParam
        }
    }
  },
  watch: {
    loadingState: function (newVal, oldVal) {
      if (newVal === true) {
        this.getReportHead(this.orgId)
      }
    },
    langChange: function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.getReportHead(this.orgId)
      }
    }
  },
  created () {
    this.getReportHead(this.orgId)
  },
  methods: {
    getReportHead (orgId) {
      if (!orgId) {
        return
      }
      RestApi.getData(this.baseUrl, this.uri + '/' + this.orgId, this.getParams).then(response => {
        if (typeof response.success !== 'undefined' && response.success) {
          const orgData = this.$store.state.CommonService.commonObj.orgProfileList.find(item => item.value === this.orgId)
          this.leftLogo = response.data.left_logo
          this.rightLogo = response.data.right_logo
          this.address = this.$i18n.locale === 'en' ? response.data.address : response.data.address_bn
          this.orgName = this.$i18n.locale === 'en' ? orgData.text_en : orgData.text_bn

          if (Object.prototype.hasOwnProperty.call(response.data, 'project_name')) {
            this.projectName = this.$i18n.locale === 'en' ? response.data.project_name : response.data.project_name_bn
          }
        }
      })
    }
  }
}
</script>
<style scoped>
  .report-title {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 20px;
    margin-top: 15px;
    color: var(--iq-dark)
  }
</style>
