<template>
  <div class="inner-section">
    <card>
      <!-- search section start -->
      <template v-slot:searchHeaderTitle>
        <h4 class="card-title">{{ $t('userManagement.roles') }} {{ $t('globalTrans.search') }}</h4>
      </template>
        <template v-slot:searchBody>
          <b-row>
            <b-col xs="12" sm="12" md="4" lg="4" xl="4">
              <b-form-group
              label-for="name"
              >
              <template v-slot:label>
                  {{ $t('globalTrans.name') }}
              </template>
                  <b-form-input
                      id="name"
                      type="text"
                      v-model="search.name"
                  >
                  </b-form-input>
              </b-form-group>
          </b-col>
            <b-col xs="12" sm="12" md="4" lg="4" xl="4">
              <b-form-group
                label-for="org_id"
              >
              <template v-slot:label>
                {{$t('userManagement.role')}} <span class="text-danger">*</span>
              </template>
                <b-form-select
                  plain
                  v-model="search.role_id"
                  :options="roleList"
                  id="role_id"
                >
                <template v-slot:first>
                  <b-form-select-option :value=0>{{$t('globalTrans.select')}}</b-form-select-option>
                </template>
                </b-form-select>
              </b-form-group>
            </b-col>
            <b-col xs="12" sm="12" md="4" lg="4" xl="4">
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
        <h4 class="card-title">{{ $t('userManagement.user_role') }} {{ $t('globalTrans.list') }}</h4>
      </template>
       <template v-slot:headerAction>
          <router-link :to="{ path: '/auth-service/user-management/assign-user-form'}" size="sm">
              {{  $t('globalTrans.add_new') }}
          </router-link>
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
                  <template v-slot:cell(user)="data">
                    <slot v-if="data.item">
                      {{ ($i18n.locale === 'bn') ? data.item.name_bn : data.item.name }}
                    </slot>
                  </template>
                  <template v-slot:cell(role)="data">
                    <slot v-if="data.item.role_user.length > 0">
                      <span  v-for="(roleData, index) in data.item.role_user" :key="index">
                        <slot v-if="roleData.role">
                          <span v-if="index != 0">, </span><span>{{ ($i18n.locale === 'bn') ? roleData.role.role_name_bn : roleData.role.role_name }}</span>
                        </slot>
                      </span >
                    </slot>
                </template>
                 <template v-slot:cell(assignRole)="data">
                    <slot v-if="data.item && data.item.user_detail">
                      <b-button v-b-modal.modal-1 pill variant="primary" size="sm" :title="$t('userManagement.assignRole')" @click="getDesignationUser(data.item)">{{  $t('userManagement.assignRole') }}</b-button>
                    </slot>
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
                <b-modal id="modal-1" size="md" title="Role Select" :ok-title="$t('globalTrans.close')" ok-only ok-variant="danger">
                  <b-overlay :show="roleLoader">
                    <p>
                      <iq-card style="min-height: 180px;">
                        <div class="card-body iq-card-body">
                          <h4 class="text-center">{{  $t('userManagement.roleList') }}</h4>
                          <hr class="mt-4"/>
                          <slot>
                            <h5 style="height: 29px">
                              <slot v-if="data.name">
                                {{  $t('userManagement.role_of') }} : <b>{{ data.name }}</b>
                              </slot>
                            </h5>
                            <hr/>
                            <slot>
                              <b-form  v-if="data.roles.length > 0">
                                <slot v-for="(role, index) in data.roles">
                                  <b-form-checkbox
                                    class="col-form-label-sm font-weight-bold mb-0"
                                    v-model="role.checked"
                                    name="checked"
                                    :unchecked-value=false
                                    :key="index"
                                    >
                                    {{ ($i18n.locale==='bn') ? role.role_name_bn  :  role.role_name  }}
                                  </b-form-checkbox>
                                </slot>
                              </b-form>
                            </slot>
                          </slot>
                          <b-col lg="col-lg-12 ml-0 pl-0" v-if="data.roles.length>0" style="margin-top: 18px !important;">
                            <button
                              class="btn btn-primary btn-sm"
                              v-on:click="SubmitData()"
                              >
                                <i class="fas fa-list"></i>Submit
                              </button>
                          </b-col>
                        </div>
                      </iq-card>
                    </p>
                  </b-overlay>
              </b-modal>
            </b-col>
          </b-row>
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
import RestApi, { authServiceBaseUrl } from '@/config/api_config'
import { userRoleList, UserRoleData, userRoleSelectList, assignUserRoleStore } from '../../api/routes'
import ModalBaseMasterList from '@/mixins/list'

