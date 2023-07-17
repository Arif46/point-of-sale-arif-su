<template>
  <div>
    <b-overlay :show="customloading">
      <b-row>
        <b-col class="sm">
          <b-button variant="primary" @click="pdfExport" class="mb-2 float-right">
            {{  $t('globalTrans.export_pdf') }}
          </b-button>
        </b-col>
      </b-row>
      <b-card>
          <b-row>
              <b-col sm="3"> {{ $t('exportTrophyGazette.registered_no') }} </b-col>
              <b-col sm="6"> <div class="text-center"> {{ $t('exportTrophyGazette.slogan') }} </div></b-col>
          </b-row>
          <b-row>
              <b-col sm="5"> <h3 class="text-right mt-3"> {{ $t('exportTrophyGazette.country') }} </h3> </b-col>
              <b-col sm="2"> <div class="text-center"> <img :src="exportTrophyCIPServiceBaseUrl + 'storage/configration/left_logo/1234731657168815.png'" width="70"/> </div></b-col>
              <b-col sm="4"> <h3 class="text-left mt-3"> {{ $t('exportTrophyGazette.gazette') }} </h3></b-col>
          </b-row>
          <b-row>
              <b-col sm="12" class="mt-2"> <div class="text-center"> {{ $t('exportTrophyGazette.extra') }} </div></b-col>
              <b-col sm="12"> <div class="text-center"> {{ $t('exportTrophyGazette.procasona') }} </div></b-col>
          </b-row>
          <b-row>
              <b-col sm="12" class="mb-2"><div class="border border-secondary"></div></b-col>
              <b-col sm="12"> <div class="text-center"> {{ getDayName }}, {{ getDateLocals }} </div></b-col>
              <b-col sm="12" class="mt-2"> <div class="border border-secondary"></div></b-col>
          </b-row>
          <b-row>
              <b-col sm="12" class="mt-4"> <div class="text-center"> {{ $t('exportTrophyGazette.govt_name') }} </div></b-col>
              <b-col sm="12"> <div class="text-center"> <b class="small font-weight-bold"> {{ $t('exportTrophyGazette.ministry_name') }} </b> </div></b-col>
              <b-col sm="12"> <div class="text-center"> <b class="small font-weight-bold">{{ $t('exportTrophyGazette.sub_section_name') }} </b> </div></b-col>
              <b-col sm="6" v-if="form.type === 2"> <div class="mt-2"> <b class="small font-weight-bold"> {{$t('exportTrophyCircular.memo_no')}} : {{ EngBangNum(form.memo_no) }}</b> </div></b-col>
              <b-col sm="3" v-if="form.type === 2">
                <div class="text-right mt-3">{{ $t('globalTrans.date') }} :</div>
              </b-col>
              <b-col sm="3" v-if="form.type === 2">
                <div class="text-left mt-1"> <b class="small font-weight-bold"> {{ getBnDateLocals }} </b> </div>
                <div class="text-left"> <b class="small font-weight-bold border-top border-black pt-1"> {{ getDateLocalsTwo }} </b> </div>
              </b-col>
              <b-col sm="12"> <div class="text-center"> <b class="small font-weight-bold"> {{ $t('exportTrophyGazette.notification') }} </b> </div></b-col>
              <b-col sm="12"> <div class="text-center mt-3 small" v-if="form.type === 1"> {{ currentLocale === 'bn' ? 'তারিখ' : 'Date' }}: {{ getBnDateLocals }}/{{ getDateLocalsTwo }} </div></b-col>
              <b-col sm="12"> <div class="text-center mt-3 small" v-if="form.type === 2"> <span class="border-bottom border-dark">{{ $t('exportTrophyGazette.national_export_tropy') }}: {{ getFiscalYear(form.fiscal_year_id) }} </span> </div></b-col>
          </b-row>
          <b-row class="mt-3">
          <b-col sm="12" v-if="form.type === 1">
            <div> <b class="small font-weight-bold"> {{$t('exportTrophyCircular.memo_no')}} : {{ EngBangNum(form.memo_no) }}</b> {{ currentLocale === 'bn' ? form.title_bn : form.title_en }}</div>
            <div class="text-left display-7 font-weight-bold"> {{ $t('exportTrophyGazette.cip_product_export') + ': ' + EngBangNum(cipApps.length) }}</div>
          </b-col>
          <b-col sm="12" v-if="form.type === 2">
            <div> <b class="small font-weight-bold"> {{ getFiscalYear(form.fiscal_year_id) }}</b> {{ currentLocale === 'bn' ? form.title_bn : form.title_en }} </div>
          </b-col>
          <b-col sm="12" v-if="form.type === 1">
            <div class="table-wrapper table-responsive">
              <table class="table table-striped table-hover table-bordered" v-if="cipApps.length > 0">
                <thead>
                  <tr>
                    <th scope="col"> {{ $t('globalTrans.sl_no') }} </th>
                    <th scope="col"> {{ $t('exportTrophyGazette.name_designation_org_address') }} </th>
                    <th scope="col"> {{ $t('exportTrophyGazette.sector') }} </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in cipApps" :key="index">
                    <td> {{ $n(index + 1) }} </td>
                    <td>
                      {{ getName(item.user_id) }} <br/>
                      {{ currentLocale === 'en' ? item.org_info.designation_en : item.org_info.designation_bn }} <br/>
                      {{ currentLocale === 'en' ? item.org_info.org_name_en : item.org_info.org_name_bn }} <br/>
                      {{ getAddress(item.org_address) }}
                    </td>
                    <td>
                      {{ getProductName(item.product_service_sector_id) }}
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="text-left display-7 font-weight-bold mt-2"> {{ $t('exportTrophyGazette.cip_trade') + ': ' + EngBangNum(cipTrades.length) }} </div>
              <table class="table table-striped table-hover table-bordered" v-if="cipTrades.length > 0">
                <thead>
                  <tr>
                    <th> {{ $t('globalTrans.sl_no') }} </th>
                    <th style="text-align:left"> {{ $t('exportTrophyGazette.name_designation_org') }} </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in cipTrades" :key="index">
                    <td> {{ $n(index + 1) }} </td>
                    <td style="text-align:left">
                      {{ currentLocale === 'en' ? item.name_en : item.name_bn }} <br/>
                      {{ currentLocale === 'en' ? item.fbcci_designation_en +', FBCCI' : item.fbcci_designation_bn +', এফবিসিসিআই' }} <br/>
                      {{ currentLocale === 'en' ? 'Representative ,' + item.referred_association_en :  'প্রতিনিধি ,' + item.referred_association_bn }} <br/>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </b-col>
          <div sm="12" v-if="form.type === 2">
            <div class="table-wrapper table-responsive" v-for="(items, index) in etApps" :key="index">
              <h6> {{ $t('exportTrophyGazette.product_sector') }} : {{ getProductName(parseInt(index)) }} </h6>
              <table class="table table-striped table-hover table-bordered">
                <thead>
                  <tr>
                    <th scope="col"> {{ $t('globalTrans.sl_no') }} </th>
                    <th scope="col"> {{ $t('exportTrophyGazette.trophy_receive_org_name') }} </th>
                    <th scope="col"> {{ $t('exportTrophyGazette.trophy_cat') }} </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index2) in items" :key="index2">
                    <td> {{ $n(parseInt(index2) + 1) }} </td>
                    <td>
                      {{ currentLocale === 'en' ? item.org_info.org_name_en : item.org_info.org_name_bn }} <br/>
                      {{ getAddress(item.org_address) }}
                    </td>
                    <td>
                      <span v-if="item.trophy === 1">{{ $t('exportTrophyConfig.gold') }}</span>
                      <span v-else-if="item.trophy === 2">{{ $t('exportTrophyConfig.silver') }}</span>
                      <span v-else-if="item.trophy === 3">{{ $t('exportTrophyConfig.bronze') }}</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </b-row>
      </b-card>
    </b-overlay>
    <b-row class="text-right">
      <b-col>
        <b-button variant="danger" class="btn-sm" @click="$bvModal.hide('modal-form-details')">{{ $t('globalTrans.cancel') }}</b-button>
      </b-col>
    </b-row>
  </div>
