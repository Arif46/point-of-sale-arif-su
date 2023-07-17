<template>
  <b-row>
    <b-col md="12">
        <ValidationObserver ref="form1"  v-slot="{ handleSubmit, reset }">
            <b-form @submit.prevent="handleSubmit(addItem)" @reset.prevent="reset">
                <b-overlay :show="loading">
                    <template>
                        <div class="bg-primary mb-3">
                            <h5 class="text-white text-center"> {{ $t('externalUser.export_product_and_success') }}</h5>
                        </div>
                    </template>
                    <!-- <b-row class="mb-3">
                        <div class="bg-dark w-50 m-auto rounded-pill">
                            <h5 class="text-white text-center"> {{ $t('externalUser.export_product_and_success') }}</h5>
                        </div>
                    </b-row> -->
                    <b-row>
                      <b-col xl="6" lg="6" sm="12">
                          <ValidationProvider name="Export Product Name" vid="product_id" rules="required|min_value:1" v-slot="{ errors }">
                              <b-form-group
                              label-for="product_id"
                              label-cols-sm="5"
                              >
                              <template v-slot:label>
                              {{$t('externalUser.export_product_name')}} <span class="text-danger">*</span>
                              </template>
                              <b-form-select
                              plain
                              :disabled="disable"
                              v-model="prod_details.product_id"
                              :options="exportSectorList"
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
                      <b-col xl="6" lg="6" sm="12">
                          <ValidationProvider name="Export Destinations" vid="destination_id" rules="required|min_value:1" v-slot="{ errors }">
                              <b-form-group
                              label-for="destination_id"
                              label-cols-sm="5"
                              >
                              <template v-slot:label>
                              {{$t('externalUser.export_destinations')}} <span class="text-danger">*</span>
                              </template>
                               <v-select
                                multiple
                                :reduce="op => op.value"
                                v-model="prod_details.destination_id"
                                :options="countryList"
                                :state="errors[0] ? false : (valid ? true : null)"
                                label='text'
                                :placeholder="$t('globalTrans.select')"
                              >
                              </v-select>
                              <div class="invalid-feedback d-block">
                              {{ errors[0] }}
                              </div>
                              </b-form-group>
                          </ValidationProvider>
                      </b-col>
                      <b-col xl="6" lg="6" sm="12">
                          <ValidationProvider name="Fiscal Year" vid="fiscal_year_id" rules="required|min_value:1" v-slot="{ errors }">
                              <b-form-group
                              label-for="fiscal_year_id"
                              label-cols-sm="5"
                              >
                              <template v-slot:label>
                              {{$t('globalTrans.fiscal_year')}} <span class="text-danger">*</span>
                              </template>
                              <b-form-select
                              plain
                              :disabled="prod_details.product_id ? false : true"
                              v-model="prod_details.fiscal_year_id"
                              @change="getIncomeGrowth(prod_details.fiscal_year_id)"
                              :options="fiscalYearList"
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
                      <b-col xl="6" lg="6" sm="12">
                          <ValidationProvider name="Export Volume" vid="export_volume" rules="required|min_value:1" v-slot="{ errors }">
                              <b-form-group
                                  label-cols-sm="5"
                                  label-for="export_volume"
                              >
                              <template v-slot:label>
                                  {{ $t('externalUser.export_volume') }} <span class="text-danger">*</span>
                                  </template>
                                  <b-form-input
                                      v-model="prod_details.export_volume"
                                      :state="errors[0] ? false : (valid ? true : null)"
                                      oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                  ></b-form-input>
                                  <div class="invalid-feedback">
                                      {{ errors[0] }}
                                  </div>
                              </b-form-group>
                          </ValidationProvider>
                      </b-col>
                      <b-col xl="6" lg="6" sm="12">
                          <ValidationProvider name="Export Value" vid="export_value_ssd" rules="required|min_value:1" v-slot="{ errors }">
                              <b-form-group
                                  label-cols-sm="5"
                                  label-for="export_value_ssd"
                              >
                              <template v-slot:label>
                                  {{ $t('externalUser.export_value_usd') }} <span class="text-danger">*</span>
                                  </template>
                                  <b-form-input
                                    :disabled="prod_details.fiscal_year_id ? false : true"
                                    @input="calculateIncomeGrowth($event)"
                                      v-model="prod_details.export_value_ssd"
                                      :state="errors[0] ? false : (valid ? true : null)"
                                      oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                  ></b-form-input>
                                  <div class="invalid-feedback">
                                      {{ errors[0] }}
                                  </div>
                              </b-form-group>
                          </ValidationProvider>
                      </b-col>
                      <b-col xl="6" lg="6" sm="12">
                          <ValidationProvider name="Income Growth" vid="income_growth" rules="required" v-slot="{ errors }">
                              <b-form-group
                                  label-cols-sm="5"
                                  label-for="income_growth"
                              >
                              <template v-slot:label>
                                  {{ $t('externalUser.income_growth') }} <span class="text-danger">*</span>
                                  </template>
                                  <b-form-input
                                    :disabled="incomeDisabled"
                                      v-model="prod_details.income_growth"
                                      :state="errors[0] ? false : (valid ? true : null)"
                                      oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                  ></b-form-input>
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
                            <b-table-simple bordered class="table-responsive">
                            <thead class="text-white bg-primary">
                                <tr>
                                    <th class="text-center" width="100px">{{ $t('globalTrans.sl_no') }}</th>
                                    <th scope="col">{{ $t('externalUser.export_product_name') }}</th>
                                    <th scope="col">{{ $t('externalUser.export_destinations') }}</th>
                                    <th scope="col">{{ $t('globalTrans.fiscal_year') }}</th>
                                    <th scope="col">{{ $t('externalUser.export_volume') }}</th>
                                    <th scope="col">{{ $t('externalUser.export_value_usd') }}</th>
                                    <th scope="col">{{ $t('externalUser.income_growth') }}</th>
                                    <th class="text-center">{{ $t('globalTrans.action') }}</th>
                                </tr>
                            </thead>
                            <b-tbody>
                                <b-tr v-for="(item, index) in descriptions" :key="index">
                                    <b-td class="text-center">{{ $n(index + 1) }}</b-td>
                                    <b-td>{{ productName(item.product_id) }}</b-td>
                                    <b-td>
                                        <div v-for="(itm, indx) in item.destination_id" :key="indx">
                                            {{ destinationName(parseInt(itm)) }}
                                        </div>
                                    </b-td>
                                    <b-td>{{ fiscalYearName(item.fiscal_year_id) }}</b-td>
                                    <b-td>{{ $n(item.export_volume, { useGrouping: false }) }}</b-td>
                                    <b-td>{{ $n(item.export_value_ssd, { useGrouping: false }) }}</b-td>
                                    <b-td>{{ $n(item.income_growth, { useGrouping: false }) }}</b-td>
                                    <b-td class="text-center">
                                        <span class="d-flex text-center">
                                            <b-button @click="editItem(item, index)" title="Location Edit" class="btn btn-success btn-sm mr-1"><i class="ri-pencil-fill m-0"></i></b-button>
                                            <b-button type="button" @click="deleteItem(index)" class="btn btn-danger" size="sm"><i class="ri-delete-bin-2-line"></i></b-button>
                                        </span>
                                    </b-td>
                                </b-tr>
                                <b-tr v-if="descriptions.length <= 0">
                                    <td colspan="8" class="text-center">
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
import { etApplicationDescriptionStoreApi, getExportIncomeGrowthApi } from '../../api/routes'

