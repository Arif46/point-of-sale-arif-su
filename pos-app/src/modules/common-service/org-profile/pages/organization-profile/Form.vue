<template>
  <b-container fluid>
    <b-row>
      <b-col lg="12" sm="12">
        <b-overlay :show="load">
          <ValidationObserver ref="form"  v-slot="{ handleSubmit, reset }">
            <b-form  @submit.prevent="handleSubmit(register)" @reset.prevent="reset" enctype="multipart/form-data">
              <ValidationProvider name="Organization name" vid="org_name" rules="required">
                <b-form-group
                  class="row"
                  label-cols-sm="4"
                  label-for="org_name"
                  slot-scope="{ valid, errors }"
                >
                  <template v-slot:label>
                    {{ $t('orgProfile.org_name')}} {{ $t('globalTrans.en')}} <span class="text-danger">*</span>
                  </template>
                <b-form-input
                    id="org_name"
                    v-model="form.org_name"
                    :state="errors[0] ? false : (valid ? true : null)"
                    ></b-form-input>
                  <div class="invalid-feedback">
                    {{ errors[0] }}
                  </div>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider name="Organization name (bn)" rules="required">
                <b-form-group
                  class="row"
                  label-cols-sm="4"
                  label-for="org_name_bn"
                  slot-scope="{ valid, errors }"
                >
                <template v-slot:label>
                    {{ $t('orgProfile.org_name')}} {{ $t('globalTrans.bn')}} <span class="text-danger">*</span>
                  </template>
                <b-form-input
                    id="org_name_bn"
                    v-model="form.org_name_bn"
                    :state="errors[0] ? false : (valid ? true : null)"
                    ></b-form-input>
                  <div class="invalid-feedback">
                    {{ errors[0] }}
                  </div>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider name="Abbreviation Name">
                <b-form-group
                  class="row"
                  label-cols-sm="4"
                  label-for="abbreviation"
                  slot-scope="{ valid, errors }"
                >
                <template v-slot:label>
                    {{ $t('orgProfile.abbreviation_name')}} {{ $t('globalTrans.en')}}
                  </template>
                <b-form-input
                    id="abbreviation"
                    v-model="form.abbreviation"
                    :state="errors[0] ? false : (valid ? true : null)"
                    ></b-form-input>
                  <div class="invalid-feedback">
                    {{ errors[0] }}
                  </div>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider name="Abbreviation Name (bn)">
                <b-form-group
                  class="row"
                  label-cols-sm="4"
                  label-for="abbreviation_bn"
                  slot-scope="{ valid, errors }"
                >
                <template v-slot:label>
                    {{ $t('orgProfile.abbreviation_name')}}  {{ $t('globalTrans.bn')}}
                  </template>
                <b-form-input
                    id="abbreviation_bn"
                    v-model="form.abbreviation_bn"
                    :state="errors[0] ? false : (valid ? true : null)"
                    ></b-form-input>
                  <div class="invalid-feedback">
                    {{ errors[0] }}
                  </div>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider name="Establishment year" rules="required">
                <b-form-group
                  class="row"
                  label-cols-sm="4"
                  slot-scope="{ valid, errors }"
                >
                <template v-slot:label>
                    {{ $t('orgProfile.establishment_year')}} <span class="text-danger">*</span>
                  </template>
                <b-form-input
                    id="establishment_year"
                    v-model="form.establishment_year"
                    :state="errors[0] ? false : (valid ? true : null)"
                    ></b-form-input>
                  <div class="invalid-feedback">
                    {{ errors[0] }}
                  </div>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider name="About Organizaion" rules="">
                <b-form-group
                  class="row"
                  label-cols-sm="4"
                  label-for="about_org"
                  slot-scope="{ valid, errors }"
                >
                <template v-slot:label>
                    {{ $t('orgProfile.about_org')}} {{ $t('globalTrans.en')}} <span class="text-danger">*</span>
                  </template>
                <b-form-textarea
                  id="about_org"
                  v-model="form.about_org"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-textarea>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider name="About Organizaion (bn)" rules="">
                <b-form-group
                  class="row"
                  label-cols-sm="4"
                  label-for="about_org_bn"
                  slot-scope="{ valid, errors }"
                >
                <template v-slot:label>
                  {{ $t('orgProfile.about_org') + $t('globalTrans.bn')}} <span class="text-danger">*</span>
                </template>
                <b-form-textarea
                  id="about_org_bn"
                  v-model="form.about_org_bn"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-textarea>
                  <div class="invalid-feedback">
                    {{ errors[0] }}
                  </div>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider name="Mission" rules="">
                <b-form-group
                  class="row"
                  label-cols-sm="4"
                  :label="$t('orgProfile.mission')"
                  label-for="mission"
                  slot-scope="{ valid, errors }"
                >
                <b-form-textarea
                  id="mission"
                  v-model="form.mission"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-textarea>
                  <div class="invalid-feedback">
                    {{ errors[0] }}
                  </div>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider name="Mission (bn)" rules="">
                <b-form-group
                  class="row"
                  label-cols-sm="4"
                  :label="$t('orgProfile.mission') + $t('globalTrans.bn')"
                  label-for="mission_bn"
                  slot-scope="{ valid, errors }"
                >
                 <b-form-textarea
                  id="mission_bn"
                  v-model="form.mission_bn"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-textarea>
                  <div class="invalid-feedback">
                    {{ errors[0] }}
                  </div>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider name="Vision" rules="">
                <b-form-group
                  class="row"
                  label-cols-sm="4"
                  :label="$t('orgProfile.vision')"
                  label-for="vision"
                  slot-scope="{ valid, errors }"
                >
                <b-form-textarea
                  id="vision"
                  v-model="form.vision"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-textarea>
                  <div class="invalid-feedback">
                    {{ errors[0] }}
                  </div>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider name="Vision (bn)" rules="">
                <b-form-group
                  class="row"
                  label-cols-sm="4"
                  :label="$t('orgProfile.vision') + $t('globalTrans.bn')"
                  label-for="vision_bn"
                  slot-scope="{ valid, errors }"
                >
                <b-form-textarea
                  id="vision"
                  v-model="form.vision_bn"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-textarea>
                  <div class="invalid-feedback">
                    {{ errors[0] }}
                  </div>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider name="Logo">
                <b-form-group
                  class="row"
                  label-cols-sm="4"
                  label-for="photo"
                  slot-scope="{ valid, errors }"
                >
                <template v-slot:label>
                  {{ $t('orgProfile.logo')}}
                  </template>
                  <b-form-file
                    id="upload_logo"
                    v-on:change="handlePhoto"
                    accept="image/*"
                    :state="errors[0] ? false : (valid ? true : null)"
                    ></b-form-file>
                  <div class="invalid-feedback">
                    {{ errors[0] }}
                  </div>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider name="Hierarchy" vid="hierarchy" rules="required">
                <b-form-group
                  class="row"
                  label-cols-sm="4"
                  slot-scope="{ valid, errors }"
                >
                <template v-slot:label>
                  {{ $t('orgProfile.hierarchy')}} <span class="text-danger">*</span>
                </template>
                <b-form-input
                    id="hierarchy"
                    v-model="form.hierarchy"
                    :state="errors[0] ? false : (valid ? true : null)"
                    ></b-form-input>
                  <div class="invalid-feedback">
                    {{ errors[0] }}
                  </div>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider name="Address" vid="address" rules="required">
                <b-form-group
                  class="row"
                  label-cols-sm="4"
                  slot-scope="{ valid, errors }"
                >
                <template v-slot:label>
                  {{ $t('orgProfile.address')}} <span class="text-danger">*</span>
                </template>
                <b-form-textarea
                    id="address"
                    v-model="form.address"
                    :state="errors[0] ? false : (valid ? true : null)"
                    ></b-form-textarea>
                  <div class="invalid-feedback">
                    {{ errors[0] }}
                  </div>
                </b-form-group>
              </ValidationProvider>
                <ValidationProvider name="Address" vid="address_bn" rules="required">
                <b-form-group
                  class="row"
                  label-cols-sm="4"
                  label-for="address_bn"
                  slot-scope="{ valid, errors }"
                >
                 <template v-slot:label>
                  {{ $t('orgProfile.address') + $t('globalTrans.bn') }} <span class="text-danger">*</span>
                </template>
                <b-form-textarea
                    id="address_bn"
                    v-model="form.address_bn"
                    :state="errors[0] ? false : (valid ? true : null)"
                    ></b-form-textarea>
                  <div class="invalid-feedback">
                    {{ errors[0] }}
                  </div>
                </b-form-group>
              </ValidationProvider>
              <div class="row">
                <div class="col-sm-3"></div>
                <div class="col text-right">
                  <b-button type="submit" variant="primary" class="mr-2">{{ saveBtnName }}</b-button>
                  &nbsp;
                  <b-button variant="danger" class="mr-1" @click="$bvModal.hide('modal-form')">{{ $t('globalTrans.cancel') }}</b-button>
                </div>
              </div>
            </b-form>
          </ValidationObserver>
        </b-overlay>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import RestApi, { commonServiceBaseUrl } from '@/config/api_config'
