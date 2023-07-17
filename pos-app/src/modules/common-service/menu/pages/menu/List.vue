<template>
  <div class="inner-section">
    <card>
      <!-- search section start -->
      <template v-slot:searchHeaderTitle>
        <h4 class="card-title">{{ $t('menu.menu') }}</h4>
      </template>
      <template v-slot:searchBody>
        <b-row>
          <b-col sm="3">
            <b-form-group
              label-for="component_id"
            >
            <template v-slot:label>
              {{$t('menu.component')}}
            </template>
            <b-form-select
              plain
              v-model="search.component_id"
              :options="componentList"
              id="component_id"
            >
              <template v-slot:first>
                <b-form-select-option :value=0>{{$t('globalTrans.select')}}</b-form-select-option>
              </template>
            </b-form-select>
            </b-form-group>
          </b-col>
          <b-col sm="3">
            <b-form-group
              label-for="module_id"
            >
            <template v-slot:label>
              {{$t('menu.module')}}
            </template>
            <b-form-select
              plain
              v-model="search.module_id"
              :options="moduleList"
              id="module_id"
            >
              <template v-slot:first>
                <b-form-select-option :value=0>{{$t('globalTrans.select')}}</b-form-select-option>
              </template>
            </b-form-select>
            </b-form-group>
          </b-col>
          <b-col sm="3">
            <b-form-group
              label-for="service_id"
            >
            <template v-slot:label>
              {{$t('menu.service')}}
            </template>
            <b-form-select
              plain
              v-model="search.service_id"
              :options="serviceList"
              id="service_id"
            >
              <template v-slot:first>
                <b-form-select-option :value=0>{{$t('globalTrans.select')}}</b-form-select-option>
              </template>
            </b-form-select>
            </b-form-group>
          </b-col>
          <b-col sm="3">
            <b-form-group
              label-for="menu_name"
            >
              <template v-slot:label>
                {{ $t('menu.menu_name') }}
              </template>
              <b-form-input
                  id="menu_name "
                  type="text"
                  v-model="search.menu_name "
              ></b-form-input>
            </b-form-group>
          </b-col>
          <b-col sm="3">
            <b-button size="sm" variant="primary" @click="searchData">
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
        <h4 class="card-title">{{ $t('menu.menu_list') }}</h4>
      </template>
      <template v-slot:headerAction>
        <a href="javascript:" class="btn-add" @click="resetId" v-b-modal.modal-form><i class="ri-add-fill"></i> {{ $t('globalTrans.add_new') }}</a>
      </template>
      <template v-slot:body>
        <b-overlay :show="loadingState">
          <base-table v-on:editMethodInParent="editMethodInParent" :labelData="labelData" :columns="columns" :search="search" :searchData="searchData" :paginations="pagination" :actions="actions" :orderChange="orderChange"/>
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
import { menuList, menuToggle } from '../../api/routes'
import ModalBaseMasterList from '@/mixins/list'
import i18n from '@/i18n'

