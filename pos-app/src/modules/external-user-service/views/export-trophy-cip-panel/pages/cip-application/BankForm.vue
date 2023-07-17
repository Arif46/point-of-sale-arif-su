<template>
  <b-row>
    <!-- <template>
      <div class="bg-primary mb-3">
          <h5 class="text-white text-center"> {{ $t('externalUser.bank_list') }}</h5>
      </div>
    </template> -->
    <b-col md="12">
        <ValidationObserver ref="form1"  v-slot="{ handleSubmit, reset }">
            <b-form @submit.prevent="handleSubmit(addItem)" @reset.prevent="reset">
                <b-overlay :show="loading">
                    <b-row class="mb-3">
                        <div class="bg-dark w-50 m-auto rounded-pill">
                            <h6 class="text-white text-center py-1"> {{ $t('externalUser.bank_list') }}</h6>
                        </div>
                    </b-row>
                    <b-row>
                        <b-col lg="6" sm="12">
                          <ValidationProvider name="Bank Name (En)" vid="bank_name_en" rules="required" v-slot="{ errors }">
                            <b-form-group
                              label-for="bank_name_en"
                              label-cols-sm="5"
                            >
                            <template v-slot:label>
                              {{ $t('externalUser.bank_name') + ' ' + $t('globalTrans.en') }} <span class="text-danger">*</span>
                            </template>
                              <b-form-input
                                v-model="bank.bank_name_en"
                                :state="errors[0] ? false : (valid ? true : null)"
                              ></b-form-input>
                              <div class="invalid-feedback">
                                {{ errors[0] }}
                              </div>
                            </b-form-group>
                          </ValidationProvider>
                        </b-col>
                        <b-col lg="6" sm="12">
                          <ValidationProvider name="Bank Name (Bn)" vid="bank_name_bn" rules="required" v-slot="{ errors }">
                            <b-form-group
                              label-for="bank_name_bn"
                              label-cols-sm="5"
                            >
                            <template v-slot:label>
                              {{ $t('externalUser.bank_name') + ' ' + $t('globalTrans.bn') }} <span class="text-danger">*</span>
                            </template>
                              <b-form-input
                                v-model="bank.bank_name_bn"
                                :state="errors[0] ? false : (valid ? true : null)"
                              ></b-form-input>
                              <div class="invalid-feedback">
                                {{ errors[0] }}
                              </div>
                            </b-form-group>
                          </ValidationProvider>
                        </b-col>
                        <b-col lg="6" sm="12">
                          <ValidationProvider name="Branch Name (En)" vid="branch_name_en" rules="required" v-slot="{ errors }">
                            <b-form-group
                              label-for="branch_name_en"
                              label-cols-sm="5"
                            >
                            <template v-slot:label>
                              {{ $t('externalUser.branch_name') + ' ' + $t('globalTrans.en') }} <span class="text-danger">*</span>
                            </template>
                              <b-form-input
                                v-model="bank.branch_name_en"
                                :state="errors[0] ? false : (valid ? true : null)"
                              ></b-form-input>
                              <div class="invalid-feedback">
                                {{ errors[0] }}
                              </div>
                            </b-form-group>
                          </ValidationProvider>
                        </b-col>
                        <b-col lg="6" sm="12">
                          <ValidationProvider name="Branch Name (Bn)" vid="branch_name_bn" rules="required" v-slot="{ errors }">
                            <b-form-group
                              label-for="branch_name_bn"
                              label-cols-sm="5"
                            >
                            <template v-slot:label>
                              {{ $t('externalUser.branch_name') + ' ' + $t('globalTrans.bn') }} <span class="text-danger">*</span>
                            </template>
                              <b-form-input
                                v-model="bank.branch_name_bn"
                                :state="errors[0] ? false : (valid ? true : null)"
                              ></b-form-input>
                              <div class="invalid-feedback">
                                {{ errors[0] }}
                              </div>
                            </b-form-group>
                          </ValidationProvider>
                        </b-col>
                        <b-col lg="6" sm="12">
                          <ValidationProvider name="Address (En)" vid="address_en" rules="required" v-slot="{ errors }">
                              <b-form-group
                                  label-cols-sm="5"
                                  label-for="address_en"
                              >
                              <template v-slot:label>
                              {{$t('globalTrans.address') + ' ' + $t('globalTrans.en')}} <span class="text-danger">*</span>
                              </template>
                                  <b-form-textarea
                                  v-model="bank.address_en"
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
                        <b-col lg="6" sm="12">
                          <ValidationProvider name="Address (Bn)" vid="address_bn" rules="required" v-slot="{ errors }">
                              <b-form-group
                                  label-cols-sm="5"
                                  label-for="address_bn"
                              >
                              <template v-slot:label>
                              {{$t('globalTrans.address') + ' ' + $t('globalTrans.bn')}} <span class="text-danger">*</span>
                              </template>
                                  <b-form-textarea
                                  v-model="bank.address_bn"
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
                        <b-col>
                          <div class="text-right mb-2">
                              <b-button type="button" v-if="editIndex !== ''" variant="danger" class="mr-1" @click="cancelItem()">{{ $t('globalTrans.cancel') }}</b-button>
                              <b-button type="submit" variant="success">{{ editIndex !== '' ? $t('globalTrans.update') : $t('globalTrans.add')}}</b-button>
                          </div>
                      </b-col>
                    </b-row>
                    <b-row>
                        <b-col xl="12" lg="12" sm="12">
                            <b-table-simple bordered>
                            <thead class="text-white bg-primary">
                                <tr>
                                    <th class="text-center" width="100px">{{ $t('globalTrans.sl_no') }}</th>
                                    <th scope="col">{{ $t('externalUser.bank_name') }}</th>
                                    <th scope="col">{{ $t('externalUser.branch_name') }}</th>
                                    <th scope="col">{{ $t('globalTrans.address') }}</th>
                                    <th class="text-center">{{ $t('globalTrans.action') }}</th>
                                </tr>
                            </thead>
                            <b-tbody>
                                <b-tr v-for="(item, index) in banks" :key="index">
                                    <b-td class="text-center">{{ $n(index + 1) }}</b-td>
                                    <b-td>{{ currentLocale === 'bn' ? item.bank_name_bn : item.bank_name_en }}</b-td>
                                    <b-td>{{ currentLocale === 'bn' ? item.branch_name_bn : item.branch_name_en }}</b-td>
                                    <b-td>{{ currentLocale === 'bn' ? item.address_bn : item.address_en }}</b-td>
                                    <b-td class="text-center">
                                        <b-button @click="editItem(item, index)" title="Edit" class="btn btn-success btn-sm mr-1"><i class="ri-pencil-fill m-0"></i></b-button>
                                        <b-button type="button" @click="deleteItem(index)" title="Delete" class="btn btn-danger" size="sm"><i class="ri-delete-bin-2-line"></i></b-button>
                                    </b-td>
                                </b-tr>
                                <b-tr v-if="banks.length <= 0">
                                    <td colspan="5" class="text-center">
                                        <span class="text-black">{{ (currentLocale === 'bn') ? 'কোন তথ্য পাওয়া যায়নি!' : 'No Data Found' }}</span>
                                    </td>
                                </b-tr>
                            </b-tbody>
                            </b-table-simple>
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
import { cipApplicationBankStoreApi } from '../../api/routes'

