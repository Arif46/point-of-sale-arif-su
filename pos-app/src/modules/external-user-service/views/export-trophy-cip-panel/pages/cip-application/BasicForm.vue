<template>
    <b-row>
        <b-col md="12">
            <ValidationObserver ref="form"  v-slot="{ handleSubmit, reset }">
                <b-form @submit.prevent="handleSubmit(submit)" @reset.prevent="reset">
                    <b-overlay :show="unitLoad">
                        <template>
                            <div class="bg-primary">
                                <h5 class="text-white text-center"> {{ $t('globalTrans.basic_information') }}</h5>
                            </div>
                        </template>
                        <b-row class="mt-2">
                            <b-col lg="12" sm="12">
                                <ValidationProvider name="Circular Title" vid="circular_name" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="12"
                                        label-for="circular_name"
                                    >
                                    <template v-slot:label>
                                        {{ $t('exportTrophyCircular.circular') }} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="application.circular_name"
                                        disabled
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col xl="6" lg="6" sm="12">
                                <ValidationProvider name="Export Product Sector" vid="product_service_sector_id" rules="required|min_value:1" v-slot="{ errors }">
                                    <b-form-group
                                    label-for="product_service_sector_id"
                                    label-cols-sm="5"
                                    >
                                    <template v-slot:label>
                                    {{$t('externalUser.export_product_sector')}} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-select
                                    plain
                                    v-model="application.product_service_sector_id"
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
                                <ValidationProvider name="CIP Application Type" vid="app_type" rules="required|min_value:1" v-slot="{ errors }">
                                    <b-form-group
                                    label-for="app_type"
                                    label-cols-sm="5"
                                    >
                                    <template v-slot:label>
                                    {{$t('externalUser.cip_application_type')}} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-select
                                    plain
                                    v-model="application.app_type"
                                    :options="cipAppTypeList"
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
                            <b-col xl="6" lg="6" sm="12">
                                <ValidationProvider name="Latent Exporter" vid="latent_exporter" rules="required|min:1">
                                    <b-form-group
                                        label-for="latent_exporter"
                                        slot-scope="{ valid, errors }"
                                        label-cols-sm="5"
                                    >
                                    <template v-slot:label>
                                        {{ $t('externalUser.latent_exporter') }} <span class="text-danger">*</span>
                                    </template>
                                        <b-form-radio-group
                                        class="text-left"
                                        v-model="application.latent_exporter"
                                        :options="latentExporterList"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                        ></b-form-radio-group>
                                        <div class="invalid-feedback d-block">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                        </b-row>
                        <b-row class="mb-3">
                            <div class="bg-dark w-50 m-auto rounded-pill">
                                <h6 class="text-white text-center py-1"> {{ $t('externalUser.cip_applicants') + ' ' + $t('globalTrans.information') }}</h6>
                            </div>
                        </b-row>
                        <b-row>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="CIP Applicant's Name (En)" vid="name_en" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="name_en"
                                    >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.name') + ' ' + $t('globalTrans.en')}} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="application.name_en"
                                        disabled
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="CIP Applicant's Name (Bn)" vid="name_bn" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="name_bn"
                                    >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.name') + ' ' + $t('globalTrans.bn')}} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="application.name_bn"
                                        disabled
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Father's Name (En)" vid="father_name_en" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="father_name_en"
                                    >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.father_name') + ' ' + $t('globalTrans.en')}} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="application.father_name_en"
                                        disabled
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Father's Name (Bn)" vid="father_name_bn" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="father_name_bn"
                                    >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.father_name') + ' ' + $t('globalTrans.bn')}} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="application.father_name_bn"
                                        disabled
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Mother's Name (En)" vid="mother_name_en" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="mother_name_en"
                                    >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.mother_name') + ' ' + $t('globalTrans.en')}} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="application.mother_name_en"
                                        disabled
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Mother's Name (Bn)" vid="mother_name_bn" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="mother_name_bn"
                                    >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.mother_name') + ' ' + $t('globalTrans.bn')}} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="application.mother_name_bn"
                                        disabled
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Gender" vid='gender' rules="required|min_value:1" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="gender"
                                    >
                                        <template v-slot:label>
                                            {{ $t('globalTrans.gender') }} <span class="text-danger">*</span>
                                        </template>
                                        <b-form-select
                                            plain
                                            v-model="application.gender"
                                            disabled
                                            :options="genderList"
                                            id="gender"
                                            :state="errors[0] ? false : (valid ? true : null)"
                                        >
                                        <template v-slot:first>
                                            <b-form-select-option :value="0">{{$t('globalTrans.select')}}</b-form-select-option>
                                        </template>
                                        </b-form-select>
                                        <div class="invalid-feedback">
                                            {{ errors[0] }}
                                        </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Date of Birth" vid="dob" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-for="dob"
                                        label-cols-sm="5"
                                        >
                                        <template v-slot:label>
                                            {{ $t('globalTrans.dob') }} <span class="text-danger">*</span>
                                        </template>
                                        <b-form-datepicker
                                            id="dob"
                                            v-model="application.dob"
                                            disabled
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
                                <ValidationProvider name="NID No" vid="nid_no" rules="required|max:30" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="nid"
                                    >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.nid') }} <span class="text-danger">*</span>
                                        </template>
                                        <b-form-input
                                            v-model="application.nid"
                                            disabled
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            :state="errors[0] ? false : (valid ? true : null)"
                                        ></b-form-input>
                                        <div class="invalid-feedback">
                                            {{ errors[0] }}
                                        </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                        </b-row>
                        <b-row class="mb-3">
                            <div class="bg-dark w-50 m-auto rounded-pill">
                                <h6 class="text-white text-center py-1"> {{ $t('externalUser.cip_applicants') + ' ' + $t('externalUser.passport') + ' ' + $t('globalTrans.information') }}</h6>
                            </div>
                        </b-row>
                        <b-row>
                            <b-col xl="6" lg="6" sm="12">
                                <ValidationProvider name="Passport No." vid="passport_no" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="passport_no"
                                    >
                                    <template v-slot:label>
                                        {{ $t('externalUser.passport_no') }} <span class="text-danger">*</span>
                                        </template>
                                        <b-form-input
                                            v-model="application.passport_info.passport_no"
                                            :state="errors[0] ? false : (valid ? true : null)"
                                        ></b-form-input>
                                        <div class="invalid-feedback">
                                            {{ errors[0] }}
                                        </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col xl="6" lg="6" sm="12">
                                <ValidationProvider name="Issuing Country" vid="country_id" rules="required|min_value:1" v-slot="{ errors }">
                                    <b-form-group
                                    label-for="country_id"
                                    label-cols-sm="5"
                                    >
                                    <template v-slot:label>
                                    {{$t('externalUser.issuing_country')}} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-select
                                    plain
                                    v-model="application.passport_info.country_id"
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
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Issue Date" vid="issue_date" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-for="issue_date"
                                        label-cols-sm="5"
                                        >
                                        <template v-slot:label>
                                            {{ $t('externalUser.issue_date') }} <span class="text-danger">*</span>
                                        </template>
                                        <b-form-datepicker
                                            id="issue_date"
                                            v-model="application.passport_info.issue_date"
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
                                <ValidationProvider name="Duration." vid="duration" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="duration"
                                    >
                                    <template v-slot:label>
                                        {{ $t('externalUser.duration') }} <span class="text-danger">*</span>
                                        </template>
                                        <b-form-input
                                            v-model="application.passport_info.duration"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            :state="errors[0] ? false : (valid ? true : null)"
                                        ></b-form-input>
                                        <div class="invalid-feedback">
                                            {{ errors[0] }}
                                        </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                        </b-row>
                        <b-row class="mb-3">
                            <div class="bg-dark w-50 m-auto rounded-pill">
                                <h6 class="text-white text-center py-1"> {{ $t('externalUser.cip_applicants') + ' ' + $t('externalUser.tax') + ' ' + $t('globalTrans.information') }}</h6>
                            </div>
                        </b-row>
                        <b-row>
                            <b-col xl="6" lg="6" sm="12">
                                <ValidationProvider name="TIN No." vid="tin_no" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="tin_no"
                                    >
                                    <template v-slot:label>
                                        {{ $t('externalUser.tin_no') }} <span class="text-danger">*</span>
                                        </template>
                                        <b-form-input
                                            v-model="application.tax_info.tin_no"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            :state="errors[0] ? false : (valid ? true : null)"
                                        ></b-form-input>
                                        <div class="invalid-feedback">
                                            {{ errors[0] }}
                                        </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col xl="6" lg="6" sm="12">
                                <ValidationProvider name="TAX Circle" vid="tax_circle" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="tax_circle"
                                    >
                                    <template v-slot:label>
                                        {{ $t('externalUser.tax_circle') }} <span class="text-danger">*</span>
                                        </template>
                                        <b-form-input
                                            v-model="application.tax_info.tax_circle"
                                            :state="errors[0] ? false : (valid ? true : null)"
                                        ></b-form-input>
                                        <div class="invalid-feedback">
                                            {{ errors[0] }}
                                        </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col xl="6" lg="6" sm="12">
                                <ValidationProvider name="Tax Region (En)" vid="tax_region_en" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="tax_region_en"
                                    >
                                    <template v-slot:label>
                                        {{ $t('externalUser.tax_region_en') }} <span class="text-danger">*</span>
                                        </template>
                                        <b-form-input
                                            v-model="application.tax_info.tax_region_en"
                                            :state="errors[0] ? false : (valid ? true : null)"
                                        ></b-form-input>
                                        <div class="invalid-feedback">
                                            {{ errors[0] }}
                                        </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col xl="6" lg="6" sm="12">
                                <ValidationProvider name="Tax Region (Bn)" vid="tax_region_bn" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="tax_region_bn"
                                    >
                                    <template v-slot:label>
                                        {{ $t('externalUser.tax_region_bn') }} <span class="text-danger">*</span>
                                        </template>
                                        <b-form-input
                                            v-model="application.tax_info.tax_region_bn"
                                            :state="errors[0] ? false : (valid ? true : null)"
                                        ></b-form-input>
                                        <div class="invalid-feedback">
                                            {{ errors[0] }}
                                        </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                        </b-row>
                        <b-row class="mb-3">
                            <div class="bg-dark w-50 m-auto rounded-pill">
                                <h6 class="text-white text-center py-1"> {{ $t('externalUser.cip_applicants') + ' ' + $t('externalUser.contact') + ' ' + $t('globalTrans.information') }}</h6>
                            </div>
                        </b-row>
                        <b-row>
                            <b-col xl="6" lg="6" sm="12">
                                <ValidationProvider name="Telephone No." vid="telephone_no" rules="required|max:12" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="telephone_no"
                                    >
                                    <template v-slot:label>
                                        {{ $t('externalUser.telephone_no') }} <span class="text-danger">*</span>
                                        </template>
                                        <b-form-input
                                            v-model="application.contact_info.telephone_no"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            :state="errors[0] ? false : (valid ? true : null)"
                                        ></b-form-input>
                                        <div class="invalid-feedback">
                                            {{ errors[0] }}
                                        </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col xl="6" lg="6" sm="12">
                                <ValidationProvider name="Mobile No." vid="mobile" rules="required|max:11" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="mobile"
                                    >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.mobile') }} <span class="text-danger">*</span>
                                        </template>
                                        <b-form-input
                                            v-model="application.contact_info.mobile_no"
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
                                <ValidationProvider name="Email" vid="email" rules="email" v-slot="{ errors }">
                                    <b-form-group
                                        class="row"
                                        label-cols-sm="5"
                                        label-for="email"
                                    >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.email') }}
                                        </template>
                                        <b-form-input
                                            id="org_bn"
                                            type="email"
                                            v-model="application.contact_info.email"
                                            :state="errors[0] ? false : (valid ? true : null)"
                                        ></b-form-input>
                                        <div class="invalid-feedback">
                                        {{ errors[0] }}
                                        </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col xl="6" lg="6" sm="12">
                                <ValidationProvider name="Fax No." vid="fax_no" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="fax_no"
                                    >
                                    <template v-slot:label>
                                        {{ $t('externalUser.fax_no') }}
                                        </template>
                                        <b-form-input
                                            v-model="application.contact_info.fax_no"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            :state="errors[0] ? false : (valid ? true : null)"
                                        ></b-form-input>
                                        <div class="invalid-feedback">
                                            {{ errors[0] }}
                                        </div>
                                    </b-form-group>
                                </ValidationProvider>
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
import { cipApplicationBasicStoreApi, circularByIdApi } from '../../api/routes'
import { mapGetters } from 'vuex'

