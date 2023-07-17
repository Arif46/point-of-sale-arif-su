<template>
  <div class="inner-section">
    <card>
      <!-- search section start -->
      <template v-slot:searchHeaderTitle>
        <h4 class="card-title">{{ $t('externalUser.cip_application') }} {{ $t('globalTrans.search') }}</h4>
      </template>
      <template v-slot:searchBody>
        <b-row>
          <b-col xl="6" lg="6" sm="12">
              <b-form-group
                  label-for="product_service_sector_id"
                  label-cols-sm="5"
                >
                <template v-slot:label>
                  {{$t('externalUser.export_product_or_service_sector')}}
                </template>
                  <b-form-select
                    plain
                    v-model="search.product_service_sector_id"
                    :options="exportSectorList"
                  >
                  <template v-slot:first>
                      <b-form-select-option :value=0>{{$t('globalTrans.select')}}</b-form-select-option>
                  </template>
                  </b-form-select>
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
        <h4 class="card-title">{{ $t('externalUser.cip_application') }} {{ $t('globalTrans.list') }}</h4>
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
                  <template v-slot:cell(application_id)="data">
                    {{ $n(data.item.application_id, { useGrouping: false }) }}
                  </template>
                  <template v-slot:cell(year)="data">
                    {{ $n(data.item.year, { useGrouping: false }) }}
                  </template>
                  <template v-slot:cell(action)="data">
                    <b-button v-b-modal.modal-detail variant="iq-bg-success mr-1" size="sm" @click="details(data.item)" class="action-btn status" :title="$t('globalTrans.view')"><i class="ri-eye-fill"></i></b-button>
                    <b-button  variant=" iq-bg-success" size="sm" @click="editData(data.item)" class="action-btn edit" :title="$t('globalTrans.edit')"><i class="ri-pencil-fill"></i></b-button>
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
    <b-modal id="modal-detail" size="xl" :title="detailsTitle" hide-footer :ok-title="$t('globalTrans.close')" ok-only ok-variant="danger">
      <Details :id="editItemId" :key="editItemId"/>
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
import { cipApplicationListApi } from '../../api/routes'
import ModalBaseMasterList from '@/mixins/list'
import i18n from '@/i18n'

const defaultColumn = [
  { label_en: i18n.messages.en.globalTrans.sl_no, label_bn: i18n.messages.bn.globalTrans.sl_no, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 1, thStyle: { width: '8%' } },
  { label_en: i18n.messages.en.globalTrans.application_id, label_bn: i18n.messages.bn.globalTrans.application_id, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 2 },
  { label_en: i18n.messages.en.externalUser.export_product_or_service_sector, label_bn: i18n.messages.bn.externalUser.export_product_or_service_sector, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 3 },
  { label_en: i18n.messages.en.exportTrophyCircular.circular, label_bn: i18n.messages.bn.exportTrophyCircular.circular, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 4 },
  { label_en: i18n.messages.en.globalTrans.year, label_bn: i18n.messages.bn.globalTrans.year, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 4, thStyle: { width: '10%' } },
  { label_en: i18n.messages.en.globalTrans.action, label_bn: i18n.messages.bn.globalTrans.action, class: 'text-center', show: '1', order: 5 }
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
        product_service_sector_id: 0,
        user_id: this.$store.state.Auth.authUser.user_id,
        limit: 20
      },
      item: '',
      sortDesc: true,
      sortDirection: 'desc',
      labelData: [],
      editItemId: 0
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
    }
  },
  computed: {
    currentLocale () {
      return this.$i18n.locale
    },
    exportSectorList () {
        return this.$store.state.ExternalUserService.cipPanel.commonObj.exportSectorList.filter(item => item.status === 1 && item.assign_for === 1).map(item => {
        if (this.currentLocale === 'bn') {
          return Object.assign({}, item, {
            value: item.value,
            text: item.text_bn
          })
        } else {
          return Object.assign({}, item, {
            value: item.value,
            text: item.text_en
          })
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
          { key: 'application_id' },
          { key: 'product_name_bn' },
          { key: 'circular.title_bn' },
          { key: 'year' },
          { key: 'action' }
        ]
      } else {
        keys = [
          { key: 'serial' },
          { key: 'application_id' },
          { key: 'product_name_en' },
          { key: 'circular.title_en' },
          { key: 'year' },
          { key: 'action' }
        ]
      }
      return labels.map((item, index) => {
        return Object.assign(item, keys[index])
      })
    },
    detailsTitle () {
      return this.$t('externalUser.cip_application') + ' ' + this.$t('globalTrans.details')
    },
    pageOptions () {
      return this.$store.state.commonObj.pageOptions
    }
  },
  methods: {
    editData (item) {
      this.$router.push(`/export-trophy-cip-panel/cip-application-form?id=${item.id}`)
    },
    searchData () {
      this.loadData()
    },
    async loadData () {
      const params = Object.assign({}, this.search, { page: this.pagination.currentPage, per_page: this.pagination.perPage })
      this.$store.dispatch('mutateCommonProperties', { loading: true, listReload: false })
      const result = await RestApi.getData(exportTrophyCIPServiceBaseUrl, cipApplicationListApi, params)
      if (result.success) {
        const listData = result.data.data.map((item, index) => {
            const tmpExportProduct = this.$store.state.ExternalUserService.cipPanel.commonObj.exportSectorList.find(el => el.value === item.product_service_sector_id)
            const tmpYear = new Date(item.created_at)
            const tmpObj = {
                serial: index,
                product_name_en: tmpExportProduct !== 'undefined' ? tmpExportProduct.text_en : '',
                product_name_bn: tmpExportProduct !== 'undefined' ? tmpExportProduct.text_bn : '',
                year: tmpYear.getFullYear()
            }
            return Object.assign({}, item, tmpObj)
        })
        this.$store.dispatch('setList', listData)
        this.paginationData(result.data, this.search.limit)
      } else {
        this.$store.dispatch('setList', [])
        this.paginationData([])
      }
      this.$store.dispatch('mutateCommonProperties', { loading: false, listReload: false })
    },
    details (item) {
      this.editItemId = item.id
    }
  }
}
</script>
