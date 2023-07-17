<template>
  <div class="inner-section">
    <card>
      <!-- search section start -->
      <template v-slot:searchHeaderTitle>
        <h4 class="card-title">{{ $t('orgProfile.ward') }} {{ $t('globalTrans.search') }}</h4>
      </template>
      <template v-slot:searchBody>
         <b-row>
            <b-col xs="12" sm="12" md="4" lg="4" xl="4">
                <b-form-group
                label-for="type"
                >
                <template v-slot:label>
                    {{ $t('orgProfile.type') }}
                </template>
                <b-form-select
                    plain
                    v-model="search.type"
                    :options="wardTypeList"
                    id="type"
                    >
                <template v-slot:first>
                    <b-form-select-option :value="0">{{$t('globalTrans.select')}}</b-form-select-option>
                </template>
                </b-form-select>
                </b-form-group>
           </b-col>
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
                <b-form-select
                    plain
                    v-model="search.union_id"
                    :options="unionList"
                    id="union_id"
                    >
                <template v-slot:first>
                    <b-form-select-option :value="0">{{$t('globalTrans.select')}}</b-form-select-option>
                </template>
                </b-form-select>
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
        <h4 class="card-title">{{ $t('orgProfile.ward') }} {{ $t('globalTrans.list') }}</h4>
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
    <b-modal id="modal-form" size="lg" :title="formTitle" hide-footer :ok-title="$t('globalTrans.close')" ok-only ok-variant="danger">
      <Form :id="editItemId" :key="editItemId"/>
    </b-modal>
    <b-modal id="details" size="lg" :title="$t('orgProfile.ward') + ' ' + $t('globalTrans.details')"  hide-footer :ok-title="$t('globalTrans.close')" ok-only ok-variant="danger">
      <Details :id="editItemId" :key="editItemId"/>
    </b-modal>
  </div>
</template>
<script>
import Form from './Form.vue'
import Details from './Details.vue'
import RestApi, { commonServiceBaseUrl } from '@/config/api_config'
import { wardList, wardToggleStatus } from '../../api/routes'
import ModalBaseMasterList from '@/mixins/list'

