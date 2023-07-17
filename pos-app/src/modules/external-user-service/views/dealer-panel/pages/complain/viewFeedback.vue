<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit, reset }">
    <b-overlay :show="loading">
      <b-form @submit.prevent="handleSubmit(saveUpdate)" @reset.prevent="reset" autocomplete="off"  enctype="multipart/form-data">
        <b-row>
          <b-col xs="12" sm="12" md="6">
            <ValidationProvider name="Feedback (En)" vid="feedback" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="heading">
                <template v-slot:label>
                  {{ $t('manage_information.feedback_en') }} <span class="text-danger">*</span>
                </template>
                <b-form-textarea
                  id="feedback"
                  disabled
                  v-model="form.feedback"
                  :state="errors[0] ? false : (valid ? true : null)"
                  rows="6"
                ></b-form-textarea>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="6">
            <ValidationProvider name="Feedback" vid="feedback_bn" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="heading">
                <template v-slot:label>
                  {{ $t('manage_information.feedback_bn') }} <span class="text-danger">*</span>
                </template>
                <b-form-textarea
                  id="feedback_bn"
                  v-model="form.feedback_bn"
                  disabled
                  :state="errors[0] ? false : (valid ? true : null)"
                  rows="6"
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
              <b-button variant="danger" class="btn-sm" @click="$bvModal.hide('modal-form-feedback')">{{ $t('globalTrans.close') }}</b-button>
          </b-col>
        </b-row>
      </b-form>
    </b-overlay>
  </ValidationObserver>
</template>
<script>
import RestApi, { licenseRegistrationServiceBaseUrl } from '@/config/api_config'
import { fdComplainStore, fdComplainUpdate } from '../../api/routes'
export default {
  name: 'ViewFeedback',
  props: ['id'],
  data () {
    return {
      valid: null,
      saveBtnName: this.$t('globalTrans.save'),
      errors: [],
      form: {
        org_id: 0,
        feedback: '',
        feedback_bn: ''
      }
    }
  },
  created () {
    if (this.id) {
      const tmp = this.getItemEntry()
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
  methods: {
    async saveUpdate () {
      this.$store.dispatch('mutateCommonProperties', { loading: true })
      let result = null
      const loadingState = { loading: false, listReload: false }
      if (this.id) {
        result = await RestApi.putData(licenseRegistrationServiceBaseUrl, `${fdComplainUpdate}/${this.id}`, this.form)
      } else {
        result = await RestApi.postData(licenseRegistrationServiceBaseUrl, fdComplainStore, this.form)
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

        this.$bvModal.hide('modal-form-feedback')
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