</template>
<script>
import RestApi, { exportTrophyCIPServiceBaseUrl } from '@/config/api_config'
import { gazettesPublishedDetailsApi } from '../../api/routes'
import AddressHelper from '@/utils/area-type-address'
import ExportPdf from './export_pdf_details'
export default {
  name: 'Details',
  props: ['id'],
  data () {
    return {
      AddressHelper: AddressHelper,
      exportTrophyCIPServiceBaseUrl: exportTrophyCIPServiceBaseUrl,
      valid: null,
      customloading: false,
      errors: [],
      userList: [],
      form: [],
      cipApps: [],
      cipTrades: [],
      etApps: []
    }
  },
  created () {
    if (this.id) {
      const tmp = this.getCircular()
      this.form = tmp
      this.detailsData()
      // this.userList = this.userDetails
    }
  },
  computed: {
    currentLocale () {
      return this.$i18n.locale
    },
    getDateLocals () {
      const result = this.form.date.split('-')
      const transDay = this.currentLocale === 'bn' ? this.EngBangNum(result[2]) : result[2]
      const transMonth = this.monthList(parseInt(result[1]))
      const transYear = this.currentLocale === 'bn' ? this.EngBangNum(result[0]) : result[0]
      return transMonth + ' ' + transDay + ', ' + transYear
    },
    getDateLocalsTwo () {
      const result = this.form.date.split('-')
      const transDay = this.currentLocale === 'bn' ? this.EngBangNum(result[2]) : result[2]
      const transMonth = this.monthList(parseInt(result[1]))
      const transYear = this.currentLocale === 'bn' ? this.EngBangNum(result[0]) : result[0]
      return transDay + ' ' + transMonth + ' ' + transYear
    },
    getBnDateLocals () {
      const transDay = this.currentLocale === 'bn' ? this.EngBangNum(this.form.bn_day) : this.form.bn_day
      const transMonth = this.banglaMonthList(parseInt(this.form.bn_month))
      const transYear = this.currentLocale === 'bn' ? this.EngBangNum(this.form.bn_year) : this.form.bn_year
      return transDay + ' ' + transMonth + ' ' + transYear
    },
    getDayName () {
      const date = new Date(this.form.date)
      return this.weekList(parseInt(date.getDay()))
    },
    loading () {
      return this.$store.state.commonObj.loading
    }
  },
  methods: {
    EngBangNum (n) {
      if (this.$i18n.locale === 'bn') {
        return n.toString().replace(/\d/g, d => '০১২৩৪৫৬৭৮৯'[d])
      } else {
        return n.toString().replace(/[০-৯]/g, d => '০১২৩৪৫৬৭৮৯'.indexOf(d))
      }
    },
    getAddress (address) {
      const newAddress = {
        pr_area_type_id: address.area_type_id,
        pr_division_id: address.division_id,
        pr_district_id: address.district_id,
        pr_upazila_id: address.upazila_id,
        pr_city_corporation_id: address.city_corporation_id,
        pr_union_id: address.union_id,
        pr_ward_id: address.ward_id,
        pr_paurashava_id: address.paurashava_id
      }
      const fullAddress = this.AddressHelper.getPresentAddress(newAddress)
      return fullAddress
    },
    getCircular () {
      const tmpData = this.$store.state.list.find(item => item.id === this.id)
      return JSON.parse(JSON.stringify(tmpData))
    },
    getName (id) {
      const userName = this.userList.find(user => user.value === id)
      if (userName !== undefined) {
        if (this.$i18n.locale === 'bn') {
          return userName.text_bn
        } else {
          return userName.text_en
        }
      }
    },
    async detailsData () {
      this.customloading = true
      const result = await RestApi.getData(exportTrophyCIPServiceBaseUrl, gazettesPublishedDetailsApi, this.form)
      if (result.success) {
        if (result.cipApplications) {
          this.cipApps = result.cipApplications
          this.cipTrades = result.cipTrades
        }
        if (result.etApplications) {
          this.etApps = result.etApplications
        }
        this.userList = result.users
        this.customloading = false
      } else {
        this.cipApps = []
        this.cipTrades = []
        this.etApps = []
        this.userList = []
        this.customloading = false
      }
    },
    weekList (Id) {
      const Obj = this.$store.state.commonObj.weekList.find(el => el.value === Id)
      if (typeof Obj !== 'undefined') {
        return this.$i18n.locale === 'bn' ? Obj.text_bn : Obj.text_en
      } else {
        return ''
      }
    },
    monthList (Id) {
      const Obj = this.$store.state.commonObj.monthList.find(el => el.value === Id)
      if (typeof Obj !== 'undefined') {
        return this.$i18n.locale === 'bn' ? Obj.text_bn : Obj.text_en
      } else {
        return ''
      }
    },
    banglaMonthList (Id) {
      const Obj = this.$store.state.commonObj.banglaMonthList.find(el => el.value === Id)
      if (typeof Obj !== 'undefined') {
        return this.$i18n.locale === 'bn' ? Obj.text_bn : Obj.text_en
      } else {
        return ''
      }
    },
    getProductName (Id) {
      const Obj = this.$store.state.ExportTrophyCipService.commonObj.exportSectorList.find(el => el.value === Id)
      if (typeof Obj !== 'undefined') {
        return this.$i18n.locale === 'bn' ? Obj.text_bn : Obj.text_en
      } else {
        return ''
      }
    },
    getFiscalYear (fiscalYear) {
      const fiscalYearObj = this.$store.state.CommonService.commonObj.fiscalYearList.find(fiscal => fiscal.value === parseInt(fiscalYear))
      if (fiscalYearObj !== 'undefined') {
        return this.currentLocale === 'bn' ? fiscalYearObj.text_bn : fiscalYearObj.text_en
      }
    },
    pdfExport () {
      this.customloading = true
      const reportTitle = this.$t('exportTrophyGazette.gazette') + ' ' + this.$t('globalTrans.details')
      ExportPdf.exportPdfDetails(exportTrophyCIPServiceBaseUrl, '/configuration/report-heading/detail', 2, reportTitle, this)
    }
  }
}
</script>
