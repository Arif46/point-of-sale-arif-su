<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit, reset }">
    <b-overlay :show="loading">
      <b-form @submit.prevent="handleSubmit(saveUpdate)" @reset.prevent="reset" autocomplete="off">
        <b-row>
          <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Bank Name" vid="bank_id" rules="required|min_value:1">
              <b-form-group
                label-for="bank_id"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                Bank Name <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                v-model="formData.bank_id"
                :options="bankList"
                id="bank_id"
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
          <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Branch Name" vid="name" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="name">
                <template v-slot:label>
                  Branch Name <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="name"
                  v-model="formData.name"
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
          <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Mobile" vid="mobile" rules="required" v-slot="{ errors }">
                <b-form-group
                  label-for="mobile">
                  <template v-slot:label>
                    Mobile <span class="text-danger">*</span>
                  </template>
                  <b-form-input
                    type="text"
                    id="mobile"
                    v-model="formData.mobile"
                    :state="errors[0] ? false : (valid ? true : null)"
                  ></b-form-input>
                  <div class="invalid-feedback">
                    {{ errors[0] }}
                  </div>
                </b-form-group>
              </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Fax" vid="fax" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="mobile">
                <template v-slot:label>
                  Fax <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="fax"
                  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                  v-model="formData.fax"
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
          <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Email" vid="email" rules="" v-slot="{ errors }">
              <b-form-group
                label-for="email"
              >
              <template v-slot:label>
                  {{ $t('globalTrans.email') }}
                  </template>
                  <b-form-input
                  id="org_bn"
                  type="email"
                  v-model="formData.email"
                  :state="errors[0] ? false : (valid ? true : null)"
                  ></b-form-input>
                  <div class="invalid-feedback">
                  {{ errors[0] }}
                  </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Routing No" vid="routing_no" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="routing_no">
                <template v-slot:label>
                  Routing No <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="routing_no"
                  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                  v-model="formData.routing_no"
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
          <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Telephone" vid="telephone" rules="required" v-slot="{ errors }">
                <b-form-group
                  label-for="heading">
                  <template v-slot:label>
                    Telephone <span class="text-danger">*</span>
                  </template>
                  <b-form-input
                    type="text"
                    id="telephone"
                    v-model="formData.telephone"
                    :state="errors[0] ? false : (valid ? true : null)"
                  ></b-form-input>
                  <div class="invalid-feedback">
                    {{ errors[0] }}
                  </div>
                </b-form-group>
              </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Address" vid="address" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="heading">
                <template v-slot:label>
                  Address <span class="text-danger">*</span>
                </template>
                <b-form-textarea
                  id="heading"
                  v-model="formData.address"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-textarea>
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
import RestApi, { apiBaseUrl } from '@/config/api_config'
import { branchStore, branchUpdate } from '../../api/routes'
export default {
  name: 'Form',
  props: ['id'],
  data () {
    return {
      valid: null,
      saveBtnName: this.id ? this.$t('globalTrans.update') : this.$t('globalTrans.save'),
      errors: [],
      formData: {
        name: '',
        bank_id: 0,
        address: '',
        telephone: '',
        mobile: '',
        fax: '',
        email: '',
        routing_no: ''
      }
    }
  },
  created () {
    if (this.id) {
      const tmp = this.getUpdateId()
      this.formData = tmp
    }
  },
  computed: {
    bankList () {
      return this.$store.state.CommonService.commonObj.bankList.filter(item => item.status === 1)
    },
    loading: function () {
      return this.$store.state.commonObj.loading
    }
  },
  watch: {
  },
  methods: {
    async saveUpdate () {
      this.$store.dispatch('mutateCommonProperties', { loading: true })
      let result = null
      const loadingState = { loading: false, listReload: false }

      if (this.id) {
        result = await RestApi.putData(apiBaseUrl, `${branchUpdate}/${this.id}`, this.formData)
      } else {
        result = await RestApi.postData(apiBaseUrl, branchStore, this.formData)
      }

      loadingState.listReload = true
      this.$store.dispatch('mutateCommonProperties', loadingState)

      if (result.success) {
        this.$store.dispatch('CommonService/mutateCommonObj', { hasDropdownLoaded: false })
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
    getDistrictList (divisionId) {
      return this.$store.state.CommonService.commonObj.districtList.filter(item => item.status === 1 && item.division_id === divisionId)
    },
    getUpazilaList (upazilaId) {
      return this.$store.state.CommonService.commonObj.upazilaList.filter(item => item.status === 1 && item.district_id === upazilaId)
    },
    getUpdateId () {
      const tmpData = this.$store.state.list.find(item => item.id === this.id)
      return JSON.parse(JSON.stringify(tmpData))
    }
  }
}
</script>
