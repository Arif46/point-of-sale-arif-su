<template>
  <div>
    <b-row>
      <b-col lg="6" sm="12">
        <ValidationProvider >
          <b-form-group
            class="row"
            label-cols-sm="4"
            >
              <template v-slot:label>
              {{ $t('globalTrans.organization') }}
              </template>
            <b-form-input
              :value="$i18n.locale === 'bn' ? form.org_name_bn : form.org_name"
              :readonly="true"
            >
            </b-form-input>
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
            {{ $t('userManagement.office_type')}}
            </template>
            <b-form-select
              plain
              v-model="form.details.office_type_id"
              :options="officeTypeList"
              :disabled="true"
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
              {{ $t('userManagement.office') }}
            </template>
            <b-form-select
              plain
              v-model="form.details.office_id"
              :options="officeList"
              id="office_id"
              :disabled="true"
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
            {{ $t('globalTrans.designation')}}
            </template>
            <b-form-select
              plain
              v-model="form.details.designation_id"
              :options="designationList"
              id="designation_id"
              :disabled="true"
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
          >
            <template v-slot:label>
            {{ $t('userManagement.name')}}
              </template>
            <b-form-input
              v-model="form.name"
              :readonly="true"
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
          >
            <template v-slot:label>
            {{ $t('userManagement.name_bn')}}
            </template>
            <b-form-input
              id="name_bn"
              v-model="form.name_bn"
              :readonly="true"
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
          >
          <template v-slot:label>
            {{ $t('userManagement.mobile_no')}}
            </template>
            <b-form-input
              id="mobile_no"
              v-model="form.mobile"
              :readonly="true"
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
          >
            <template v-slot:label>
            {{ $t('globalTrans.email')}}
            </template>
            <b-form-input
              id="email"
              v-model="form.email"
              :readonly="true"
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
          >
          <template v-slot:label>
            {{ $t('userManagement.username')}}
            </template>
            <b-form-input
              id="username"
              v-model="form.username"
              :readonly="true"
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
          >
          <template v-slot:label>
            {{ $t('userManagement.nothi_user_id')}}
            </template>
            <b-form-input
              id="nothi_user_id"
              v-model="form.nothi_user_id"
              :readonly="true"
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
              :disabled="true"
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
          >
          <template v-slot:label>
            {{ $t('userManagement.answer')}}
            </template>
            <b-form-input
              id="answer"
              v-model="form.answer.answer"
              :readonly="true"
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
          >
          <template v-slot:label>
            {{ $t('userManagement.photo')}}
            </template>
            <!-- <img :src="irriSchemeServiceBaseUrl + 'download-attachment?file=uploads/farmer-basic/original/' + dataTest.farmerBasicInfo.attachment" class="img-fluid rounded mr-1" alt="user"> -->
            <img :src="authServiceBaseUrl + 'download-attachment?file=app/public/'+ form.details.photo" alt="User Photo" style="width:100px;height:100px;border:1px solid"/>
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
  </div>
</template>
<script>
import { authServiceBaseUrl } from '@/config/api_config'
export default {
  name: 'Details',
  props: ['id', 'secretQuestionList'],
  data () {
    return {
      authServiceBaseUrl: authServiceBaseUrl,
      errors: [],
      form: {},
      officeTypeList: [],
      officeList: [],
      designationList: [],
      secretQList: []
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
  created () {
    this.secretQList = this.secretQuestionList
    const tmp = this.getUser()
    if (tmp.org_admin === 1) {
      this.form = Object.assign(tmp, { org_admin: true })
    } else {
      this.form = Object.assign(tmp, { org_admin: false })
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
    getUser () {
      const tmpData = this.$store.state.list.find(item => item.id === this.id)
      return JSON.parse(JSON.stringify(tmpData))
    }
  }
}
</script>
<style scoped>
  .mt-7 {
    margin-top: 7px;
  }
</style>
