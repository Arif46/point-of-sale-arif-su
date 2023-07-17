<template>
  <div class="inner-section">
    <card>
      <!-- search section start -->
      <template v-slot:searchHeaderTitle>
        <h4 class="card-title">City Corporation Search</h4>
      </template>
      <template v-slot:searchBody>
        <b-row>
           <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <b-form-group
              label-for="division_name"
            >
              <template v-slot:label>
                {{ $t('orgProfile.division_name') }}
              </template>
            <b-form-select
                plain
                v-model="search.division_id"
                :options="divisionList"
                id="division_id"
                >
            <template v-slot:first>
                <b-form-select-option :value="0">{{$t('globalTrans.select')}}</b-form-select-option>
            </template>
            </b-form-select>
            </b-form-group>
          </b-col>
           <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <b-form-group
              label-for="district_name"
            >
              <template v-slot:label>
                {{ $t('orgProfile.district_name') }}
              </template>
            <b-form-select
                plain
                v-model="search.district_id"
                :options="districtList"
                id="district_id"
                >
            <template v-slot:first>
                <b-form-select-option :value="0">{{$t('globalTrans.select')}}</b-form-select-option>
            </template>
            </b-form-select>
            </b-form-group>
          </b-col>
          <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <b-form-group
              label-for="name"
            >
              <template v-slot:label>
                City Corporation Name
              </template>
              <b-form-input
                  id="name"
                  type="text"
                  v-model="search.name"
              ></b-form-input>
            </b-form-group>
          </b-col>
          <b-col sm="4">
            <b-button size="sm" variant="primary" class="mt-20" @click="searchData">
              <i class="ri-search-line"></i> {{ $t('globalTrans.search') }}
            </b-button>
          </b-col>
        </b-row>
      </template>
      <!-- search section end -->
    </card>

    <body-card>
      <!-- table section start -->
      <template v-slot:headerTitle>
        <h4 class="card-title">City Corporation List</h4>
      </template>
      <template v-slot:headerAction>
        <a href="javascript:" class="btn-add" @click="resetId" v-b-modal.modal-form><i class="ri-add-fill"></i> {{ $t('globalTrans.add_new') }}</a>
      </template>
      <template v-slot:body>
        <b-overlay :show="loadingState">
          <base-table v-on:editMethodInParent="editMethodInParent" :labelData="labelData" :columns="columns" :search="search" :searchData="searchData" :paginations="pagination" :actions="actions" />
        </b-overlay>
      </template>
      <!-- table section end -->
    </body-card>
    <b-modal id="modal-form" size="md" :title="formTitle" hide-footer :ok-title="$t('globalTrans.close')" ok-only ok-variant="danger">
      <Form :id="editItemId" :key="editItemId"/>
    </b-modal>
  </div>
</template>
<style scoped>
table#table-transition-example .flip-list-move {
  transition: transform 1s;
}
</style>
<script>
import Form from './Form.vue'
import RestApi, { apiBaseUrl } from '@/config/api_config'
import { cityCorporationList, cityCorporationToggle } from '../../api/routes'
import ModalBaseMasterList from '@/mixins/list'
import i18n from '@/i18n'

