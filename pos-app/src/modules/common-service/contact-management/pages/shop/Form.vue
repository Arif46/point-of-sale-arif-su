<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit, reset }">
    <b-overlay :show="loading">
      <b-form @submit.prevent="handleSubmit(saveUpdate)" @reset.prevent="reset" autocomplete="off">
        <b-row>
          <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Area Type" vid="area_type_id" rules="required|min_value:1">
              <b-form-group
                label-for="area_type_id"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                Area Type <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                v-model="formData.area_type_id"
                :options="areaTypeList"
                id="area_type_id"
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
          <b-col xs="12" sm="12" md="6" lg="6" xl="6">
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
          <b-col xs="12" sm="12" md="6" lg="6" xl="6" v-if="formData.area_type_id === 1">
            <ValidationProvider name="CityCorporation" vid="city_corporation_id " rules="required|min_value:1">
              <b-form-group
                label-for="city_corporation_id "
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                City Corporation Name <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                v-model="formData.city_corporation_id "
                :options="cityCorporationList"
                id="city_corporation_id "
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
          <b-col xs="12" sm="12" md="6" lg="6" xl="6"  v-if="formData.area_type_id === 2 || formData.area_type_id === 3">
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
          <b-col xs="12" sm="12" md="6" lg="6" xl="6" v-if="formData.area_type_id === 2">
            <ValidationProvider name="Paurashava Name" vid="paurashava_id " rules="required|min_value:1">
              <b-form-group
                label-for="paurashava_id "
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                Paurashava Name <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                v-model="formData.paurashava_id "
                :options="pauroshavaList"
                id="paurashava_id "
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
          <b-col xs="12" sm="12" md="6" lg="6" xl="6" v-if="formData.area_type_id === 3">
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
          <b-col xs="12" sm="12" md="6" lg="6" xl="6" v-if="formData.area_type_id === 3">
            <ValidationProvider name="Ward Name" vid="ward_id" rules="required|min_value:1">
              <b-form-group
                label-for="ward_id"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                Ward Name <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                v-model="formData.ward_id"
                :options="wardList"
                id="ward_id"
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
            <ValidationProvider name="Name" vid="name" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="name">
                <template v-slot:label>
                Name <span class="text-danger">*</span>
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
          <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Mobile" vid="mobile" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="mobile">
                <template v-slot:label>
                Mobile Number<span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="name"
                  v-model="formData.mobile"
                  :state="errors[0] ? false : (valid ? true : null)"
                  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Owner Name" vid="owner_name " rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="owner_name ">
                <template v-slot:label>
                 Owner Name <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="owner_name "
                  v-model="formData.owner_name "
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="owner_mobile " vid="owner_mobile" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="owner_mobile">
                <template v-slot:label>
                Owner Mobile<span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="owner_mobile"
                  v-model="formData.owner_mobile"
                  :state="errors[0] ? false : (valid ? true : null)"
                  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Logo" vid="logo" v-slot="{ errors }">
              <b-form-group
                class="row"
                label-cols-sm="12"
                label-for="logo"
              >
              <template v-slot:label>
                Logo <span style="font-size:10px" class="text-danger">Maximum Size (2MB) & Accepted Format (jpg, png, jpeg)</span>
              </template>
              <b-input-group>
                <b-form-file
                  validate="size:10"
                  id="logo"
                  v-model="formData.logo"
                  @change="onChange"
                  :state="errors[0] ? false : (valid ? true : null)"
                  placeholder="Choose a file or drop it here"
                  drop-placeholder="Drop file here..."
                ></b-form-file>
                <!-- <b-input-group-append v-if="formData.Logo">
                  <a target="_blank" :href="rjscServiceBaseUrl + 'storage/' + form.thumbnail" style="padding: 2px 10px;" class="btn btn-primary btn-sm" ><i class="ri-download-2-line"></i></a>
                </b-input-group-append> -->
              </b-input-group>
              <div class="d-block invalid-feedback">
                <!-- {{ errors[0] }} -->
                {{ fileValidationMsz }}
              </div>
              </b-form-group>
          </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Address Details" vid="address_details">
              <b-form-group
                class="row"
                label-cols-sm="12"
                label-for="address_details"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                Address Details
              </template>
                <b-form-textarea
                  id="address_details"
                  v-model="formData.address_details"
                  :state="errors[0] ? false : (valid ? true : null)"
                >
                </b-form-textarea>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Note" vid="note">
              <b-form-group
                class="row"
                label-cols-sm="12"
                label-for="note"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                Note
              </template>
                <b-form-textarea
                  id="note"
                  v-model="formData.note"
                  :state="errors[0] ? false : (valid ? true : null)"
                >
                </b-form-textarea>
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
import { shopEntryStore, shopEntryUpdate } from '../../api/routes'
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
        mobile: '',
        owner_name: '',
        owner_mobile: '',
        area_type_id: 0,
        division_id: 0,
        district_id: 0,
        city_corporation_id: 0,
        upazila_id: 0,
        paurashava_id: 0,
        ward_id: 0,
        union_id: 0,
        address_details: '',
        logo: ''
      },
      fileValidationMsz: '',
      districtList: [],
      upazilaList: [],
      unionList: [],
      cityCorporationList: [],
      pauroshavaList: [],
      wardList: [],
      apiBaseUrl: apiBaseUrl
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
    areaTypeList () {
      return this.$store.state.CommonService.commonObj.areaTypeList
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
          this.cityCorporationList = this.getCityCorporationList(newVal)
        } else {
          this.upazilaList = []
          this.cityCorporationList = []
        }
      },
      'formData.upazila_id': function (newVal, oldVal) {
        if (newVal !== oldVal) {
          this.unionList = this.getUnionList(newVal)
          this.pauroshavaList = this.getPaurashavaList(newVal)
        } else {
          this.unionList = []
          this.pauroshavaList = []
        }
      },
      'formData.union_id': function (newVal, oldVal) {
        if (newVal !== oldVal) {
          this.wardList = this.getWardList(newVal)
        } else {
          this.wardList = []
        }
      }
  },
  methods: {
    onChange (e) {
      this.fileValidationMsz = ''
      const input = event.target
      const file = input.files[0]
      if (file.size > 1024 * 2048) {
        e.preventDefault()
        this.fileValidationMsz = 'Maximum file size must be 2MB'
      }
      if (input.files && input.files[0]) {
        const reader = new FileReader()
        reader.onload = (e) => {
          this.formData.logo = e.target.result
        }
        reader.readAsDataURL(input.files[0])
      } else {
        this.formData.logo = ''
      }
    },
    async saveUpdate () {
      this.$store.dispatch('mutateCommonProperties', { loading: true })
      let result = null
      const loadingState = { loading: false, listReload: false }
      if (this.id) {
        result = await RestApi.putData(apiBaseUrl, `${shopEntryUpdate}/${this.id}`, this.formData)
      } else {
        result = await RestApi.postData(apiBaseUrl, shopEntryStore, this.formData)
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
          this.$toast.error({
            title: 'Error',
            message: result.errors.logo[0],
            color: '#FF0000'
          })
        this.$refs.form.setErrors(result.errors)
      }
    },
    getDistrictList (divisionId) {
      return this.$store.state.CommonService.commonObj.districtList.filter(item => item.status === 1 && item.division_id === divisionId)
    },
    getUpazilaList (districtId) {
      return this.$store.state.CommonService.commonObj.upazilaList.filter(item => item.status === 1 && item.district_id === districtId)
    },
    getUnionList (unionId) {
      return this.$store.state.CommonService.commonObj.unionList.filter(item => item.status === 1 && item.upazila_id === unionId)
    },
    getCityCorporationList (districtId) {
      return this.$store.state.CommonService.commonObj.cityCorporationList.filter(item => item.status === 1 && item.district_id === districtId)
    },
    getPaurashavaList (upazilaId) {
      return this.$store.state.CommonService.commonObj.paurashavaList.filter(item => item.status === 1 && item.upazila_id === upazilaId)
    },
    getWardList (unionId) {
      return this.$store.state.CommonService.commonObj.wardList.filter(item => item.status === 1 && item.union_id === unionId)
    },
    getUpdateId () {
      const tmpData = this.$store.state.list.find(item => item.id === this.id)
      return JSON.parse(JSON.stringify(tmpData))
    }
  }
}
</script>
