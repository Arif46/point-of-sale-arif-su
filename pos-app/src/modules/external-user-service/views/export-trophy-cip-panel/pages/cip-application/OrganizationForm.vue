<template>
  <b-row>
    <b-col md="12">
        <ValidationObserver ref="form"  v-slot="{ handleSubmit, reset }">
            <b-form @submit.prevent="handleSubmit(submit)" @reset.prevent="reset">
                <b-overlay :show="loading">
                    <b-row class="mb-3">
                        <div class="bg-dark w-50 m-auto rounded-pill">
                            <h6 class="text-white text-center py-1"> {{ $t('externalUser.org_info') }}</h6>
                        </div>
                    </b-row>
                    <b-row>
                        <b-col xl="6" lg="6" sm="12">
                          <ValidationProvider name="Owner Name(En)" vid="org_info.owner_name_en" rules="required" v-slot="{ errors }">
                              <b-form-group
                                  label-cols-sm="5"
                                  label-for="owner_name_en"
                              >
                              <template v-slot:label>
                                  {{ $t('externalUser.owner_name_en') }} <span class="text-danger">*</span>
                                  </template>
                                  <b-form-input
                                      v-model="orgTab.org_info.owner_name_en"
                                      :state="errors[0] ? false : (valid ? true : null)"
                                  ></b-form-input>
                                  <div class="invalid-feedback">
                                      {{ errors[0] }}
                                  </div>
                              </b-form-group>
                          </ValidationProvider>
                        </b-col>
                        <b-col xl="6" lg="6" sm="12">
                          <ValidationProvider name="Owner Name(Bn)" vid="org_info.owner_name_bn" rules="required" v-slot="{ errors }">
                              <b-form-group
                                  label-cols-sm="5"
                                  label-for="owner_name_bn"
                              >
                              <template v-slot:label>
                                  {{ $t('externalUser.owner_name_bn') }} <span class="text-danger">*</span>
                                  </template>
                                  <b-form-input
                                      v-model="orgTab.org_info.owner_name_bn"
                                      :state="errors[0] ? false : (valid ? true : null)"
                                  ></b-form-input>
                                  <div class="invalid-feedback">
                                      {{ errors[0] }}
                                  </div>
                              </b-form-group>
                          </ValidationProvider>
                        </b-col>
                        <b-col xl="6" lg="6" sm="12">
                          <ValidationProvider name="Organization Name(En)" vid="org_info.org_name_en" rules="required" v-slot="{ errors }">
                              <b-form-group
                                  label-cols-sm="5"
                                  label-for="org_name_en"
                              >
                              <template v-slot:label>
                                  {{ $t('externalUser.org_name_en') }} <span class="text-danger">*</span>
                                  </template>
                                  <b-form-input
                                      v-model="orgTab.org_info.org_name_en"
                                      :state="errors[0] ? false : (valid ? true : null)"
                                  ></b-form-input>
                                  <div class="invalid-feedback">
                                      {{ errors[0] }}
                                  </div>
                              </b-form-group>
                          </ValidationProvider>
                        </b-col>
                        <b-col xl="6" lg="6" sm="12">
                          <ValidationProvider name="Organization Name(Bn)" vid="org_info.org_name_bn" rules="required" v-slot="{ errors }">
                              <b-form-group
                                  label-cols-sm="5"
                                  label-for="org_name_bn"
                              >
                              <template v-slot:label>
                                  {{ $t('externalUser.org_name_bn') }} <span class="text-danger">*</span>
                                  </template>
                                  <b-form-input
                                      v-model="orgTab.org_info.org_name_bn"
                                      :state="errors[0] ? false : (valid ? true : null)"
                                  ></b-form-input>
                                  <div class="invalid-feedback">
                                      {{ errors[0] }}
                                  </div>
                              </b-form-group>
                          </ValidationProvider>
                        </b-col>
                        <b-col xl="6" lg="6" sm="12">
                          <ValidationProvider name="Designation (En)" vid="org_info.designation_en" rules="required" v-slot="{ errors }">
                              <b-form-group
                                  label-cols-sm="5"
                                  label-for="designation_en"
                              >
                              <template v-slot:label>
                                  {{ $t('externalUser.designation_en') }} <span class="text-danger">*</span>
                                  </template>
                                  <b-form-input
                                      v-model="orgTab.org_info.designation_en"
                                      :state="errors[0] ? false : (valid ? true : null)"
                                  ></b-form-input>
                                  <div class="invalid-feedback">
                                      {{ errors[0] }}
                                  </div>
                              </b-form-group>
                          </ValidationProvider>
                        </b-col>
                        <b-col xl="6" lg="6" sm="12">
                          <ValidationProvider name="Designation (Bn)" vid="org_info.designation_bn" rules="required" v-slot="{ errors }">
                              <b-form-group
                                  label-cols-sm="5"
                                  label-for="designation_bn"
                              >
                              <template v-slot:label>
                                  {{ $t('externalUser.designation_bn') }} <span class="text-danger">*</span>
                                  </template>
                                  <b-form-input
                                      v-model="orgTab.org_info.designation_bn"
                                      :state="errors[0] ? false : (valid ? true : null)"
                                  ></b-form-input>
                                  <div class="invalid-feedback">
                                      {{ errors[0] }}
                                  </div>
                              </b-form-group>
                          </ValidationProvider>
                        </b-col>
                        <b-col xl="6" lg="6" sm="12">
                          <ValidationProvider name="Bin No" vid="org_info.bin_no" rules="required" v-slot="{ errors }">
                              <b-form-group
                                  label-cols-sm="5"
                                  label-for="bin_no"
                              >
                              <template v-slot:label>
                                  {{ $t('externalUser.bin_no') }} <span class="text-danger">*</span>
                                  </template>
                                  <b-form-input
                                      v-model="orgTab.org_info.bin_no"
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
                          <ValidationProvider name="Organization Type" vid="org_info.org_type" rules="required|min_value:1" v-slot="{ errors }">
                              <b-form-group
                              label-for="org_type"
                              label-cols-sm="5"
                              >
                                <template v-slot:label>
                                  {{$t('externalUser.org_type')}} <span class="text-danger">*</span>
                                </template>
                              <b-form-select
                                plain
                                v-model="orgTab.org_info.org_type"
                                :options="orgTypeList"
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
                          <ValidationProvider vid="org_info.epz_affiliated_org" rules="min_value:1" v-slot="{ errors }">
                              <b-form-group
                              label-for="epz_affiliated_org"
                              label-cols-sm="5"
                              >
                              <b-form-checkbox
                                v-model="orgTab.org_info.epz_affiliated_org"
                                name="epz_affiliated_org"
                                value="1"
                                unchecked-value="2"
                              >
                               {{ $t('externalUser.epz_affiliated_org') }}
                              </b-form-checkbox>
                              <div class="invalid-feedback">
                                {{ errors[0] }}
                              </div>
                              </b-form-group>
                          </ValidationProvider>
                        </b-col>
                        <b-col xl="6" lg="6" sm="12">
                          <ValidationProvider vid="org_info.bangladeshi_owned_company" rules="min_value:1" v-slot="{ errors }">
                              <b-form-group
                              label-for="bangladeshi_owned_company"
                              label-cols-sm="5"
                              >
                              <b-form-checkbox
                                v-model="orgTab.org_info.bangladeshi_owned_company"
                                name="bangladeshi_owned_company"
                                value="1"
                                unchecked-value="2"
                              >
                                {{ $t('externalUser.bangladeshi_owned_compnay') }}
                              </b-form-checkbox>
                              <div class="invalid-feedback">
                                {{ errors[0] }}
                              </div>
                              </b-form-group>
                          </ValidationProvider>
                        </b-col>
                    </b-row>
                    <b-row class="mb-3">
                        <div class="bg-dark w-50 m-auto rounded-pill">
                            <h6 class="text-white text-center py-1"> {{ $t('externalUser.org_tax_info') }}</h6>
                        </div>
                    </b-row>
                    <b-row>
                        <b-col xl="6" lg="6" sm="12">
                            <ValidationProvider name="TIN No." vid="org_tax_info.tin_no" rules="required" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="tin_no"
                                >
                                    <template v-slot:label>
                                    {{ $t('externalUser.tin_no') }} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.org_tax_info.tin_no"
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
                            <ValidationProvider name="TAX Circle" vid="org_tax_info.tax_circle" rules="required" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="tax_circle"
                                >
                                <template v-slot:label>
                                    {{ $t('externalUser.tax_circle') }} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.org_tax_info.tax_circle"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                        <b-col xl="6" lg="6" sm="12">
                            <ValidationProvider name="Tax Region (En)" vid="org_tax_info.tax_region_en" rules="required" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="tax_region_en"
                                >
                                <template v-slot:label>
                                    {{ $t('externalUser.tax_region_en') }} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.org_tax_info.tax_region_en"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                        <b-col xl="6" lg="6" sm="12">
                            <ValidationProvider name="Tax Region (Bn)" vid="org_tax_info.tax_region_bn" rules="required" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="tax_region_bn"
                                >
                                <template v-slot:label>
                                    {{ $t('externalUser.tax_region_bn') }} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.org_tax_info.tax_region_bn"
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
                            <h6 class="text-white text-center py-1"> {{ $t('externalUser.office_contact_info') }}</h6>
                        </div>
                    </b-row>
                    <b-row>
                        <b-col xl="6" lg="6" sm="12">
                            <ValidationProvider name="Telephone No." vid="office_contact_info.telephone_no" rules="required|max:12" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="telephone_no"
                                >
                                <template v-slot:label>
                                    {{ $t('externalUser.telephone_no') }} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.office_contact_info.telephone_no"
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
                            <ValidationProvider name="Mobile No." vid="office_contact_info.mobile_no" rules="required|max:11" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="mobile_no"
                                >
                                <template v-slot:label>
                                    {{ $t('globalTrans.mobile') }} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.office_contact_info.mobile_no"
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
                            <ValidationProvider name="Email" vid="office_contact_info.email" rules="required|email" v-slot="{ errors }">
                                <b-form-group
                                    class="row"
                                    label-cols-sm="5"
                                    label-for="email"
                                >
                                <template v-slot:label>
                                    {{ $t('globalTrans.email') }} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        id="org_bn"
                                        type="email"
                                        v-model="orgTab.office_contact_info.email"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                    {{ errors[0] }}
                                    </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                        <b-col xl="6" lg="6" sm="12">
                            <ValidationProvider name="Fax No." vid="office_contact_info.fax_no" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="fax_no"
                                >
                                <template v-slot:label>
                                    {{ $t('externalUser.fax_no') }}
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.office_contact_info.fax_no"
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
                            <h6 class="text-white text-center py-1"> {{ $t('externalUser.factory_contact_info') }}</h6>
                        </div>
                    </b-row>
                    <b-row>
                        <b-col xl="6" lg="6" sm="12">
                            <ValidationProvider name="Telephone No." vid="factory_contact_info.telephone_no" rules="required|max:12" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="factory_contact_info.telephone_no"
                                >
                                <template v-slot:label>
                                    {{ $t('externalUser.telephone_no') }} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.factory_contact_info.telephone_no"
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
                            <ValidationProvider name="Mobile No." vid="factory_contact_info.mobile_no" rules="required|max:11" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="mobile_no"
                                >
                                <template v-slot:label>
                                    {{ $t('globalTrans.mobile') }} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.factory_contact_info.mobile_no"
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
                            <ValidationProvider name="Email" vid="factory_contact_info.email" rules="required|email" v-slot="{ errors }">
                                <b-form-group
                                    class="row"
                                    label-cols-sm="5"
                                    label-for="email"
                                >
                                <template v-slot:label>
                                    {{ $t('globalTrans.email') }} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        id="org_bn"
                                        type="email"
                                        v-model="orgTab.factory_contact_info.email"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                    {{ errors[0] }}
                                    </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                        <b-col xl="6" lg="6" sm="12">
                            <ValidationProvider name="Fax No." vid="factory_contact_info.fax_no" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="fax_no"
                                >
                                <template v-slot:label>
                                    {{ $t('externalUser.fax_no') }}
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.factory_contact_info.fax_no"
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
                            <h6 class="text-white text-center py-1"> {{ $t('externalUser.contact_person_info') }}</h6>
                        </div>
                    </b-row>
                    <b-row>
                        <b-col lg="6" sm="12">
                            <ValidationProvider name="Contact Person's Name (En)" vid="contact_person_info.name_en" rules="required" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="name_en"
                                >
                                <template v-slot:label>
                                    {{ $t('globalTrans.name') + ' ' + $t('globalTrans.en')}} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    v-model="orgTab.contact_person_info.name_en"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                        <b-col lg="6" sm="12">
                            <ValidationProvider name="Contact Person's Name (Bn)" vid="contact_person_info.name_bn" rules="required" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="name_bn"
                                >
                                <template v-slot:label>
                                    {{ $t('globalTrans.name') + ' ' + $t('globalTrans.bn')}} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    v-model="orgTab.contact_person_info.name_bn"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                        <b-col lg="6" sm="12">
                            <ValidationProvider name="Contact Person's Designation (En)" vid="contact_person_info.designation_en" rules="required" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="designation_en"
                                >
                                <template v-slot:label>
                                    {{ $t('globalTrans.designation') + ' ' + $t('globalTrans.en')}} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    v-model="orgTab.contact_person_info.designation_en"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                        <b-col lg="6" sm="12">
                            <ValidationProvider name="Contact Person's Designation (Bn)" vid="contact_person_info.designation_bn" rules="required" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="designation_en"
                                >
                                <template v-slot:label>
                                    {{ $t('globalTrans.designation') + ' ' + $t('globalTrans.bn')}} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    v-model="orgTab.contact_person_info.designation_bn"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                        <b-col xl="6" lg="6" sm="12">
                            <ValidationProvider name="Mobile No." vid="contact_person_info.mobile_no" rules="required|max:11" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="mobile_no"
                                >
                                <template v-slot:label>
                                    {{ $t('globalTrans.mobile') }} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="orgTab.contact_person_info.mobile"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
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
                            <h6 class="text-white text-center py-1"> {{ $t('externalUser.org_address') }}</h6>
                        </div>
                    </b-row>
                    <b-row class="mt-2">
                        <b-col v-if="isShow" lg="12" md="12" sm="12">
                            <Address :data="pr_address" :addressType="'present'" :param="fieldObj" @pr-address-data="receivePrAddress" title="Present Address"/>
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
import { cipApplicationOrganizationStoreApi } from '../../api/routes'
import Address from '@/components/Address.vue'

