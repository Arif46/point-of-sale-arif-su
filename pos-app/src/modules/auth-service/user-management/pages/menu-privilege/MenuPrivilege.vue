<template>
  <div class="inner-section">
    <card>
      <!-- search section start -->
      <template v-slot:searchHeaderTitle>
        <h4 class="card-title">{{ $t('userManagement.menu_privilege') }}</h4>
      </template>
      <template v-slot:searchBody>
        <b-row>
          <b-overlay :show="loadingSearch">
            <b-col class="row">
              <b-form-group
                class="col-6"
                label-cols-sm="3"
                label-for="org_id"
                >
                <template v-slot:label>
                  {{ $t('orgProfile.org_name')}} <span class="text-danger">*</span>
                </template>
                <b-form-select
                  plain
                  v-model="search.org_id"
                  :options="orgProfileList"
                  id="org_id"
                  >
                  <template v-slot:first>
                    <b-form-select-option :value="0">{{$t('globalTrans.select')}}</b-form-select-option>
                  </template>
                </b-form-select>
              </b-form-group>
              <b-form-group
                  class="col-6"
                  label-cols-sm="4"
                  label-for="role_id"
                  label-class="text-right"
                  >
                  <template v-slot:label :class="text-align-right" class="col-4">
                    {{ $t('userManagement.roles') }} <span class="text-danger">*</span>
                  </template>
                  <b-form-select
                    plain
                    v-model="search.role_id"
                    :options="roleListData"
                    id="roleList"
                    >
                    <template v-slot:first>
                      <b-form-select-option :value="0">{{$t('globalTrans.select')}}</b-form-select-option>
                    </template>
                  </b-form-select>
              </b-form-group>
            </b-col>
          </b-overlay>
        </b-row>
      </template>
      <!-- search section end -->
    </card>

    <body-card>
      <!-- table section start -->
      <template v-slot:headerTitle>
        <h4 class="card-title">{{ $t('userManagement.menu_privilege') }}</h4>
      </template>
      <template v-slot:headerAction>
        <!-- <router-link :to="{ name: 'common_service.access_control.menu_privilege' }" class="btn-add">
            {{  $t('globalTrans.add_new') }}
        </router-link> -->
        <router-link to="menu-privilege-list">{{  $t('userManagement.menu_privilege_list') }}</router-link>
      </template>
      <template v-slot:body>
        <b-overlay  :show="loadingData">
          <b-row>
            <b-form-group
              class="col-6"
              label-cols-sm="4"
              label-for="role_id"
              label-class="text-right"
              v-if="search.role_id"
              >
              <template v-slot:label :class="text-align-right" class="col-4">
                {{ $t('menu.component') }} <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                v-model="search.component_id"
                :options="componentList"
                id="componentList"
                >
                <template v-slot:first>
                  <b-form-select-option :value="0">{{$t('globalTrans.select')}}</b-form-select-option>
                </template>
              </b-form-select>
            </b-form-group>
            <b-form-group
              class="col-6"
              label-cols-sm="4"
              label-for="module_id"
              v-if="search.role_id"
              >
              <template v-slot:label>
                {{ $t('menu.module')}}
              </template>
              <b-form-select
                plain
                v-model="search.module_id"
                :options="moduleList"
                id="module_id"
                >
                <template v-slot:first>
                  <b-form-select-option :value="0">{{$t('globalTrans.select')}}</b-form-select-option>
                </template>
              </b-form-select>
            </b-form-group>
            <b-col md="12" class="table-responsive">
              <div class="d-flex justify-content-center" v-if="loader">
                <div class="spinner-border" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
              </div>
              <table class="table tablesorter border table-hover" v-if="datas.length>0">
                <tr>
                  <th style="vertical-align: middle;width:30%;text-align:center"> {{ $t('menu.module') }}</th>
                  <th style="vertical-align: middle;width:30%;text-align:center"> {{ $t('menu.service') }}</th>
                  <th style="padding-left:25px;">
                    <label for="CheckBoxAll" @click="checkAll()"><input type="checkbox" name="selectcheck" id="selectcheck"  v-model='isCheckAll'> {{ $t('globalTrans.checkAll') }} </label>
                  </th>
                </tr>
                <slot v-for="(datacheck, index) in datas">
                  <tr  :key="index">
                    <td style="vertical-align: middle;width:30%;text-align:center" class="text-capitalize">
                      {{ ($i18n.locale==='bn') ? datacheck.module_name_bn  :  datacheck.module_name  }}
                    </td>
                    <td colspan="2" class="text-capitalize">
                      <table style="width:100%" class="table tablesorter border table-hover" v-for="(datacheck1, index1) in datacheck.service" :key="index1">
                        <tr>
                          <td  style="vertical-align: middle;width:45%;text-align:center">
                            {{ ($i18n.locale==='bn') ? datacheck1.service_name_bn  :  datacheck1.service_name  }}
                          </td>
                          <td>
                            <slot v-if="datacheck1.master_menus.length>0">
                              <div class="form-check">
                                <input class="col-form-label-sm font-weight-bold mb-0 form-check-input" :id="'CheckBox' + datacheck1.id" type="checkbox" @click="checkAllChild(datacheck1)" v-model='datacheck1.isCheckAll'/>
                                <label :for="'CheckBox' + datacheck1.id">{{ $t('globalTrans.checkAll') }}  {{ datacheck1.service_name ? ($i18n.locale==='bn') ? datacheck1.service_name_bn  :  datacheck1.service_name  :  ($i18n.locale==='bn') ? datacheck.module_name_bn  :  datacheck.module_name + ' ' + $t('globalTrans.withoutService')  }}</label>
                              </div>
                              <hr class="p-0 m-0"/>
                              <div v-for="(datacheck2, index2) in datacheck1.master_menus" :key="index2">
                                <b-form-checkbox
                                  class="col-form-label-sm font-weight-bold mb-0"
                                  v-model="datacheck2.checked"
                                  name="checked"
                                  :unchecked-value=false
                                  >
                                  {{ ($i18n.locale==='bn') ? datacheck2.menu_name_bn  :  datacheck2.menu_name  }}
                                  </b-form-checkbox>
                              </div>
                            </slot>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </slot>
                <tr>
                  <td colspan="2">
                  </td>
                  <td>
                    <button
                      class="btn btn-primary pull-right"
                        v-on:click="SubmitData()"
                      >
                        <i class="fas fa-list"></i>Submit
                      </button>
                  </td>
                </tr>
              </table>
              <div class="panel-body text-center mt-3" v-else>
                <h4 v-if="is_hit" class="text-danger">{{ $t('globalTrans.noDataFound') }}</h4>
              </div>
            </b-col>
          </b-row>
        </b-overlay>
      </template>
      <!-- <pre>{{datas}}</pre> -->
      <!-- table section end -->
    </body-card>
  </div>
