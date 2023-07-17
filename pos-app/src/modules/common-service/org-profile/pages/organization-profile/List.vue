<template>
  <div class="inner-section">
    <card>
      <!-- search section start -->
      <template v-slot:searchHeaderTitle>
        <h4 class="card-title">{{ $t('orgProfile.org_profile') }} {{ $t('globalTrans.search') }}</h4>
      </template>
      <template v-slot:searchBody>
        <b-row>
          <b-col sm="6">
            <b-form-group
              label-for="org_profile"
            >
              <template v-slot:label>
                {{ $t('orgProfile.org_profile') }}
              </template>
              <b-form-input
                  id="org_profile"
                  type="text"
                  v-model="search.org_profile"
              ></b-form-input>
            </b-form-group>
          </b-col>
          <b-col xs="12" sm="12" md="6">
            <b-form-group
            :label="$t('orgProfile.establishment_year')"
            label-for="establishment_year"
            >
            <b-form-input
                id="establishment_year"
                v-model="search.establishment_year"
                ></b-form-input>
            </b-form-group>
        </b-col>
          <b-col sm="4">
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
        <h4 class="card-title">{{ $t('orgProfile.org_profile') }} {{ $t('globalTrans.list') }}</h4>
      </template>
      <template v-slot:headerAction>
        <a href="javascript:" class="btn-add" @click="resetId" v-b-modal.modal-form><i class="ri-add-fill"></i> {{ $t('globalTrans.add_new') }}</a>
      </template>
      <template v-slot:body>
        <b-overlay :show="loadingState">
          <base-table v-on:editMethodInParent="editMethodInParent" :labelData="labelData" :columns="columns" :search="search" :searchData="searchData" :paginations="pagination" :actions="actions" :imageUrl ="commonServiceBaseUrl" />
        </b-overlay>
      </template>
      <!-- table section end -->
    </body-card>
    <b-modal id="modal-form" size="lg" :title="formTitle" hide-footer :ok-title="$t('globalTrans.close')" ok-only ok-variant="danger">
      <Form :id="editItemId" :key="editItemId"/>
    </b-modal>
    <b-modal id="details" size="lg" :title="$t('orgProfile.org_profile') + ' ' + $t('globalTrans.details')"  hide-footer :ok-title="$t('globalTrans.close')" ok-only ok-variant="danger">
      <Details :id="editItemId" :key="editItemId"/>
    </b-modal>
  </div>
</template>
<script>
import Form from './Form.vue'
import Details from './Details.vue'
import RestApi, { commonServiceBaseUrl } from '@/config/api_config'
import { orgProfileList, orgProfileToggle } from '../../api/routes'
import ModalBaseMasterList from '@/mixins/list'

export default {
  mixins: [ModalBaseMasterList],
  components: {
    Form,
    Details
  },
  data () {
    return {
      commonServiceBaseUrl: commonServiceBaseUrl,
      sortBy: '',
      search: {
        org_profile: '',
        establishment_year: '',
        limit: 20
      },
      labelData: [
        { labels: 'globalTrans.sl_no', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 1, thStyle: { width: '9%' } },
        { labels: 'globalTrans.organization', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 2, thStyle: { width: '20%' } },
        { labels: 'orgProfile.establishment_year', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 3, thStyle: { width: '20%' } },
        { labels: 'orgProfile.abbreviation_name', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 4, thStyle: { width: '20%' } },
        { labels: 'orgProfile.about_org', class: 'text-left', sortable: true, stickyColumn: true, show: '0', order: 5, thStyle: { width: '10%' } },
        { labels: 'orgProfile.mission', class: 'text-left', sortable: true, stickyColumn: true, show: '0', order: 6, thStyle: { width: '10%' } },
        { labels: 'orgProfile.vision', class: 'text-left', sortable: true, stickyColumn: true, show: '0', order: 7, thStyle: { width: '10%' } },
        { labels: 'orgProfile.logo', class: 'text-left', sortable: true, stickyColumn: false, show: '1', order: 8, thStyle: { width: '10%' } },
        { labels: 'orgProfile.hierarchy', class: 'text-left', sortable: true, stickyColumn: true, show: '0', order: 9, thStyle: { width: '10%' } },
        { labels: 'orgProfile.address', class: 'text-left', sortable: true, stickyColumn: true, show: '0', order: 10, thStyle: { width: '10%' } },
        { labels: 'globalTrans.status', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 11 },
        { labels: 'globalTrans.action', class: 'text-left', show: '1', order: 12 }
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
          { key: 'org_name_bn' },
          { key: 'establishment_year' },
          { key: 'abbreviation_bn' },
          { key: 'about_org_bn' },
          { key: 'mission_bn' },
          { key: 'vision_bn' },
          { key: 'logo' },
          { key: 'hierarchy' },
          { key: 'address_bn' },
          { key: 'status' },
          { key: 'action' }
        ]
      } else {
        keys = [
          { key: 'serial' },
          { key: 'org_name' },
          { key: 'establishment_year' },
          { key: 'abbreviation' },
          { key: 'about_org' },
          { key: 'mission' },
          { key: 'vision' },
          { key: 'logo' },
          { key: 'hierarchy' },
          { key: 'address' },
          { key: 'status' },
          { key: 'action' }
        ]
      }
      return labels.map((item, index) => {
        return Object.assign(item, keys[index])
      })
    },
    formTitle () {
      return (this.editItemId === 0) ? this.$t('orgProfile.org_profile') + ' ' + this.$t('globalTrans.entry') : this.$t('orgProfile.org_profile') + ' ' + this.$t('globalTrans.modify')
    }
  },
  methods: {
    editMethodInParent (item, type) {
      if (type === 1) {
        this.edit(item)
      } else if (type === 2) {
        this.changeStatus(1, commonServiceBaseUrl, orgProfileToggle, item)
      }
    },
    searchData () {
      this.loadData()
    },
    async loadData () {
      const params = Object.assign({}, this.search, { page: this.pagination.currentPage, per_page: this.pagination.perPage })
      this.$store.dispatch('mutateCommonProperties', { loading: true, listReload: false })
      const result = await RestApi.getData(commonServiceBaseUrl, orgProfileList, params)
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
