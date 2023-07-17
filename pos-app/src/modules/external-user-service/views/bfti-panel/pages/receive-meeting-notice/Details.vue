<template>
  <b-row>
   <b-row>
      <b-col lg="12" sm="12">
        <iq-card>
          <template>
            <b-row>
              <b-col lg="12" sm="12">
                <b-overlay :show="loading">
                  <b-button @click="pdfExport" class="btn-add">
                    {{ $t('globalTrans.print') }}
                  </b-button>
                  <b-row class="m-4">
                    <b-col md="6" lg="6"> {{ detailsData.memo_no }}</b-col>
                    <b-col md="6" lg="6" class="text-right"> {{ $t('globalTrans.date') }}- {{ todayDate() }}. </b-col>
                  </b-row>
                  <b-row>
                    <b-col md="12 text-center">
                      <span class="badge badge-white text-dark font-weight-bold card-title"><h5>
                        {{ detailsData.meeting_title_en }} <br />
                        {{ detailsData.venue_en }} <br />
                        {{ $t('globalTrans.date') }}: {{ formatted(detailsData.meeting_date) }}
                        </h5></span>
                    </b-col>
                    <b-col lg="12" sm="12" class="m-4">
                      <div>
                        <p class="text-weight-bold"> {{ $t('systemActivityManage.agenda') }}: <br /> </p>
                        <p class="text-dark pl-4" v-html="detailsData.agenda_text_en"></p>
                        <!-- <b-col md="12 text-center">
                          <span class="badge badge-primary card-title"><h5>{{ $t('globalTrans.details') }}</h5></span>
                        </b-col> -->
                        <b-table-simple hover small caption-top responsive striped bordered>
                          <b-tr>
                            <b-th>{{ $t('systemActivityManage.item') }}</b-th>
                            <b-th>{{ $t('systemActivityManage.decision') }}</b-th>
                             <b-th>{{ $t('systemActivityManage.update') }}</b-th>
                            <b-th>{{ $t('globalTrans.designation') }}</b-th>
                             <b-th>{{ $t('stakeholder.employee_name') }}</b-th>
                          </b-tr>
                          <template v-for="(head, index) in detailsData.heads">
                            <slot v-for="(detail, index1) in head.details">
                              <b-tr v-if="index1 === 0" :key="index">
                                <b-td colspan="5"><h5>{{ head.head_title_en }}</h5></b-td>
                              </b-tr>
                              <b-tr>
                                <b-td> {{ detail.item }} </b-td>
                                <b-td> {{ detail.decision }} </b-td>
                                <b-td> {{ detail.update }} </b-td>
                                <b-td> {{ getDesignationList(detail.designation_id) }} </b-td>
                                <b-td> {{ getEmployeeName(detail.employee_user_id) }} </b-td>
                              </b-tr>
                            </slot>
                          </template>
                        </b-table-simple>
                      </div>
                    </b-col>
                  </b-row>
                </b-overlay>
              </b-col>
            </b-row>
          </template>
        </iq-card>
      </b-col>
    </b-row>
  </b-row>
</template>
<script>
import RestApi, { authServiceBaseUrl, bazarMonitoringServiceBaseUrl, bftiResReportServiceBaseUrl } from '@/config/api_config'
import { userListByDesignWise, detailsDataApi } from '../../api/routes'
import ExportPdf from './export_pdf_details'

export default {
  name: 'Details',
  props: ['id', 'item'],
  data () {
    return {
      loading: true,
      errors: [],
      detailsData: [],
      officer: {}
    }
  },
  created () {
    this.getAllUserList()
    if (this.item) {
      // const tmp = this.getDetailsData()
      // this.detailsData = tmp
      const tmp = this.DetailsData()
      this.detailsData = tmp
    }
  },
  methods: {
    getAllUserList () {
      this.$store.dispatch('mutateCommonProperties', { loading: true })
      const loadingState = { loading: false, listReload: false }
      this.userLoading = true
      RestApi.getData(authServiceBaseUrl, userListByDesignWise).then(response => {
        if (response.success) {
          this.allUserList = response.data
        }
      })
      loadingState.listReload = true
      this.$store.dispatch('mutateCommonProperties', loadingState)
    },
    getDetailsData () {
      const tmpData = this.$store.state.list.find(item => item.id === this.id)
      return JSON.parse(JSON.stringify(tmpData))
    },
    DetailsData () {
      this.loading = true
      const params = Object.assign({}, { id: this.item.id })
      RestApi.getData(bftiResReportServiceBaseUrl, detailsDataApi, params).then(response => {
        if (response.success) {
          this.detailsData = response.data
        }
        this.loading = false
      })
    },
    findUser (desigId, userId) {
      const params = Object.assign({}, { designation_id: desigId })
      this.loading = true
      RestApi.getData(authServiceBaseUrl, userListByDesignWise, params).then(response => {
        if (response.success) {
          this.officer = response.data.find(user => user.id === userId)
        }
        this.loading = false
      })
    },
    getDesignationList (id) {
      const data = this.$store.state.CommonService.commonObj.designationList.find(desig => desig.value === parseInt(id))
      return data !== 'undefined' ? data.text : ''
    },
    pdfExport () {
      const reportTitle = this.$t('systemActivityManage.meeting_information') + ' ' + this.$t('globalTrans.details')
      ExportPdf.exportPdfDetails(bazarMonitoringServiceBaseUrl, '/configuration/report-head/detail', 11, reportTitle, this, this.detailsData, this.todayDate(), this.formatted(this.detailsData.meeting_date))
    },
    formatted (value) {
      return new Date(value).toLocaleString(this.$i18n.locale + '-GB', {
        day: 'numeric', // numeric, 2-digit
        year: 'numeric', // numeric, 2-digit
        month: 'long' // numeric, 2-digit, long, short, narrow
      })
    },
    EngBangNum (n) {
      if (this.$i18n.locale === 'bn') {
        return n.toString().replace(/\d/g, d => '০১২৩৪৫৬৭৮৯'[d])
      } else {
        return n.toString().replace(/[০-৯]/g, d => '০১২৩৪৫৬৭৮৯'.indexOf(d))
      }
    },
    todayDate () {
      const today = new Date().toISOString().slice(0, 10)
      return this.formatted(today)
    },
    getEmployeeName (empID) {
      const empData = this.allUserList.find(user => user.id === empID)
      if (empData) {
        return empData.name
      }
    }
    // getDesignationList (id) {
    //   const data = this.$store.state.CommonService.commonObj.designationList.find(desig => desig.value === parseInt(id))
    //   return data !== 'undefined' ? data.text : ''
    // }
  }
}
</script>