</template>
<script>
import RestApi, { commonServiceBaseUrl, authServiceBaseUrl } from '@/config/api_config'
import { mapGetters } from 'vuex'

export default {
  components: {},
  data () {
    return {
      search: {
        component_id: 0,
        module_id: 0,
        org_id: 0,
        role_id: 0
      },
      is_hit: false,
      roleList: [],
      isCheckAll: false,
      loader: false,
      loadingSearch: false,
      loadingData: false,
      datas: [],
      allreadyMenus: [],
      moduleList: []
    }
  },
  watch: {
    'search.org_id': function (newVal, oldVal) {
      this.loadData()
    },
    'search.component_id': function (newVal, oldVal) {
      this.is_hit = false
      this.moduleList = this.getModuleList(newVal)
      this.getallreadyMenus()
    },
    'search.module_id': function (newVal, oldVal) {
      this.is_hit = false
      this.getallreadyMenus()
    },
    'search.role_id': function (newVal, oldVal) {
      this.datas = []
      this.allreadyMenus = []
    }
  },
  created () {
    // this.loadData()
  },
  computed: {
    orgProfileList () {
        return this.$store.state.CommonService.commonObj.orgProfileList.filter(item => item.status === 1)
    },
    roleListData: function () {
      const listObject = this.roleList
      const tmpList = listObject.map((obj, index) => {
        if (this.$i18n.locale === 'bn') {
            return { value: obj.id, text: obj.role_name_bn }
        } else {
            return { value: obj.id, text: obj.role_name }
        }
      })
      return tmpList
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
    // componentList: function () {
    //   return this.authorizedComponents.map(item => {
    //       return { value: item.id, text: this.currentLocale === 'en' ? item.component_name : item.component_name_bn }
    //   })
    // },
    ...mapGetters({
      commonObj: 'commonObj',
      authorizedComponents: 'Auth/getAuthorizedComponents'
    }),
    listReload () {
      return this.$store.state.commonObj.listReload
    },
    loadingState () {
      if (this.listReload) {
        return true
      } else if (this.loading) {
        return true
      } else {
        return false
      }
    },
    currentLocale () {
      return this.$i18n.locale
    }
  },
  methods: {
    checkAllChild (checkdatas) {
      checkdatas.master_menus.map(item => {
        if (checkdatas.isCheckAll) {
          item.checked = false
        } else {
          item.checked = true
        }
        return Object.assign({}, item)
      })
      return checkdatas
    },
    getallreadyMenus () {
      this.loader = true
      RestApi.getData(authServiceBaseUrl, 'user-management/role/get-allready-assign-menus', this.search).then(response => {
        this.allreadyMenus = response
        this.getMenus()
      })
    },
    loadData () {
      this.loadingSearch = true
      RestApi.getData(authServiceBaseUrl, 'user-management/role/role-list-select/' + this.search.org_id, {}).then(response => {
      this.loadingSearch = false
        this.roleList = response
      }, error => {
        if (error) {
          this.loadingSearch = false
        }
        this.$store.dispatch('mutateCommonProperties', { loading: false, listReload: false })
        this.loadingSearch = false
      })
    },
    getMenus () {
      this.loadingData = true
      if (this.search.component_id && this.search.role_id) {
          this.datas = []
          RestApi.getData(commonServiceBaseUrl, 'menu/menu/all-menu-list', this.search).then(response => {
          this.loadingData = false
          const allDatas = []
          response.forEach((element, key) => {
            element.service.forEach((element2, key2) => {
              this.loadingData = false
              element2.master_menus.forEach((element3, key3) => {
                  element3.checked = false
                  this.allreadyMenus.forEach((element4, key4) => {
                    if (element3.id === element4.master_menu_id) {
                      element3.checked = true
                    }
                  })
                })
            })
            allDatas[key] = element
          })
          this.is_hit = true
          this.datas = allDatas
          // this.datas = response
        }, error => {
          if (error) {
            this.loadingData = false
          }
          this.loadingData = false
          this.$store.dispatch('mutateCommonProperties', { loading: false, listReload: false })
        })
      }
      this.loader = false
    },
    async confirmData () {
      this.loadingData = true
      let result = null
      this.role_loader = true
      result = await RestApi.postData(authServiceBaseUrl, 'user-management/role/menu-wise-role-store/' + this.search.role_id + '/' + this.search.component_id + '/' + this.search.module_id, this.datas)
      if (result.success) {
        this.loadingData = false
        this.$toast.success({
          title: 'Success',
          message: 'Data saved successfully',
          color: '#D6E09B'
        })
        this.loadingData = false
        // this.$router.push({ path: '/auth-service/user-management/menu-privilege-list' })
        this.isCheckAll = false
        this.search.module_id = 0
        this.search.component_id = 0
        this.datas = []
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
    },
    checkAll () {
      this.isCheckAll = !this.isCheckAll
      const allDatas = []
      if (this.isCheckAll) {
        this.datas.forEach((element, key) => {
          element.service.forEach((element2, key2) => {
            element2.master_menus.forEach((element3, key3) => {
                element3.checked = true
              })
          })
          allDatas[key] = element
        })
        this.datas = allDatas
      }
      if (!this.isCheckAll) {
        this.datas.forEach((element, key) => {
          element.service.forEach((element2, key2) => {
            element2.master_menus.forEach((element3, key3) => {
                element3.checked = false
              })
          })
          allDatas[key] = element
        })
        this.datas = allDatas
      }
    },
    getModuleList (componentId) {
      return this.$store.state.CommonService.commonObj.moduleList.filter(item => item.component_id === componentId).map(obj => {
        if (this.$i18n.locale === 'bn') {
          return { value: obj.value, text: obj.text_bn }
        } else {
          return { value: obj.value, text: obj.text_en }
        }
      })
    }
  }
}
</script>