import { orgProfileStore, orgProfileUpdate } from '../../api/routes'

export default {
  props: ['id'],
  created () {
    if (this.id) {
      const tmp = this.getOrgrofileData()
      // Object.freeze(tmp)
      this.form = tmp
    }
  },
  mounted () {
  },
  data () {
    return {
      saveBtnName: this.id ? this.$t('globalTrans.update') : this.$t('globalTrans.save'),
      form: {
        id: null,
        org_name: '',
        org_name_bn: '',
        abbreviation: '',
        abbreviation_bn: '',
        establishment_year: '',
        about_org: '',
        about_org_bn: '',
        mission: '',
        mission_bn: '',
        vision: '',
        vision_bn: '',
        logo: '',
        hierarchy: '',
        address: '',
        address_bn: ''
      },
      upload_logo: '',
      load: false
    }
  },
  computed: {},
  methods: {
     handlePhoto (e) {
      const selectedPhoto = e.target.files[0]
      const reader = new FileReader()
      reader.onload = (event) => {
        this.form.logo = event.target.result
      }
      reader.readAsDataURL(selectedPhoto)
    },
    getOrgrofileData () {
      const tmpData = this.$store.state.list.find(item => item.id === this.id)
      return JSON.parse(JSON.stringify(tmpData))
    },
    onFileChange (e) {
      this.upload_logo = e.target.files[0]
    },
    async register () {
      this.$store.dispatch('mutateCommonProperties', { loading: true })
      let result = null
      const loadinState = { loading: false, listReload: true }
      this.load = true
      if (this.form.id) {
        // formData.append('_method', 'PUT')
        result = await RestApi.putData(commonServiceBaseUrl, `${orgProfileUpdate}/${this.id}`, this.form)
      } else {
        result = await RestApi.postData(commonServiceBaseUrl, orgProfileStore, this.form)
      }
      this.load = false
      this.$store.dispatch('mutateCommonProperties', loadinState)
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
    }
  }
}
</script>
