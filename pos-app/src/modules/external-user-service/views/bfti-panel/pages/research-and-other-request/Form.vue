<template>
  <div class="section-wrapper">
    <ValidationObserver ref="form" v-slot="{ handleSubmit, reset }">
      <b-overlay :show="loading">
        <b-form @submit.prevent="handleSubmit(saveUpdate)" @reset.prevent="reset" autocomplete="off">
          <!-- <b-row>
            <b-col md="12">
              <span class="card-title"><h5>{{ $t('bfti.research_and_other_request') }}:</h5></span>
            </b-col>
          </b-row> -->
          <body-card>
            <template v-slot:headerTitle>
              <h5 class="card-title"> {{ $t('bfti.research_and_other_request') }}</h5>
            </template>
            <template v-slot:body>
              <b-row>
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
              </b-row>
              <b-row>
                <b-col xs="12" sm="12" md="6">
                  <ValidationProvider name="Topic (En)" vid="topic" rules="required" v-slot="{ errors }">
                    <b-form-group
                      label-for="topic">
                      <template v-slot:label>
                        {{ $t('bfti.topic') }}  {{ $t('globalTrans.en') }} <span class="text-danger">*</span>
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
                <b-col xs="12" sm="12" md="6">
                  <ValidationProvider name="Topic (Bn)" vid="topic_bn" v-slot="{ errors }">
                    <b-form-group
                      label-for="topic_bn">
                      <template v-slot:label>
                        {{ $t('bfti.topic') }} {{ $t('globalTrans.bn') }}
                      </template>
                      <b-form-input
                        id="topic_bn"
                        v-model="form.topic_bn"
                        :state="errors[0] ? false : (valid ? true : null)"
                      ></b-form-input>
                      <div class="invalid-feedback">
                        {{ errors[0] }}
                      </div>
                    </b-form-group>
                  </ValidationProvider>
                </b-col>
                <b-col xs="12" sm="12" md="6">
                  <ValidationProvider name="Description (En)" vid="description" rules="required" v-slot="{ errors }">
                    <b-form-group
                      label-for="heading_bn">
                      <template v-slot:label>
                        {{ $t('bfti.description') }}  {{ $t('globalTrans.en') }}<span class="text-danger">*</span>
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
                  <ValidationProvider name="Description (Bn)" vid="description_bn" v-slot="{ errors }">
                    <b-form-group
                      label-for="description_bn">
                      <template v-slot:label>
                        {{ $t('bfti.description') }}  {{ $t('globalTrans.bn') }}
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
                  <ValidationProvider name="Budget Source (En)" vid="budget_source" v-slot="{ errors }">
                    <b-form-group
                      label-for="budget_source">
                      <template v-slot:label>
                        {{ $t('bfti.budget_source') }} {{ $t('globalTrans.en') }}
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
                  <ValidationProvider name="Budget Source (Bn)" vid="budget_source_bn" rules="" v-slot="{ errors }">
                    <b-form-group
                      label-for="budget_source_bn">
                      <template v-slot:label>
                        {{ $t('bfti.budget_source') }} {{ $t('globalTrans.bn') }}
                      </template>
                      <b-form-input
                        id="budget_source_bn"
                        v-model="form.budget_source_bn"
                        :state="errors[0] ? false : (valid ? true : null)"
                      ></b-form-input>
                      <div class="invalid-feedback">
                        {{ errors[0] }}
                      </div>
                    </b-form-group>
                  </ValidationProvider>
                </b-col>
                <b-col xs="12" sm="12" md="6">
                  <ValidationProvider name="Date From" vid="duration_start_date" rules="required" v-slot="{ errors }">
                    <b-form-group
                      label-for="date"
                    >
                      <template v-slot:label>
                        {{ $t('globalTrans.date_from') }}  <span class="text-danger">*</span>
                      </template>
                      <b-form-datepicker b-form-datepicker
                        id="duration_start_date"
                        v-model="form.duration_start_date"
                        :state="errors[0] ? false : (valid ? true : null)"
                        :placeholder="$t('globalTrans.select')"
                        :locale="currentLocale"
                        @input="diffYearMonthDay"
                      >
                      </b-form-datepicker>
                      <div class="invalid-feedback">
                        {{ errors[0] }}
                      </div>
                    </b-form-group>
                  </ValidationProvider>
                </b-col>
                <b-col xs="12" sm="12" md="6">
                  <ValidationProvider name="Date To" vid="duration_end_date" rules="required" v-slot="{ errors }">
                    <b-form-group
                      label-for="date"
                    >
                      <template v-slot:label>
                        {{ $t('globalTrans.date_to') }}  <span class="text-danger">*</span>
                      </template>
                      <b-form-datepicker b-form-datepicker
                        id="duration_end_date"
                        v-model="form.duration_end_date"
                        :state="errors[0] ? false : (valid ? true : null)"
                        :placeholder="$t('globalTrans.select')"
                        :locale="currentLocale"
                        @input="diffYearMonthDay"
                      >
                      </b-form-datepicker>
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
                        {{ $t('research_plan_management.duration') }} <span class="text-danger">*</span>
                      </template>
                      <b-form-input
                        id="duration"
                        v-model="form.duration"
                        :state="errors[0] ? false : (valid ? true : null)"
                        disabled
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
                        accept=".pdf"
                        placeholder="Choose a file or drop it here..."
                        drop-placeholder="Drop file here..."
                      ></b-form-file>
                      <div class="invalid-feedback">
                        {{ errors[0] }}
                      </div>
                    </b-form-group>
                  </ValidationProvider>
                <template class="pb-3" v-if="item">
                  <a target="_blank" :href="bftiResReportServiceBaseUrl +item.attachment">{{ $t('bfti.attachment_down')}}</a> <br>
                </template>
                </b-col>
              </b-row>
            </template>
          </body-card>
          <body-card>
            <template v-slot:headerTitle>
              <h5 class="card-title"> {{ $t('bfti.contact_information') }}</h5>
            </template>
            <template v-slot:body>
              <b-row>
                <b-col xs="12" sm="12" md="6">
                  <ValidationProvider name="Name (En)" vid="name" rules="required" v-slot="{ errors }">
                    <b-form-group
                      label-for="name">
                      <template v-slot:label>
                        {{ $t('bfti.contact_person') }} {{ $t('globalTrans.en') }} <span class="text-danger">*</span>
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
                  <ValidationProvider name="Name (bn)" vid="name_bn" v-slot="{ errors }">
                    <b-form-group
                      label-for="name_bn">
                      <template v-slot:label>
                        {{ $t('bfti.contact_person') }} {{ $t('globalTrans.bn') }}
                      </template>
                      <b-form-input
                        id="name_bn"
                        v-model="form.name_bn"
                        :state="errors[0] ? false : (valid ? true : null)"
                      ></b-form-input>
                      <div class="invalid-feedback">
                        {{ errors[0] }}
                      </div>
                    </b-form-group>
                  </ValidationProvider>
                </b-col>
                <b-col xs="12" sm="12" md="6">
                  <ValidationProvider name="Designation (En)" vid="designation" rules="required" v-slot="{ errors }">
                    <b-form-group
                      label-for="designation">
                      <template v-slot:label>
                        {{ $t('bfti.designation') }} {{ $t('globalTrans.en') }} <span class="text-danger">*</span>
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
                  <ValidationProvider name="Designation (Bn)" vid="designation_bn" v-slot="{ errors }">
                    <b-form-group
                      label-for="designation_bn">
                      <template v-slot:label>
                        {{ $t('bfti.designation') }} {{ $t('globalTrans.bn') }}
                      </template>
                      <b-form-input
                        id="designation_bn"
                        v-model="form.designation_bn"
                        :state="errors[0] ? false : (valid ? true : null)"
                      ></b-form-input>
                      <div class="invalid-feedback">
                        {{ errors[0] }}
                      </div>
                    </b-form-group>
                  </ValidationProvider>
                </b-col>
                <b-col xs="12" sm="12" md="6">
                  <ValidationProvider name="Organization (En)" vid="organization" rules="required" v-slot="{ errors }">
                    <b-form-group
                      label-for="organization">
                      <template v-slot:label>
                        {{ $t('globalTrans.organization') }} {{ $t('globalTrans.en') }} <span class="text-danger">*</span>
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
                  <ValidationProvider name="Organization (Bn)" vid="organization_bn" v-slot="{ errors }">
                    <b-form-group
                      label-for="organization_bn">
                      <template v-slot:label>
                        {{ $t('globalTrans.organization') }} {{ $t('globalTrans.bn') }}
                      </template>
                      <b-form-input
                        id="organization_bn"
                        v-model="form.organization_bn"
                        :state="errors[0] ? false : (valid ? true : null)"
                      ></b-form-input>
                      <div class="invalid-feedback">
                        {{ errors[0] }}
                      </div>
                    </b-form-group>
                  </ValidationProvider>
                </b-col>
                <b-col xs="12" sm="12" md="6">
                  <ValidationProvider name="Contact Number" vid="contact_number" rules="required|min:11|max:11" v-slot="{ errors }">
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
                  <ValidationProvider name="Email" vid="email" rules="email" v-slot="{ errors }">
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
                        {{ $t('bfti.submission_date') }} <span class="text-danger">*</span>
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
            </template>
          </body-card>
          <b-row class="text-right">
            <b-col>
              <b-button type="submit" @click="form.flag = 2 " variant="primary" class="mr-2">{{$t('configuration.final_save')}}</b-button>
              <b-button type="submit" @click="form.flag = 1 " variant="warning" class="mr-2">{{$t('configuration.save_draft')}}</b-button>
              <b-button variant="danger" class="btn-sm" @click="$bvModal.hide('modal-form')">{{ $t('globalTrans.cancel') }}</b-button>
            </b-col>
          </b-row>
        </b-form>
      </b-overlay>
    </ValidationObserver>
  </div>