const defaultColumn = [
  { labels: 'globalTrans.sl_no', class: 'text-center', sortable: true, stickyColumn: true, show: '1', order: 1, thStyle: { width: '9%' } },
  { labels: 'globalTrans.user', class: 'text-center', sortable: true, stickyColumn: true, show: '1', order: 2, thStyle: { width: '30%' } },
  { labels: 'userManagement.role', class: 'text-center', sortable: true, stickyColumn: true, show: '1', order: 3, thStyle: { width: '30%' } },
  { labels: 'globalTrans.action', class: 'text-center', show: '1', order: 4, thStyle: { width: '30%' } }
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
          role_id: 0,
          name: '',
          limit: 20
        },
        data: {
          designation_id: 0,
          user_id: '',
          name: '',
          roles: []
        },
      allRoles: [],
      user_detail: '',
      datas: [],
      sortDesc: true,
      sortDirection: 'desc',
      labelData: [],
      roleLoader: false,
      authServiceBaseUrl: authServiceBaseUrl
    }
  },
  created () {
    this.labelData = this.labelList
    this.loadData()
    this.rolData()
  },
  watch: {
    'search.limit': function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.loadData()
      }
    }
  },
  computed: {
    roleList: function () {
      const listObject = this.allRoles
      const tmpList = listObject.map((obj, index) => {
        if (this.$i18n.locale === 'bn') {
          return { value: obj.id, text: obj.role_name_bn }
        } else {
          return { value: obj.id, text: obj.role_name }
        }
      })
      return tmpList
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
          { key: 'user' },
          { key: 'role' },
          { key: 'assignRole' }
        ]
      } else {
        keys = [
          { key: 'serial' },
          { key: 'user' },
          { key: 'role' },
          { key: 'assignRole' }
        ]
      }
      return labels.map((item, index) => {
        return Object.assign(item, keys[index])
      })
    },
    formTitle () {
      return (this.editItemId === 0) ? this.$t('userManagement.roles') + ' ' + this.$t('globalTrans.entry') : this.$t('userManagement.roles') + ' ' + this.$t('globalTrans.modify')
    },
    pageOptions () {
      return this.$store.state.commonObj.pageOptions
    },
    currentLocale () {
      return this.$i18n.locale
    }
  },
  methods: {
    searchData () {
      this.loadData()
    },
    async loadData () {
      const params = Object.assign({}, this.search, { page: this.pagination.currentPage, per_page: this.pagination.perPage })
      this.$store.dispatch('mutateCommonProperties', { loading: true, listReload: false })
      const result = await RestApi.getData(authServiceBaseUrl, userRoleList, params)
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
    },
    getDesignationUser (user) {
      this.data = {
        designation_id: 0,
        user_id: '',
        name: '',
        roles: []
      }
      const search = {
        designation_id: user.user_detail.designation_id,
        office_id: user.user_detail.office_id,
        user_id: user.id,
        office_type_id: user.user_detail.office_type_id
      }
      if (search.designation_id) {
        this.roleLoader = true
        RestApi.getData(authServiceBaseUrl, UserRoleData, search).then(response => {
          this.data.user_id = user.id
          this.data.name = user.name
          this.data.roles = response
          this.roleLoader = false
        }, error => {
          if (error) {
            //
          }
          this.$store.dispatch('mutateCommonProperties', { loading: false, listReload: false })
        })
      }
    },
    details (item) {
      this.user_detail = item
    },
    rolData () {
      RestApi.getData(authServiceBaseUrl, userRoleSelectList, {}).then(response => {
        this.allRoles = response
      }, error => {
        if (error) {
          //
        }
      })
    },
    async confirmData () {
      let result = null
      this.roleLoader = true
      result = await RestApi.postData(authServiceBaseUrl, assignUserRoleStore, this.data)
      if (result.success) {
        this.roleLoader = false
        this.$bvModal.hide('modal-1')
        this.$toast.success({
          title: 'Success',
          message: 'Data saved successfully',
          color: '#D6E09B'
        })
        this.loadData()
      }
    },
    async SubmitData () {
      this.$swal({
        title: this.$t('globalTrans.recommendentChangeMsg'),
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        focusConfirm: false
      }).then((resultSwal) => {
        if (resultSwal.isConfirmed) {
          this.confirmData()
        }
      })
    }
  }
}
</script>
