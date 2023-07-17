<template>
  <b-row>
    <div class="bg-primary mb-3">
        <h5 class="text-white text-center"> {{ $t('externalUser.group_based') + ' ' + $t('globalTrans.information') }}</h5>
    </div>
    <b-col md="12">
        <ValidationObserver ref="form"  v-slot="{ handleSubmit, reset }">
            <b-form @submit.prevent="handleSubmit(submit)" @reset.prevent="reset">
                <b-overlay :show="loading">
                    <b-row>
                       <b-col xl="12" lg="12" sm="12">
                          <ValidationProvider vid="applied_group_of_companies" rules="min_value:1" v-slot="{ errors }">
                              <b-form-group
                              label-for="applied_group_of_companies"
                              label-cols-sm="3"
                              >
                              <b-form-checkbox
                                v-model="applied_group_of_companies"
                                name="applied_group_of_companies"
                                value="1"
                                unchecked-value="2"
                              >
                               {{ $t('externalUser.applied_group_of_companies') }}
                              </b-form-checkbox>
                              <div class="invalid-feedback">
                                {{ errors[0] }}
                              </div>
                              </b-form-group>
                          </ValidationProvider>
                      </b-col>
                    </b-row>
                    <b-row v-if="parseInt(applied_group_of_companies) === 1" class="mb-3">
                      <div class="bg-dark w-50 m-auto rounded-pill">
                          <h6 class="text-white text-center py-1"> {{ $t('externalUser.group_based_application_data') }}</h6>
                      </div>
                      <b-col lg="12" sm="12" class="mt-3">
                        <div class="row pb-1 pt-3 border border-info mt-2" v-for="(group, index) in group_based_apps" :key="index">
                          <b-col lg="6" sm="12">
                            <ValidationProvider name="Group Name (En)" :vid="`group_based_apps` + [index] + `.group_name_en`" rules="required" v-slot="{ errors }">
                              <b-form-group
                                :label-for="`group_based_apps` + [index] + `.group_name_en`"
                                label-cols-sm="6"
                              >
                              <template v-slot:label>
                                {{ $t('externalUser.group_name') + ' ' + $t('globalTrans.en') }} <span class="text-danger">*</span>
                              </template>
                                <b-form-input
                                  v-model="group.group_name_en"
                                  :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                  {{ errors[0] }}
                                </div>
                              </b-form-group>
                            </ValidationProvider>
                          </b-col>
                          <b-col lg="6" sm="12">
                            <ValidationProvider name="Group Name (Bn)" :vid="`group_based_apps` + [index] + `.group_name_bn`" rules="required" v-slot="{ errors }">
                              <b-form-group
                                :label-for="`group_based_apps` + [index] + `.group_name_bn`"
                                label-cols-sm="6"
                              >
                              <template v-slot:label>
                                {{ $t('externalUser.group_name') + ' ' + $t('globalTrans.bn') }} <span class="text-danger">*</span>
                              </template>
                                <b-form-input
                                  v-model="group.group_name_bn"
                                  :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                  {{ errors[0] }}
                                </div>
                              </b-form-group>
                            </ValidationProvider>
                          </b-col>
                          <b-col lg="6" sm="12">
                            <ValidationProvider name="Group Organization Name (En)" :vid="`group_based_apps` + [index] + `.org_name_en`" rules="required" v-slot="{ errors }">
                              <b-form-group
                                :label-for="`group_based_apps` + [index] + `.org_name_en`"
                                label-cols-sm="6"
                              >
                              <template v-slot:label>
                                {{ $t('externalUser.group_org_name') + ' ' + $t('globalTrans.en') }} <span class="text-danger">*</span>
                              </template>
                                <b-form-input
                                  v-model="group.org_name_en"
                                  :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                  {{ errors[0] }}
                                </div>
                              </b-form-group>
                            </ValidationProvider>
                          </b-col>
                          <b-col lg="6" sm="12">
                            <ValidationProvider name="Group Organization Name (Bn)" :vid="`group_based_apps` + [index] + `.org_name_bn`" rules="required" v-slot="{ errors }">
                              <b-form-group
                                :label-for="`group_based_apps` + [index] + `.org_name_bn`"
                                label-cols-sm="6"
                              >
                              <template v-slot:label>
                                {{ $t('externalUser.group_org_name') + ' ' + $t('globalTrans.bn') }} <span class="text-danger">*</span>
                              </template>
                                <b-form-input
                                  v-model="group.org_name_bn"
                                  :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                  {{ errors[0] }}
                                </div>
                              </b-form-group>
                            </ValidationProvider>
                          </b-col>
                          <b-col xl="6" lg="6" sm="12">
                              <ValidationProvider name="Export Value" :vid="`group_based_apps` + [index] + `.export_value`" rules="required" v-slot="{ errors }">
                                  <b-form-group
                                      label-cols-sm="6"
                                      :label-for="`group_based_apps` + [index] + `.export_value`"
                                      class="mb-0"
                                  >
                                      <template v-slot:label>
                                      {{ $t('externalUser.export_value') }} <span class="text-danger">*</span>
                                      </template>
                                      <b-form-input
                                          v-model="group.export_value"
                                          oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                          :state="errors[0] ? false : (valid ? true : null)"
                                      ></b-form-input>
                                      <div class="invalid-feedback">
                                          {{ errors[0] }}
                                      </div>
                                  </b-form-group>
                              </ValidationProvider>
                          </b-col>
                          <b-row>
                            <b-col class="mb-2" sm="12" style="max-width: 22%">
                                <p class="text-black" style="border-bottom: 1px solid #ddd; font-weight: bold">
                                    {{ $t('globalTrans.attachment') + ' ' }} <span v-if="!$route.query.id" class="text-danger">*</span>
                                </p>
                            </b-col>
                          </b-row>
                          <!-- <b-row> -->
                            <b-col lg="6" v-for="(document, index2) in group.attachments" :key="index2">
                                <b-row>
                                    <b-col sm="12" lg="8">
                                      <ValidationProvider name="Attachment" :vid="`group.attachments${[index]}.attachment${index2}`" :rules="$route.query.id ? '' : 'required'" v-slot="{ errors }">
                                            <b-form-group
                                                label-class="mr-3"
                                                :label-for="`document.attachment${index + index2}`"
                                            >
                                              <b-form-file
                                                  accept="application/pdf,application/doc,application/docx,application/csv"
                                                  v-model="new_attachment"
                                                  v-on:change="onChange($event, index, index2)"
                                                  :state="errors[0] ? false : (valid ? true : null)"
                                              >
                                              </b-form-file>
                                              <div class="invalid-feedback">
                                                  {{ errors[0] }}
                                              </div>
                                            </b-form-group>
                                      </ValidationProvider>
                                    </b-col>
                                    <b-col sm="12" lg="4">
                                        <a v-if="$route.query.id && document.attachment" class="btn btn-success btn-sm mr-1" target="_blank" :href="baseUrl + 'download-attachment?file=' + document.attachment" title="attachment"><i class="ri-download-cloud-fill"></i></a>
                                        <button type="button" class="btn btn-primary btn-sm mr-1" v-if="showAdd(index, index2)" @click="addDocument(index)" title="Add More"><i class="ri-add-line m-0"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" v-if="showTrash(index)" @click="deleteDocument(index, index2)" title="Delete"><i class="ri-delete-bin-line m-0"></i></button>
                                    </b-col>
                                  </b-row>
                              </b-col>
                          <!-- </b-row> -->
                          <b-col lg="12" sm="12">
                            <b-col lg="2" class="float-right pr-0 mb-2">
                              <b-button v-if="index === 0" type="button" @click="addItem" class="float-right btn-sm" variant="secondary"><i class="ri-add-line p-0 m-0"></i></b-button>
                              <b-button v-if="index !== 0" type="button" @click="removeItem(index)" class="float-right btn-sm" variant="danger"><i class="ri-close-fill p-0 m-0"></i></b-button>
                            </b-col>
                          </b-col>
                        </div>
                      </b-col>
                    </b-row>
                </b-overlay>
            </b-form>
        </ValidationObserver>
    </b-col>
