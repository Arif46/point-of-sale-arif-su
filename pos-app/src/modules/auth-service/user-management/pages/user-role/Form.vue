<template>
 <b-container fluid>
    <ValidationObserver>
      <b-row>
        <template>
          <div style="font-size:12px; background-color: #77a0cb; padding:6px; font-family: fantasy" class="mt-2">
            <h5 class="text-white text-left"> {{ $t('userManagement.roles') }}</h5>
          </div>
        </template>
        <b-col xs="12" sm="12" md="4" lg="4" xl="4" class="mt-2">
            <ValidationProvider name="Organization" vid="org_id" rules="required|min_value:1">
                <b-form-group
                    label-for="org_id"
                    slot-scope="{ valid, errors }"
                >
                <template v-slot:label>
                    {{$t('organogram.org')}} <span class="text-danger">*</span>
                </template>
                <b-form-select
                    plain
                    v-model="search.org_id"
                    :options="orgList"
                    id="org_id"
                    :state="errors[0] ? false : (valid ? true : null)"
                >
                    <template v-slot:first>
                    <b-form-select-option :value=0>{{$t('globalTrans.select')}}</b-form-select-option>
                    </template>
                </b-form-select>
                <div class="invalid-feedback">
                    {{ errors[0] }}
                </div>
                </b-form-group>
            </ValidationProvider>
        </b-col>
        <b-col xs="12" sm="12" md="4" lg="4" xl="4" class="mt-2">
          <ValidationProvider name="Office Type" vid="office_type_id" rules="required|min_value:1">
              <b-form-group
                  label-for="office_type_id"
                  slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                  {{$t('organogram.office_type')}} <span class="text-danger">*</span>
              </template>
              <b-form-select
                  plain
                  v-model="search.office_type_id"
                  :options="officeTypeList"
                  id="office_type_id"
                  :state="errors[0] ? false : (valid ? true : null)"
              >
                  <template v-slot:first>
                  <b-form-select-option :value=0>{{$t('globalTrans.select')}}</b-form-select-option>
                  </template>
              </b-form-select>
              <div class="invalid-feedback">
                  {{ errors[0] }}
              </div>
              </b-form-group>
          </ValidationProvider>
        </b-col>
        <b-col xs="12" sm="12" md="4" lg="4" xl="4" class="mt-2">
          <ValidationProvider name="Office name" vid="office_id" rules="required|min_value:1">
              <b-form-group
                  label-for="office_id"
                  slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                  {{$t('organogram.office_name')}} <span class="text-danger">*</span>
              </template>
              <b-form-select
                  plain
                  v-model="search.office_id"
                  :options="officeList"
                  id="office_id"
                  :state="errors[0] ? false : (valid ? true : null)"
              >
                  <template v-slot:first>
                  <b-form-select-option :value=0>{{$t('globalTrans.select')}}</b-form-select-option>
                  </template>
              </b-form-select>
              <div class="invalid-feedback">
                  {{ errors[0] }}
              </div>
              </b-form-group>
          </ValidationProvider>
        </b-col>
      </b-row>
      <b-row>
        <template>
          <div style="font-size:12px; background-color: #77a0cb; padding:6px; font-family: fantasy" class="mt-2">
            <h5 class="text-white text-left"> {{ $t('userManagement.roles') }}</h5>
            <p style="margin-top:-2%; font-size:20px; font-left:10px; font-family: fantasy" class="text-right"><router-link to="assign-user-list" :class="'text-light'">{{  $t('userManagement.user') }} {{  $t('globalTrans.list') }}</router-link></p>
          </div>
        </template>
        <b-row>
          <b-col lg="6" sm="12" class="user-section mt-3">
            <iq-card>
              <template class="mt-2">
                <h4 class="text-center">{{ $t('userManagement.user') }} {{ $t('globalTrans.list') }}</h4>
                <hr class="mt-4"/>
                  <ValidationProvider name="Designation" vid="designation_id" rules="required|min_value:1">
                    <b-form-group
                        class="row mb-0"
                        label-cols-sm="3"
                        label-for="designation_id"
                        slot-scope="{ valid, errors }"
                    >
                    <template v-slot:label>
                        {{$t('organogram.designation')}} <span class="text-danger">*</span>
                    </template>
                    <b-form-select
                        plain
                        v-model="search.designation_id"
                        :options="designationList"
                        id="designation_id"
                        :state="errors[0] ? false : (valid ? true : null)"
                    >
                        <template v-slot:first>
                        <b-form-select-option :value=0>{{$t('globalTrans.select')}}</b-form-select-option>
                        </template>
                    </b-form-select>
                    <div class="invalid-feedback">
                        {{ errors[0] }}
                    </div>
                    </b-form-group>
                  </ValidationProvider>
                <div class="d-flex justify-content-center" v-if="loader">
                  <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </div>
                <slot v-else>
                  <table class="table mt-2" v-if="userRole.user_ids.length>0">
                    <slot v-for="(user, index) in userRole.user_ids">
                      <tr :key="index">
                        <td>{{index+1}}</td>
                        <td>
                          <b-form-radio
                            class="col-form-label-sm font-weight-bold mb-0"
                            v-model="user.checked"
                            @change="clickUserMenue(user)"
                            name="checked"
                            :unchecked-value=false
                            >
                            {{ ($i18n.locale==='bn') ? user.name_bn  :  user.name  }}
                          </b-form-radio>
                        </td>
                      </tr>
                    </slot>
                  </table>
                  <div class="panel-body text-center mt-3" v-else>
                    <h6 class="text-danger">{{ $t('globalTrans.noDataFound') }}</h6>
                  </div>
                </slot>
              </template>
            </iq-card>
          </b-col>
            <b-col lg="6" sm="12" class="role-section mt-3">
            <iq-card>
              <template class="mt-2">
                <h4 class="text-center">{{ $t('userManagement.role') }} {{ $t('globalTrans.list') }}</h4>
                <hr class="mt-4"/>
                  <slot>
                    <h5 style="height: 29px">
                      <slot v-if="data.name">
                        {{  $t('userManagement.role_of') }} : <b>{{ data.name }}</b>
                      </slot>
                      <slot v-else>
                        <div class="text-center text-danger">{{  $t('userManagement.PleaseSelectUser') }}</div>
                      </slot>
                    </h5>
                    <hr/>
                    <slot v-if="roleLoader">
                      Loading ......
                    </slot>
                    <slot>
                        <b-form  v-if="data.roles.length>0">
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
              </template>
            </iq-card>
          </b-col>
        </b-row>
      </b-row>
    </ValidationObserver>
    </b-container>
