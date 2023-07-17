<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit, reset }">
    <b-overlay :show="loading">
    <b-form @submit.prevent="handleSubmit(saveUpdate)" @reset.prevent="reset" autocomplete="off">
      <b-row>
        <b-col lg="6" md="6" sm="6" xs="12">
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
              v-model="form.org_id"
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
        <b-col lg="6" md="6" sm="6" xs="12">
          <ValidationProvider name="Designation" vid="designation_id" rules="required|min_value:1">
            <b-form-group
              label-for="designation_id"
              slot-scope="{ valid, errors }"
            >
            <template v-slot:label>
              {{$t('organogram.designation')}} <span class="text-danger">*</span>
            </template>
            <b-form-select
              plain
              v-model="form.designation_id"
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
        </b-col>
        <b-col sm="6">
          <ValidationProvider name="Role (En)" vid="role_name" rules="required" v-slot="{ errors }">
            <b-form-group
              label-for="role_name">
              <template v-slot:label>
                {{ $t('userManagement.role_en') }} <span class="text-danger">*</span>
              </template>
              <b-form-input
                id="role_name"
                v-model="form.role_name"
                :state="errors[0] ? false : (valid ? true : null)"
              ></b-form-input>
              <div class="invalid-feedback">
                {{ errors[0] }}
              </div>
            </b-form-group>
          </ValidationProvider>
        </b-col>
        <b-col sm="6">
          <ValidationProvider name="Role Name (Bn)" vid="role_name_bn" rules="required" v-slot="{ errors }">
            <b-form-group
              label-for="role_name_bn">
              <template v-slot:label>
                {{ $t('userManagement.role_bn') }} <span class="text-danger">*</span>
              </template>
              <b-form-input
                id="role_name_bn"
                v-model="form.role_name_bn"
                :state="errors[0] ? false : (valid ? true : null)"
              ></b-form-input>
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
import { roleStore, roleUpdate } from '../../api/routes'
export default {
  name: 'Form',
  props: ['id'],
  data () {
    return {
      valid: null,
      saveBtnName: this.id ? this.$t('globalTrans.update') : this.$t('globalTrans.save'),
      errors: [],
      form: {
        role_name: '',
        role_name_bn: '',
        org_id: 0,
        designation_id: 0
      },
      designationList: []
    }
  },
  created () {
    if (this.id) {
      const tmp = this.getRole()
      this.form = tmp
    }
  },
  watch: {
    'form.org_id': function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.designationList = this.getDesignationList(newVal)
      }
    }
  },
  computed: {
    loading: function () {
      return this.$store.state.commonObj.loading
    },
    orgList () {
      return this.$store.state.CommonService.commonObj.orgProfileList.map(item => {
        if (this.$i18n.locale === 'bn') {
          return { value: item.value, text: item.text_bn }
        } else {
          return { value: item.value, text: item.text_en }
        }
      })
    }
  },
  methods: {
    getDesignationList (orgId) {
      return this.$store.state.CommonService.commonObj.designationList.filter(item => item.status === 1 && item.org_id === orgId).map(obj => {
        if (this.$i18n.locale === 'bn') {
          return { value: obj.value, text: obj.text_bn }
        } else {
          return { value: obj.value, text: obj.text_en }
        }
      })
    },
    async saveUpdate () {
      this.$store.dispatch('mutateCommonProperties', { loading: true })
      let result = null
      const loadingState = { loading: false, listReload: false }

      if (this.id) {
        result = await RestApi.putData(authServiceBaseUrl, `${roleUpdate}/${this.id}`, this.form)
      } else {
        result = await RestApi.postData(authServiceBaseUrl, roleStore, this.form)
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
    getRole () {
      const tmpData = this.$store.state.list.find(item => item.id === this.id)
      return JSON.parse(JSON.stringify(tmpData))
    }
  }
}
</script>
