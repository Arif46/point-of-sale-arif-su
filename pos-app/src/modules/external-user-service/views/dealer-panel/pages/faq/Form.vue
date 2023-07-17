<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit, reset }">
    <b-overlay :show="loading">
      <b-form @submit.prevent="handleSubmit(saveUpdate)" @reset.prevent="reset" autocomplete="off">
        <b-row>
          <b-col md="12 text-center">
            <span class="badge badge-primary card-title"><h5>{{ $t('bfti.research_and_other_request') }}</h5></span>
          </b-col>
          <b-col xs="12" sm="12" md="6">
            <ValidationProvider name="Document" vid="doc_type" rules="required|min_value:1">
              <b-form-group
                label-for="doc_type"
                slot-scope="{ valid, errors }"
              >
                <template v-slot:label>
                  {{$t('bfti.doc_type')}} <span class="text-danger">*</span>
                </template>
                <b-form-select
                  plain
                  v-model="form.doc_type_id"
                  :options="docTypeList"
                  id="doc_type"
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
          <b-col xs="12" sm="12" md="6">
            <ValidationProvider name="Topic" vid="topic" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="topic">
                <template v-slot:label>
                  {{ $t('bfti.topic') }} <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="topic"
                  v-model="form.topic"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="12">
            <ValidationProvider name="Description" vid="description" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="heading_bn">
                <template v-slot:label>
                  {{ $t('bfti.description') }}<span class="text-danger">*</span>
                </template>
                <b-form-textarea
                  id="heading_bn"
                  v-model="form.description"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-textarea>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="6">
            <ValidationProvider name="Budget" vid="budget" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="budget">
                <template v-slot:label>
                  {{ $t('bfti.budget') }} <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="budget"
                  type="number"
                  v-model="form.budget"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="6">
            <ValidationProvider name="Budget Source" vid="budget_source" rules="" v-slot="{ errors }">
              <b-form-group
                label-for="budget_source">
                <template v-slot:label>
                  {{ $t('bfti.budget_source') }}
                </template>
                <b-form-input
                  id="budget_source"
                  v-model="form.budget_source"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="6">
            <ValidationProvider name="Duration" vid="duration" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="duration">
                <template v-slot:label>
                  {{ $t('bfti.duration') }} <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="duration"
                  v-model="form.duration"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="6">
            <ValidationProvider name="Attachment" vid="attachment" :rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="attachment">
                <template v-slot:label>
                  {{ $t('bfti.attachment') }} <span v-if="required === 'required'" class="text-danger">*</span>
                </template>
                <b-form-file
                  id="attachment"
                  v-model="form.file"
                  @change="onChange"
                  :state="errors[0] ? false : (valid ? true : null)"
                  placeholder="Choose a file or drop it here..."
                  drop-placeholder="Drop file here..."
                ></b-form-file>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
           <template class="pb-3" v-if="item">
             <a :href="'/'+item.attachment">{{ $t('bfti.attachment_down')}}</a> <br>
           </template>
          </b-col>
        </b-row>
        <b-row>
          <b-col md="12 text-center">
            <span class="badge badge-primary card-title"><h5>{{ $t('bfti.contact_information') }}</h5></span>
          </b-col>
          <b-col xs="12" sm="12" md="6">
            <ValidationProvider name="Name" vid="name" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="name">
                <template v-slot:label>
                  {{ $t('bfti.contact_person') }} <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="name"
                  v-model="form.name"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="6">
            <ValidationProvider name="Designation" vid="designation" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="designation">
                <template v-slot:label>
                  {{ $t('bfti.designation') }} <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="designation"
                  v-model="form.designation"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="6">
            <ValidationProvider name="Organization" vid="organization" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="organization">
                <template v-slot:label>
                  {{ $t('bfti.organization') }} <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="organization"
                  v-model="form.organization"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="6">
            <ValidationProvider name="Contact Number" vid="contact_number" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="contact_number">
                <template v-slot:label>
                  {{ $t('bfti.contact_number') }} <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="contact_number"
                  v-model="form.contact_number"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="6">
            <ValidationProvider name="Email" vid="email" rules="" v-slot="{ errors }">
              <b-form-group
                label-for="email">
                <template v-slot:label>
                  {{ $t('bfti.email') }}
                </template>
                <b-form-input
                  id="email"
                  type="email"
                  v-model="form.email"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col xs="12" sm="12" md="6">
            <ValidationProvider name="Submission date" vid="submission_date" rules="required" v-slot="{ errors }">
              <b-form-group
                label-for="submission_date">
                <template v-slot:label>
                  {{ $t('globalTrans.date') }} <span class="text-danger">*</span>
                </template>
                <b-form-datepicker b-form-datepicker id="submission_date" v-model="form.submission_date"
                                   :state="errors[0] ? false : (valid ? true : null)"
                >
                </b-form-datepicker>
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
import RestApi, { bftiResReportServiceBaseUrl } from '@/config/api_config'
import { bftiResearchRequestStoreApi, bftiResearchRequestUpdateApi } from '../../api/routes'
export default {
  name: 'Form',
  props: ['item'],
  data () {
    return {
      valid: null,
      saveBtnName: this.id ? this.$t('globalTrans.update') : this.$t('globalTrans.save'),
      errors: [],
      required: 'required',
      form: {
        doc_type_id: 0,
        topic: '',
        description: '',
        budget: '',
        budget_source: '',
        duration: '',
        name: '',
        designation: '',
        organization: '',
        contact_number: '',
        email: '',
        submission_date: new Date(),
        file: [],
        user_id: this.$store.state.Auth.authUser.user_id
      }
    }
  },
  created () {
    if (this.item) {
      this.required = ''
      this.form = this.item
      this.form.doc_type_id = this.item.document_type_id
      this.form.contact_number = this.item.contact_no
    } else {
      this.required = 'required'
    }
  },
  watch: {
  /*  'form.contact_number': function (newVal, oldVal) {

    } */
  },
  computed: {
    loading: function () {
      return this.$store.state.commonObj.loading
    },
    docTypeList () {
      return this.$store.state.BftiResearchAndReportService.commonObj.documentTypeList.filter(item => item.status === 1)
    }
  },
  methods: {
    onChange (event) {
      const input = event.target
      if (input.files && input.files[0]) {
        const reader = new FileReader()
        reader.onload = (e) => {
          this.form.attachment = e.target.result
        }
        reader.readAsDataURL(input.files[0])
      } else {
        this.form.attachment = ''
      }
    },
    async saveUpdate () {
      this.$store.dispatch('mutateCommonProperties', { loading: true })
      let result = null
      const loadingState = { loading: false, listReload: false }
      if (this.item) {
        result = await RestApi.putData(bftiResReportServiceBaseUrl, `${bftiResearchRequestUpdateApi}/${this.item.id}`, this.form)
      } else {
        result = await RestApi.postData(bftiResReportServiceBaseUrl, bftiResearchRequestStoreApi, this.form)
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
    getLawEntry () {
      const tmpData = this.$store.state.list.find(item => item.id === this.id)
      return JSON.parse(JSON.stringify(tmpData))
    }
  }
}
</script>
