<template>
  <div class="inner-section">
    <card>
      <!-- search section start -->
      <template v-slot:searchHeaderTitle>
        <h4 class="card-title">{{ $t('orgProfile.union') }} {{$t('globalTrans.search')}}</h4>
      </template>
      <template v-slot:searchBody>
        <b-row>
           <b-col xs="12" sm="12" md="4" lg="4" xl="4">
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
            <b-col xs="12" sm="12" md="4" lg="4" xl="4">
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
           <b-col xs="12" sm="12" md="4" lg="4" xl="4">
                <b-form-group
                label-for="upazila_name"
                >
                <template v-slot:label>
                    {{ $t('orgProfile.upazila_name') }}
                </template>
                <b-form-select
                    plain
                    v-model="search.upazila_id"
                    :options="upazilaList"
                    id="upazila_id"
                    >
                <template v-slot:first>
                    <b-form-select-option :value="0">{{$t('globalTrans.select')}}</b-form-select-option>
                </template>
                </b-form-select>
                </b-form-group>
          </b-col>
          <b-col xs="12" sm="12" md="4" lg="4" xl="4">
            <b-form-group
              label-for="union_name"
            >
              <template v-slot:label>
                {{ $t('orgProfile.union_name') }}
              </template>
              <b-form-input
                  id="union_name"
                  type="text"
                  v-model="search.union_name"
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
        <h4 class="card-title">{{ $t('orgProfile.union_list') }}</h4>
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
import RestApi, { commonServiceBaseUrl } from '@/config/api_config'
import { unionList, unionToggleStatus } from '../../api/routes'
import ModalBaseMasterList from '@/mixins/list'
import i18n from '@/i18n'

const defaultColumn = [
  { label_en: i18n.messages.en.globalTrans.sl_no, label_bn: i18n.messages.bn.globalTrans.sl_no, class: 'text-center', sortable: true, stickyColumn: true, show: '1', order: 1, thStyle: { width: '10%' } },
  { label_en: i18n.messages.en.orgProfile.division_name, label_bn: i18n.messages.bn.orgProfile.division_name_bn, class: 'text-center', sortable: true, stickyColumn: true, show: '1', order: 2, thStyle: { width: '15%' } },
  { label_en: i18n.messages.en.orgProfile.district_name, label_bn: i18n.messages.bn.orgProfile.district_name_bn, class: 'text-center', sortable: true, stickyColumn: true, show: '1', order: 3, thStyle: { width: '15%' } },
  { label_en: i18n.messages.en.orgProfile.upazila_name, label_bn: i18n.messages.bn.orgProfile.upazila_name_bn, class: 'text-center', sortable: true, stickyColumn: true, show: '1', order: 4, thStyle: { width: '15%' } },
  { label_en: i18n.messages.en.orgProfile.union_name, label_bn: i18n.messages.bn.orgProfile.union_name_bn, class: 'text-center', sortable: true, stickyColumn: true, show: '1', order: 5, thStyle: { width: '15%' } },
  { label_en: i18n.messages.en.globalTrans.status, label_bn: i18n.messages.bn.globalTrans.status, class: 'text-center', sortable: true, stickyColumn: true, show: '1', order: 6 },
  { label_en: i18n.messages.en.globalTrans.action, label_bn: i18n.messages.bn.globalTrans.action, class: 'text-center', show: '1', order: 7 }
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
        union_name: '',
        division_id: 0,
        district_id: 0,
        upazila_id: 0,
        limit: 20
      },
      sortDesc: true,
      sortDirection: 'desc',
      labelData: [],
      districtList: [],
      upazilaList: [],
      actions: {
        edit: true,
        details: false,
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
    },
    'search.district_id': function (newVal, oldVal) {
        this.search.upazila_id = 0
        if (newVal !== oldVal) {
            this.upazilaList = this.getUpazilaList(newVal)
        } else {
            this.upazilaList = []
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
      if (this.$i18n.locale === 'bn') {
        keys = [
          { key: 'serial' },
          { key: 'division_name_bn' },
          { key: 'district_name_bn' },
          { key: 'upazila_name_bn' },
          { key: 'union_name_bn' },
          { key: 'status' },
          { key: 'action' }
        ]
      } else {
        keys = [
          { key: 'serial' },
          { key: 'division_name' },
          { key: 'district_name' },
          { key: 'upazila_name' },
          { key: 'union_name' },
          { key: 'status' },
          { key: 'action' }
        ]
      }
      return labels.map((item, index) => {
        return Object.assign(item, keys[index])
      })
    },
    formTitle () {
      return (this.editItemId === 0) ? this.$t('orgProfile.union') + ' ' + this.$t('globalTrans.entry') : this.$t('orgProfile.union') + ' ' + this.$t('globalTrans.modify')
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
    searchData () {
      this.loadData()
    },
    editMethodInParent (item, type) {
      if (type === 1) {
        this.edit(item)
      } else if (type === 2) {
        this.changeStatus(1, commonServiceBaseUrl, unionToggleStatus, item)
      }
    },
    async loadData () {
      const params = Object.assign({}, this.search, { page: this.pagination.currentPage, per_page: this.pagination.perPage })
      this.$store.dispatch('mutateCommonProperties', { loading: true, listReload: false })
      const result = await RestApi.getData(commonServiceBaseUrl, unionList, params)
      if (result.success) {
        const listData = result.data.data.map((item, index) => {
        const divisionObj = this.$store.state.CommonService.commonObj.divisionList.find(division => division.value === parseInt(item.division_id))
        const divisionData = {}
            if (typeof divisionObj !== 'undefined') {
                divisionData.division_name = divisionObj.text_en
                divisionData.division_name_bn = divisionObj.text_bn
            } else {
                divisionData.division_name = ''
                divisionData.division_name_bn = ''
            }
        const districtObj = this.$store.state.CommonService.commonObj.districtList.find(district => district.value === parseInt(item.district_id))
        const districtData = {}
        if (typeof districtObj !== 'undefined') {
            districtData.district_name = districtObj.text_en
            districtData.district_name_bn = districtObj.text_bn
        } else {
            districtData.district_name = ''
            districtData.district_name_bn = ''
        }
        const upazilaObj = this.$store.state.CommonService.commonObj.upazilaList.find(upazilla => upazilla.value === parseInt(item.upazila_id))
        const upazillaData = {}
        if (typeof upazilaObj !== 'undefined') {
            upazillaData.upazila_name = upazilaObj.text_en
            upazillaData.upazila_name_bn = upazilaObj.text_bn
        } else {
            upazillaData.upazila_name = ' '
            upazillaData.upazila_name_bn = ' '
        }
        return Object.assign({}, item, { serial: index }, divisionData, districtData, upazillaData)
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
    },
    getUpazilaList (id) {
        return this.$store.state.CommonService.commonObj.upazilaList.filter(item => item.status === 1 && item.district_id === id)
    }
  }
}
</script>
