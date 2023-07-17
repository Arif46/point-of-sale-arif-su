<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit, reset }">
    <b-overlay :show="loading">
      <b-form @submit.prevent="handleSubmit(saveUpdate)" @reset.prevent="reset" autocomplete="off">
        <b-row>
            <template>
                <span class="btn btn-primary"><h5 class="text-left">{{ $t('policy_advocacy.policy_information') }}</h5></span>
            </template>
            <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Memo No." vid="memo_no" rules="required">
              <b-form-group
                class="row"
                label-for="memo_no"
                slot-scope="{ valid, errors }">
                <template v-slot:label>
                  {{ $t('meeting_management.memo_no') }} <span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="memo_no"
                  v-model="form.memo_no"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
            </b-col>
            <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Meeting Date" vid="submission_date" rules="required">
              <b-form-group
                class="row"
                label-for="submission_date"
                slot-scope="{ valid, errors }">
                <template v-slot:label>
                  {{ $t('policy_advocacy.submission_date') }}  <span class="text-danger">*</span>
                </template>
                <b-form-datepicker
                  b-form-datepicker
                  id="submission_date"
                  v-model="form.submission_date"
                  :state="errors[0] ? false : (valid ? true : null)"
                >
                </b-form-datepicker>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
            </b-col>
            <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Policy Title" vid="policy_title" rules="required">
              <b-form-group
                class="row"
                label-for="policy_title"
                slot-scope="{ valid, errors }">
                <template v-slot:label>
                  {{ $t('policy_advocacy.policy_title') }} {{ $t('globalTrans.en') }}<span class="text-danger">*</span>
                </template>
                <b-form-input
                  id="policy_title"
                  v-model="form.policy_title"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
            </b-col>
            <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Policy Title" vid="policy_title_bn" rules="">
              <b-form-group
                class="row"
                label-for="policy_title_bn"
                slot-scope="{ valid, errors }">
                <template v-slot:label>
                  {{ $t('policy_advocacy.policy_title') }} {{ $t('globalTrans.bn') }}
                </template>
                <b-form-input
                  id="policy_title_bn"
                  v-model="form.policy_title_bn"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
            </b-col>
            <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Attachment" vid="attachment" v-slot="{ errors }">
              <b-form-group
                label-for="attachment">
                <template v-slot:label>
                  {{ $t('bfti.attachment') }}
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
            <b-col xs="12" sm="12" md="12" lg="12" xl="12">
            <ValidationProvider name="Description Instruction" vid="description">
              <b-form-group
                class="row"
                label-for="description"
                slot-scope="{ valid, errors }">
                <template v-slot:label>
                  {{ $t('policy_advocacy.description_instruction') }} {{ $t('globalTrans.en') }}
                </template>
                <b-form-textarea
                    rows="3"
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
            <b-col xs="12" sm="12" md="12" lg="12" xl="12">
            <ValidationProvider name="Description Instruction (Bn)" vid="description_bn">
              <b-form-group
              class="row"
              label-for="description_bn"
              slot-scope="{ valid, errors }">
              <template v-slot:label>
                {{ $t('policy_advocacy.description_instruction') }} {{ $t('globalTrans.bn') }}
              </template>
              <b-form-textarea
              rows="3"
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
        </b-row>
        <b-row>
          <hr>
              <template>
                <span class="btn btn-primary"><h5 class="text-left">{{ $t('policy_advocacy.focal_point_information') }}</h5></span>
            </template>
         <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Name (En)" vid="name" rules="required">
              <b-form-group
              class="row"
              label-for="name"
              slot-scope="{ valid, errors }">
              <template v-slot:label>
                {{ $t('globalTrans.name') }} {{ $t('globalTrans.en') }}<span class="text-danger">*</span>
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
          <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Name (Bn)" vid="name_bn" rules="">
              <b-form-group
                class="row"
                label-for="name_bn"
                slot-scope="{ valid, errors }">
                <template v-slot:label>
                  {{ $t('globalTrans.name') }} {{ $t('globalTrans.bn') }}
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
           <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Designation" vid="designation" rules="required">
              <b-form-group
                class="row"
                label-for="designation"
                slot-scope="{ valid, errors }">
                <template v-slot:label>
                  {{ $t('globalTrans.designation') }} {{ $t('globalTrans.en') }}<span class="text-danger">*</span>
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
           <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Designation (Bn)" vid="designation_bn" rules="">
              <b-form-group
                class="row"
                label-for="designation_bn"
                slot-scope="{ valid, errors }">
                <template v-slot:label>
                  {{ $t('globalTrans.designation') }} {{ $t('globalTrans.bn') }}
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
           <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Organization" vid="organization" rules="required">
              <b-form-group
                class="row"
                label-for="organization"
                slot-scope="{ valid, errors }">
                <template v-slot:label>
                  {{ $t('globalTrans.organization') }}   {{ $t('globalTrans.name') }} {{ $t('globalTrans.en') }}<span class="text-danger">*</span>
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
           <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Organization (Bn)" vid="organization_bn" rules="">
              <b-form-group
                class="row"
                label-for="organization_bn"
                slot-scope="{ valid, errors }">
                <template v-slot:label>
                  {{ $t('globalTrans.organization') }} {{ $t('globalTrans.name') }} {{ $t('globalTrans.bn') }}
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
            <ValidationProvider name="Email" vid="email" rules="email" v-slot="{ errors }">
              <b-form-group
                label-for="email">
                <template v-slot:label>
                  {{ $t('globalTrans.email') }} <span class="text-danger">*</span>
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
            <b-col xs="12" sm="12" md="6" lg="6" xl="6">
            <ValidationProvider name="Contact Number" vid="contact_no" rules="required|min:11|max:11" v-slot="{ errors }">
              <b-form-group
                label-for="contact_no">
                <template v-slot:label>
                  {{ $t('bfti.contact_number') }} <span class="text-danger">*</span>
                </template>
                <b-form-input
                  type="number"
                  id="contact_no"
                  v-model="form.contact_no"
                  :state="errors[0] ? false : (valid ? true : null)"
                ></b-form-input>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
              </b-form-group>
            </ValidationProvider>
          </b-col>
        </b-row>
        <!-- <b-row class="text-right">
          <b-col>
              <b-button type="submit" variant="success" class="mr-2 btn-sm">{{ saveBtnName }}</b-button>
              <b-button variant="danger" class="btn-sm" @click="$bvModal.hide('modal-form')">{{ $t('globalTrans.cancel') }}</b-button>
          </b-col>
        </b-row> -->
        <b-row class="text-right">
          <b-col>
              <b-button type="submit" @click="form.flag = 2 " variant="primary" class="mr-2">Final Save</b-button>
              &nbsp;
              <b-button type="submit" @click="form.flag = 1 " variant="warning" class="mr-2">Save Draft</b-button>
              <b-button variant="danger" class="btn-sm" @click="$bvModal.hide('modal-form')">{{ $t('globalTrans.cancel') }}</b-button>
            </b-col>
        </b-row>
      </b-form>
    </b-overlay>
  </ValidationObserver>
</template>
<script>
import RestApi, { bftiResReportServiceBaseUrl } from '@/config/api_config'
import { bftiPolicyRequestStoreApi, bftiPolicyRequestUpdateApi } from '../../api/routes'
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
        memo_no: '',
        policy_title: '',
        flag: 1,
        is_admin: 0,
        policy_title_bn: '',
        description: '',
        description_bn: '',
        attachment: '',
        name: '',
        name_bn: '',
        organization: '',
        organization_bn: '',
        designation: '',
        designation_bn: '',
        email: '',
        contact_no: '',
        status: 1,
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
      this.form.contact_no = this.item.contact_no
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
        result = await RestApi.putData(bftiResReportServiceBaseUrl, `${bftiPolicyRequestUpdateApi}/${this.item.id}`, this.form)
      } else {
        result = await RestApi.postData(bftiResReportServiceBaseUrl, bftiPolicyRequestStoreApi, this.form)
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