const defaultColumn = [
  { label_en: i18n.messages.en.globalTrans.sl_no, label_bn: i18n.messages.bn.globalTrans.sl_no, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 1, thStyle: { width: '8%' } },
  { label_en: i18n.messages.en.menu.component, label_bn: i18n.messages.bn.menu.component, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 2, thStyle: { width: '30%' } },
  { label_en: i18n.messages.en.menu.module, label_bn: i18n.messages.bn.menu.module, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 3, thStyle: { width: '20%' } },
  { label_en: i18n.messages.en.menu.service, label_bn: i18n.messages.bn.menu.service, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 4, thStyle: { width: '20%' } },
  { label_en: i18n.messages.en.menu.menu, label_bn: i18n.messages.bn.menu.menu, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 5, thStyle: { width: '20%' } },
  { label_en: i18n.messages.en.menu.sorting_order, label_bn: i18n.messages.bn.menu.sorting_order, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 6 },
  { label_en: i18n.messages.en.globalTrans.status, label_bn: i18n.messages.bn.globalTrans.status, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 7 },
  { label_en: i18n.messages.en.globalTrans.action, label_bn: i18n.messages.bn.globalTrans.action, class: 'text-left', show: '1', order: 8 }
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
        component_id: 0,
        module_id: 0,
        service_id: 0,
        menu_name: '',
        limit: 20
      },
      sortDesc: true,
      sortDirection: 'desc',
      labelData: [],
      moduleList: [],
      serviceList: [],
      actions: {
        edit: true,
        details: false,
        toogle: true,
        delete: false
      },
      orderChange: {
        checkList: this.$store.state.CommonService.commonObj.menuList,
        type: 'Comp',
        colspan: 5,
        urlSave: 'menu/change-serial-order/MasterMenu'
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
    'search.component_id': function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.moduleList = this.getModuleList(newVal)
      }
    },
    'search.module_id': function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.serviceList = this.getServiceList()
      }
    }
  },
  computed: {
    componentList () {
      return this.$store.state.CommonService.commonObj.componentList.map(item => {
        if (this.$i18n.locale === 'bn') {
          return { value: item.value, text: item.text_bn }
        } else {
          return { value: item.value, text: item.text_en }
        }
      })
    },
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
          { key: 'component_bn' },
          { key: 'module_bn' },
          { key: 'service_bn' },
          { key: 'menu_name_bn' },
          { key: 'sorting_order' },
          { key: 'status' },
          { key: 'action' }
        ]
      } else {
        keys = [
          { key: 'serial' },
          { key: 'component_en' },
          { key: 'module_en' },
          { key: 'service_en' },
          { key: 'menu_name' },
          { key: 'sorting_order' },
          { key: 'status' },
          { key: 'action' }
        ]
      }
      return labels.map((item, index) => {
        return Object.assign(item, keys[index])
      })
    },
    formTitle () {
      return (this.editItemId === 0) ? this.$t('menu.menu') + ' ' + this.$t('globalTrans.entry') : this.$t('menu.menu') + ' ' + this.$t('globalTrans.modify')
    },
    pageOptions () {
      return this.$store.state.commonObj.pageOptions
    },
    currentLocale () {
      return this.$i18n.locale
    }
  },
  methods: {
    getModuleList (componentId) {
      return this.$store.state.CommonService.commonObj.moduleList.filter(item => item.component_id === componentId).map(obj => {
        if (this.$i18n.locale === 'bn') {
          return { value: obj.value, text: obj.text_bn }
        } else {
          return { value: obj.value, text: obj.text_en }
        }
      })
    },
    getServiceList () {
      return this.$store.state.CommonService.commonObj.serviceList.filter(item => item.component_id === this.search.component_id && item.module_id === this.search.module_id).map(obj => {
        if (this.$i18n.locale === 'bn') {
          return { value: obj.value, text: obj.text_bn }
        } else {
          return { value: obj.value, text: obj.text_en }
        }
      })
    },
    editMethodInParent (item, type) {
      if (type === 1) {
        this.edit(item)
      } else if (type === 2) {
        this.changeStatus(1, commonServiceBaseUrl, menuToggle, item)
      }
    },
    searchData () {
      this.loadData()
    },
    async loadData () {
      const params = Object.assign({}, this.search, { page: this.pagination.currentPage, per_page: this.pagination.perPage })
      this.$store.dispatch('mutateCommonProperties', { loading: true, listReload: false })
      const result = await RestApi.getData(commonServiceBaseUrl, menuList, params)
      if (result.success) {
        const listData = result.data.data.map((item, index) => {
          const componentObj = this.$store.state.CommonService.commonObj.componentList.find(compItem => compItem.value === item.component_id)
          const moduleObj = this.$store.state.CommonService.commonObj.moduleList.find(compItem => compItem.value === item.module_id)
          const serviceObj = this.$store.state.CommonService.commonObj.serviceList.find(serviceItem => serviceItem.value === item.service_id)
          const componentData = {
            component_bn: componentObj !== undefined ? componentObj.text_bn : '',
            component_en: componentObj !== undefined ? componentObj.text_en : ''
          }
          const moduleData = {
            module_bn: moduleObj !== undefined ? moduleObj.text_bn : '',
            module_en: moduleObj !== undefined ? moduleObj.text_en : ''
          }
          const serviceData = {
            service_bn: serviceObj !== undefined ? serviceObj.text_bn : '',
            service_en: serviceObj !== undefined ? serviceObj.text_en : ''
          }
          return Object.assign({}, item, { serial: index }, componentData, moduleData, serviceData)
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
