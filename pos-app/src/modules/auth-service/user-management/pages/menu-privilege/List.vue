<template>
  <div class="inner-section">
    <card>
      <!-- search section start -->
      <template v-slot:searchHeaderTitle>
        <h4 class="card-title">{{ $t('userManagement.menu_privilege') }}</h4>
      </template>
      <template v-slot:searchBody>
        <b-row>
          <b-col xs="12" sm="12" md="4" lg="4" xl="4">
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
          <b-col xs="12" sm="12" md="4" lg="4" xl="4">
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
          <b-col xs="12" sm="12" md="4" lg="4" xl="4">
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
          <b-col xs="12" sm="12" md="4" lg="4" xl="4">
            <b-form-group
              label-for="menu"
            >
              <template v-slot:label>
                {{ $t('menu.menu') }}
              </template>
            <b-form-select
                plain
                v-model="search.menu_id"
                :options="menuList"
                id="menu_id"
                >
            <template v-slot:first>
                <b-form-select-option :value="0">{{$t('globalTrans.select')}}</b-form-select-option>
            </template>
            </b-form-select>
            </b-form-group>
          </b-col>
          <b-col xs="12" sm="12" md="4" lg="4" xl="4">
            <b-form-group
              label-for="role"
            >
              <template v-slot:label>
                {{ $t('userManagement.roles') }}
              </template>
            <b-form-select
                plain
                v-model="search.role_id"
                :options="roleList"
                id="role_id"
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
        <h4 class="card-title">{{ $t('userManagement.menu_privilege_list') }}</h4>
      </template>
      <!-- <template v-slot:headerAction>
        <a href="javascript:" class="btn-add" @click="resetId" v-b-modal.modal-form><i class="ri-add-fill"></i> {{ $t('globalTrans.add_new') }}</a>
      </template> -->
      <template v-slot:headerAction>
        <!-- <router-link :to="{ name: 'common_service.access_control.menu_privilege' }" class="btn-add">
            {{  $t('globalTrans.add_new') }}
        </router-link> -->
        <router-link to="menu-privilege">{{  $t('globalTrans.add_new') }}</router-link>
      </template>
      <template v-slot:body>
        <b-overlay :show="loadingState">
          <base-table v-on:editMethodInParent="editMethodInParent" :labelData="labelData" :columns="columns" :search="search" :searchData="searchData" :paginations="pagination" :actions="actions" />
        </b-overlay>
      </template>
      <!-- table section end -->
    </body-card>
  </div>
</template>
<script>
// import { core } from '@/config/pluginInit'
import { mapGetters } from 'vuex'
import RestApi, { commonServiceBaseUrl, authServiceBaseUrl } from '@/config/api_config'
import { officeTypeToggle } from '../../api/routes'
import ModalBaseMasterList from '@/mixins/list'
// import i18n from '@/i18n'

