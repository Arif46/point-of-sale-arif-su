<template>
    <ValidationObserver ref="form2"  v-slot="{ handleSubmit, reset }">
        <b-form @submit.prevent="handleSubmit(addItem)" @reset.prevent="reset">
            <b-overlay :show="unitLoad">
                <b-row>
                    <b-col xl="6" lg="6" sm="12">
                        <ValidationProvider name="Selection Year" vid="selection_year" rules="required|min_value:1" v-slot="{ errors }">
                            <b-form-group
                            label-for="selection_year"
                            label-cols-sm="5"
                            >
                            <template v-slot:label>
                            {{$t('externalUser.selection_year')}} <span class="text-danger">*</span>
                            </template>
                            <b-form-select
                            plain
                            v-model="detail_obj.selection_year"
                            :options="yearList"
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
                        <ValidationProvider name="Product Sector" vid="product_sector_id" rules="required|min_value:1" v-slot="{ errors }">
                            <b-form-group
                            label-for="product_sector_id"
                            label-cols-sm="5"
                            >
                            <template v-slot:label>
                            {{$t('externalUser.product_sector')}} <span class="text-danger">*</span>
                            </template>
                            <b-form-select
                            plain
                            v-model="detail_obj.product_sector_id"
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
                                <th scope="col">{{ $t('externalUser.selection_year') }}</th>
                                <th scope="col">{{ $t('externalUser.product_name') }}</th>
                                <th width="10%" class="text-center">{{ $t('globalTrans.action') }}</th>
                            </tr>
                        </thead>
                        <b-tbody>
                            <b-tr v-for="(item, index) in selecteds" :key="index">
                                <b-td class="text-center">{{ $n(index + 1) }}</b-td>
                                <b-td>{{ $n(item.selection_year, { useGrouping: false }) }}</b-td>
                                <b-td>{{ productName(item.product_sector_id) }}</b-td>
                                <b-td class="text-center">
                                    <b-button @click="editItem(item, index)" title="Edit" class="btn btn-success btn-sm mr-1"><i class="ri-pencil-fill m-0"></i></b-button>
                                    <b-button type="button" @click="deleteItem(index)" title="Delete" class="btn btn-danger" size="sm"><i class="ri-delete-bin-2-line"></i></b-button>
                                </b-td>
                            </b-tr>
                            <b-tr v-if="selecteds.length <= 0">
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
    props: ['selecteds'],
    data () {
      return {
        valid: null,
        unitLoad: false,
        editIndex: '',
        detail_obj: {
            selection_year: 0,
            product_sector_id: 0
        }
      }
    },
    computed: {
        yearList: function () {
            return this.$store.state.commonObj.yearList.map(item => {
                if (this.$i18n.locale === 'bn') {
                    return { value: item, text: this.$n(item, { useGrouping: false }) }
                } else {
                    return { value: item, text: item }
                }
            })
        },
    exportSectorList () {
      return this.$store.state.ExternalUserService.cipPanel.commonObj.exportSectorList.filter(item => item.status === 1 && item.assign_for === 1).map(item => {
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
            this.selecteds.splice(index, 1)
        },
        async addItem () {
            let result = []
            if (this.editIndex !== '') {
                const editList = [...this.selecteds]
                editList.splice(parseInt(this.editIndex), 1)
                result = [...editList]
            } else {
                result = this.selecteds
            }
            const selectionYear = this.detail_obj.selection_year
            const productSectorId = this.detail_obj.product_sector_id
            const newData = result.find(item => parseInt(item.selection_year) === selectionYear && parseInt(item.product_sector_id) === productSectorId)
            if (typeof newData === 'undefined') {
                    if (this.editIndex !== '') {
                        this.selecteds[parseInt(this.editIndex)] = this.detail_obj
                    } else {
                        this.selecteds.push(JSON.parse(JSON.stringify(this.detail_obj)))
                    }
                    this.detail_obj = {
                        selection_year: 0,
                        product_sector_id: 0
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
