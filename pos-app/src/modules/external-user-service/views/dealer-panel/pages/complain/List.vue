<template>
  <div class="inner-section">
    <card>
    </card>
    <body-card>
      <!-- table section start -->
      <template v-slot:headerTitle>
        <h4 class="card-title">{{ $t('manage_information.complain') }} {{ $t('globalTrans.list') }}</h4>
      </template>
      <template v-slot:headerAction>
         <a href="javascript:" class="btn-add" @click="resetId" v-b-modal.modal-form><i class="ri-add-fill"></i> {{ $t('globalTrans.add_new') }}</a>
      </template>
      <template v-slot:body>
        <b-overlay :show="loadingState">
          <select-column-check v-on:editMethodInParent="editMethodInParent" :labelData="labelData" :search="search" :columns="columns" />
          <b-row>
            <b-col md="12" class="table-responsive">
              <slot v-if="columns.filter(item => item.show === '1').length > 0">
                <b-table :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection" head-variant="primary" class="tg" :items="listData" :emptyText="$t('globalTrans.noDataFound')" show-empty bordered hover :fields="columns.filter(item => item.show === '1').sort((a, b) => { return a.order - b.order })">
                  <template v-slot:cell(serial)="data">
                    {{ $n(data.item.serial +1) }}
                  </template>
                  <template v-slot:cell(complain_id)="data">
                    {{ data.item.complain_id }}
                  </template>
                  <template v-slot:cell(office_id)="data">
                    {{ data.item.office_id }}
                  </template>
                  <template v-slot:cell(compailer_name)="data">
                    {{ data.item.compailer_name }}
                  </template>
                  <template v-slot:cell(subject)="data">
                    {{ data.item.subject }}
                  </template>
                  <template v-slot:cell(details)="data">
                    {{ data.item.details }}
                  </template>
                  <template v-slot:cell(status)="data">
                    <span class="badge badge-primary" v-if="data.item.status == 0">{{$t('globalTrans.pending')}}</span>
                    <span class="badge badge-primary" v-if="data.item.status == 1">{{$t('manage_information.done')}}</span>
                  </template>
                  <template v-slot:cell(action)="data">
                     <b-button v-b-modal.modal-form-feedback @click="editMethodInParent(data.item,1)" class="btn btn-sm btn-success">{{$t('manage_information.feedback')}}
                     </b-button>
                  </template>
                </b-table>
              </slot>
              <div class="pagination-wrapper mt-3" v-if="columns.filter(item => item.show === '1').length > 0">
                <b-pagination
                  v-model="pagination.currentPage"
                  :perPage="search.limit"
                  :total-rows="pagination.totalRows"
                  @input="searchData"
                />
               </div>
            </b-col>
          </b-row>
        </b-overlay>
      </template>
      <!-- table section end -->
    </body-card>
    <b-modal id="modal-form" size="lg" :title="formTitle" hide-footer :ok-title="$t('globalTrans.close')" ok-only ok-variant="danger">
      <Form :id="editItemId" :key="editItemId"/>
    </b-modal>
    <b-modal id="modal-form-feedback" size="lg" :title="formTitle" hide-footer :ok-title="$t('globalTrans.close')" ok-only ok-variant="danger">
      <ViewFeedback :id="editItemId" :key="editItemId"/>
    </b-modal>
  </div>
</template>
<script>
import Form from './Form.vue'
import ViewFeedback from './viewFeedback.vue'
import RestApi, { licenseRegistrationServiceBaseUrl } from '@/config/api_config'
import { complainList } from '../../api/routes'
import ModalBaseMasterList from '@/mixins/list'