export default {
  mixins: [ModalBaseMasterList],
  components: {
  },
  data () {
    return {
      search: {
        component_id: 0,
        module_id: 0,
        service_id: 0,
        menu_id: 0,
        role_id: 0,
        limit: 20
      },
      labelData: [
        { labels: 'globalTrans.sl_no', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 1, thStyle: { width: '8%' } },
        { labels: 'userManagement.roles', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 2, thStyle: { width: '18%' } },
        { labels: 'menu.component_name', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 3, thStyle: { width: '18%' } },
        { labels: 'menu.module_name', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 4, thStyle: { width: '18%' } },
        { labels: 'menu.service_name', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 5, thStyle: { width: '18%' } },
        { labels: 'menu.menu_name', class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 6, thStyle: { width: '18%' } }
      ],
      actions: {
        edit: true,
        details: true,
        toogle: true,
        delete: false
      },
      moduleList: [],
      serviceList: [],
      menuList: [],
      allRoles: []
    }
  },
  // created () {
  //   this.loadData()
  // },
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
          { key: 'role' },
          { key: 'component_name_bn' },
          { key: 'module_name_bn' },
          { key: 'service_name_bn' },
          { key: 'menu_name_bn' }
        ]
      } else {
        keys = [
          { key: 'serial' },
          { key: 'role' },
          { key: 'component_name' },
          { key: 'module_name' },
          { key: 'service_name' },
          { key: 'menu_name' }
        ]
      }
      return labels.map((item, index) => {
        return Object.assign(item, keys[index])
      })
    },
    formTitle () {
      return (this.editItemId === 0) ? this.$t('userManagement.office_type') + ' ' + this.$t('globalTrans.entry') : this.$t('userManagement.office_type') + ' ' + this.$t('globalTrans.modify')
    },
    componentList () {
      return this.$store.state.CommonService.commonObj.componentList.map(item => {
        if (this.$i18n.locale === 'bn') {
          return { value: item.value, text: item.text_bn }
        } else {
          return { value: item.value, text: item.text_en }
        }
      })
    },
    orgProfileList () {
        return this.$store.state.CommonService.commonObj.orgProfileList.filter(item => item.status === 1)
    },
    ...mapGetters({
      commonObj: 'commonObj',
      authorizedComponents: 'Auth/getAuthorizedComponents',
      authUser: 'Auth/authUser'
    }),
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
    }
  },
  mounted () {
    this.rolData()
    // core.index()
    if (this.authUser.role_id === 0 && this.authUser.is_org_admin === 1) {
      this.search = Object.assign({}, this.search, {
        role_id: this.authUser.role_id
      })
    } else if (this.authUser.role_id === 0) {
      this.search = Object.assign({}, this.search, {
        role_id: this.authUser.office_detail.role_id
      })
    }
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
      this.serviceList = this.getServiceList()
      this.menuList = this.getMenuList(newVal, 'module')
    },
    'search.service_id': function (newVal, oldVal) {
      this.menuList = this.getMenuList(newVal, 'service')
    }
  },
  methods: {
    editMethodInParent (item, type) {
      if (type === 1) {
        this.edit(item)
      } else if (type === 2) {
        this.changeStatus(1, commonServiceBaseUrl, officeTypeToggle, item)
      }
    },
    searchData () {
      if (this.authUser.role_id === 0 && this.authUser.is_org_admin === 1) {
        this.search = Object.assign({}, this.search, {
          role_id: this.authUser.role_id
        })
      } else if (this.authUser.role_id === 0) {
        this.search = Object.assign({}, this.search, {
          role_id: this.authUser.office_detail.role_id
        })
      }
      this.loadData()
    },
    async loadData () {
      this.$store.dispatch('mutateCommonProperties', { loading: true })
      const params = Object.assign({}, this.search, { page: this.pagination.currentPage, per_page: this.pagination.perPage })
      await RestApi.getData(authServiceBaseUrl, 'user-management/role/role-wise-menu-list', params).then(response => {
        if (response.success) {
          this.getRelationalData(response)
          this.paginationData(response.data)
        }
        this.$store.dispatch('mutateCommonProperties', { loading: false, listReload: false })
      }, error => {
        if (error) {
          //
        }
        this.$store.dispatch('mutateCommonProperties', { loading: false, listReload: false })
      })
    },
    getRelationalData (data) {
      const componentList = this.$store.state.CommonService.commonObj.componentList
      const moduleList = this.$store.state.CommonService.commonObj.moduleList
      const serviceList = this.$store.state.CommonService.commonObj.serviceList
      const menuList = this.$store.state.CommonService.commonObj.menuList
      const allData = data.data.data.map((item, index) => {
        const componentObject = componentList.find(component => component.value === item.component_id)
        const moduleObject = moduleList.find(module => module.value === item.module_id)
        const serviceObject = serviceList.find(service => service.value === item.service_id)
        const menuObject = menuList.find(menu => menu.value === item.master_menu_id)
        const componentData = {
          component_name: typeof componentObject !== 'undefined' ? componentObject.text_en : '',
          component_name_bn: typeof componentObject !== 'undefined' ? componentObject.text_bn : ''
        }
        const moduleData = {
          module_name: typeof moduleObject !== 'undefined' ? moduleObject.text_en : '',
          module_name_bn: typeof moduleObject !== 'undefined' ? moduleObject.text_bn : ''
        }
        const serviceData = {
          service_name: typeof serviceObject !== 'undefined' ? serviceObject.text_en : '',
          service_name_bn: typeof serviceObject !== 'undefined' ? serviceObject.text_bn : ''
        }
        const menuData = {
          menu_name: typeof menuObject !== 'undefined' ? menuObject.text_en : '',
          menu_name_bn: typeof menuObject !== 'undefined' ? menuObject.text_bn : ''
        }
        return Object.assign({}, item, { serial: index }, componentData, moduleData, serviceData, menuData)
      })
      this.$store.dispatch('setList', allData)
    },
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
    getMenuList (Id, type) {
      const menuList = this.$store.state.CommonService.commonObj.menuList
      if (Id) {
        let menuData = ''
        if (type === 'module') {
          menuData = menuList.filter(menu => menu.module_id === Id)
        } else {
          menuData = menuList.filter(menu => menu.service_id === Id)
        }
        const tmpList = menuData.map((obj, index) => {
          if (this.$i18n.locale === 'bn') {
            return { value: obj.value, text: obj.text_bn }
          } else {
            return { value: obj.value, text: obj.text_en }
          }
        })
        return tmpList
      }
    },
    rolData () {
      RestApi.getData(authServiceBaseUrl, 'user-management/role/role-list-select/all', {}).then(response => {
        this.allRoles = response
      }, error => {
        if (error) {
          //
        }
        this.$store.dispatch('mutateCommonProperties', { loading: false, listReload: false })
      })
    }
  }
}
</script>
