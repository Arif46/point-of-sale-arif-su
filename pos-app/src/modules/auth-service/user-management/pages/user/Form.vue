<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit, reset }">
    <b-overlay :show="loading">
      <b-form @submit.prevent="handleSubmit(saveUpdate)" @reset.prevent="reset" autocomplete="off">
        <b-row>
          <b-col lg="6" sm="12">
            <ValidationProvider name="Org Id" vid="org_id" rules="required|min_value:1">
              <b-form-group
                class="row"
                label-cols-sm="4"
                label-for="org_id"
                slot-scope="{ valid, errors }"
                >
                  <template v-slot:label>
                  {{ $t('globalTrans.organization')}} <span class="text-danger">*</span>
                  </template>
                <b-form-select
                  plain
                  v-model="form.details.org_id"
                  :options="orgList"
                  id="org_id"
                  :state="errors[0] ? false : (valid ? true : null)"
                  >
                  <template v-slot:first>
                    <b-form-select-option :value="0">{{$t('globalTrans.select')}}</b-form-select-option>
                  </template>
                </b-form-select>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col lg="6" sm="12">
            <ValidationProvider name="Office Type id" vid="office_type_id" rules="required|min_value:1">
              <b-form-group
                class="row"
                label-cols-sm="4"
                label-for="office_type_id"
                slot-scope="{ valid, errors }"
                >
                <template v-slot:label>
                {{ $t('userManagement.office_type')}} <span class="text-danger">*</span>
                </template>
                <b-form-select
                  plain
                  v-model="form.details.office_type_id"
                  :options="officeTypeList"
                  :state="errors[0] ? false : (valid ? true : null)"
                  >
                  <template v-slot:first>
                    <b-form-select-option :value="0">{{$t('globalTrans.select')}}</b-form-select-option>
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
          <b-col lg="6" sm="12">
            <ValidationProvider name="Office Id" vid="office_id" rules="required|min_value:1">
              <b-form-group
                class="row"
                label-cols-sm="4"
                label-for="office_id"
                slot-scope="{ valid, errors }"
                >
                <template v-slot:label>
                  {{ $t('userManagement.office')}} <span class="text-danger">*</span>
                </template>
                <b-form-select
                  plain
                  v-model="form.details.office_id"
                  :options="officeList"
                  id="office_id"
                  :state="errors[0] ? false : (valid ? true : null)"
                  >
                  <template v-slot:first>
                    <b-form-select-option :value="0">{{$t('globalTrans.select')}}</b-form-select-option>
                  </template>
                </b-form-select>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col lg="6" sm="12">
            <ValidationProvider name="Designation Id" vid="designation_id" rules="required|min_value:1">
              <b-form-group
                class="row"
                label-cols-sm="4"
                label-for="designation_id"
                slot-scope="{ valid, errors }"
                >
                <template v-slot:label>
                {{ $t('globalTrans.designation')}} <span class="text-danger">*</span>
                </template>
                <b-form-select
                  plain
                  v-model="form.details.designation_id"
                  :options="designationList"
                  id="designation_id"
                  :state="errors[0] ? false : (valid ? true : null)"
                  >
                  <template v-slot:first>
                    <b-form-select-option :value="0">{{$t('globalTrans.select')}}</b-form-select-option>
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
          <b-col lg="6" sm="12">
            <ValidationProvider name="Name (En)" vid="name" rules="required">
              <b-form-group
                class="row"
                label-cols-sm="4"
                label-for="name"
                slot-scope="{ valid, errors }"
              >
                <template v-slot:label>
                {{ $t('userManagement.name')}} <span class="text-danger">*</span>
                  </template>
                <b-form-input
                  v-model="form.name"
                  :state="errors[0] ? false : (valid ? true : null)"
                  ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col lg="6" sm="12">
            <ValidationProvider name="Name (Bn)" vid="name_bn" rules="required">
              <b-form-group
                class="row"
                label-cols-sm="4"
                label-for="name_bn"
                slot-scope="{ valid, errors }"
              >
                <template v-slot:label>
                {{ $t('userManagement.name_bn')}}<span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="name_bn"
                  v-model="form.name_bn"
                  :state="errors[0] ? false : (valid ? true : null)"
                  ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
        </b-row>
        <b-row>
          <b-col lg="6" sm="12">
            <ValidationProvider name="Mobile No" vid="mobile_no" rules="required|numeric|min:11" >
              <b-form-group
                class="row"
                label-cols-sm="4"
                label-for="mobile_no"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                {{ $t('userManagement.mobile_no')}} <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="mobile_no"
                  v-model="form.mobile"
                  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                  :state="errors[0] ? false : (valid ? true : null)"
                  ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col lg="6" sm="12">
            <ValidationProvider name="Email" vid="email" rules="required|email|min:3">
              <b-form-group
                class="row"
                label-cols-sm="4"
                label-for="email"
                slot-scope="{ valid, errors }"
              >
                <template v-slot:label>
                {{ $t('globalTrans.email')}} <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="email"
                  v-model="form.email"
                  :state="errors[0] ? false : (valid ? true : null)"
                  ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
        </b-row>
        <b-row>
          <b-col lg="6" sm="12">
            <ValidationProvider name="UserName" vid="username" rules="required">
              <b-form-group
                class="row"
                label-cols-sm="4"
                label-for="username"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                {{ $t('userManagement.username')}} <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="username"
                  v-model="form.username"
                  :state="errors[0] ? false : (valid ? true : null)"
                  ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col lg="6" sm="12">
            <ValidationProvider name="Nothi User Id">
              <b-form-group
                class="row"
                label-cols-sm="4"
                label-for="nothi_user_id"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                {{ $t('userManagement.nothi_user_id')}}
                </template>
                <b-form-input
                  id="nothi_user_id"
                  v-model="form.nothi_user_id"
                  :state="errors[0] ? false : (valid ? true : null)"
                  ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
        </b-row>
        <b-row>
          <b-col lg="6" sm="12">
            <ValidationProvider name="Password" :rules="passwordRules">
              <b-form-group
                class="row"
                label-cols-sm="4"
                label-for="password"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                {{ $t('userManagement.password')}} <span v-if="!form.id" class="text-danger">*</span>
                </template>
                <b-form-input
                  type="password"
                  id="password"
                  v-model="form.password"
                  autocomplete="new-password"
                  :state="errors[0] ? false : (valid ? true : null)"
                  ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col lg="6" sm="12">
            <ValidationProvider name="Repeat Password" vid="password_confirmation" :rules="passwordConfirmRules">
              <b-form-group
                class="row"
                label-cols-sm="4"
                label-for="password_confirmation"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                {{ $t('userManagement.password_confirmation')}}<span v-if="!form.id" class="text-danger">*</span>
                </template>
                <b-form-input
                  type="password"
                  id="password_confirmation"
                  v-model="form.password_confirmation"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
        </b-row>
        <b-row>
          <b-col lg="6" sm="12">
            <ValidationProvider name="Secret Question" vid="secret_question_id">
              <b-form-group
                class="row"
                label-cols-sm="4"
                label-for="secret_question_id"
                slot-scope="{ valid, errors }"
                >
                <template v-slot:label>
                {{ $t('userManagement.secret_question') }}
                </template>
                <b-form-select
                  plain
                  v-model="form.answer.secret_question_id"
                  :options="secretQList"
                  :readonly="1"
                  id="secret_question_id"
                  :state="errors[0] ? false : (valid ? true : null)"
                  >
                  <template v-slot:first>
                    <b-form-select-option :value="0">{{$t('globalTrans.select')}}</b-form-select-option>
                  </template>
                </b-form-select>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col lg="6" sm="12">
            <ValidationProvider name="Answer">
              <b-form-group
                class="row"
                label-cols-sm="4"
                label-for="answer"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                {{ $t('userManagement.answer')}}
                </template>
                <b-form-input
                  id="answer"
                  v-model="form.answer.answer"
                  :state="errors[0] ? false : (valid ? true : null)"
                  ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
        </b-row>
        <b-row>
          <b-col lg="6" sm="12">
            <ValidationProvider name="Photo">
              <b-form-group
                class="row"
                label-cols-sm="4"
                label-for="photo"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                {{ $t('userManagement.photo')}}
                </template>
                <b-form-file
                  id="photo"
                  v-on:change="handlePhoto"
                  accept="image/*"
                  :state="errors[0] ? false : (valid ? true : null)"
                  ></b-form-file>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col lg="6" sm="12">
            <ValidationProvider name="Organization Admin" vid="org_admin">
              <b-form-group
                class="row"
                label-cols-sm="4"
                label-for="Internal"
                slot-scope="{ valid, errors }"
              >
                <template v-slot:label>
                  {{ $t('userManagement.organization_admin') }}
                </template>
                <b-form-checkbox
                  class="mt-2"
                  id="Internal"
                  v-model="form.org_admin"
                  :state="errors[0] ? false : (valid ? true : null)"
                  >Yes</b-form-checkbox>
                  <div class="invalid-feedback">
                    {{ errors[0] }}
                  </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
        </b-row>
        <b-row class="text-right">
          <b-col>
              <b-button type="submit" variant="success" class="mr-2 btn-sm">{{ saveBtnName }}</b-button>
              <b-button variant="danger" class="btn-sm" @click="$bvModal.hide('modal-form')">{{ $t('globalTrans.cancel') }}</b-button>
          </b-col>
        </b-row>
      </b-form>
    </b-overlay>
  </ValidationObserver>
