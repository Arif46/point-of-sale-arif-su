<template>
  <b-overlay :show="loading">
  <ValidationObserver ref="form" v-slot="{ handleSubmit, reset }">
    <b-form @submit.prevent="handleSubmit(saveUpdate)" @reset.prevent="reset" autocomplete="off">
      <b-row>
        <b-col sm="12">
          <ValidationProvider name="Upazila Name (En)" vid="upazila_name" rules="required" v-slot="{ errors }">
            <b-form-group
              label-for="upazila_name">
              <template v-slot:label>
                {{ $t('orgProfile.upazila_name_en') }} <span class="text-danger">*</span>
              </template>
              <b-form-input
                id="upazila_name"
                v-model="upazila.upazila_name"
                :state="errors[0] ? false : (valid ? true : null)"
              ></b-form-input>
              <div class="invalid-feedback">
                {{ errors[0] }}
              </div>
            </b-form-group>
          </ValidationProvider>
        </b-col>
        <b-col sm="12">
          <ValidationProvider name="Upazila Name (Bn)" vid="upazila_name_bn" rules="required" v-slot="{ errors }">
            <b-form-group
              label-for="upazila_name_bn">
              <template v-slot:label>
                {{ $t('orgProfile.upazila_name_bn') }} <span class="text-danger">*</span>
              </template>
              <b-form-input
                id="upazila_name_bn"
                v-model="upazila.upazila_name_bn"
                :state="errors[0] ? false : (valid ? true : null)"
              ></b-form-input>
              <div class="invalid-feedback">
                {{ errors[0] }}
              </div>
            </b-form-group>
          </ValidationProvider>
        </b-col>
        <b-col sm="12">
          <ValidationProvider name="District" vid="district_id" rules="required|min_value:1" v-slot="{ errors }">
            <b-form-group
              label-for="district_id">
              <template v-slot:label>
                {{ $t('orgProfile.district') }} <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                id="district_id"
                :options="districtList"
                v-model="upazila.district_id"
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
      <b-row class="text-right">
        <b-col>
            <b-button type="submit" variant="success" class="mr-2 btn-sm">{{ saveBtnName }}</b-button>
            <b-button variant="danger" class="btn-sm" @click="$bvModal.hide('modal-form')">{{ $t('globalTrans.cancel') }}</b-button>
        </b-col>
      </b-row>
    </b-form>
  </ValidationObserver>
  </b-overlay>
</template>
<script>
import RestApi, { commonServiceBaseUrl } from '@/config/api_config'
import { upazilaStore, upazilaUpdate } from '../../api/routes'
export default {
  name: 'Form',
  props: ['id'],
  data () {
    return {
      valid: null,
      saveBtnName: this.id ? this.$t('globalTrans.update') : this.$t('globalTrans.save'),
      errors: [],
      upazila: {
        upazila_name: '',
        upazila_name_bn: '',
        district_id: 0
      }
    }
  },
  computed: {
    loading () {
      return this.$store.state.commonObj.loading
    },
    districtList () {
      return this.$store.state.CommonService.commonObj.districtList
    }
  },
  created () {
    if (this.id) {
      const tmp = this.getUpazila()
      this.upazila = tmp
    }
  },
  methods: {
    async saveUpdate () {
      this.$store.dispatch('mutateCommonProperties', { loading: true })
      let result = null
      const loadingState = { loading: false, listReload: false }

      if (this.id) {
        result = await RestApi.putData(commonServiceBaseUrl, `${upazilaUpdate}/${this.id}`, this.upazila)
      } else {
        result = await RestApi.postData(commonServiceBaseUrl, upazilaStore, this.upazila)
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
    getUpazila () {
      const tmpData = this.$store.state.list.find(item => item.id === this.id)
      return JSON.parse(JSON.stringify(tmpData))
    }
  }
}
</script>
