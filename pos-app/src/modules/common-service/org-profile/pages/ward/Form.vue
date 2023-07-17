<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit, reset }">
    <b-overlay :show="loading">
      <b-form @submit.prevent="handleSubmit(saveUpdate)" @reset.prevent="reset" autocomplete="off">
        <b-row>
          <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Type" vid="type" rules="required|min_value:1">
              <b-form-group
                label-for="type"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                {{$t('orgProfile.type')}} <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                v-model="ward.type"
                :options="typeList"
                id="type"
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
          <b-col xs="12" sm="12" md="6" lg="6" xl="6" v-if="ward.type === 1">
            <ValidationProvider name="City Corporation" vid="city_corporation_id" rules="required|min_value:1">
              <b-form-group
                label-for="city_corporation_id"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                {{$t('orgProfile.city_corporation')}} <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                v-model="ward.city_corporation_id"
                :options="cityCorporationList"
                id="city_corporation_id"
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
          <b-col xs="12" sm="12" md="6" lg="6" xl="6" v-if="ward.type === 2 || ward.type === 3">
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
                v-model="ward.division_id"
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
          <b-col xs="12" sm="12" md="6" lg="6" xl="6" v-if="ward.type === 2 || ward.type === 3">
            <ValidationProvider name="District" vid="district_id" rules="required|min_value:1">
              <b-form-group
                label-for="division_id"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                {{$t('orgProfile.district_name')}} <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                v-model="ward.district_id"
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
          <b-col xs="12" sm="12" md="6" lg="6" xl="6" v-if="ward.type === 2 || ward.type === 3">
            <ValidationProvider name="Upazila" vid="upazila_id" rules="required|min_value:1">
              <b-form-group
                label-for="division_id"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                {{$t('orgProfile.upazila_name')}} <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                v-model="ward.upazila_id"
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
          <b-col xs="12" sm="12" md="6" lg="6" xl="6" v-if="ward.type === 2">
            <ValidationProvider name="Upazila" vid="municipality_id" rules="required|min_value:1">
              <b-form-group
                label-for="municipality_id"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                {{$t('orgProfile.municipality_name')}} <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                v-model="ward.municipality_id"
                :options="municipalityList"
                id="municipality_id"
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
          <b-col xs="12" sm="12" md="6" lg="6" xl="6" v-if="ward.type === 3">
            <ValidationProvider name="Union" vid="union_id" rules="required|min_value:1">
              <b-form-group
                label-for="union_id"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                {{$t('orgProfile.union_name')}} <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                v-model="ward.union_id"
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
          <b-row v-for="(detail, index) in ward.ward_details" :key="index" mt-2>
              <b-col xs="8" sm="8" md="5" lg="5" xl="5">
                  <ValidationProvider name="ward Name (En)" vid="ward_name" rules="required" v-slot="{ errors }">
                      <b-form-group
                      label-for="ward_name">
                      <template v-slot:label>
                          {{ $t('orgProfile.ward_name')}} {{ $t('globalTrans.en')}} <span class="text-danger">*</span>
                      </template>
                      <b-form-input
                          id="ward_name"
                          v-model="detail.ward_name"
                          :state="errors[0] ? false : (valid ? true : null)"
                      ></b-form-input>
                      <div class="invalid-feedback">
                          {{ errors[0] }}
                      </div>
                      </b-form-group>
                  </ValidationProvider>
              </b-col>
              <b-col xs="8" sm="8" md="5" lg="5" xl="5">
                  <ValidationProvider name="ward Name (Bn)" vid="ward_name_bn" rules="required" v-slot="{ errors }">
                      <b-form-group
                      label-for="ward_name_bn">
                      <template v-slot:label>
                          {{ $t('orgProfile.ward_name') }} {{ $t('globalTrans.bn')}}<span class="text-danger">*</span>
                      </template>
                      <b-form-input
                          id="ward_name_bn"
                          v-model="detail.ward_name_bn"
                          :state="errors[0] ? false : (valid ? true : null)"
                      ></b-form-input>
                      <div class="invalid-feedback">
                          {{ errors[0] }}
                      </div>
                      </b-form-group>
                  </ValidationProvider>
              </b-col>
              <b-col xl="2" lg="2" sm="4" class="mt-2">
                  <b-button v-show="index == ward.ward_details.length-1" variant="iq-bg-success" size="sm" @click="addWard()"><i class="ri-add-line m-0"></i>{{ $t('globalTrans.add_more')}}</b-button>
                  <b-button v-show="index || ( !index && ward.ward_details.length > 1)" variant=" iq-bg-danger" size="sm" @click="remove(index)"><i class="ri-delete-bin-line m-0"></i></b-button>
              </b-col>
          </b-row>
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
import { wardStore, wardUpdate } from '../../api/routes'
export default {
  name: 'Form',
  props: ['id'],
  data () {
    return {
      valid: null,
      saveBtnName: this.id ? this.$t('globalTrans.update') : this.$t('globalTrans.save'),
      errors: [],
      ward: {
        type: 0,
        city_corporation_id: 0,
        division_id: 0,
        district_id: 0,
        upazila_id: 0,
        union_id: 0,
        pauroshoba_id: 0,
        municipality_id: 0,
        ward_details: [
          {
            master_ward_id: 0,
            ward_name: '',
            ward_name_bn: ''
          }
        ]
      },
      districtList: [],
      upazilaList: [],
      unionList: []
    }
  },
  created () {
    if (this.id) {
      const tmp = this.getWard()
      this.ward = tmp
    }
  },
  computed: {
    divisionList () {
      return this.$store.state.CommonService.commonObj.divisionList.filter(item => item.status === 1)
    },
    typeList: function () {
        const objectData = this.$store.state.commonObj.typeList
        return objectData.map((obj, key) => {
            if (this.$i18n.locale === 'bn') {
                return { value: obj.id, text: obj.name_bn }
            } else {
                return { value: obj.id, text: obj.name }
            }
        })
    },
    cityCorporationList () {
      return this.$store.state.CommonService.commonObj.cityCorporationList.filter(item => item.status === 1)
    },
    municipalityList () {
      return this.$store.state.CommonService.commonObj.municipalityList.filter(item => item.status === 1)
    },
    loading: function () {
      return this.$store.state.commonObj.loading
    }
  },
  watch: {
    'ward.division_id': function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.districtList = this.getDistrictList(newVal)
      } else {
        this.districtList = []
      }
    },
    'ward.district_id': function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.upazilaList = this.getUpazilaList(newVal)
      } else {
        this.upazilaList = []
      }
    },
    'ward.upazila_id': function (newVal, oldVal) {
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
        result = await RestApi.putData(commonServiceBaseUrl, `${wardUpdate}/${this.id}`, this.ward)
      } else {
        result = await RestApi.postData(commonServiceBaseUrl, wardStore, this.ward)
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
    getWard () {
      const tmpData = this.$store.state.list.find(item => item.id === this.id)
      return JSON.parse(JSON.stringify(tmpData))
    },
    getDistrictList (id) {
      return this.$store.state.CommonService.commonObj.districtList.filter(item => item.status === 1 && item.division_id === id)
    },
    getUpazilaList (id) {
      return this.$store.state.CommonService.commonObj.upazilaList.filter(item => item.status === 1 && item.district_id === id)
    },
    getUnionList (upazilaId) {
       return this.$store.state.CommonService.commonObj.unionList.filter(item => item.status === 1 && item.upazila_id === upazilaId)
    },
    addWard () {
        const tmp = {
            master_ward_id: 0,
            ward_name: '',
            ward_name_bn: ''
        }
        this.ward.ward_details.push(tmp)
      },
      remove (key) {
        this.ward.ward_details.splice(key, 1)
      }
  }
}
</script>