</template>
<script>
import RestApi, { authServiceBaseUrl } from '@/config/api_config'
import { userStore, userUpdate } from '../../api/routes'
export default {
  name: 'Form',
  props: ['id', 'secretQuestionList'],
  data () {
    return {
      valid: null,
      saveBtnName: this.id ? this.$t('globalTrans.update') : this.$t('globalTrans.save'),
      errors: [],
      form: {
        name: '',
        name_bn: '',
        username: '',
        email: '',
        org_admin: false,
        mobile: '',
        nid: '',
        password: '',
        password_confirmation: '',
        details: {
          designation_id: 0,
          org_id: 0,
          office_type_id: 0,
          office_id: 0,
          role_id: 0,
          photo: null
        },
        answer: {
          secret_question_id: 0,
          answer: ''
        }
      },
      photoDemo: [],
      officeTypeList: [],
      officeList: [],
      designationList: [],
      secretQList: []
    }
  },
  created () {
    this.secretQList = this.secretQuestionList
    if (this.id) {
      const tmp = this.getUser()
      if (tmp.org_admin === 1) {
        this.form = Object.assign(tmp, { org_admin: true })
      } else {
        this.form = Object.assign(tmp, { org_admin: false })
      }
    }
  },
  computed: {
    loading: function () {
      return this.$store.state.commonObj.loading
    },
    orgList: function () {
      return this.$store.state.CommonService.commonObj.orgProfileList
    },
    passwordRules: function () {
      return this.id ? '' : 'required|min:6'
    },
    passwordConfirmRules: function () {
      return this.id ? '' : 'required|min:6'
    }
  },
  watch: {
    'form.details.org_id': function (newVal, oldVal) {
      if (oldVal !== newVal) {
        this.officeTypeList = this.getOfficeTypeList(newVal)
      }
    },
    'form.details.office_type_id': function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.officeList = this.getOfficeList(newVal)
      }
    },
    'form.details.office_id': function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.designationList = this.getDesignationList(newVal)
      }
    }
  },
  methods: {
    getOfficeTypeList (orgId) {
      return this.$store.state.CommonService.commonObj.officeTypeList.filter(offType => offType.org_id === orgId)
    },
    getOfficeList (officeTypeId) {
      return this.$store.state.CommonService.commonObj.officeList.filter(office => office.office_type_id === officeTypeId)
    },
    getDesignationList (officeId) {
      return this.$store.state.CommonService.commonObj.assignDesignationList.filter(desgn => desgn.office_id === officeId && desgn.office_type_id === this.form.details.office_type_id && desgn.org_id === this.form.details.org_id)
    },
    handlePhoto (e) {
      const selectedPhoto = e.target.files[0]
      const reader = new FileReader()
      reader.onload = (event) => {
        this.form.details.photo = event.target.result
        this.form.details.update_photo = 1
      }
      reader.readAsDataURL(selectedPhoto)
    },
    async saveUpdate () {
      this.$store.dispatch('mutateCommonProperties', { loading: true })
      let result = null
      const loadingState = { loading: false, listReload: false }
      const formData = Object.assign(this.form, {
        org_admin: this.form.org_admin ? 1 : 2
      })
      if (this.id) {
        result = await RestApi.putData(authServiceBaseUrl, `${userUpdate}/${this.id}`, formData)
      } else {
        result = await RestApi.postData(authServiceBaseUrl, userStore, formData)
      }

      loadingState.listReload = true
      this.$store.dispatch('mutateCommonProperties', loadingState)

      if (result.success) {
        this.$store.dispatch('mutateCommonProperties', { hasDropdownLoaded: false })
        this.$toast.success({
          title: 'Success',
          message: this.id ? this.$t('globalTrans.update_msg') : this.$t('globalTrans.save_msg'),
          color: '#D6E09B'
        })

        this.$bvModal.hide('modal-form')
      } else {
        this.$refs.form.setErrors(result.errors)
      }
    },
    getUser () {
      const tmpData = this.$store.state.list.find(item => item.id === this.id)
      return JSON.parse(JSON.stringify(tmpData))
    }
  }
}
</script>
