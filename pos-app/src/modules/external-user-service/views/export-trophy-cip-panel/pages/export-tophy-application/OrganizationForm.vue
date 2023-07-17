<template>
    <b-row>
        <b-col md="12">
            <ValidationObserver ref="form"  v-slot="{ handleSubmit, reset }">
                <b-form @submit.prevent="handleSubmit(submit)" @reset.prevent="reset">
                    <b-overlay :show="loading">
                        <b-row class="mb-3">
                            <div class="bg-dark w-50 m-auto rounded-pill">
                                <h5 class="text-white text-center"> {{ $t('externalUser.org_owner_info') }}</h5>
                            </div>
                        </b-row>
                        <b-row>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Owner's Name (En)" vid="orgTab.owner_info.owner_name_en" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                      label-cols-sm="5"
                                      label-for="orgTab.owner_info.owner_name_en"
                                    >
                                    <template v-slot:label>
                                      {{ $t('globalTrans.name') + ' ' + $t('globalTrans.en')}} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.owner_info.owner_name_en"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                      {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Owner's Name (Bn)" vid="orgTab.owner_info.owner_name_bn" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="orgTab.owner_info.owner_name_bn"
                                    >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.name') + ' ' + $t('globalTrans.bn')}} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.owner_info.owner_name_bn"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Father's Name (En)" vid="orgTab.owner_info.father_husband_name_en" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="orgTab.owner_info.father_husband_name_en"
                                    >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.father_name') + ' ' + $t('globalTrans.en')}} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.owner_info.father_husband_name_en"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Father's Name (Bn)" vid="orgTab.owner_info.father_husband_name_bn" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="orgTab.owner_info.father_husband_name_en"
                                    >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.father_name') + ' ' + $t('globalTrans.bn')}} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.owner_info.father_husband_name_bn"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Mother's Name (En)" vid="orgTab.owner_info.mother_name_en" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="orgTab.owner_info.mother_name_en"
                                    >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.mother_name') + ' ' + $t('globalTrans.en')}} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.owner_info.mother_name_en"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Mother's Name (Bn)" vid="orgTab.owner_info.mother_name_bn" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="orgTab.owner_info.mother_name_bn"
                                    >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.mother_name') + ' ' + $t('globalTrans.bn')}} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.owner_info.mother_name_bn"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Designation (Bn)" vid="orgTab.owner_info.designation_en" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="orgTab.owner_info.designation_en"
                                    >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.designation') + ' ' + $t('globalTrans.en')}} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.owner_info.designation_en"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Designation (Bn)" vid="orgTab.owner_info.designation_bn" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="orgTab.owner_info.designation_bn"
                                    >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.designation') + ' ' + $t('globalTrans.bn')}} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.owner_info.designation_bn"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col xl="6" lg="6" sm="12">
                                <ValidationProvider name="NID No" vid="orgTab.owner_info.nid_no" rules="required|max:14" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="orgTab.owner_info.nid_no"
                                    >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.nid') }} <span class="text-danger">*</span>
                                        </template>
                                        <b-form-input
                                            v-model="orgTab.owner_info.nid_no"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            :state="errors[0] ? false : (valid ? true : null)"
                                        ></b-form-input>
                                        <div class="invalid-feedback">
                                            {{ errors[0] }}
                                        </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Date of Birth" vid="orgTab.owner_info.dob" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-for="orgTab.owner_info.dob"
                                        label-cols-sm="5"
                                        >
                                        <template v-slot:label>
                                            {{ $t('globalTrans.dob') }} <span class="text-danger">*</span>
                                        </template>
                                        <b-form-datepicker b-form-datepicker
                                            id="dob"
                                            v-model="orgTab.owner_info.dob"
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
                                <ValidationProvider name="Smart Id No" vid="orgTab.owner_info.smart_id_no" rules="" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="orgTab.owner_info.smart_id_no"
                                    >
                                    <template v-slot:label>
                                        {{ $t('externalUser.smart_id_no') }}
                                        </template>
                                        <b-form-input
                                            v-model="orgTab.owner_info.smart_id_no"
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
                                <h5 class="text-white text-center"> {{ $t('externalUser.org_owner_passport_info') }}</h5>
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
                                            v-model="orgTab.passport_info.passport_no"
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
                                    v-model="orgTab.passport_info.country_id"
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
                                        <b-form-datepicker b-form-datepicker
                                            id="issue_date"
                                            v-model="orgTab.passport_info.issue_date"
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
                                            v-model="orgTab.passport_info.duration"
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
                                <h5 class="text-white text-center"> {{ $t('externalUser.owner_tax_info') }}</h5>
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
                                            v-model="orgTab.tax_info.tin_no"
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
                                            v-model="orgTab.tax_info.tax_circle"
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
                                            v-model="orgTab.tax_info.tax_region_en"
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
                                            v-model="orgTab.tax_info.tax_region_bn"
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
                                <h5 class="text-white text-center"> {{ $t('externalUser.owner_contact_info') }}</h5>
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
                                            v-model="orgTab.contact_info.telephone_no"
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
                                <ValidationProvider name="Mobile No." vid="mobile" rules="required|min:11|max:11" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="mobile"
                                    >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.mobile') }} <span class="text-danger">*</span>
                                        </template>
                                        <b-form-input
                                            v-model="orgTab.contact_info.mobile_no"
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
                                            v-model="orgTab.contact_info.email"
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
                                            v-model="orgTab.contact_info.fax_no"
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
                                <h5 class="text-white text-center"> {{ $t('externalUser.entrepreneur') }}</h5>
                            </div>
                        </b-row>
                        <b-row>
                            <b-col class="offset-3" xl="6" lg="6" sm="12">
                                <ValidationProvider vid="is_woman_entrepreneur" rules="required|min_value:1" v-slot="{ errors }">
                                    <b-form-group
                                    label-for="is_woman_entrepreneur"
                                    label-cols-sm="5"
                                    >
                                    <b-form-checkbox
                                        v-model="orgTab.passport_info.women_entrepreneur"
                                        name="women_entrepreneur"
                                        value="1"
                                        unchecked-value="2"
                                    >
                                        {{ $t('externalUser.is_woman_entrepreneur') }}
                                    </b-form-checkbox>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                        </b-row>
                        <b-row v-if="parseInt(orgTab.passport_info.women_entrepreneur) === 1">
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Woman Entreprenure's Name (En)" vid="name_en" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                      label-cols-sm="5"
                                      label-for="name_en"
                                    >
                                    <template v-slot:label>
                                      {{ $t('globalTrans.name') + ' ' + $t('globalTrans.en')}} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.entrepreneurs.name_en"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                      {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Woman Entreprenure's Name (Bn)" vid="name_bn" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                      label-cols-sm="5"
                                      label-for="name_bn"
                                    >
                                    <template v-slot:label>
                                      {{ $t('globalTrans.name') + ' ' + $t('globalTrans.bn')}} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.entrepreneurs.name_bn"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                      {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Designation (Bn)" vid="orgTab.entrepreneurs.designation_en" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="orgTab.entrepreneurs.designation_en"
                                    >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.designation') + ' ' + $t('globalTrans.en')}} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.entrepreneurs.designation_en"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Designation (Bn)" vid="orgTab.entrepreneurs.designation_bn" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="orgTab.entrepreneurs.designation_bn"
                                    >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.designation') + ' ' + $t('globalTrans.bn')}} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.entrepreneurs.designation_bn"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="License No" vid="orgTab.entrepreneurs.license_no" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="orgTab.entrepreneurs.license_no"
                                    >
                                    <template v-slot:label>
                                        {{ $t('externalUser.license_no') }} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.entrepreneurs.license_no"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Copy of update license" vid="orgTab.entrepreneurs.update_license_no" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="orgTab.entrepreneurs.update_license_no"
                                    >
                                    <template v-slot:label>
                                        {{ $t('externalUser.update_license_no') }} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.entrepreneurs.license"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Certification of concern bank" vid="orgTab.entrepreneurs.certification_of_concern_bank" rules="required" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="orgTab.entrepreneurs.certification_of_concern_bank"
                                    >
                                    <template v-slot:label>
                                        {{ $t('externalUser.certification_of_concern_bank') }} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.entrepreneurs.certificate"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                            <b-col lg="6" sm="12">
                                <ValidationProvider name="Direct involved bussness" vid="orgTab.entrepreneurs.direct_involved_bussness" rules="" v-slot="{ errors }">
                                    <b-form-group
                                        label-cols-sm="5"
                                        label-for="orgTab.entrepreneurs.direct_involved_bussness"
                                    >
                                        <b-form-checkbox
                                            v-model="orgTab.entrepreneurs.directly_involced_business"
                                            name="directly_involced_business"
                                            value="1"
                                            unchecked-value="2"
                                        >
                                            {{ $t('externalUser.direct_involved_bussness') }}
                                        </b-form-checkbox>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                    </b-form-group>
                                </ValidationProvider>
                            </b-col>
                        </b-row>
                        <b-row v-if="parseInt(orgTab.passport_info.women_entrepreneur) === 1">
                            <b-col class="mb-2" sm="12">
                                <p class="text-black" style="border-bottom: 1px solid #ddd; font-weight: bold">
                                    {{ $t('externalUser.name_of_porduct_and_service') }}
                                </p>
                            </b-col>
                            <b-col lg="12" v-for="(item, index) in orgTab.entrepreneurs.product_service_name_details" :key="index">
                                <b-row>
                                    <b-col sm="5" lg="5">
                                      <ValidationProvider name="Product or service name" :vid="`entrepreneurs.product_service_name_details${[index]}.name_en${index}`" :rules="'required'" v-slot="{ errors }">
                                            <b-form-group
                                                label-class="mr-3"
                                                :label-for="`item.name_en${index}`"
                                            >
                                            <template v-slot:label>
                                                {{ $t('externalUser.product_service_name') + $t('globalTrans.en') }} <span class="text-danger">*</span>
                                            </template>
                                              <b-form-input
                                                  v-model="item.name_en"
                                                  :state="errors[0] ? false : (valid ? true : null)"
                                              >
                                              </b-form-input>
                                              <div class="invalid-feedback">
                                                  {{ errors[0] }}
                                              </div>
                                            </b-form-group>
                                      </ValidationProvider>
                                    </b-col>
                                    <b-col sm="5" lg="5">
                                      <ValidationProvider name="Product or service name (Bn)" :vid="`entrepreneurs.product_service_name_details${[index]}.name_bn${index}`" :rules="'required'" v-slot="{ errors }">
                                            <b-form-group
                                                label-class="mr-3"
                                                :label-for="`item.name_bn${index}`"
                                            >
                                            <template v-slot:label>
                                                {{ $t('externalUser.product_service_name') + $t('globalTrans.bn') }} <span class="text-danger">*</span>
                                            </template>
                                              <b-form-input
                                                  v-model="item.name_bn"
                                                  :state="errors[0] ? false : (valid ? true : null)"
                                              >
                                              </b-form-input>
                                              <div class="invalid-feedback">
                                                  {{ errors[0] }}
                                              </div>
                                            </b-form-group>
                                      </ValidationProvider>
                                    </b-col>
                                    <b-col sm="2" lg="2" class="mt-3">
                                        <button type="button" class="btn btn-primary btn-sm mr-2" @click="addItem(index)" title="Add More"><i class="ri-add-line m-0"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" v-if="orgTab.entrepreneurs.product_service_name_details.length > 1" @click="deleteItem(index)" title="Delete"><i class="ri-delete-bin-line m-0"></i></button>
                                    </b-col>
                                  </b-row>
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
import { etApplicationOrgStoreApi } from '../../api/routes'
import { mapGetters } from 'vuex'

export default {
    props: ['app_id', 'orgTab'],
    data () {
      return {
        errors: [],
        valid: null,
        loading: false
      }
    },
    created () {
    },
    computed: {
      countryList () {
        return this.$store.state.CommonService.commonObj.countryList.filter(item => item.status === 1)
      },
      genderList: function () {
        return this.$store.state.commonObj.genderList.map(el => {
          return Object.assign({ value: el.value, text: this.$i18n.locale === 'bn' ? el.text_bn : el.text_en })
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
        addItem (index) {
            const obj = { name_en: '', name_bn: '' }
            this.orgTab.entrepreneurs.product_service_name_details.push(obj)
        },
        deleteItem (index) {
          this.orgTab.entrepreneurs.product_service_name_details.splice(index, 1)
        },
        async submit () {
          var check = await this.$refs.form.validate()
          if (check) {
            this.loading = true
            this.$store.dispatch('mutateCommonProperties', { loading: true })
            const loadingState = { loading: false, listReload: false }
            this.orgTab.app_id = this.app_id
            const result = await RestApi.postData(exportTrophyCIPServiceBaseUrl, etApplicationOrgStoreApi, this.orgTab)
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
