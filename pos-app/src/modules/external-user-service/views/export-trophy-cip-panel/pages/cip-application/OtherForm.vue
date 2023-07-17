<template>
  <b-row>
    <b-overlay :show="loading">
      <template>
      <div class="bg-primary mb-3">
          <h5 class="text-white text-center"> {{ $t('externalUser.compliance_information') }}</h5>
      </div>
    </template>
    <b-col md="12">
        <ValidationObserver ref="form"  v-slot="{ handleSubmit, reset }">
            <b-form @submit.prevent="handleSubmit(submit)" @reset.prevent="reset">
              <b-row>
                  <b-col xl="6" lg="6" sm="12">
                    <ValidationProvider vid="other_compliance.export_leather_shoes" rules="min_value:1" v-slot="{ errors }">
                        <b-form-group
                        label-for="other_compliance.export_leather_shoes"
                        label-cols-sm="3"
                        >
                        <b-form-checkbox
                          v-model="other_compliance.export_leather_shoes"
                          name="export_leather_shoes"
                          value="1"
                          unchecked-value="2"
                        >
                          {{ $t('externalUser.export_leather_shoes') }}
                        </b-form-checkbox>
                        <div class="invalid-feedback">
                          {{ errors[0] }}
                        </div>
                        </b-form-group>
                    </ValidationProvider>
                  </b-col>
                  <b-col xl="6" lg="6" sm="12">
                    <ValidationProvider name="Merchandising PRC" vid="other_compliance.merchandising_prc" :rules="!$route.query.id || other_compliance.merchandising_prc === '' ? 'required' : ''" v-slot="{ errors }">
                        <b-form-group
                          label-for="other_compliance.merchandising_prc"
                          label-cols-sm="5"
                        >
                        <template v-slot:label>
                          {{ $t('externalUser.merchandising_prc')}} <span v-if="!$route.query.id || other_compliance.merchandising_prc === ''" class="text-danger">*</span>
                            <span v-if="$route.query.id && other_compliance.merchandising_prc">
                                <a target="_blank" :href="baseUrl + 'download-attachment?file=' + other_compliance.merchandising_prc" title="attachment" class="mr-3"><i class="ri-download-cloud-fill"></i></a>
                            </span>
                        </template>
                        <b-form-file
                        plain
                        accept="application/pdf,application/doc,application/docx,application/csv"
                        v-on:change="onFileChangePRC"
                        v-model="merchandising_input"
                        :state="errors[0] ? false : (valid ? true : null)"
                        ></b-form-file>
                          <div class="invalid-feedback">
                            {{ errors[0] }}
                          </div>
                        </b-form-group>
                    </ValidationProvider>
                  </b-col>
              </b-row>
              <b-row class="mb-3">
                  <div class="bg-dark w-50 m-auto rounded-pill">
                      <h6 class="text-white text-center py-1"> {{ $t('externalUser.org_compliance_information') }}</h6>
                  </div>
              </b-row>
              <b-row>
                <b-col xl="12" lg="12" sm="12">
                    <ValidationProvider vid="compliance_current_fiscal_year" rules="min_value:1" v-slot="{ errors }">
                        <b-form-group
                        label-for="compliance_current_fiscal_year"
                        >
                        <b-form-checkbox
                          v-model="other_compliance.compliance_current_fiscal_year"
                          name="compliance_current_fiscal_year"
                          value="1"
                          unchecked-value="2"
                        >
                          {{ $t('externalUser.compliance_current_fiscal_year') }}
                        </b-form-checkbox>
                        <div class="invalid-feedback">
                          {{ errors[0] }}
                        </div>
                        </b-form-group>
                    </ValidationProvider>
                  </b-col>
                  <b-col xl="6" lg="6" sm="12">
                      <ValidationProvider name="Merchandising Sector" vid="merchandising_sector" rules="required|min:1" v-slot="{ errors }">
                        <b-form-group
                            label-for="merchandising_sector"
                            label-cols-sm="12"
                          >
                          <template v-slot:label>
                            {{ $t('externalUser.merchandising_sector') }} <span class="text-danger">*</span>
                          </template>
                            <b-form-radio-group
                              class="text-left"
                              v-model="other_compliance.merchandising_sector"
                              :options="merchandisingTypeList"
                              :state="errors[0] ? false : (valid ? true : null)"
                            ></b-form-radio-group>
                            <div class="invalid-feedback d-block">
                            {{ errors[0] }}
                          </div>
                          </b-form-group>
                      </ValidationProvider>
                  </b-col>
                  <b-col xl="6" lg="6" sm="12">
                    <ValidationProvider :name="other_compliance.merchandising_sector == 1 ? 'Textile Facotry Inspection...' : 'Updated Inspection Report...'"
                    vid="other_compliance.report"
                    :rules="!$route.query.id || other_compliance.report === '' ? 'required' : ''" v-slot="{ errors }">
                        <b-form-group
                          label-for="other_compliance.report"
                          label-cols-sm="12"
                        >
                        <template v-slot:label>
                          {{ other_compliance.merchandising_sector == 1 ? $t('externalUser.textile_factory_inspection') : $t('externalUser.updated_inspection') }}
                          <span v-if="!$route.query.id || other_compliance.report === ''" class="text-danger">*</span>
                          <span v-if="$route.query.id && other_compliance.report">
                              <a target="_blank" :href="baseUrl + 'download-attachment?file=' + other_compliance.report" title="attachment" class="mr-3"><i class="ri-download-cloud-fill"></i></a>
                          </span>
                        </template>
                        <b-form-file
                        plain
                        accept="application/pdf,application/doc,application/docx,application/csv"
                        v-on:change="onFileChangeReport"
                        v-model="report_input"
                        :state="errors[0] ? false : (valid ? true : null)"
                        ></b-form-file>
                          <div class="invalid-feedback">
                            {{ errors[0] }}
                          </div>
                        </b-form-group>
                    </ValidationProvider>
                  </b-col>
              </b-row>
            </b-form>
        </ValidationObserver>
    </b-col>
    <b-col md="12">
      <b-row>
        <b-col xl="12" lg="12" sm="12">
            <ValidationProvider vid="export_destination_add" rules="min_value:1" v-slot="{ errors }">
                <b-form-group
                label-for="export_destination_add"
                >
                <b-form-checkbox
                  v-model="other_compliance.export_destination_add"
                  name="export_destination_add"
                  value="1"
                  unchecked-value="2"
                >
                  {{ $t('externalUser.export_destination_add') }}
                </b-form-checkbox>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
                </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col v-if="parseInt(other_compliance.export_destination_add) === 1" xl="12" lg="12" sm="12">
            <DestinationAdd :destinations="export_destinations" />
          </b-col>
          <b-col xl="12" lg="12" sm="12">
            <ValidationProvider vid="export_products_add" rules="min_value:1" v-slot="{ errors }">
                <b-form-group
                label-for="export_products_add"
                >
                <b-form-checkbox
                  v-model="other_compliance.export_products_add"
                  name="export_products_add"
                  value="1"
                  unchecked-value="2"
                >
                  {{ $t('externalUser.export_products_add') }}
                </b-form-checkbox>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
                </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col v-if="parseInt(other_compliance.export_products_add) === 1" xl="12" lg="12" sm="12">
            <ProductAdd :products="export_products" />
          </b-col>
          <b-col xl="12" lg="12" sm="12">
            <ValidationProvider vid="applicant_selected_cip_past_year" rules="min_value:1" v-slot="{ errors }">
                <b-form-group
                label-for="applicant_selected_cip_past_year"
                >
                <b-form-checkbox
                  v-model="other_compliance.applicant_selected_cip_past_year"
                  name="applicant_selected_cip_past_year"
                  value="1"
                  unchecked-value="2"
                >
                  {{ $t('externalUser.applicant_selected_cip_past_year') }}
                </b-form-checkbox>
                <div class="invalid-feedback">
                  {{ errors[0] }}
                </div>
                </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col v-if="parseInt(other_compliance.applicant_selected_cip_past_year) === 1" xl="12" lg="12" sm="12">
            <SelectedYear :selecteds="cip_selecteds" />
          </b-col>
      </b-row>
    </b-col>
    <b-col md="12">
      <ValidationObserver ref="form4"  v-slot="{ handleSubmit, reset }">
          <b-form @submit.prevent="handleSubmit(submit)" @reset.prevent="reset">
              <b-row>
                <b-col xl="12" lg="12" sm="12">
                  <ValidationProvider vid="trade_dispute_current_fiscal_year" rules="min_value:1" v-slot="{ errors }">
                      <b-form-group
                      label-for="trade_dispute_current_fiscal_year"
                      >
                      <b-form-checkbox
                        v-model="other_compliance.trade_dispute_current_fiscal_year"
                        name="trade_dispute_current_fiscal_year"
                        value="1"
                        unchecked-value="2"
                      >
                        {{ $t('externalUser.trade_dispute_current_fiscal_year') }}
                      </b-form-checkbox>
                      <div class="invalid-feedback">
                        {{ errors[0] }}
                      </div>
                      </b-form-group>
                  </ValidationProvider>
                </b-col>
                <b-col xl="12" lg="12" sm="12">
                  <ValidationProvider vid="dispute_settled" rules="min_value:1" v-slot="{ errors }">
                      <b-form-group
                      label-for="dispute_settled"
                      >
                      <b-form-checkbox
                        v-model="other_compliance.dispute_settled"
                        name="dispute_settled"
                        value="1"
                        unchecked-value="2"
                      >
                        {{ $t('externalUser.dispute_settled') }}
                      </b-form-checkbox>
                      <div class="invalid-feedback">
                        {{ errors[0] }}
                      </div>
                      </b-form-group>
                  </ValidationProvider>
                </b-col>
                <b-col v-if="parseInt(other_compliance.dispute_settled) === 1" xl="12" lg="12" sm="12">
                  <b-col xl="6" lg="6" sm="12">
                      <ValidationProvider name="Dispute Settled Document" vid="dispute_settled_document" :rules="!$route.query.id || other_compliance.dispute_settled_document === '' || other_compliance.dispute_settled_document === null ? 'required' : ''" v-slot="{ errors }">
                          <b-form-group
                            label-for="dispute_settled_document"
                            label-cols-sm="12"
                          >
                          <template v-slot:label>
                            {{ $t('externalUser.dispute_settled_document')}} <span v-if="!$route.query.id || other_compliance.dispute_settled_document === '' || other_compliance.dispute_settled_document === null" class="text-danger">*</span>
                              <span v-if="$route.query.id && other_compliance.dispute_settled_document">
                                  <a target="_blank" :href="baseUrl + 'download-attachment?file=' + other_compliance.dispute_settled_document" title="attachment" class="mr-3"><i class="ri-download-cloud-fill"></i></a>
                              </span>
                          </template>
                          <b-form-file
                          plain
                          accept="application/pdf,application/doc,application/docx,application/csv"
                          v-on:change="onFileChangeDispute"
                          v-model="dispute_settled_input"
                          :state="errors[0] ? false : (valid ? true : null)"
                          ></b-form-file>
                            <div class="invalid-feedback">
                              {{ errors[0] }}
                            </div>
                          </b-form-group>
                      </ValidationProvider>
                  </b-col>
                </b-col>
                <b-col xl="6" lg="6" sm="12">
                    <ValidationProvider name="Attachment of Applicant's Sign" vid="other_compliance.signature" :rules="!$route.query.id || other_compliance.signature === '' ? 'required': ''" v-slot="{ errors }">
                        <b-form-group
                          label-for="other_compliance.signature"
                          label-cols-sm="12"
                        >
                        <template v-slot:label>
                          {{ $t('externalUser.applicant_signature')}} <span v-if="!$route.query.id || other_compliance.signature === ''" class="text-danger">*</span>
                            <span v-if="$route.query.id && other_compliance.signature">
                                <a target="_blank" :href="baseUrl + 'download-attachment?file=storage/' + other_compliance.signature" title="attachment" class="mr-3"><i class="ri-download-cloud-fill"></i></a>
                            </span>
                        </template>
                        <b-form-file
                        plain
                        accept="image/*"
                        v-on:change="onFileChangeSign"
                        v-model="signature_input"
                        :state="errors[0] ? false : (valid ? true : null)"
                        ></b-form-file>
                          <div class="invalid-feedback">
                            {{ errors[0] }}
                          </div>
                        </b-form-group>
                    </ValidationProvider>
                </b-col>
                <b-col lg="6" sm="12">
                  <ValidationProvider name="Other Information" vid="other_compliance.other_information" rules="" v-slot="{ errors }">
                      <b-form-group
                          label-cols-sm="5"
                          label-for="other_compliance.other_information"
                      >
                      <template v-slot:label>
                      {{ $t('externalUser.other_info_if_any') }}
                      </template>
                          <b-form-textarea
                          v-model="other_compliance.other_information"
                          rows="1"
                          max-rows="2"
                          :state="errors[0] ? false : (valid ? true : null)"
                          ></b-form-textarea>
                          <div class="invalid-feedback">
                          {{ errors[0] }}
                          </div>
                      </b-form-group>
                  </ValidationProvider>
                </b-col>
              </b-row>
          </b-form>
      </ValidationObserver>
    </b-col>
    </b-overlay>