export default {
    props: ['app_id', 'application'],
    data () {
        return {
            errors: [],
            valid: null,
            unitLoad: false,
            circular: {}
        }
    },
    created () {
        if (this.$route.query.id) {
            this.circular = this.application.circular
        }
        if (this.$route.query.circular_id) {
            this.getCircular()
        }
    },
    watch: {
        currentLocale: function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.application.circular_name = this.$i18n.locale === 'bn' ? this.circular.title_bn : this.circular.title_en
            }
        }
    },
    computed: {
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
        countryList () {
            return this.$store.state.CommonService.commonObj.countryList.filter(item => item.status === 1)
        },
        genderList: function () {
            return this.$store.state.commonObj.genderList.map(el => {
                return Object.assign({ value: el.value, text: this.$i18n.locale === 'bn' ? el.text_bn : el.text_en })
            })
        },
        cipAppTypeList () {
            return this.$store.state.ExternalUserService.cipPanel.cipAppTypeList.map(el => {
                return Object.assign({}, el, { text: this.$i18n.locale === 'bn' ? el.text_bn : el.text_en })
            })
        },
        latentExporterList () {
            return this.$store.state.ExternalUserService.cipPanel.latentExporterList.map(el => {
                return Object.assign({}, el, { text: this.$i18n.locale === 'bn' ? el.text_bn : el.text_en })
            })
        },
        ...mapGetters({
            commonProfile: 'Auth/commonProfile',
            authUser: 'Auth/authUser'
        }),
        currentLocale () {
            return this.$i18n.locale
        }
    },
    methods: {
        async getCircular () {
            this.unitLoad = true
            const param = {
                circular_id: this.application.circular_id,
                app_type: 1,
                user_id: this.authUser.user_id
            }
            const result = await RestApi.getData(exportTrophyCIPServiceBaseUrl, circularByIdApi, param)
            if (result.success) {
                this.circular = result.data
                this.application.circular_name = this.$i18n.locale === 'bn' ? this.circular.title_bn : this.circular.title_en
                this.application.year = this.getYear(result.data.fiscal_year_id)
                this.unitLoad = false
            } else {
                this.$toast.error({
                    title: '!',
                    message: result.message,
                    color: '#D6E09B'
                })
                this.$router.push({ path: 'circular' })
                this.unitLoad = false
            }
        },
        async submit () {
            var check = await this.$refs.form.validate()
            if (check) {
                this.unitLoad = true
                this.$store.dispatch('mutateCommonProperties', { loading: true })
                const loadingState = { loading: false, listReload: false }
                this.application.app_id = this.app_id
                const result = await RestApi.postData(exportTrophyCIPServiceBaseUrl, cipApplicationBasicStoreApi, this.application)
                loadingState.listReload = true
                this.$store.dispatch('mutateCommonProperties', loadingState)
                this.unitLoad = false
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
        },
        getYear (fiscalYearId) {
            const fiscalYear = this.$store.state.CommonService.commonObj.fiscalYearList.find(item => item.value === fiscalYearId)
            return fiscalYear.text_en.split('-')[0]
        }
    }
}
</script>