export default {
  mixins: [ModalBaseMasterList],
  components: {
    Form,
    ViewFeedback
  },
  data () {
    return {
      licenseRegistrationServiceBaseUrl: licenseRegistrationServiceBaseUrl,
      sortBy: '',
      sortDesc: true,
      sortDirection: 'desc',
      search: {
        office_id: 0,
        complain_id: '',
        limit: 10
      },
      labelData: [
        { labels: 'globalTrans.sl_no', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 1, thStyle: { width: '5%' } },
        { labels: 'manage_information.complain_id', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 2, thStyle: { width: '20%' } },
        { labels: 'manage_information.regional_office', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 3, thStyle: { width: '' } },
        { labels: 'manage_information.complainer_name', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 3, thStyle: { width: '' } },
        { labels: 'manage_information.subject', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 3, thStyle: { width: '' } },
        { labels: 'manage_information.details', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 3, thStyle: { width: '' } },
        { labels: 'globalTrans.status', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 4 },
        { labels: 'dealer.feedback', class: 'text-left', sortable: true, stickyColumn: false, show: '1', order: 5 }
      ],
      actions: {
        edit: true,
        details: false,
        toogle: true,
        delete: false
      }
    }
  },
  created () {
    this.loadData()
  },
  watch: {
    'search.limit': function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.loadData()
      }
    }
  },
  computed: {
    columns () {
      const labelData = this.labelData
      const labels = labelData.map((item, index) => {
        return Object.assign(item, { label: this.$t(item.labels, this.$i18n.locale) })
      })
      let keys = []
      if (this.$i18n.locale === 'bn') {
        keys = [
          { key: 'serial' },
          { key: 'complain_id' },
          { key: 'office_name_bn' },
          { key: 'complainer_name' },
          { key: 'subject' },
          { key: 'details' },
          { key: 'status' },
          { key: 'action' }
        ]
      } else {
        keys = [
          { key: 'serial' },
          { key: 'complain_id' },
          { key: 'office_name' },
          { key: 'complainer_name' },
          { key: 'subject' },
          { key: 'details' },
          { key: 'status' },
          { key: 'action' }
        ]
      }
      return labels.map((item, index) => {
        return Object.assign(item, keys[index])
      })
    },
    formTitle () {
      return (this.editItemId === 0) ? this.$t('dealer.complain') + ' ' + this.$t('globalTrans.entry') : this.$t('dealer.complain') + ' ' + this.$t('globalTrans.details')
    },
   getRegionalOfficeList (orgId = null) {
      const officeList = this.$store.state.CommonService.commonObj.officeList.map(item => {
        if (this.$i18n.locale === 'bn') {
          return { value: item.value, text: item.text_bn }
        } else {
          return { value: item.value, text: item.text_en }
        }
        })
      return officeList
    },
    serviceList () {
        return this.$store.state.LicenseRegistrationService.commonObj.serviceNamesList.filter(item => item.status === 1)
    }
  },
  methods: {
    editMethodInParent (item, type) {
      if (type === 1) {
        this.edit(item)
      }
    },
    searchData () {
      this.loadData()
    },
    async loadData () {
      const params = Object.assign({}, { page: this.pagination.currentPage, per_page: this.pagination.perPage })
      this.$store.dispatch('mutateCommonProperties', { loading: true, listReload: false })
      const result = await RestApi.getData(licenseRegistrationServiceBaseUrl, complainList, params)
      if (result.success) {
        const listData = result.data.map((item, index) => {
          const officeObj = this.$store.state.CommonService.commonObj.officeList.find(law => law.value === parseInt(item.office_id))
           const officeData = {}
            if (typeof officeObj !== 'undefined') {
                officeData.office_name = officeObj.text_en
                officeData.office_name_bn = officeObj.text_bn
            } else {
              officeData.office_name = ''
              officeData.office_name_bn = ''
            }
            // const complainerObj = this.$store.state.CommonService.commonObj.designationList.find(law => law.value === parseInt(item.user_id))
            // const complainerData = {}
            // if (typeof complainerObj !== 'undefined') {
            //     complainerData.complainer_name = complainerObj.text_en
            //     complainerData.complainer_name_bn = complainerObj.text_bn
            // } else {
            //   complainerData.complainer_name = ''
            //   complainerData.complainer_name_bn = ''
            // }
          return Object.assign({}, item, { serial: index }, officeData)
        })
        this.$store.dispatch('setList', listData)
        this.paginationData(result.data, this.search.limit)
      } else {
        this.$store.dispatch('setList', [])
        this.paginationData([])
      }
      this.$store.dispatch('mutateCommonProperties', { loading: false, listReload: false })
    }
  }
}
</script>