</b-row>
</template>

<script>
import RestApi, { exportTrophyCIPServiceBaseUrl } from '@/config/api_config'
import { cipApplicationOthersStoreApi } from '../../api/routes'
import DestinationAdd from './DestinationAdd.vue'
import ProductAdd from './ProductAdd.vue'
import SelectedYear from './SelectedYear.vue'
export default {
    props: ['app_id', 'other_compliance', 'export_destinations', 'export_products', 'cip_selecteds', 'app_status', 'baseUrl'],
    components: { DestinationAdd, ProductAdd, SelectedYear },
    data () {
      return {
        valid: null,
        loading: false,
        report_input: [],
        merchandising_input: [],
        dispute_settled_input: [],
        signature_input: []
      }
    },
    computed: {
      merchandisingTypeList () {
          return this.$store.state.ExternalUserService.cipPanel.merchandisingTypeList.map(el => {
              return Object.assign({}, el, { text: this.$i18n.locale === 'bn' ? el.text_bn : el.text_en })
          })
      },
      currentLocale () {
        return this.$i18n.locale
      }
    },
    methods: {
        onFileChangePRC (e) {
            const input = e.target
            if (input.files && input.files[0]) {
              const reader = new FileReader()
              reader.onload = (e) => {
                this.other_compliance.merchandising_prc_file = e.target.result
              }
              reader.readAsDataURL(input.files[0])
            } else {
              this.other_compliance.merchandising_prc_file = ''
            }
        },
        onFileChangeReport (e) {
            const input = e.target
            if (input.files && input.files[0]) {
              const reader = new FileReader()
              reader.onload = (e) => {
                this.other_compliance.report_file = e.target.result
              }
              reader.readAsDataURL(input.files[0])
            } else {
              this.other_compliance.report_file = ''
            }
        },
        onFileChangeDispute (e) {
            const input = e.target
            if (input.files && input.files[0]) {
              const reader = new FileReader()
              reader.onload = (e) => {
                this.other_compliance.dispute_settled_document_file = e.target.result
              }
              reader.readAsDataURL(input.files[0])
            } else {
              this.other_compliance.dispute_settled_document_file = ''
            }
        },
        onFileChangeSign (e) {
            const input = e.target
            if (input.files && input.files[0]) {
              const reader = new FileReader()
              reader.onload = (e) => {
                this.other_compliance.signature_file = e.target.result
              }
              reader.readAsDataURL(input.files[0])
            } else {
              this.other_compliance.signature_file = ''
            }
        },
        async submit () {
          var check = await this.$refs.form.validate()
          var check2 = await this.$refs.form4.validate()
          if (check && check2) {
            this.loading = true
            this.$store.dispatch('mutateCommonProperties', { loading: true })
            const loadingState = { loading: false, listReload: false }
            const myObj = {
              other_compliance: this.other_compliance,
              export_destinations: this.export_destinations,
              export_products: this.export_products,
              cip_selecteds: this.cip_selecteds,
              app_id: this.app_id,
              app_status: this.app_status
            }
            const result = await RestApi.postData(exportTrophyCIPServiceBaseUrl, cipApplicationOthersStoreApi, myObj)
            loadingState.listReload = false
            this.$store.dispatch('mutateCommonProperties', loadingState)
            this.loading = false
            if (result.success) {
                this.$toast.success({
                    title: 'Success',
                    message: this.app_id ? this.$t('globalTrans.update_msg') : this.$t('globalTrans.save_msg'),
                    color: '#D6E09B'
                })
                return result
            } else {
              this.$toast.error({
                title: this.$t('globalTrans.error'),
                message: this.$t('globalTrans.form_error_msg'),
                color: '#D6E09B'
              })
            }
          }
      }
    }
}
</script>

<style>

</style>
