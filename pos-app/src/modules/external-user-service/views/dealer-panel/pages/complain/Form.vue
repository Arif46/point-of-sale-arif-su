<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit, reset }">
    <b-overlay :show="loading">
    <b-form @submit.prevent="handleSubmit(saveUpdate)" @reset.prevent="reset" autocomplete="off">
      <b-row>
        <b-col lg="6" sm="12">
          <ValidationProvider name="Office" vid="office_id" rules="required|min_value:1">
            <b-form-group
              label-for="office_id"
              slot-scope="{ valid, errors }"
            >
            <template v-slot:label>
              {{$t('dealer.regional_office')}} <span class="text-danger">*</span>
            </template>
            <b-form-select
              plain
              v-model="form.office_id"
              :options="getRegionalOfficeList"
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
        <b-col lg="6" sm="12">
          <ValidationProvider name="Subject" vid="subject" rules="required">
            <b-form-group
              label-for="subject"
              slot-scope="{ valid, errors }"
            >
            <template v-slot:label>
              {{ $t('dealer.com_subject') }} <span class="text-danger">*</span>
            </template>
            <b-form-input
                id="subject"
                v-model="form.subject"
                :state="errors[0] ? false : (valid ? true : null)"
              ></b-form-input>
            <div class="invalid-feedback">
              {{ errors[0] }}
            </div>
            </b-form-group>
          </ValidationProvider>
        </b-col>
        <b-col sm="12">
          <ValidationProvider name="Complain Details" vid="details" rules="required|min:10" v-slot="{ errors }">
            <b-form-group
              label-for="details">
              <template v-slot:label>
                {{ $t('dealer.details') }} <span class="text-danger">*</span>
              </template>
              <b-form-textarea
                    id="details"
                    rows="3"
                    v-model="form.details"
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
import RestApi, { licenseRegistrationServiceBaseUrl } from '@/config/api_config'
import { complainStore, complainUpdate } from '../../api/routes'
export default {
  name: 'Form',
  props: ['id'],
  data () {
    return {
      valid: null,
      saveBtnName: this.id ? this.$t('globalTrans.update') : this.$t('globalTrans.save'),
      errors: [],
      form: {
        subject: '',
        details: '',
        office_id: 0
      }
    }
  },
  created () {
    if (this.id) {
      const tmp = this.getDocument()
      this.form = tmp
      this.form.oldfile = tmp.attachment
    }
  },
  computed: {
    loading: function () {
      return this.$store.state.commonObj.loading
    },
    getRegionalOfficeList (orgId = null) {
      const officeList = this.$store.state.CommonService.commonObj.officeList.map(item => {
        if (this.$i18n.locale === 'bn') {
          return { value: item.value, text: item.text_bn }
        } else {
          return { value: item.value, text: item.text_en }
        }
        })
      return officeList
    }
  },
  methods: {
    async saveUpdate () {
      this.$store.dispatch('mutateCommonProperties', { loading: true })
      let result = null
      const loadingState = { loading: false, listReload: false }
      if (this.id) {
        result = await RestApi.putData(licenseRegistrationServiceBaseUrl, `${complainUpdate}/${this.id}`, this.form)
      } else {
        result = await RestApi.postData(licenseRegistrationServiceBaseUrl, complainStore, this.form)
      }

      loadingState.listReload = true
      this.$store.dispatch('mutateCommonProperties', loadingState)

      if (result.success) {
        this.$store.dispatch('LicenseRegistrationService/mutateCommonObj', { hasDropdownLoaded: false })
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
    getItemEntry () {
      const tmpData = this.$store.state.list.find(item => item.id === this.id)
      return JSON.parse(JSON.stringify(tmpData))
    }
  }
}
</script>
