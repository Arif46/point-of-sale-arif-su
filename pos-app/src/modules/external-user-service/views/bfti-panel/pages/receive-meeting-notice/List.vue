<template>
  <div class="inner-section">
    <card>
      <!-- search section start -->
      <template v-slot:searchHeaderTitle>
        <h4 class="card-title">{{ $t('systemActivityManage.meeting') }} {{ $t('globalTrans.search') }}</h4>
      </template>
      <template v-slot:searchBody>
        <b-row>
          <b-col xs="12" sm="12" md="3">
            <ValidationProvider name="Start date" vid="start_date" rules="''" v-slot="{ errors }">
              <b-form-group
                label-for="start_date">
                <template v-slot:label>
                  {{ $t('systemActivityManage.meeting_date_from') }}
                </template>
                <b-form-datepicker b-form-datepicker id="start_date" v-model="search.meeting_start_date"
                                   :state="errors[0] ? false : (valid ? true : null)"
                >
                </b-form-datepicker>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="3">
            <ValidationProvider name="End date" vid="end_date" rules="''" v-slot="{ errors }">
              <b-form-group
                label-for="end_date">
                <template v-slot:label>
                  {{ $t('systemActivityManage.meeting_date_to') }}
                </template>
                <b-form-datepicker b-form-datepicker id="end_date" v-model="search.meeting_end_date"
                                   :state="errors[0] ? false : (valid ? true : null)"
                >
                </b-form-datepicker>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="2">
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
        <h4 class="card-title">{{ $t('systemActivityManage.meeting') }} {{ $t('globalTrans.list') }}</h4>
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
                    {{data.index + 1}}
                  </template>
                  <template v-slot:cell(action)="data">
                    <b-button v-b-modal.modal-form-details variant="iq-bg-success mr-2" size="sm" @click="details(data.item)" class="action-btn status" :title="$t('globalTrans.view')"><i class="ri-eye-fill"></i></b-button>
                  </template>
                  <template v-slot:cell(status)="data">
                    <span class="badge badge-primary" v-if="data.item.status === 0">{{$t('globalTrans.pending')}}</span>
                    <span class="badge badge-success" v-if="data.item.status === 1">{{$t('globalTrans.approved')}}</span>
                    <span class="badge badge-danger" v-if="data.item.status === -1">{{$t('globalTrans.rejected')}}</span>
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
      <Details  :item="item"/>
    </b-modal>
  </div>
</template>
<style scoped>
  table#table-transition-example .flip-list-move {
    transition: transform 1s;
  }
</style>
<script>
  import RestApi, { bftiResReportServiceBaseUrl } from '@/config/api_config'
  import { createMeetingListApi } from '../../api/routes'
  import ModalBaseMasterList from '@/mixins/list'
  import i18n from '@/i18n'
  import Details from './Details'

  const defaultColumn = [
    { label_en: i18n.messages.en.globalTrans.sl_no, label_bn: i18n.messages.bn.globalTrans.sl_no, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 1, thStyle: { width: '10%' } },
    { label_en: i18n.messages.en.systemActivityManage.meeting_title, label_bn: i18n.messages.bn.systemActivityManage.meeting_title, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 2, thStyle: { width: '10%' } },
    { label_en: i18n.messages.en.systemActivityManage.memo_no, label_bn: i18n.messages.bn.systemActivityManage.memo_no, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 3, thStyle: { width: '20%' } },
    { label_en: i18n.messages.en.systemActivityManage.meeting_date, label_bn: i18n.messages.bn.systemActivityManage.meeting_date, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 4, thStyle: { width: '10%' } },
    { label_en: i18n.messages.en.globalTrans.status, label_bn: i18n.messages.bn.globalTrans.status, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 4, thStyle: { width: '10%' } },
    { label_en: i18n.messages.en.globalTrans.action, label_bn: i18n.messages.bn.globalTrans.action, class: 'text-center', show: '1', order: 5, thStyle: { width: '10%' } }
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
          document_type_id: 0,
          start_date: '',
          end_date: '',
          limit: 10,
          type: this.$store.state.Auth.authUser.user_type,
          user_id: this.$store.state.Auth.authUser.user_id
        },
        item: '',
        sortDesc: true,
        sortDirection: 'desc',
        labelData: [],
        editItem: [],
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
      docTypeList () {
        return this.$store.state.BftiResearchAndReportService.commonObj.documentTypeList.filter(item => item.status === 1)
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
            { key: 'meeting_title_bn' },
            { key: 'memo_no' },
            { key: 'meeting_date' },
            { key: 'status' },
            { key: 'action' }
          ]
        } else {
          keys = [
            { key: 'serial' },
            { key: 'meeting_title_en' },
            { key: 'memo_no' },
            { key: 'meeting_date' },
            { key: 'status' },
            { key: 'action' }
          ]
        }
        return labels.map((item, index) => {
          return Object.assign(item, keys[index])
        })
      },
      detailsTitle () {
        return this.$t('systemActivityManage.meeting') + ' ' + this.$t('globalTrans.details')
      },
      formTitle () {
        return this.$t('systemActivityManage.meeting')
      },
      pageOptions () {
        return this.$store.state.commonObj.pageOptions
      }
    },
    methods: {
      edit (item) {
        this.item = item
      },
      searchData () {
        this.loadData()
      },
      async loadData () {
        const params = Object.assign({}, this.search, { page: this.pagination.currentPage, per_page: this.pagination.perPage })
        this.$store.dispatch('mutateCommonProperties', { loading: true, listReload: false })
        const result = await RestApi.getData(bftiResReportServiceBaseUrl, createMeetingListApi, params)
        if (result.success) {
          this.$store.dispatch('setList', result.data.data)
          this.paginationData(result.data.data, this.search.limit)
        } else {
          this.$store.dispatch('setList', [])
          this.paginationData([])
        }
        this.$store.dispatch('mutateCommonProperties', { loading: false, listReload: false })
      },
      details (item) {
        this.item = item
      }
    }
  }
</script>
