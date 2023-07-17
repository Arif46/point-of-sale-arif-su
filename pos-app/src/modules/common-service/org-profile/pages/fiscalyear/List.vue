<template>
  <div class="inner-section">
    <card>
      <!-- search section start -->
      <template v-slot:searchHeaderTitle>
        <h4 class="card-title">{{ $t('globalTrans.fiscal_year') }} {{ $t('globalTrans.search') }}</h4>
      </template>
      <template v-slot:searchBody>
        <b-row>
          <b-col sm="4">
            <b-form-group
              label-for="fiscal_year_id"
            >
            <template v-slot:label>
              {{$t('globalTrans.fiscal_year')}}
            </template>
              <b-form-select
                plain
                v-model="search.id"
                :options="fiscalYear"
                id="fiscal_year_id"
              >
              <template v-slot:first>
                <b-form-select-option :value=0>{{$t('globalTrans.select')}}</b-form-select-option>
              </template>
              </b-form-select>
            </b-form-group>
          </b-col>
          <b-col sm="4">
            <b-button size="sm" class="mt-20" variant="primary" @click="searchData">
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
        <h4 class="card-title">{{ $t('globalTrans.fiscal_year') }} {{ $t('globalTrans.list') }}</h4>
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
<script>
import Form from './Form.vue'
import RestApi, { commonServiceBaseUrl } from '@/config/api_config'
import { fiscalYearList, fiscalYearToggle } from '../../api/routes'
import ModalBaseMasterList from '@/mixins/list'

export default {
  mixins: [ModalBaseMasterList],
  components: {
    Form
  },
  data () {
    return {
      sortBy: '',
      search: {
        id: 0,
        limit: 20
      },
      labelData: [
        { labels: 'globalTrans.sl_no', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 1, thStyle: { width: '9%' } },
        { labels: 'globalTrans.fiscal_year', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 2, thStyle: { width: '20%' } },
        { labels: 'menu.start_date', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 3, thStyle: { width: '20%' } },
        { labels: 'menu.end_date', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 4, thStyle: { width: '20%' } },
        { labels: 'menu.sorting_order', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 5, thStyle: { width: '20%' } },
        { labels: 'globalTrans.status', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 6 },
        { labels: 'globalTrans.action', class: 'text-left', show: '1', order: 7 }
      ],
      actions: {
        edit: true,
        details: false,
        toogle: true,
        delete: false
      },
      orderChange: {
        checkList: this.$store.state.CommonService.commonObj.fiscalYearList,
        type: 'Comp',
        colspan: 4,
        urlSave: 'org-profile/change-serial-order/MasterFiscalYear'
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
    fiscalYear () {
      return this.$store.state.CommonService.commonObj.fiscalYearList.map(item => {
        if (this.$i18n.locale === 'bn') {
          return { value: item.value, text: this.EngBangNum(item.text_bn) }
        } else {
          return { value: item.value, text: item.text_en }
        }
      })
    },
    columns () {
      const labelData = this.labelData
      const labels = labelData.map((item, index) => {
        return Object.assign(item, { label: this.$t(item.labels, this.$i18n.locale) })
      })
      let keys = []
      if (this.$i18n.locale === 'bn') {
        keys = [
          { key: 'serial' },
          { key: 'year' },
          { key: 'start_date' },
          { key: 'end_date' },
          { key: 'sorting_order' },
          { key: 'status' },
          { key: 'action' }
        ]
      } else {
        keys = [
          { key: 'serial' },
          { key: 'year' },
          { key: 'start_date' },
          { key: 'end_date' },
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
      return (this.editItemId === 0) ? this.$t('globalTrans.fiscal_year') + ' ' + this.$t('globalTrans.entry') : this.$t('globalTrans.fiscal_year') + ' ' + this.$t('globalTrans.modify')
    }
  },
  methods: {
    EngBangNum (n) {
      if (this.$i18n.locale === 'bn') {
        return n.replace(/\d/g, d => '০১২৩৪৫৬৭৮৯'[d])
      } else {
        return n.replace(/[০-৯]/g, d => '০১২৩৪৫৬৭৮৯'.indexOf(d))
      }
    },
    editMethodInParent (item, type) {
      if (type === 1) {
        this.edit(item)
      } else if (type === 2) {
        this.changeStatus(1, commonServiceBaseUrl, fiscalYearToggle, item)
      }
    },
    searchData () {
      this.loadData()
    },
    async loadData () {
      const params = Object.assign({}, this.search, { page: this.pagination.currentPage, per_page: this.pagination.perPage })
      this.$store.dispatch('mutateCommonProperties', { loading: true, listReload: false })
      const result = await RestApi.getData(commonServiceBaseUrl, fiscalYearList, params)
      if (result.success) {
        const listData = result.data.data.map((item, index) => {
          return Object.assign({}, item, { serial: index })
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
