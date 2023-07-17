<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit, reset }">
    <b-overlay :show="loading">
      <b-form @submit.prevent="handleSubmit(saveUpdate)" @reset.prevent="reset" autocomplete="off">
        <b-row>
          <b-col sm="12">
            <ValidationProvider name="Component" vid="component_id" rules="required|min_value:1">
              <b-form-group
                label-for="component_id"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                {{$t('menu.component')}} <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                v-model="form.component_id"
                :options="componentList"
                id="component_id"
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
          <b-col sm="12">
            <ValidationProvider name="Module" vid="module_id" rules="required|min_value:1">
              <b-form-group
                label-for="module_id"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                {{$t('menu.module')}} <span class="text-danger">*</span>
              </template>
              <b-form-select
                plain
                v-model="form.module_id"
                :options="moduleList"
                id="module_id"
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
          <b-col sm="12">
            <ValidationProvider name="Service" vid="service_id">
              <b-form-group
                label-for="service_id"
                slot-scope="{ valid, errors }"
              >
              <template v-slot:label>
                {{$t('menu.service')}}
              </template>
              <b-form-select
                plain
                v-model="form.service_id"
                :options="serviceList"
                id="service_id"
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
          <b-col sm="6">
            <ValidationProvider name="Menu Name (En)" vid="menu_name" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="menu_name">
                <template v-slot:label>
                  {{ $t('menu.menu_name') }} <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="menu_name"
                  v-model="form.menu_name"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col sm="6">
            <ValidationProvider name="Menu Name (Bn)" vid="menu_name_bn" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="menu_name_bn">
                <template v-slot:label>
                  {{ $t('menu.menu_name_bn') }} <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="menu_name_bn"
                  v-model="form.menu_name_bn"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col sm="12">
            <ValidationProvider name="Url" vid="url" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="sorting_order">
                <template v-slot:label>
                  {{ $t('menu.url') }} <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="url"
                  v-model="form.url"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col sm="12">
            <ValidationProvider name="Associated Url" vid="associated_urls">
              <b-form-group
                label-for="associated_urls">
                <template v-slot:label>
                  {{ $t('menu.associated_urls') }}
                </template>
                <b-form-input
                  id="associated_urls"
                  v-model="form.associated_urls"
                ></b-form-input>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col sm="12">
            <ValidationProvider name="Sorting Order" vid="sorting_order" rules="required|min_value:1" v-slot="{ errors }">
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
import { menuStore, menuUpdate } from '../../api/routes'
export default {
  name: 'Form',
  props: ['id'],
  data () {
    return {
      valid: null,
      saveBtnName: this.id ? this.$t('globalTrans.update') : this.$t('globalTrans.save'),
      errors: [],
      form: {
        component_id: 0,
        module_id: 0,
        service_id: 0,
        menu_name: '',
        menu_name_bn: '',
        url: '',
        associated_urls: '',
        sorting_order: 0
      },
      moduleList: [],
      serviceList: []
    }
  },
  created () {
    if (this.id) {
      const tmp = this.getComponent()
      this.form = tmp
    }
  },
  watch: {
    'form.component_id': function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.moduleList = this.getModuleList(newVal)
      }
    },
    'form.module_id': function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.serviceList = this.getServiceList()
      }
    }
  },
  computed: {
    loading: function () {
      return this.$store.state.commonObj.loading
    },
    componentList () {
      return this.$store.state.CommonService.commonObj.componentList.map(item => {
        if (this.$i18n.locale === 'bn') {
          return { value: item.value, text: item.text_bn }
        } else {
          return { value: item.value, text: item.text_en }
        }
      })
    }
  },
  methods: {
    getModuleList (componentId) {
      return this.$store.state.CommonService.commonObj.moduleList.filter(item => item.component_id === componentId).map(obj => {
        if (this.$i18n.locale === 'bn') {
          return { value: obj.value, text: obj.text_bn }
        } else {
          return { value: obj.value, text: obj.text_en }
        }
      })
    },
    getServiceList () {
      return this.$store.state.CommonService.commonObj.serviceList.filter(item => item.component_id === this.form.component_id && item.module_id === this.form.module_id).map(obj => {
        if (this.$i18n.locale === 'bn') {
          return { value: obj.value, text: obj.text_bn }
        } else {
          return { value: obj.value, text: obj.text_en }
        }
      })
    },
    async saveUpdate () {
      this.$store.dispatch('mutateCommonProperties', { loading: true })
      let result = null
      const loadingState = { loading: false, listReload: false }

      if (this.id) {
        result = await RestApi.putData(commonServiceBaseUrl, `${menuUpdate}/${this.id}`, this.form)
      } else {
        result = await RestApi.postData(commonServiceBaseUrl, menuStore, this.form)
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
    getComponent () {
      const tmpData = this.$store.state.list.find(item => item.id === this.id)
      return JSON.parse(JSON.stringify(tmpData))
    }
  }
}
</script>