</template>
<script>
import RestApi, { authServiceBaseUrl } from '@/config/api_config'
import { userListByDesignWise, UserRoleData, assignUserRoleStore } from '../../api/routes'
import { mapGetters } from 'vuex'
export default {
  name: 'Form',
  props: ['id'],
  data () {
    return {
      valid: null,
      errors: [],
      search: {
        org_id: 0,
        office_type_id: 0,
        office_id: 0,
        designation_id: 0
      },
      userRole: {
        user_ids: []
      },
      data: {
        user_id: '',
        name: '',
        designation_id: 0,
        org_id: 0,
        roles: []
      },
      officeTypeList: [],
      officeList: [],
      designationList: [],
      loader: false,
      roleLoader: false,
      is_hit: false
    }
  },
  created () {
    if (this.authUser.role_id === 0 && this.authUser.is_org_admin === 1) {
      this.search = Object.assign({}, this.search, {
        org_id: this.authUser.org_id
      })
    } else if (this.authUser.role_id === 0) {
      this.search = Object.assign({}, this.search, {
        org_id: this.authUser.office_detail.org_id,
        office_type_id: this.authUser.office_detail.office_type_id,
        office_id: this.authUser.office_detail.office_id,
        designation_id: this.authUser.office_detail.designation_id
      })
    }
  },
  computed: {
    orgList () {
      return this.$store.state.CommonService.commonObj.orgProfileList.map(item => {
        if (this.$i18n.locale === 'bn') {
          return { value: item.value, text: item.text_bn }
        } else {
          return { value: item.value, text: item.text_en }
        }
      })
    },
    currentLocale () {
      return this.$i18n.locale
    },
    ...mapGetters({
      authUser: 'Auth/authUser'
    })
  },
  watch: {
    'search.org_id': function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.officeTypeList = this.getOfficeTypeList(newVal)
        this.designationList = this.getDesignationList(newVal)
        this.setOfficeList(newVal, this.search.office_type_id)
        this.setDesignationList(newVal)
      } else {
        this.officeTypeList = []
        this.designationList = []
      }
    },
    'search.office_type_id': function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.officeList = this.getOfficeList(newVal)
        this.setOfficeList(this.search.org_id, newVal)
        this.getDesignationUser()
      } else {
        this.officeList = []
      }
    },
    'search.office_id': function (newVal) {
      this.getDesignationUser()
    },
    'search.designation_id': function (newVal, oldVal) {
      this.getDesignationUser()
    }
  },
  methods: {
    getDesignationUser () {
      if (this.search.designation_id) {
        this.userRole.user_ids = []
        this.data.id = ''
        this.data.name = ''
        this.data.roles = []
        this.loader = true
        RestApi.getData(authServiceBaseUrl, userListByDesignWise, this.search).then(response => {
          this.userRole.user_ids = response.data
          this.loader = false
          this.is_hit = true
        }, error => {
          if (error) {
          }
          this.$store.dispatch('mutateCommonProperties', { loading: false, listReload: false })
        })
      }
    },
    getUserRoledata () {
      this.roleLoader = true
      this.data.org_id = this.search.org_id
      RestApi.getData(authServiceBaseUrl, UserRoleData, this.data).then(response => {
        this.data.roles = response
        this.roleLoader = false
      }, error => {
        if (error) {
          //
        }
        this.$store.dispatch('mutateCommonProperties', { loading: false, listReload: false })
      })
    },
    clickUserMenue (user) {
      this.data.user_id = user.user_id
      this.data.name = user.name
      this.data.designation_id = this.search.designation_id
      this.getUserRoledata()
    },
    setOfficeList (orgId, officeTypeId) {
      this.search.office_id = 0
      let officeList = []
      if (officeTypeId) {
         officeList = this.$store.state.CommonService.commonObj.officeList.filter(item => item.status === 1 && item.office_type_id === officeTypeId)
         this.officeList = officeList
         return
      }
      officeList = this.$store.state.CommonService.commonObj.officeList.filter(item => item.status === 1 && item.org_id === orgId)
      this.officeList = officeList
    },
    setDesignationList (orgId) {
      const desigList = this.$store.state.CommonService.commonObj.designationList.filter(item => item.status === 1 && item.org_id === orgId)
      this.designationList = desigList
    },
    getOfficeTypeList (id) {
      return this.$store.state.CommonService.commonObj.officeTypeList.filter(item => item.status === 1 && item.org_id === id)
    },
    getOfficeList (id) {
      return this.$store.state.CommonService.commonObj.officeList.filter(item => item.status === 1 && item.office_type_id === id)
    },
    getDesignationList (id) {
      return this.$store.state.CommonService.commonObj.designationList.filter(item => item.status === 1 && item.org_id === id)
    },
    async confirmData () {
      let result = null
      this.roleLoader = true
      result = await RestApi.postData(authServiceBaseUrl, assignUserRoleStore, this.data)
      if (result.success) {
        this.roleLoader = false
        this.$toast.success({
          title: 'Success',
          message: 'Data saved successfully',
          color: '#D6E09B'
        })
      }
      this.$router.push({ path: '/auth-service/user-management/assign-user-list' })
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
<style scoped>
  .user-section .iq-card {
    border: solid 1px #e6e6e6
  }
  .role-section .iq-card {
    border: solid 1px #e6e6e6
  }
</style>