export default {
    props: ['app_id', 'banks'],
    data () {
      return {
        valid: null,
        loading: false,
        editIndex: '',
        bank: {
            bank_name_en: '',
            bank_name_bn: '',
            branch_name_en: '',
            branch_name_bn: '',
            address_en: '',
            address_bn: ''
        }
      }
    },
    computed: {
      currentLocale () {
        return this.$i18n.locale
      }
    },
    methods: {
      cancelItem () {
            this.bank = {}
            this.editIndex = ''
            this.$refs.form1.reset()
      },
      editItem (item, index) {
          this.bank = Object.assign({}, item)
          this.editIndex = index
      },
      deleteItem (index) {
          this.banks.splice(index, 1)
      },
      async addItem () {
          let result = []
          if (this.editIndex !== '') {
              const editList = [...this.banks]
              editList.splice(parseInt(this.editIndex), 1)
              result = [...editList]
          } else {
              result = this.banks
          }
          const bankName = this.bank.bank_name_en
          const branchName = this.bank.branch_name_en

          const newData = result.find(item => item.bank_name_en === bankName && item.branch_name_en === branchName)
          if (typeof newData === 'undefined') {
              if (this.editIndex !== '') {
                  this.banks[parseInt(this.editIndex)] = this.bank
              } else {
                  this.banks.push(JSON.parse(JSON.stringify(this.bank)))
              }
              this.bank = {
                  bank_name_en: '',
                  bank_name_bn: '',
                  branch_name_en: '',
                  branch_name_bn: '',
                  address_en: '',
                  address_bn: ''
              }
              this.editIndex = ''
          } else {
            this.$toast.error({
                title: '!',
                message: 'Item already added',
                color: '#D6E09B'
            })
          }
          this.$nextTick(() => {
              this.$refs.form1.reset()
          })
        },
        async submit () {
          if (this.banks.length > 0) {
              this.loading = true
              this.$store.dispatch('mutateCommonProperties', { loading: true })
              const loadingState = { loading: false, listReload: false }
              const myObj = {
                banks: this.banks,
                app_id: this.app_id
              }
              const result = await RestApi.postData(exportTrophyCIPServiceBaseUrl, cipApplicationBankStoreApi, myObj)
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
          } else {
            this.$toast.error({
                title: '!',
                message: 'Add atleast one item',
                color: '#D6E09B'
            })
          }
      }
    }
}
</script>
