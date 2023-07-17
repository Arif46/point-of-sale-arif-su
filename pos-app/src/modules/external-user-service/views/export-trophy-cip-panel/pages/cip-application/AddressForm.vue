<template>
    <b-row>
        <b-col md="12">
            <ValidationObserver ref="form"  v-slot="{ handleSubmit, reset }">
                <b-form @submit.prevent="handleSubmit(submit)" @reset.prevent="reset">
                    <b-overlay :show="loading">
                        <!-- <template>
                            <div class="bg-primary">
                                <h5 class="text-white text-center"> {{ $t('externalUser.cip_applicants') + ' ' + $t('globalTrans.address') }}</h5>
                            </div>
                        </template> -->
                        <b-row class="mb-3">
                            <div class="bg-dark w-50 m-auto rounded-pill">
                                <h6 class="text-white text-center py-1"> {{ $t('externalUser.cip_applicants') + ' ' + $t('globalTrans.address') }}</h6>
                            </div>
                        </b-row>
                        <b-row class="mt-2">
                            <b-col sm="12" style="max-width: 22%">
                                <p class="text-black" style="border-bottom: 1px solid #ddd; font-weight: bold">
                                    {{ $t('globalTrans.present_address') + ' :' }}
                                </p>
                            </b-col>
                            <b-col v-if="isShow" lg="12" md="12" sm="12">
                                <Address :data="address.pr_address" :addressType="'present'" :param="fieldObj" @pr-address-data="receivePrAddress" title="Present Address"/>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Address Status" vid="is_same" v-slot="{ errors }">
                                    <b-form-group
                                        class="row mb-0"
                                        label-cols-sm="5"
                                        label-for="is_same"
                                    >
                                    <template v-slot:label>
                                        <div style="border-bottom: 1px solid #ddd; font-weight: bold">
                                            {{ $t('globalTrans.permanent_address') + ' :' }}
                                        </div>
                                    </template>
                                    <b-form-checkbox
                                        v-model="address.is_same_as_present"
                                        @change="isSameAsPermanent($event)"
                                        value="1"
                                        unchecked-value="0"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    >
                                    <span class="text-black">{{ $t('globalTrans.same') + ' ?' }}</span>
                                    </b-form-checkbox>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col v-if="isShow" lg="12" md="12" sm="12">
                                <Address :data="address.pm_address" :addressType="'permanent'" :param="fieldObj" @pm-address-data="receivePmAddress" title="Permanent Address"/>
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
import { cipApplicationAddressStoreApi } from '../../api/routes'
import { EventBus } from '@/EventBusLayout'
import Address from '@/components/Address.vue'

export default {
  props: ['app_id', 'address', 'isShow'],
    components: { Address },
    data () {
        return {
            fieldObj: {
                xl: 6,
                lg: 6,
                md: 6,
                sm: 12,
                labelCols: 5,
                noAddress: true
            },
            errors: [],
            valid: null,
            loading: false
        }
    },
    created () {
    },
    watch: {
    },
    computed: {
        currentLocale () {
            return this.$i18n.locale
        }
    },
    methods: {
        isSameAsPermanent (val) {
            const Obj = {
                is_same: val,
                pr_address: this.address.pr_address
            }
            EventBus.$emit('SAME_ADDRESS', Obj)
        },
        receivePrAddress (address) {
            this.address.pr_address = address
        },
        receivePmAddress (address) {
            this.address.pm_address = address
        },
        async submit () {
            this.loading = true
            var check = await this.$refs.form.validate()
            if (check) {
                this.$store.dispatch('mutateCommonProperties', { loading: true })
                const loadingState = { loading: false, listReload: false }
                this.address.app_id = this.app_id
                let result = null
                if (this.app_id) {
                  result = await RestApi.postData(exportTrophyCIPServiceBaseUrl, cipApplicationAddressStoreApi, this.address)
                }
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
