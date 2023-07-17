<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit, reset }">
    <b-overlay :show="loading">
      <b-form @submit.prevent="handleSubmit(saveUpdate)" @reset.prevent="reset" autocomplete="off">
        <b-row>
          <b-col xs="12" sm="12" md="12" lg="12" xl="12">
            <ValidationProvider name="Division Name" vid="division_id" rules="required|min_value:1">
              <b-form-group
                label-for="division_id"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                Division Name <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                v-model="formData.division_id"
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
                District Name <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                v-model="formData.district_id"
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
            <ValidationProvider name="Upzilla Name" vid="upazila_id" rules="required|min_value:1">
              <b-form-group
                label-for="upazila_id"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                Upazila Name <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                v-model="formData.upazila_id"
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
            <ValidationProvider name="Union Name" vid="union_id" rules="required|min_value:1">
              <b-form-group
                label-for="union_id"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                Union Name <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                v-model="formData.union_id"
                :options="unionList"
                id="union_id"
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
            <ValidationProvider name="Ward Name" vid="name" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="name">
                <template v-slot:label>
                  Ward Name <span class="text-danger">*</span>
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
import { wardStore, wardUpdate } from '../../api/routes'
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
        division_id: 0,
        district_id: 0,
        upazila_id: 0,
        union_id: 0
      },
      districtList: [],
      upazilaList: [],
      unionList: []
    }
  },
  created () {
    if (this.id) {
      const tmp = this.getUpdateId()
      this.formData = tmp
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
      'formData.division_id': function (newVal, oldVal) {
        if (newVal !== oldVal) {
          this.districtList = this.getDistrictList(newVal)
        } else {
          this.districtList = []
        }
      },
      'formData.district_id': function (newVal, oldVal) {
        if (newVal !== oldVal) {
          this.upazilaList = this.getUpazilaList(newVal)
        } else {
          this.upazilaList = []
        }
      },
      'formData.upazila_id': function (newVal, oldVal) {
        if (newVal !== oldVal) {
          this.unionList = this.getUnionList(newVal)
        } else {
          this.unionList = []
        }
      }
  },
  methods: {
    async saveUpdate () {
      this.$store.dispatch('mutateCommonProperties', { loading: true })
      let result = null
      const loadingState = { loading: false, listReload: false }

      if (this.id) {
        result = await RestApi.putData(apiBaseUrl, `${wardUpdate}/${this.id}`, this.formData)
      } else {
        result = await RestApi.postData(apiBaseUrl, wardStore, this.formData)
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
    getUnionList (unionId) {
      return this.$store.state.CommonService.commonObj.unionList.filter(item => item.status === 1 && item.upazila_id === unionId)
    },
    getUpdateId () {
      const tmpData = this.$store.state.list.find(item => item.id === this.id)
      return JSON.parse(JSON.stringify(tmpData))
    }
  }
}
</script>