export default {
    props: ['app_id', 'descriptions'],
    data () {
      return {
        valid: null,
        loading: false,
        editIndex: '',
        incomeDisabled: true,
        prod_details: {
          product_id: 0,
          destination_id: [],
          fiscal_year_id: 0,
          export_volume: '',
          export_value_ssd: '',
          income_growth: ''
        },
        disable: false
      }
    },
    computed: {
    exportSectorList () {
      return this.$store.state.ExternalUserService.cipPanel.commonObj.exportSectorList.filter(item => item.status === 1 && item.assign_for === 2).map(item => {
        if (this.currentLocale === 'bn') {
          return Object.assign({}, item, {
            value: item.value,
            text: item.text_bn
          })
        } else {
          return Object.assign({}, item, {
            value: item.value,
            text: item.text_en
          })
        }
      })
    },
    countryList () {
        return this.$store.state.CommonService.commonObj.countryList.filter(item => item.status === 1)
    },
      fiscalYearList () {
        const toDay = new Date().toISOString().slice(0, 10)
        const lastYear = new Date(new Date().setFullYear(new Date().getFullYear() - 1))
        const prevDate = lastYear.toISOString().slice(0, 10)
        const previousYear = this.$store.state.CommonService.commonObj.fiscalYearList.filter(item => item.start_date < prevDate && item.end_date >= prevDate && item.status === 1)
        const currentYear = this.$store.state.CommonService.commonObj.fiscalYearList.filter(item => item.start_date < toDay && item.end_date >= toDay && item.status === 1)
        return [...previousYear, ...currentYear]
      },
      currentLocale () {
        return this.$i18n.locale
      }
    },
    methods: {
        calculateIncomeGrowth (exportValue) {
            const index = this.fiscalYearList.findIndex(rank => rank.value === this.prod_details.fiscal_year_id)
            const descriptions = this.descriptions.filter(el => el.product_id === this.prod_details.product_id)
            if (index !== 0) {
                const value = parseFloat(exportValue) - parseFloat(descriptions[0].export_value_ssd)
                const growth = (value * 100) / parseFloat(descriptions[0].export_value_ssd)
                this.prod_details.income_growth = growth.toFixed(2)
            }
        },
        async getIncomeGrowth (yearId) {
            const index = this.fiscalYearList.findIndex(rank => rank.value === yearId)
            const product = this.descriptions.find(el => el.product_id === this.prod_details.product_id)
            if (index !== 0 && typeof product === 'undefined') {
                const newFisID = this.fiscalYearList[0].value
                const newData = this.descriptions.find(el => el.fiscal_year_id === newFisID && el.product_id === this.prod_details.product_id)
                if (typeof newData === 'undefined') {
                    this.prod_details.fiscal_year_id = 0
                }
            }
            if (index === 0 && typeof product === 'undefined') {
                this.unitLoad = true
                this.prod_details.user_id = this.$store.state.Auth.authUser.user_id
                const result = await RestApi.getData(exportTrophyCIPServiceBaseUrl, getExportIncomeGrowthApi, this.prod_details)
                if (result.success) {
                    this.prod_details.income_growth = result.data.income_growth
                    // this.prod_details.already_in_db = 1
                    this.unitLoad = false
                } else {
                    this.incomeDisabled = false
                    this.unitLoad = false
                }
            }
        },
        cancelItem () {
            this.prod_details = {
                product_id: 0,
                destination_id: [],
                fiscal_year_id: 0,
                export_volume: '',
                export_value_ssd: '',
                income_growth: ''
            }
            this.editIndex = ''
            this.$refs.form1.reset()
        },
        editItem (item, index) {
            this.prod_details = Object.assign({}, item)
            if (!this.$route.query.id) {
                this.prod_details.destination_id = item.destination_id
            } else {
                this.prod_details.destination_id = JSON.parse(item.destination_id)
            }
            this.editIndex = index
        },
        deleteItem (index) {
            this.descriptions.splice(index, 1)
            if (this.descriptions.length === 0) {
                this.disable = false
            }
        },
        async addItem () {
            let result = []
            if (this.editIndex !== '') {
                const editList = [...this.descriptions]
                editList.splice(parseInt(this.editIndex), 1)
                result = [...editList]
            } else {
                result = this.descriptions
            }
            const product = this.prod_details.product_id
            const fiscalYear = this.prod_details.fiscal_year_id
            // const destination = this.prod_details.destination_id
            const checkData = result.find(item => item.product_id === product)
            if (typeof checkData === 'undefined') {
                this.disable = true
            } else {
                this.disable = false
            }

            const newData = result.find(item => item.product_id === product && item.fiscal_year_id === fiscalYear)
            if (typeof newData === 'undefined') {
                if (this.editIndex !== '') {
                    this.descriptions[parseInt(this.editIndex)] = this.prod_details
                } else {
                    this.descriptions.push(JSON.parse(JSON.stringify(this.prod_details)))
                }
                const productId = this.prod_details.product_id
                this.prod_details = {
                    product_id: productId,
                    destination_id: [],
                    fiscal_year_id: 0,
                    export_volume: '',
                    export_value_ssd: '',
                    income_growth: ''
                }
                if (this.disable === false) {
                    this.prod_details.product_id = 0
                }
                this.editIndex = ''
            } else {
              this.$toast.error({
                  title: '!',
                  message: 'Item already added',
                  color: '#D6E09B'
              })
            }
            this.incomeDisabled = true
            this.$nextTick(() => {
                this.$refs.form1.reset()
            })
        },
        productName (Id) {
          const Obj = this.$store.state.ExternalUserService.cipPanel.commonObj.exportSectorList.find(item => item.value === Id)
          if (typeof Obj !== 'undefined') {
            return this.$i18n.locale === 'bn' ? Obj.text_bn : Obj.text_en
          } else {
            return ''
          }
        },
        destinationName (Id) {
          const Obj = this.$store.state.CommonService.commonObj.countryList.find(item => item.value === Id)
          if (typeof Obj !== 'undefined') {
              return this.$i18n.locale === 'bn' ? Obj.text_bn : Obj.text_en
          } else {
            return ''
          }
        },
        fiscalYearName (Id) {
          const Obj = this.$store.state.CommonService.commonObj.fiscalYearList.find(item => item.value === Id)
          if (typeof Obj !== 'undefined') {
            return this.$i18n.locale === 'bn' ? Obj.text_bn : Obj.text_en
          } else {
            return ''
          }
        },
        async submit () {
            if (this.descriptions.length > 1) {
              this.loading = true
              this.$store.dispatch('mutateCommonProperties', { loading: true })
              const loadingState = { loading: false, listReload: false }
              const myObj = {
                descriptions: this.descriptions,
                app_id: this.app_id
              }
              const result = await RestApi.postData(exportTrophyCIPServiceBaseUrl, etApplicationDescriptionStoreApi, myObj)
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
                message: 'Add item for all fiscal year',
                color: '#D6E09B'
            })
          }
      }
    }
}
</script>
