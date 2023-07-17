<template>
    <ValidationObserver ref="form2"  v-slot="{ handleSubmit, reset }">
        <b-form @submit.prevent="handleSubmit(addItem)" @reset.prevent="reset">
            <b-overlay :show="unitLoad">
                <b-row>
                    <b-col xl="6" lg="6" sm="12">
                        <ValidationProvider name="Product Name" vid="product_id" rules="required|min_value:1" v-slot="{ errors }">
                            <b-form-group
                            label-for="product_id"
                            label-cols-sm="5"
                            >
                            <template v-slot:label>
                            {{$t('externalUser.product_name')}} <span class="text-danger">*</span>
                            </template>
                            <b-form-select
                            plain
                            v-model="detail_obj.product_id"
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
                        <ValidationProvider name="PRC No." vid="prc_no" rules="required|min_value:1" v-slot="{ errors }">
                            <b-form-group
                                label-cols-sm="5"
                                label-for="prc_no"
                            >
                            <template v-slot:label>
                                {{ $t('externalUser.prc_no') }} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    v-model="detail_obj.prc_no"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                            </b-form-group>
                        </ValidationProvider>
                    </b-col>
                    <b-col lg="6" sm="12">
                        <ValidationProvider name="HS Code" vid="hs_code" rules="required" v-slot="{ errors }">
                        <b-form-group
                            label-for="hs_code"
                            label-cols-sm="5"
                        >
                        <template v-slot:label>
                            {{ $t('externalUser.hs_code') }} <span class="text-danger">*</span>
                        </template>
                            <b-form-input
                            v-model="detail_obj.hs_code"
                            :state="errors[0] ? false : (valid ? true : null)"
                            ></b-form-input>
                            <div class="invalid-feedback">
                            {{ errors[0] }}
                            </div>
                        </b-form-group>
                        </ValidationProvider>
                    </b-col>
                    <b-col lg="6" sm="12">
                        <ValidationProvider name="PRC Date" vid="prc_date" rules="required" v-slot="{ errors }">
                            <b-form-group
                                label-for="prc_date"
                                label-cols-sm="5"
                                >
                                <template v-slot:label>
                                    {{ $t('externalUser.prc_date') }} <span class="text-danger">*</span>
                                </template>
                                <b-form-datepicker b-form-datepicker
                                    v-model="detail_obj.prc_date"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                >
                                </b-form-datepicker>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                            </b-form-group>
                        </ValidationProvider>
                    </b-col>
                    <b-col lg="6" sm="12">
                        <ValidationProvider name="Realization Date" vid="realization_date" rules="required" v-slot="{ errors }">
                            <b-form-group
                                label-for="realization_date"
                                label-cols-sm="5"
                                >
                                <template v-slot:label>
                                    {{ $t('externalUser.realization_date') }} <span class="text-danger">*</span>
                                </template>
                                <b-form-datepicker b-form-datepicker
                                    v-model="detail_obj.realization_date"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                >
                                </b-form-datepicker>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                            </b-form-group>
                        </ValidationProvider>
                    </b-col>
                    <b-col xl="6" lg="6" sm="12">
                        <ValidationProvider name="Export Value" vid="export_value_usd" rules="required|min_value:1" v-slot="{ errors }">
                            <b-form-group
                                label-cols-sm="5"
                                label-for="export_value_usd"
                            >
                            <template v-slot:label>
                                {{ $t('externalUser.export_value_usd') }} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    v-model="detail_obj.export_value_usd"
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
                        <b-table-simple bordered>
                        <thead class="text-white bg-primary">
                            <tr>
                                <th class="text-center" width="100px">{{ $t('globalTrans.sl_no') }}</th>
                                <th scope="col">{{ $t('externalUser.product_name') }}</th>
                                <th scope="col">{{ $t('externalUser.prc_no') }}</th>
                                <th scope="col">{{ $t('externalUser.hs_code') }}</th>
                                <th scope="col">{{ $t('externalUser.prc_date') }}</th>
                                <th scope="col">{{ $t('externalUser.realization_date') }}</th>
                                <th scope="col">{{ $t('externalUser.export_value_usd') }}</th>
                                <th width="10%" class="text-center">{{ $t('globalTrans.action') }}</th>
                            </tr>
                        </thead>
                        <b-tbody>
                            <b-tr v-for="(item, index) in products" :key="index">
                                <b-td class="text-center">{{ $n(index + 1) }}</b-td>
                                <b-td>{{ productName(item.product_id) }}</b-td>
                                <b-td>{{ $n(item.prc_no, { useGrouping: false }) }}</b-td>
                                <b-td>{{ item.hs_code }}</b-td>
                                <b-td>{{ item.prc_date | dateFormat }}</b-td>
                                <b-td>{{ item.realization_date | dateFormat }}</b-td>
                                <b-td>{{ $n(item.export_value_usd, { useGrouping: false }) }}</b-td>
                                <b-td class="text-center">
                                    <b-button @click="editItem(item, index)" title="Edit" class="btn btn-success btn-sm mr-1"><i class="ri-pencil-fill m-0"></i></b-button>
                                    <b-button type="button" @click="deleteItem(index)" title="Delete" class="btn btn-danger" size="sm"><i class="ri-delete-bin-2-line"></i></b-button>
                                </b-td>
                            </b-tr>
                            <b-tr v-if="products.length <= 0">
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
</template>

<script>
export default {
    props: ['products'],
    data () {
      return {
        valid: null,
        unitLoad: false,
        editIndex: '',
        detail_obj: {
            product_id: 0,
            prc_no: '',
            prc_date: '',
            realization_date: '',
            hs_code: '',
            export_value_usd: ''
        }
      }
    },
    computed: {
        exportSectorList () {
            return this.$store.state.ExternalUserService.cipPanel.commonObj.exportSectorList.filter(item => item.status === 1 && item.assign_for === 1).map(item => {
                if (this.currentLocale === 'bn') {
                    return Object.assign({}, item, {
                        text: item.text_bn
                    })
                } else {
                    return Object.assign({}, item, {
                        text: item.text_en
                    })
                }
            })
        },
        currentLocale () {
            return this.$i18n.locale
        }
    },
    methods: {
        cancelItem () {
                this.detail_obj = {}
                this.editIndex = ''
                this.$refs.form2.reset()
        },
        editItem (item, index) {
            this.detail_obj = Object.assign({}, item)
            this.editIndex = index
        },
        deleteItem (index) {
            this.products.splice(index, 1)
        },
        async addItem () {
            let result = []
            if (this.editIndex !== '') {
                const editList = [...this.products]
                editList.splice(parseInt(this.editIndex), 1)
                result = [...editList]
            } else {
                result = this.products
            }
            const productId = this.detail_obj.product_id
            const newData = result.find(item => parseInt(item.product_id) === parseInt(productId))
            if (typeof newData === 'undefined') {
                    if (this.editIndex !== '') {
                        this.products[parseInt(this.editIndex)] = this.detail_obj
                    } else {
                        this.products.push(JSON.parse(JSON.stringify(this.detail_obj)))
                    }
                    this.detail_obj = {
                        product_id: 0,
                        prc_no: '',
                        prc_date: '',
                        realization_date: '',
                        hs_code: '',
                        export_value_usd: ''
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
                this.$refs.form2.reset()
            })
        },
        productName (Id) {
          const Obj = this.$store.state.ExternalUserService.cipPanel.commonObj.exportSectorList.find(item => item.value === Id)
          if (typeof Obj !== 'undefined') {
            return this.$i18n.locale === 'bn' ? Obj.text_bn : Obj.text_en
          } else {
            return ''
          }
        }
    }
}
</script>
