<template>
  <div class="inner-section">
    <card>
      <!-- search section start -->
      <template v-slot:searchHeaderTitle>
        <h4 class="card-title">{{ $t('globalTrans.publish') }} {{ $t('exportTrophyGazette.gazette') }} {{ $t('globalTrans.search') }}</h4>
      </template>
      <template v-slot:searchBody>
        <b-row>
          <b-col sm="4">
            <b-form-group
              label-for="type"
            >
            <template v-slot:label>
              {{$t('exportTrophyConfig.awardType')}}
            </template>
            <b-form-select
              plain
              v-model="search.type"
              :options="assignTypeList"
              id="type"
            >
              <template v-slot:first>
                <b-form-select-option :value=0>{{$t('globalTrans.select')}}</b-form-select-option>
              </template>
            </b-form-select>
            </b-form-group>
          </b-col>
          <b-col sm="4" v-if="hideFiscalYear">
            <b-form-group
              label-for="fiscal_year_id"
            >
            <template v-slot:label>
              {{$t('globalTrans.fiscal_year')}}
            </template>
              <b-form-select
                plain
                v-model="search.fiscal_year_id"
                :options="fiscalYear"
                id="fiscal_year_id"
              >
              <template v-slot:first>
                <b-form-select-option :value=0>{{$t('globalTrans.select')}}</b-form-select-option>
              </template>
              </b-form-select>
            </b-form-group>
          </b-col>
          <b-col sm="4" v-if="hideYear">
            <b-form-group
              label-for="year"
            >
            <template v-slot:label>
              {{$t('globalTrans.year')}}
            </template>
              <b-form-select
                plain
                v-model="search.year"
                :options="YearList"
                id="year"
              >
              <template v-slot:first>
                <b-form-select-option :value=0>{{$t('globalTrans.select')}}</b-form-select-option>
              </template>
              </b-form-select>
            </b-form-group>
          </b-col>
          <b-col sm="3">
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
        <h4 class="card-title">{{ $t('globalTrans.publish') }} {{ $t('exportTrophyGazette.gazette') }} {{ $t('globalTrans.list') }}</h4>
      </template>
      <template v-slot:body>
        <b-overlay :show="loadingState">
          <b-row>
            <b-col sm="12">
              <div class="quick-filter-wrapper">
                <div class="quick-filter-left">
                  <b-dropdown split split-variant="outline-secondary" size="sm" id="dropdown-form" :text="$t('globalTrans.column_visibility')" ref="dropdown">
                    <b-dropdown-form>
                      <div
                        class="form-group"
                        v-for="(field, index) in labelData"
                        :key="index"
                        >
                          <b-form-checkbox
                            :id="'checkbox-' + field.label_en"
                            v-model="field.show"
                            :name="'checkbox-' + field.label_en"
                            value=1
                            unchecked-value=0
                          >
                            {{ ($i18n.locale==='bn') ? field.label_bn : field.label_en }}
                          </b-form-checkbox>
                      </div>
                    </b-dropdown-form>
                  </b-dropdown>
                </div>
                <div class="quick-filter-right">
                  <b-form-group
                    :label="$t('menu.perpage')"
                    label-for="per-page-select"
                  >
                    <b-form-select
                      id="per-page-select"
                      v-model="search.limit"
                      :options="pageOptions"
                      size="sm"
                    ></b-form-select>
                  </b-form-group>
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row>
            <b-col md="12" class="table-responsive">
              <slot v-if ="columns.filter(item => item.show === '1').length > 0">
                <b-table :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection" head-variant="primary" class="tg" :items="listData" :emptyText="$t('globalTrans.noDataFound')" show-empty bordered hover :fields="columns.filter(item => item.show === '1').sort((a, b) => { return a.order - b.order })">
                  <template v-slot:cell(serial)="data">
                    {{ $n(data.item.serial + pagination.slOffset) }}
                  </template>
                  <template v-slot:cell(type)="data">
                    <span v-if="data.item.type == 1">{{$t('exportTrophyConfig.cip')}}</span>
                    <span v-else>{{$t('exportTrophyConfig.export_trophy')}}</span>
                  </template>
                  <template v-slot:cell(year_fiscal_year)="data">
                    <span v-if="data.item.type == 1">{{ $n(data.item.year, { useGrouping: false }) }}</span>
                    <span v-else>{{ EngBangNum(getFiscalYear(data.item.fiscal_year_id)) }}</span>
                  </template>
                  <template v-slot:cell(status)="data">
                    <span class="badge badge-danger" v-if="data.item.status == 1">{{$t('globalTrans.pending')}}</span>
                    <span class="badge badge-info" v-else-if="data.item.status == 2">
                      {{$t('globalTrans.forward')}} to {{ getNameReceiver(data.item.last_forward['receiver_id']) }}
                    </span>
                    <span class="badge badge-primary" v-else-if="data.item.status == 3">{{$t('globalTrans.approve')}}</span>
                    <span class="badge badge-success" v-else-if="data.item.status == 4">{{$t('globalTrans.publish')}}</span>
                  </template>
                  <template v-slot:cell(action)="data">
                    <b-button v-b-modal.modal-form-details variant="iq-bg-success mr-1" size="sm" @click="details(data.item)" class="action-btn status" :title="$t('globalTrans.view')"><i class="ri-eye-fill"></i></b-button>
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
    <b-modal id="modal-form-details" size="lg" :title="detailsTitle" hide-footer :ok-title="$t('globalTrans.close')" ok-only ok-variant="danger">
      <Details :id="editItemId" :key="editItemId" :userDetails="userDetails"/>
    </b-modal>
  </div>
