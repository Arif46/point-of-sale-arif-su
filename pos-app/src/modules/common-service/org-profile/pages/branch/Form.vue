<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit, reset }">
    <b-overlay :show="loading">
    <b-form @submit.prevent="handleSubmit(saveUpdate)" @reset.prevent="reset" autocomplete="off">
      <b-row>
        <b-col xs="12" sm="12" md="6" lg="6" xl="6">
          <ValidationProvider name="Organization" vid="org_id" rules="required|min_value:1">
            <b-form-group
              label-for="org_id"
              slot-scope="{ valid, errors }"
            >
            <template v-slot:label>
              {{$t('orgProfile.org_name')}} <span class="text-danger">*</span>
            </template>
            <b-form-select
              plain
              v-model="form.org_id"
              :options="orgProfileList"
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
        <b-col xs="12" sm="12" md="6" lg="6" xl="6">
          <ValidationProvider name="Bank" vid="bank_id" rules="required|min_value:1">
            <b-form-group
              label-for="bank_id"
              slot-scope="{ valid, errors }"
            >
            <template v-slot:label>
              {{$t('orgProfile.bank')}} <span class="text-danger">*</span>
            </template>
            <b-form-select
              plain
              v-model="form.bank_id"
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
          <ValidationProvider name="Branch Name (En)" vid="branch_name" rules="required" v-slot="{ errors }">
            <b-form-group
              label-for="branch_name">
              <template v-slot:label>
                {{ $t('orgProfile.branch_name') }} <span class="text-danger">*</span>
              </template>
              <b-form-input
                id="branch_name"
                v-model="form.branch_name"
                :state="errors[0] ? false : (valid ? true : null)"
              ></b-form-input>
              <div class="invalid-feedback">
                {{ errors[0] }}
              </div>
            </b-form-group>
          </ValidationProvider>
        </b-col>
        <b-col xs="12" sm="12" md="6" lg="6" xl="6">
          <ValidationProvider name="Branch Name (Bn)" vid="branch_name_bn" rules="required" v-slot="{ errors }">
            <b-form-group
              label-for="branch_name_bn">
              <template v-slot:label>
                {{ $t('orgProfile.branch_name_bn') }} <span class="text-danger">*</span>
              </template>
              <b-form-input
                id="branch_name_bn"
                v-model="form.branch_name_bn"
                :state="errors[0] ? false : (valid ? true : null)"
              ></b-form-input>
              <div class="invalid-feedback">
                {{ errors[0] }}
              </div>
            </b-form-group>
          </ValidationProvider>
        </b-col>
        <b-col xs="12" sm="12" md="6" lg="6" xl="6">
          <ValidationProvider name="Address (En)" vid="address" rules="required" v-slot="{ errors }">
            <b-form-group
              label-for="address">
              <template v-slot:label>
                {{ $t('orgProfile.address') }} <span class="text-danger">*</span>
              </template>
              <b-form-textarea
                  id="address"
                  placeholder="Enter something..."
                  rows="3"
                  v-model="form.address"
                  :state="errors[0] ? false : (valid ? true : null)"
              ></b-form-textarea>
              <div class="invalid-feedback">
                {{ errors[0] }}
              </div>
            </b-form-group>
          </ValidationProvider>
        </b-col>
        <b-col xs="12" sm="12" md="6" lg="6" xl="6">
          <ValidationProvider name="Address (Bn)" vid="address_bn" rules="required" v-slot="{ errors }">
            <b-form-group
              label-for="address">
              <template v-slot:label>
                {{ $t('orgProfile.address_bn') }} <span class="text-danger">*</span>
              </template>
              <b-form-textarea
                  id="address_bn"
                  placeholder="Enter something..."
                  rows="3"
                  v-model="form.address_bn"
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
import RestApi, { commonServiceBaseUrl } from '@/config/api_config'
import { branchStore, branchUpdate } from '../../api/routes'
export default {
  name: 'Form',
  props: ['id'],
  data () {
    return {
      valid: null,
      saveBtnName: this.id ? this.$t('globalTrans.update') : this.$t('globalTrans.save'),
      errors: [],
      form: {
        org_id: 0,
        bank_id: 0,
        branch_name: '',
        branch_name_bn: '',
        address: '',
        address_bn: ''
      },
      bankList: []
    }
  },
  created () {
    if (this.id) {
      const tmp = this.getBranch()
      this.form = tmp
    }
  },
  computed: {
    loading: function () {
      return this.$store.state.commonObj.loading
    },
    orgProfileList () {
      return this.$store.state.CommonService.commonObj.orgProfileList.filter(item => item.status === 1)
    }
  },
  watch: {
    'form.org_id': function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.bankList = this.getBank()
      }
    }
  },
  methods: {
    getBank () {
      return this.$store.state.CommonService.commonObj.bankList.filter(item => item.status === 1 && item.org_id === this.form.org_id).map(itemObj => {
        if (this.$i18n.locale === 'bn') {
          return { value: itemObj.value, text: itemObj.text_bn }
        } else {
          return { value: itemObj.value, text: itemObj.text_en }
        }
      })
    },
    async saveUpdate () {
      this.$store.dispatch('mutateCommonProperties', { loading: true })
      let result = null
      const loadingState = { loading: false, listReload: false }

      if (this.id) {
        result = await RestApi.putData(commonServiceBaseUrl, `${branchUpdate}/${this.id}`, this.form)
      } else {
        result = await RestApi.postData(commonServiceBaseUrl, branchStore, this.form)
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
    getBranch () {
      const tmpData = this.$store.state.list.find(item => item.id === this.id)
      return JSON.parse(JSON.stringify(tmpData))
    }
  }
}
</script>
