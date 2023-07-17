<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit, reset }">
    <b-overlay :show="loading">
      <b-form @submit.prevent="handleSubmit(saveUpdate)" @reset.prevent="reset" autocomplete="off">
        <b-row>
          <b-col xs="12" sm="12" md="12" lg="12" xl="12">
            <ValidationProvider name="Division" vid="division_id" rules="required|min_value:1">
              <b-form-group
                label-for="division_id"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                {{$t('orgProfile.division_name')}} <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                v-model="pauroshoba.division_id"
                :options="divisionList"
                id="division_id"
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
          <b-col xs="12" sm="12" md="12" lg="12" xl="12">
            <ValidationProvider name="District" vid="district_id" rules="required|min_value:1">
              <b-form-group
                label-for="district_id"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                {{$t('orgProfile.district_name')}} <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                v-model="pauroshoba.district_id"
                :options="districtList"
                id="district_id"
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
          <b-col xs="12" sm="12" md="12" lg="12" xl="12">
            <ValidationProvider name="District" vid="upazila_id" rules="required|min_value:1">
              <b-form-group
                label-for="upazila_id"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                {{$t('orgProfile.upazila_name')}} <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                v-model="pauroshoba.upazila_id"
                :options="upazilaList"
                id="upazila_id"
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
          <b-col xs="12" sm="12" md="12" lg="12" xl="12">
            <ValidationProvider name="Pauroshoba Name Name (En)" vid="pauroshoba_name" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="pauroshoba_name">
                <template v-slot:label>
                  {{ $t('orgProfile.municipality_name_en') }} <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="pauroshoba_name"
                  v-model="pauroshoba.pauroshoba_name"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="12" lg="12" xl="12">
            <ValidationProvider name="Pauroshoba Name (Bn)" vid="pauroshoba_name_bn" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="pauroshoba_name_bn">
                <template v-slot:label>
                  {{ $t('orgProfile.municipality_name_bn') }} <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="pauroshoba_name_bn"
                  v-model="pauroshoba.pauroshoba_name_bn"
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
import RestApi, { commonServiceBaseUrl } from '@/config/api_config'
import { municipalityStore, municipalityUpdate } from '../../api/routes'
export default {
  name: 'Form',
  props: ['id'],
  data () {
    return {
      valid: null,
      saveBtnName: this.id ? this.$t('globalTrans.update') : this.$t('globalTrans.save'),
      errors: [],
      districtList: [],
      upazilaList: [],
      pauroshoba: {
        pauroshoba_name: '',
        pauroshoba_name_bn: '',
        district_id: 0,
        division_id: 0,
        upazila_id: 0
      }
    }
  },
  created () {
    if (this.id) {
      const tmp = this.getPauroshoba()
      this.pauroshoba = tmp
    }
  },
  computed: {
    divisionList () {
        return this.$store.state.CommonService.commonObj.divisionList.filter(item => item.status === 1)
    },
    loading: function () {
      return this.$store.state.commonObj.loading
    }
  },
  watch: {
    'pauroshoba.division_id': function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.districtList = this.getDistrictList(newVal)
      } else {
        this.districtList = []
      }
    },
    'pauroshoba.district_id': function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.upazilaList = this.getUpazilaList(newVal)
      } else {
        this.upazilaList = []
      }
    }
  },
  methods: {
    async saveUpdate () {
      this.$store.dispatch('mutateCommonProperties', { loading: true })
      let result = null
      const loadingState = { loading: false, listReload: false }

      if (this.id) {
        result = await RestApi.putData(commonServiceBaseUrl, `${municipalityUpdate}/${this.id}`, this.pauroshoba)
      } else {
        result = await RestApi.postData(commonServiceBaseUrl, municipalityStore, this.pauroshoba)
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
    getPauroshoba () {
      const tmpData = this.$store.state.list.find(item => item.id === this.id)
      return JSON.parse(JSON.stringify(tmpData))
    },
    getDistrictList (id) {
      return this.$store.state.CommonService.commonObj.districtList.filter(item => item.status === 1 && item.division_id === id)
    },
    getUpazilaList (id) {
      return this.$store.state.CommonService.commonObj.upazilaList.filter(item => item.status === 1 && item.district_id === id)
    }
  }
}
</script>