</template>
<style scoped>
table#table-transition-example .flip-list-move {
  transition: transform 1s;
}
</style>
<script>
import Details from './Details.vue'
import RestApi, { exportTrophyCIPServiceBaseUrl } from '@/config/api_config'
import { gazettesPublishedListApi } from '../../api/routes'
import ModalBaseMasterList from '@/mixins/list'
import i18n from '@/i18n'

const defaultColumn = [
  { label_en: i18n.messages.en.globalTrans.sl_no, label_bn: i18n.messages.bn.globalTrans.sl_no, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 1, thStyle: { width: '8%' } },
  { label_en: i18n.messages.en.exportTrophyConfig.awardType, label_bn: i18n.messages.bn.exportTrophyConfig.awardType, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 2, thStyle: { width: '20%' } },
  { label_en: i18n.messages.en.exportTrophyConfig.fiscal_year, label_bn: i18n.messages.bn.exportTrophyConfig.fiscal_year, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 3, thStyle: { width: '20%' } },
  { label_en: i18n.messages.en.exportTrophyGazette.title, label_bn: i18n.messages.bn.exportTrophyGazette.title, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 4, thStyle: { width: '30%' } },
  { label_en: i18n.messages.en.globalTrans.status, label_bn: i18n.messages.bn.globalTrans.status, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 5 },
  { label_en: i18n.messages.en.globalTrans.action, label_bn: i18n.messages.bn.globalTrans.action, class: 'text-left', show: '1', order: 6 }
]
export default {
  mixins: [ModalBaseMasterList],
  components: {
    Details
  },
  data () {
    return {
      sortBy: '',
      search: {
        type: 0,
        fiscal_year_id: 0,
        year: 0,
        limit: 20
      },
      hideFiscalYear: false,
      hideYear: false,
      userDetails: [],
      sortDesc: true,
      sortDirection: 'desc',
      labelData: [],
      editItemId: ''
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
    'search.type': function (newVal, oldVal) {
      if (newVal !== oldVal) {
        if (newVal === 1) {
          this.hideYear = true
          this.hideFiscalYear = false
        }
        if (newVal === 2) {
          this.hideFiscalYear = true
          this.hideYear = false
        }
      }
    }
  },
  computed: {
    YearList () {
      return this.$store.state.commonObj.yearList.map(item => {
        if (this.$i18n.locale === 'bn') {
          return { value: item, text: this.EngBangNum(item.toString()) }
        } else {
          return { value: item, text: item }
        }
      })
    },
    currentLocale () {
      return this.$i18n.locale
    },
    assignTypeList () {
      return this.$store.state.ExportTrophyCipService.commonObj.assignTypeList.map(el => {
        return Object.assign({}, el, { text: this.$i18n.locale === 'bn' ? el.text_bn : el.text_en })
      })
    },
    fiscalYear () {
      return this.$store.state.CommonService.commonObj.fiscalYearList.map(item => {
        if (this.$i18n.locale === 'bn') {
          return { value: item.value, text: this.EngBangNum(item.text_bn) }
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
          { key: 'type' },
          { key: 'year_fiscal_year' },
          { key: 'title_bn' },
          { key: 'status' },
          { key: 'action' }
        ]
      } else {
        keys = [
          { key: 'serial' },
          { key: 'type' },
          { key: 'year_fiscal_year' },
          { key: 'title_en' },
          { key: 'status' },
          { key: 'action' }
        ]
      }
      return labels.map((item, index) => {
        return Object.assign(item, keys[index])
      })
    },
    formTitle () {
      return (this.editItemId === 0) ? this.$t('exportTrophyGazette.gazette') + ' ' + this.$t('globalTrans.entry') : this.$t('exportTrophyGazette.gazette') + ' ' + this.$t('globalTrans.modify')
    },
    detailsTitle () {
      return this.$t('exportTrophyGazette.gazette') + ' ' + this.$t('globalTrans.details')
    },
    pageOptions () {
      return this.$store.state.commonObj.pageOptions
    }
  },
  methods: {
    searchData () {
      this.loadData()
    },
    details (item) {
      this.editItemId = item.id
    },
    EngBangNum (n) {
      if (this.$i18n.locale === 'bn') {
        return n.replace(/\d/g, d => '০১২৩৪৫৬৭৮৯'[d])
      } else {
        return n.replace(/[০-৯]/g, d => '০১২৩৪৫৬৭৮৯'.indexOf(d))
      }
    },
    async loadData () {
      const params = Object.assign({}, this.search, { page: this.pagination.currentPage, per_page: this.pagination.perPage })
      this.$store.dispatch('mutateCommonProperties', { loading: true, listReload: false })
      const result = await RestApi.getData(exportTrophyCIPServiceBaseUrl, gazettesPublishedListApi, params)
      if (result.success) {
        this.userList = result.userDetails
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
    },
    getFiscalYear (fiscalYear) {
      const fiscalYearObj = this.$store.state.CommonService.commonObj.fiscalYearList.find(fiscal => fiscal.value === parseInt(fiscalYear))
      if (fiscalYearObj !== 'undefined') {
        return this.currentLocale === 'bn' ? fiscalYearObj.text_bn : fiscalYearObj.text_en
      }
    },
    getNameReceiver (id) {
      if (this.userList) {
        const userName = this.userList.find(user => user.value === id)
        if (this.$i18n.locale === 'bn') {
          return userName.text_bn
        } else {
          return userName.text_en
        }
      }
    }
  }
}
</script>