</b-row>
</template>

<script>
import RestApi, { exportTrophyCIPServiceBaseUrl } from '@/config/api_config'
import { cipApplicationGroupStoreApi } from '../../api/routes'

export default {
    props: ['app_id', 'group_based_apps', 'applied_group', 'baseUrl'],
    data () {
      return {
        valid: null,
        loading: false,
        new_attachment: [],
        applied_group_of_companies: ''
      }
    },
    created () {
      this.applied_group_of_companies = this.applied_group
    },
    computed: {
      currentLocale () {
        return this.$i18n.locale
      }
    },
    methods: {
        deleteDocument (index, index2) {
            this.group_based_apps[index].attachments = this.group_based_apps[index].attachments.filter((_, indx) => indx !== index2)
        },
        showTrash (index) {
            const length = this.group_based_apps[index].attachments.length
            if (length === 1) {
                return false
            }
            return true
        },
        onChange (event, index, index2) {
            const input = event.target
            if (input.files && input.files[0]) {
                const reader = new FileReader()
                reader.onload = (e) => {
                    this.group_based_apps[index].attachments[index2].file = e.target.result
                }
                reader.readAsDataURL(input.files[0])
            } else {
                this.group_based_apps[index].attachments[index2].file = ''
            }
        },
        showAdd (index, index2) {
            const length = this.group_based_apps[index].attachments.length
            if (index2 === length - 1) {
                return true
            }
            return false
        },
        addDocument (index) {
            const obj = { attachment: null }
            this.group_based_apps[index].attachments.push(obj)
        },
        addItem () {
          const tmpGroup = {
              group_name_en: '',
              group_name_bn: '',
              export_value: '',
              org_name_en: '',
              org_name_bn: '',
              attachments: [
                  {
                      attachment: null
                  }
              ]
          }
          this.group_based_apps.push(tmpGroup)
        },
        removeItem (index) {
          this.group_based_apps.splice(index, 1)
        },
        async submit () {
          var check = await this.$refs.form.validate()
          if (check) {
              this.loading = true
              this.$store.dispatch('mutateCommonProperties', { loading: true })
              const loadingState = { loading: false, listReload: false }
              const myObj = {
                applied_group_of_companies: parseInt(this.applied_group_of_companies),
                group_based_apps: this.group_based_apps,
                app_id: this.app_id
              }
              const result = await RestApi.postData(exportTrophyCIPServiceBaseUrl, cipApplicationGroupStoreApi, myObj)
              loadingState.listReload = true
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
