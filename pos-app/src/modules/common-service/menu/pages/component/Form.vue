<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit, reset }">
    <b-overlay :show="loading">
      <b-form @submit.prevent="handleSubmit(saveUpdate)" @reset.prevent="reset" autocomplete="off">
        <b-row>
          <b-col sm="6">
            <ValidationProvider name="Component Name (En)" vid="component_name" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="component_name">
                <template v-slot:label>
                  {{ $t('menu.component_name_en') }} <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="component_name"
                  v-model="form.component_name"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col sm="6">
            <ValidationProvider name="Component Name (Bn)" vid="component_name_bn" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="component_name_bn">
                <template v-slot:label>
                  {{ $t('menu.component_name_bn') }} <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="component_name_bn"
                  v-model="form.component_name_bn"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col sm="12">
            <ValidationProvider name="Description (En)" vid="description_en" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="description">
                <template v-slot:label>
                  {{ $t('globalTrans.description_en') }} <span class="text-danger">*</span>
                </template>
                <b-form-textarea
                  id="description"
                  v-model="form.description"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-textarea>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col sm="12">
            <ValidationProvider name="Description (Bn)" vid="description_bn" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="description_bn">
                <template v-slot:label>
                  {{ $t('globalTrans.description_bn') }} <span class="text-danger">*</span>
                </template>
                <b-form-textarea
                  id="description_bn"
                  v-model="form.description_bn"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-textarea>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col sm="12">
            <ValidationProvider name="Sorting Order" vid="sorting_order" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="sorting_order">
                <template v-slot:label>
                  {{ $t('menu.sorting_order') }} <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="sorting_order"
                  v-model="form.sorting_order"
                  :state="errors[0] ? false : (valid ? true : null)"
                  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <ValidationProvider name="Organization list" vid="org_id" rules="required">
            <b-form-group
              class="row"
              label-for="organization_list"
              slot-scope="{ valid, errors }"
            >
              <template v-slot:label>
                {{ $t('globalTrans.organization') }} <span class="text-danger">*</span>
              </template>
              <b-form-checkbox-group
                  v-model="form.org_id"
                  :options="organizationList"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-checkbox-group>
              <div class="invalid-feedback">
                {{ errors[0] }}
              </div>
            </b-form-group>
          </ValidationProvider>
          <!-- <b-row>
            <b-col lg="12" sm="12">
              <ValidationProvider name="Attachment" vid="attachment">
                <b-form-group
                  class="row"
                  label-cols-sm="3"
                  label-for="attachment"
                  slot-scope="{ valid, errors }"
                >
                <template v-slot:label>
                    {{$t('globalTrans.attachment')}}
                </template>
                <b-form-file
                  id="attachment"
                  v-on:change="onFileChange"
                  v-model="form.attachment"
                  :state="errors[0] ? false : (valid ? true : null)"
                  >
                </b-form-file>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
                </b-form-group>
              </ValidationProvider>
            </b-col>
          </b-row> -->
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
import { componentStore, componentUpdate } from '../../api/routes'
export default {
  name: 'Form',
  props: ['id'],
  data () {
    return {
      valid: null,
      saveBtnName: this.id ? this.$t('globalTrans.update') : this.$t('globalTrans.save'),
      errors: [],
      form: {
        component_name: '',
        component_name_bn: '',
        description: '',
        description_bn: '',
        sorting_order: '',
        org_id: [],
        attachment: []
      },
      componentList: this.$store.state.CommonService.commonObj.componentList,
      attachmentDemo: []
    }
  },
  created () {
    this.getOrganizationlist()
    if (this.id) {
      const tmp = this.getComponent()
      this.form = tmp
    }
  },
  computed: {
    loading: function () {
      return this.$store.state.commonObj.loading
    }
  },
  methods: {
    getOrganizationlist () {
      const tmp = this.$store.state.CommonService.commonObj.orgProfileList.map(item => {
        if (this.$i18n.locale === 'en') {
          return { text: item.abbreviation, value: item.value, status: item.status }
        } else {
          return { text: item.abbreviation_bn, value: item.value, status: item.status }
        }
      })
      this.organizationList = tmp.filter(item => item.status === 1)
    },
    onFileChange (e) {
      this.attachmentDemo = e.target.files[0]
    },
    async saveUpdate () {
      this.$store.dispatch('CommonService/mutateCommonObj', { loading: true })
      let result = null
      const loadingState = { loading: false, listReload: false }
      const config = {
        headers: { 'content-type': 'multipart/form-data' }
      }
      var formData = new FormData()
      Object.keys(this.form).map(key => {
        if (key === 'attachment') {
          formData.append(key, this.attachmentDemo)
        } else {
          formData.append(key, this.form[key])
        }
      })
      if (this.id) {
        result = await RestApi.putData(commonServiceBaseUrl, `${componentUpdate}/${this.id}`, this.form)
      } else {
        result = await RestApi.postData(commonServiceBaseUrl, componentStore, formData, config)
      }

      loadingState.listReload = true
      this.$store.dispatch('mutateCommonProperties', loadingState)

      if (result.success) {
        this.$store.dispatch('mutateCommonProperties', { loading: true })
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
    getComponent () {
      const tmpData = this.$store.state.list.find(item => item.id === this.id)
      return JSON.parse(JSON.stringify(tmpData))
    }
  }
}
</script>