const defaultColumn = [
  { label_en: i18n.messages.en.globalTrans.sl_no, label_bn: i18n.messages.bn.globalTrans.sl_no, class: 'text-center', sortable: true, stickyColumn: true, show: '1', order: 1 },
  { label_en: i18n.messages.en.orgProfile.division_name, label_bn: i18n.messages.bn.orgProfile.division_name_bn, class: 'text-center', sortable: true, stickyColumn: true, show: '1', order: 2 },
  { label_en: i18n.messages.en.orgProfile.district_name, label_bn: i18n.messages.bn.orgProfile.district_name_bn, class: 'text-center', sortable: true, stickyColumn: true, show: '1', order: 3 },
  { label_en: i18n.messages.en.orgProfile.city_corporation, label_bn: i18n.messages.bn.orgProfile.city_corporation, class: 'text-center', sortable: true, stickyColumn: true, show: '1', order: 3 },
  { label_en: i18n.messages.en.globalTrans.status, label_bn: i18n.messages.bn.globalTrans.status, class: 'text-center', sortable: true, stickyColumn: true, show: '1', order: 4 },
  { label_en: i18n.messages.en.globalTrans.action, label_bn: i18n.messages.bn.globalTrans.action, class: 'text-center', show: '1', order: 5 }
]
export default {
  mixins: [ModalBaseMasterList],
  components: {
    Form
  },
  data () {
    return {
      transProps: {
        name: 'flip-list'
      },
      sortBy: '',
      search: {
        name: '',
        division_id: 0,
        district_id: 0,
        limit: 20
      },
      sortDesc: true,
      sortDirection: 'desc',
      labelData: [],
      districtList: [],
      actions: {
        edit: true,
        toogle: true,
        delete: false
      }
    }
  },
  created () {
    this.labelData = this.labelList
    this.loadData()
  },
  watch: {
    'search.limit': function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.loadData()
      }
    },
    'search.division_id': function (newVal, oldVal) {
        this.search.district_id = 0
        if (newVal !== oldVal) {
            this.districtList = this.getDistrictList(newVal)
        } else {
            this.districtList = []
        }
    }
  },
  computed: {
    labelList: function () {
      const dataList = defaultColumn
      return dataList.map(item => {
        if (this.$i18n.locale === 'bn') {
          const data = { value: item.label_en, text: item.label_bn }
          return Object.assign({}, item, data)
        } else {
          const data = { value: item.label_en, text: item.label_en }
          return Object.assign({}, item, data)
        }
      })
    },
    columns () {
      const labelData = this.labelData
      const labels = labelData.map((item, index) => {
        const labelData = {}
        labelData.label = this.$i18n.locale === 'bn' ? item.label_bn : item.label_en
        return Object.assign(item, labelData)
      })
      let keys = []
        keys = [
          { key: 'serial' },
          { key: 'division_name' },
          { key: 'district_name' },
          { key: 'name' },
          { key: 'status' },
          { key: 'action' }
        ]
      return labels.map((item, index) => {
        return Object.assign(item, keys[index])
      })
    },
    formTitle () {
      return (this.editItemId === 0) ? 'City Corporation' + ' ' + this.$t('globalTrans.entry') : 'City Corporation' + ' ' + this.$t('globalTrans.modify')
    },
    pageOptions () {
      return this.$store.state.commonObj.pageOptions
    },
    currentLocale () {
      return this.$i18n.locale
    },
    divisionList () {
        return this.$store.state.CommonService.commonObj.divisionList.filter(item => item.status === 1)
    }
  },
  methods: {
    editMethodInParent (item, type) {
      if (type === 1) {
        this.edit(item)
      } else if (type === 2) {
        this.changeStatus(1, apiBaseUrl, cityCorporationToggle, item)
      }
    },
    searchData () {
      this.loadData()
    },
    async loadData () {
      const params = Object.assign({}, this.search, { page: this.pagination.currentPage, per_page: this.pagination.perPage })
      this.$store.dispatch('mutateCommonProperties', { loading: true, listReload: false })
      const result = await RestApi.getData(apiBaseUrl, cityCorporationList, params)
      if (result.success) {
        const listData = result.data.data.map((item, index) => {
        const divisionObj = this.$store.state.CommonService.commonObj.divisionList.find(division => division.value === parseInt(item.division_id))
        const districtObj = this.$store.state.CommonService.commonObj.districtList.find(district => district.value === parseInt(item.district_id))
        const divisionData = {}
        const districtData = {}
            if (typeof divisionObj !== 'undefined') {
                divisionData.division_name = divisionObj.text
            } else {
                divisionData.division_name = ''
            }
            if (typeof districtObj !== 'undefined') {
                districtData.district_name = districtObj.text
            } else {
                districtData.district_name = ''
            }
          return Object.assign({}, item, { serial: index }, divisionData, districtData)
        })
        this.$store.dispatch('setList', listData)
        this.paginationData(result.data, this.search.limit)
      } else {
        this.$store.dispatch('setList', [])
        this.paginationData([])
      }
      this.$store.dispatch('mutateCommonProperties', { loading: false, listReload: false })
    },
    getDistrictList (id) {
      return this.$store.state.CommonService.commonObj.districtList.filter(item => item.status === 1 && item.division_id === id)
    }
    // remove (item) {
    //   this.changeStatus(apiBaseUrl, pauroshavaToggle, item)
    // }
  }
}
</script>
