<template>
  <div class="inner-section">
    <card>
      <!-- search section start -->
      <template v-slot:searchHeaderTitle>
        <h4 class="card-title">{{ $t('userManagement.roles') }}</h4>
      </template>
      <template v-slot:searchBody>
        <b-row>
          <b-col sm="4">
            <b-form-group
              label-for="role_id"
            >
            <template v-slot:label>
              {{$t('organogram.org')}}
            </template>
            <b-form-select
              plain
              v-model="search.org_id"
              :options="orgProfileList"
              id="org_id"
            >
              <template v-slot:first>
                <b-form-select-option :value=0>{{$t('globalTrans.select')}}</b-form-select-option>
              </template>
            </b-form-select>
            </b-form-group>
          </b-col>
          <b-col sm="4">
            <b-form-group
              label-for="designation_id"
            >
            <template v-slot:label>
              {{$t('organogram.designation')}}
            </template>
            <b-form-select
              plain
              v-model="search.designation_id"
              :options="designationList"
              id="designaitonList"
            >
              <template v-slot:first>
                <b-form-select-option :value=0>{{$t('globalTrans.select')}}</b-form-select-option>
              </template>
            </b-form-select>
            </b-form-group>
          </b-col>
          <b-col sm="4">
            <b-form-group
              label-for="role_name"
            >
              <template v-slot:label>
                {{ $t('userManagement.roles') }}
              </template>
              <b-form-input
                  id="role_name"
                  type="text"
                  v-model="search.role_name"
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
        <h4 class="card-title">{{ $t('userManagement.roles') }} {{ $t('globalTrans.list') }}</h4>
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
  </div>
</template>
<script>
import Form from './Form.vue'
import RestApi, { authServiceBaseUrl } from '@/config/api_config'
import { roleList, roleToggle } from '../../api/routes'
import ModalBaseMasterList from '@/mixins/list'
// import i18n from '@/i18n'

export default {
  mixins: [ModalBaseMasterList],
  components: {
    Form
  },
  data () {
    return {
      search: {
        org_id: 0,
        designation_id: 0,
        role_name: '',
        limit: 20
      },
      designationList: [],
      labelData: [
        { labels: 'globalTrans.sl_no', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 1, thStyle: { width: '9%' } },
        { labels: 'globalTrans.organization', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 2, thStyle: { width: '20%' } },
        { labels: 'organogram.designation', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 3, thStyle: { width: '20%' } },
        { labels: 'userManagement.role', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 4, thStyle: { width: '20%' } },
        { labels: 'globalTrans.status', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 5 },
        { labels: 'globalTrans.action', class: 'text-left', show: '1', order: 6 }
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
    },
    'search.org_id': function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.designationList = this.getDesignation()
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
          { key: 'designation_bn' },
          { key: 'role_name_bn' },
          { key: 'status' },
          { key: 'action' }
        ]
      } else {
        keys = [
          { key: 'serial' },
          { key: 'org_name' },
          { key: 'designation' },
          { key: 'role_name' },
          { key: 'status' },
          { key: 'action' }
        ]
      }
      return labels.map((item, index) => {
        return Object.assign(item, keys[index])
      })
    },
    formTitle () {
      return (this.editItemId === 0) ? this.$t('userManagement.roles') + ' ' + this.$t('globalTrans.entry') : this.$t('userManagement.roles') + ' ' + this.$t('globalTrans.modify')
    },
    orgProfileList () {
      return this.$store.state.CommonService.commonObj.orgProfileList.filter(item => item.status === 1)
    }
  },
  methods: {
    getDesignation () {
      return this.$store.state.CommonService.commonObj.designationList.filter(item => item.status === 1 && item.org_id === this.search.org_id).map(itemObj => {
        if (this.$i18n.locale === 'bn') {
          return { value: itemObj.value, text: itemObj.text_bn }
        } else {
          return { value: itemObj.value, text: itemObj.text_en }
        }
      })
    },
    editMethodInParent (item, type) {
      if (type === 1) {
        this.edit(item)
      } else if (type === 2) {
        this.changeStatus(1, authServiceBaseUrl, roleToggle, item)
      }
    },
    searchData () {
      this.loadData()
    },
    async loadData () {
      const params = Object.assign({}, this.search, { page: this.pagination.currentPage, per_page: this.pagination.perPage })
      this.$store.dispatch('mutateCommonProperties', { loading: true, listReload: false })
      const result = await RestApi.getData(authServiceBaseUrl, roleList, params)
      if (result.success) {
        const listData = result.data.data.map((item, index) => {
        const orgObj = this.$store.state.CommonService.commonObj.orgProfileList.find(org => org.value === parseInt(item.org_id))
        const designationObj = this.$store.state.CommonService.commonObj.designationList.find(designation => designation.value === parseInt(item.designation_id))
        const orgData = {}
        const designationData = {}
            if (typeof orgObj !== 'undefined') {
                orgData.org_name = orgObj.text_en
                orgData.org_name_bn = orgObj.text_bn
            } else {
              orgData.org_name = ''
              orgData.org_name_bn = ''
            }
            if (typeof designationObj !== 'undefined') {
              designationData.designation = designationObj.text_en
              designationData.designation_bn = designationObj.text_bn
            } else {
              designationData.designation = ''
              designationData.designation_bn = ''
            }
          return Object.assign({}, item, { serial: index }, orgData, designationData)
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