export default {
  mixins: [ModalBaseMasterList],
  components: {
    Form,
    Details
  },
  data () {
    return {
      sortBy: '',
      search: {
        type: 0,
        division_id: 0,
        district_id: 0,
        upazila_id: 0,
        union_id: 0,
        limit: 20
      },
      labelData: [],
      actions: {
        edit: true,
        details: true,
        toogle: true,
        delete: false
      },
      districtList: [],
      upazilaList: [],
      unionList: []

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
    },
    'search.upazila_id': function (newVal, oldVal) {
        this.search.union_id = 0
        if (newVal !== oldVal) {
            this.unionList = this.getUnionList(newVal)
        } else {
           this.unionList = []
        }
    }
  },
  computed: {
    labelList () {
      return [
        { label_en: this.$t('globalTrans.sl_no', 'en'), label_bn: this.$t('globalTrans.sl_no', 'bn'), class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 1, thStyle: { width: '9%' } },
        { label_en: this.$t('orgProfile.type', 'en'), label_bn: this.$t('orgProfile.type', 'bn'), class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 2, thStyle: { width: '10%' } },
        { label_en: this.$t('orgProfile.division_name', 'en'), label_bn: this.$t('orgProfile.division_name', 'bn'), class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 3, thStyle: { width: '10%' } },
        { label_en: this.$t('orgProfile.district_name', 'en'), label_bn: this.$t('orgProfile.district_name', 'bn'), class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 4, thStyle: { width: '10%' } },
        { label_en: this.$t('orgProfile.upazila_name', 'en'), label_bn: this.$t('orgProfile.upazila_name', 'bn'), class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 5, thStyle: { width: '10%' } },
        { label_en: this.$t('orgProfile.union_name', 'en'), label_bn: this.$t('orgProfile.union_name', 'bn'), class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 6, thStyle: { width: '10%' } },
        { label_en: this.$t('orgProfile.city_corporation', 'en'), label_bn: this.$t('orgProfile.city_corporation', 'bn'), class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 7, thStyle: { width: '10%' } },
        { label_en: this.$t('orgProfile.municipality', 'en'), label_bn: this.$t('orgProfile.municipality', 'bn'), class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 8, thStyle: { width: '10%' } },
        { label_en: this.$t('globalTrans.status', 'en'), label_bn: this.$t('globalTrans.status', 'bn'), class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 9 },
        { label_en: this.$t('globalTrans.action', 'en'), label_bn: this.$t('globalTrans.action', 'bn'), class: 'text-left', show: '1', order: 10 }
      ]
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
          { key: 'type_bn' },
          { key: 'division_name_bn' },
          { key: 'district_name_bn' },
          { key: 'upazila_name_bn' },
          { key: 'union_name_bn' },
          { key: 'city_corporation_bn' },
          { key: 'municipality_bn' },
          { key: 'status' },
          { key: 'action' }
        ]
      } else {
        keys = [
          { key: 'serial' },
          { key: 'type_en' },
          { key: 'division_name' },
          { key: 'district_name' },
          { key: 'upazila_name' },
          { key: 'union_name' },
          { key: 'city_corporation' },
          { key: 'municipality' },
          { key: 'status' },
          { key: 'action' }
        ]
      }
      return labels.map((item, index) => {
        return Object.assign(item, keys[index])
      })
    },
    formTitle () {
      return (this.editItemId === 0) ? this.$t('orgProfile.ward') + ' ' + this.$t('globalTrans.entry') : this.$t('orgProfile.ward') + ' ' + this.$t('globalTrans.modify')
    },
    divisionList () {
      return this.$store.state.CommonService.commonObj.divisionList.filter(item => item.status === 1)
    },
    wardTypeList: function () {
        const objectData = this.$store.state.commonObj.typeList
        return objectData.map((obj, key) => {
            if (this.$i18n.locale === 'bn') {
                return { value: obj.id, text: obj.name_bn }
            } else {
                return { value: obj.id, text: obj.name }
            }
        })
    }
  },
  methods: {
    editMethodInParent (item, type) {
      if (type === 1) {
        this.edit(item)
      } else if (type === 2) {
        this.changeStatus(1, commonServiceBaseUrl, wardToggleStatus, item)
      }
    },
    searchData () {
      this.loadData()
    },
    async loadData () {
      const params = Object.assign({}, this.search, { page: this.pagination.currentPage, per_page: this.pagination.perPage })
      this.$store.dispatch('mutateCommonProperties', { loading: true, listReload: false })
      const result = await RestApi.getData(commonServiceBaseUrl, wardList, params)
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
        const unionObj = this.$store.state.CommonService.commonObj.unionList.find(union => union.value === parseInt(item.union_id))
        const unionData = {}
        if (typeof unionObj !== 'undefined') {
            unionData.union_name = unionObj.text_en
            unionData.union_name_bn = unionObj.text_bn
        } else {
            unionData.union_name = ' '
            unionData.union_name_bn = ' '
        }
        const cityCorporationObj = this.$store.state.CommonService.commonObj.cityCorporationList.find(corporation => corporation.value === parseInt(item.city_corporation_id))
        const cityCorporationData = {}
        if (typeof cityCorporationObj !== 'undefined') {
            cityCorporationData.city_corporation = cityCorporationObj.text_en
            cityCorporationData.city_corporation_bn = cityCorporationObj.text_bn
        } else {
            cityCorporationData.city_corporation = ' '
            cityCorporationData.city_corporation_bn = ' '
        }
        const wardTypeObj = this.$store.state.commonObj.typeList.find(wardType => wardType.id === parseInt(item.type))
        const typeData = {}
        if (typeof wardTypeObj !== 'undefined') {
            typeData.type_en = wardTypeObj.name
            typeData.type_bn = wardTypeObj.name_bn
        } else {
            typeData.type_en = ' '
            typeData.type_bn = ' '
        }
        const municipalityObj = this.$store.state.CommonService.commonObj.municipalityList.find(municipality => municipality.value === parseInt(item.municipality_id))
        const municipalityData = {}
        if (typeof municipalityObj !== 'undefined') {
            municipalityData.municipality = municipalityObj.text_en
            municipalityData.municipality_bn = municipalityObj.text_bn
        } else {
            municipalityData.municipality = ' '
            municipalityData.municipality_bn = ' '
        }
        return Object.assign({}, item, { serial: index }, divisionData, districtData, upazillaData, unionData, cityCorporationData, typeData, municipalityData)
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
    },
    getUnionList (upazilaId) {
       return this.$store.state.CommonService.commonObj.unionList.filter(item => item.status === 1 && item.upazila_id === upazilaId)
    }
  }
}
</script>
