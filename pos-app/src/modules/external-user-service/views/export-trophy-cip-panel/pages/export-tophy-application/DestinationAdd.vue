<template>
    <ValidationObserver ref="form1"  v-slot="{ handleSubmit, reset }">
        <b-form @submit.prevent="handleSubmit(addItem)" @reset.prevent="reset">
            <b-overlay :show="unitLoad">
                <b-row>
                    <b-col xl="6" lg="6" sm="12">
                        <ValidationProvider name="Country Name" vid="country_id" rules="required|min_value:1" v-slot="{ errors }">
                            <b-form-group
                            label-for="country_id"
                            label-cols-sm="5"
                            >
                            <template v-slot:label>
                                {{$t('globalTrans.country')}} <span class="text-danger">*</span>
                            </template>
                            <b-form-select
                            plain
                            v-model="detail_obj.country_id"
                            :options="countryList"
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
                        <ValidationProvider name="Buyer Organization Name (En)" vid="buyer_org_name_en" rules="required" v-slot="{ errors }">
                        <b-form-group
                            label-for="buyer_org_name_en"
                            label-cols-sm="5"
                        >
                        <template v-slot:label>
                            {{ $t('externalUser.buyer_org_name') + ' ' + $t('globalTrans.en') }} <span class="text-danger">*</span>
                        </template>
                            <b-form-input
                            v-model="detail_obj.buyer_org_name_en"
                            :state="errors[0] ? false : (valid ? true : null)"
                            ></b-form-input>
                            <div class="invalid-feedback">
                            {{ errors[0] }}
                            </div>
                        </b-form-group>
                        </ValidationProvider>
                    </b-col>
                    <b-col lg="6" sm="12">
                        <ValidationProvider name="Buyer Organization Name (Bn)" vid="buyer_org_name_bn" rules="required" v-slot="{ errors }">
                        <b-form-group
                            label-for="buyer_org_name_bn"
                            label-cols-sm="5"
                        >
                        <template v-slot:label>
                            {{ $t('externalUser.buyer_org_name') + ' ' + $t('globalTrans.bn') }} <span class="text-danger">*</span>
                        </template>
                            <b-form-input
                            v-model="detail_obj.buyer_org_name_bn"
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
                        <ValidationProvider name="Relization Date" vid="realization_date" rules="required" v-slot="{ errors }">
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
                                <th scope="col">{{ $t('globalTrans.country') }}</th>
                                <th scope="col">{{ $t('externalUser.prc_no') }}</th>
                                <th scope="col">{{ $t('externalUser.buyer_org_name') }}</th>
                                <th scope="col">{{ $t('externalUser.prc_date') }}</th>
                                <th scope="col">{{ $t('externalUser.realization_date') }}</th>
                                <th scope="col">{{ $t('externalUser.export_value_usd') }}</th>
                                <th width="10%" class="text-center">{{ $t('globalTrans.action') }}</th>
                            </tr>
                        </thead>
                        <b-tbody>
                            <b-tr v-for="(item, index) in destinations" :key="index">
                                <b-td class="text-center">{{ $n(index + 1) }}</b-td>
                                <b-td>{{ countryName(item.country_id) }}</b-td>
                                <b-td>{{ $n(item.prc_no, { useGrouping: false }) }}</b-td>
                                <b-td>{{ currentLocale === 'en' ? item.buyer_org_name_en : item.buyer_org_name_bn }}</b-td>
                                <b-td>{{ item.prc_date | dateFormat }}</b-td>
                                <b-td>{{ item.realization_date | dateFormat }}</b-td>
                                <b-td>{{ $n(item.export_value_usd, { useGrouping: false }) }}</b-td>
                                <b-td class="text-center">
                                    <b-button @click="editItem(item, index)" title="Edit" class="btn btn-success btn-sm mr-1"><i class="ri-pencil-fill m-0"></i></b-button>
                                    <b-button type="button" @click="deleteItem(index)" title="Delete" class="btn btn-danger" size="sm"><i class="ri-delete-bin-2-line"></i></b-button>
                                </b-td>
                            </b-tr>
                            <b-tr v-if="destinations.length <= 0">
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
    props: ['destinations'],
    data () {
      return {
        valid: null,
        unitLoad: false,
        editIndex: '',
        detail_obj: {
            country_id: 0,
            prc_no: '',
            prc_date: '',
            realization_date: '',
            buyer_org_name_en: '',
            buyer_org_name_bn: '',
            export_value_usd: ''
        }
      }
    },
    computed: {
        countryList () {
            return this.$store.state.CommonService.commonObj.countryList.filter(item => item.status === 1)
        },
        currentLocale () {
            return this.$i18n.locale
        }
    },
    methods: {
        cancelItem () {
                this.detail_obj = {}
                this.editIndex = ''
                this.$refs.form1.reset()
        },
        editItem (item, index) {
            this.detail_obj = Object.assign({}, item)
            this.editIndex = index
        },
        deleteItem (index) {
            this.destinations.splice(index, 1)
        },
        async addItem () {
            let result = []
            if (this.editIndex !== '') {
                const editList = [...this.destinations]
                editList.splice(parseInt(this.editIndex), 1)
                result = [...editList]
            } else {
                result = this.destinations
            }
            const countryId = this.detail_obj.country_id
            const newData = result.find(item => parseInt(item.country_id) === parseInt(countryId))

            if (typeof newData === 'undefined') {
                    if (this.editIndex !== '') {
                        this.destinations[parseInt(this.editIndex)] = this.detail_obj
                    } else {
                        this.destinations.push(JSON.parse(JSON.stringify(this.detail_obj)))
                    }
                    this.detail_obj = {
                        country_id: 0,
                        prc_no: '',
                        prc_date: '',
                        realization_date: '',
                        buyer_org_name_en: '',
                        buyer_org_name_bn: '',
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
                this.$refs.form1.reset()
            })
        },
        countryName (Id) {
            const Obj = this.$store.state.CommonService.commonObj.countryList.find(item => item.value === Id)
            if (typeof Obj !== 'undefined') {
                return this.$i18n.locale === 'bn' ? Obj.text_bn : Obj.text_en
            } else {
                return ''
            }
        }
    }
}
</script>