export default {
    props: ['app_id', 'orgTab', 'isShow'],
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
        pr_address: {},
        valid: null,
        loading: false
      }
    },
    created () {
        if (this.$route.query.id) {
            if (this.orgTab.org_address) {
                this.pr_address = {
                    pr_area_type_id: this.orgTab.org_address.area_type_id,
                    pr_division_id: this.orgTab.org_address.division_id,
                    pr_district_id: this.orgTab.org_address.district_id,
                    pr_upazila_id: this.orgTab.org_address.upazila_id,
                    pr_city_corporation_id: this.orgTab.org_address.city_corporation_id,
                    pr_union_id: this.orgTab.org_address.union_id,
                    pr_ward_id: this.orgTab.org_address.ward_id,
                    pr_pauroshoba_id: this.orgTab.org_address.paurashava_id
                }
            }
        }
    },
    computed: {
      orgTypeList: function () {
        return this.$store.state.ExternalUserService.cipPanel.orgTypeList.map(item => {
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
        receivePrAddress (address) {
            this.pr_address = address
        },
        async submit () {
          var check = await this.$refs.form.validate()
          if (check) {
              this.loading = true
              this.$store.dispatch('mutateCommonProperties', { loading: true })
              const loadingState = { loading: false, listReload: false }
              this.orgTab.app_id = this.app_id
              this.orgTab.pr_address = this.pr_address
              const result = await RestApi.postData(exportTrophyCIPServiceBaseUrl, cipApplicationOrganizationStoreApi, this.orgTab)
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

<style>

</style>