</template>
<script>
import RestApi, { bftiResReportServiceBaseUrl } from '@/config/api_config'
import { bftiResearchRequestStoreApi, bftiResearchRequestUpdateApi } from '../../api/routes'
import { helpers } from '@/utils/helper-functions'
export default {
  name: 'Form',
  props: ['item'],
  data () {
    return {
      bftiResReportServiceBaseUrl: bftiResReportServiceBaseUrl,
      valid: null,
      saveBtnName: this.id ? this.$t('globalTrans.update') : this.$t('globalTrans.save'),
      errors: [],
      required: 'required',
      form: {
        doc_type_id: 3,
        topic: '',
        topic_bn: '',
        description: '',
        description_bn: '',
        budget: '',
        budget_source: '',
        budget_source_bn: '',
        duration: '',
        name: '',
        name_bn: '',
        designation: '',
        designation_bn: '',
        organization: '',
        organization_bn: '',
        contact_number: '',
        email: '',
        flag: '',
        submission_date: new Date(),
        file: [],
        user_id: this.$store.state.Auth.authUser.user_id,
        externalFlag: true // this flag will check in backend api either it come from admin or external
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
     currentLocale () {
      return this.$i18n.locale
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
    saveUpdate () {
      let msg = ''
      if (this.form.flag === 1) {
        msg = window.vm.$t('configuration.save_draft_mess')
      }
      if (this.form.flag === 2) {
        msg = window.vm.$t('configuration.final_save_mess')
      }
      window.vm.$swal({
        title: msg,
        showCancelButton: true,
        confirmButtonText: window.vm.$t('globalTrans.yes'),
        cancelButtonText: window.vm.$t('globalTrans.no'),
        focusConfirm: false
      }).then((result) => {
        if (result.isConfirmed) {
          this.Approval()
        }
      })
    },
    async Approval () {
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
    },
    diffYearMonthDay () {
      if (this.form.duration_start_date && this.form.duration_end_date) {
        const dt1 = new Date(this.form.duration_start_date)
        const dt2 = new Date(this.form.duration_end_date)
        const time = (dt2.getTime() - dt1.getTime()) / 1000
        const divisionNumberForYear = 60 * 60 * 24 * 365
        const divisionNumberForMonth = 60 * 60 * 24 * 30
        const divisionNumberForDay = 60 * 60 * 24
        const year = Math.abs(Math.floor(time / divisionNumberForYear))
        const month = Math.abs(Math.floor((time - (year * divisionNumberForYear)) / divisionNumberForMonth))
        const days = Math.abs(Math.floor((time - (year * divisionNumberForYear) - (month * divisionNumberForMonth)) / divisionNumberForDay))
        this.form.duration = this.$i18n.locale === 'bn' ? helpers.convertEnglishToBanglaNumber(year) + ' ' + this.$t('research_plan_management.years', 'bn') + ', ' + helpers.convertEnglishToBanglaNumber(month) + ' ' + this.$t('research_plan_management.months', 'bn') + ', ' + helpers.convertEnglishToBanglaNumber(days) + ' ' + this.$t('research_plan_management.days', 'bn') : year + ' ' + this.$t('research_plan_management.years', 'en') + ', ' + month + ' ' + this.$t('research_plan_management.months', 'en') + ', ' + days + ' ' + this.$t('research_plan_management.days', 'en')
      }
    }
  }
}
</script>
