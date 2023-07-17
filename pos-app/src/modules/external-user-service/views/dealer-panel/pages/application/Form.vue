<template>
  <div>
    <b-overlay :show="loading">
      <b-row>
        <b-col sm="12">
          <div class="text-center mb-4 mt-2">
            <h5 class="card-title" style="border-bottom: 2px solid gray;font-weight: 600">{{ $t('dealer.application_form') }}</h5>
          </div>
          <ValidationObserver ref="form" v-slot="{ handleSubmit, reset }">
            <b-form @submit.prevent="handleSubmit(saveUpdate)" @reset.prevent="reset" autocomplete="off">
              <b-row>
                  <b-col xs="12" sm="12" md="4" lg="4" xl="4">
                  <ValidationProvider name="Applicant Name (EN)" vid="applicant_name" rules="required">
                    <b-form-group
                      class="row"
                      label-for="applicant_name"
                      slot-scope="{ valid, errors }">
                      <template v-slot:label>
                        {{ $t('dealer.applicant_name') }} <span class="text-danger">*</span>
                      </template>
                      <b-form-input
                        id="applicant_name"
                        v-model="form.applicant_name"
                        :state="errors[0] ? false : (valid ? true : null)"
                      ></b-form-input>
                      <div class="invalid-feedback">
                        {{ errors[0] }}
                      </div>
                    </b-form-group>
                  </ValidationProvider>
                  </b-col>
                  <b-col xs="12" sm="12" md="4" lg="4" xl="4">
                  <ValidationProvider name="Applicant Name (BN)" vid="applicant_name_bn" rules="required">
                    <b-form-group
                      class="row"
                      label-for="applicant_name_bn"
                      slot-scope="{ valid, errors }">
                      <template v-slot:label>
                        {{ $t('dealer.applicant_name_bn') }} <span class="text-danger">*</span>
                      </template>
                      <b-form-input
                        id="applicant_name_bn"
                        v-model="form.applicant_name_bn"
                        :state="errors[0] ? false : (valid ? true : null)"
                      ></b-form-input>
                      <div class="invalid-feedback">
                        {{ errors[0] }}
                      </div>
                    </b-form-group>
                  </ValidationProvider>
                  </b-col>
                  <b-col xs="12" sm="12" md="4" lg="4" xl="4">
                  <ValidationProvider name="Father/ Spouse Name (EN)" vid="father_spouse_name" rules="required">
                    <b-form-group
                      class="row"
                      label-for="father_spouse_name"
                      slot-scope="{ valid, errors }">
                      <template v-slot:label>
                        {{ $t('dealer.father_spouse_name') }} <span class="text-danger">*</span>
                      </template>
                      <b-form-input
                        id="father_spouse_name"
                        v-model="form.father_spouse_name"
                        :state="errors[0] ? false : (valid ? true : null)"
                      ></b-form-input>
                      <div class="invalid-feedback">
                        {{ errors[0] }}
                      </div>
                    </b-form-group>
                  </ValidationProvider>
                  </b-col>
                  <b-col xs="12" sm="12" md="4" lg="4" xl="4">
                  <ValidationProvider name="Father/ Spouse Name (EN)" vid="father_spouse_name_bn" rules="required">
                    <b-form-group
                      class="row"
                      label-for="father_spouse_name_bn"
                      slot-scope="{ valid, errors }">
                      <template v-slot:label>
                        {{ $t('dealer.father_spouse_name_bn') }} <span class="text-danger">*</span>
                      </template>
                      <b-form-input
                        id="father_spouse_name_bn"
                        v-model="form.father_spouse_name_bn"
                        :state="errors[0] ? false : (valid ? true : null)"
                      ></b-form-input>
                      <div class="invalid-feedback">
                        {{ errors[0] }}
                      </div>
                    </b-form-group>
                  </ValidationProvider>
                  </b-col>
                  <b-col xs="12" sm="12" md="4" lg="4" xl="4">
                  <ValidationProvider name="Mobile" vid="mobile" rules="required">
                    <b-form-group
                      class="row"
                      label-for="mobile"
                      slot-scope="{ valid, errors }">
                      <template v-slot:label>
                        {{ $t('dealer.mobile') }} <span class="text-danger">*</span>
                      </template>
                      <b-form-input
                        id="mobile"
                        type="number"
                        v-model="form.mobile"
                        :state="errors[0] ? false : (valid ? true : null)"
                      ></b-form-input>
                      <div class="invalid-feedback">
                        {{ errors[0] }}
                      </div>
                    </b-form-group>
                  </ValidationProvider>
                  </b-col>
                  <b-col lg="12" sm="12">
                    <ValidationProvider name="Address Status" vid="is_same" v-slot="{ errors }">
                        <b-form-group
                            class="row"
                            label-cols-sm="4"
                            label-for="is_same"
                        >
                        <template v-slot:label>
                            <div style="font-weight: bold">
                                {{ $t('dealer.dealer_condition_msg') }}
                            </div>
                        </template>
                        <b-form-checkbox
                            style="margin-top:5px"
                            v-model="form.other_family_license"
                            :state="errors[0] ? false : (valid ? true : null)"
                            value=1
                            unchecked-value=0
                        >
                        <span class="text-black">{{ $t('globalTrans.yes') }}</span>
                        </b-form-checkbox>
                        <div class="invalid-feedback">
                            {{ errors[0] }}
                        </div>
                        </b-form-group>
                    </ValidationProvider>
                  </b-col>
                  <b-col v-if="form.other_family_license == 1" md="12" sm="12">
                    <b-row>
                      <b-col md="4" sm="12">
                        <ValidationProvider name="Dealership Name (En)" vid="other_dealer_name" rules="required">
                          <b-form-group
                            class="row"
                            label-for="other_dealer_name"
                            slot-scope="{ valid, errors }">
                            <template v-slot:label>
                              {{ $t('dealer.dealer_name') }} <span class="text-danger">*</span>
                            </template>
                            <b-form-input
                              id="other_dealer_name"
                              v-model="form.other_dealer_name"
                              :state="errors[0] ? false : (valid ? true : null)"
                            ></b-form-input>
                            <div class="invalid-feedback">
                              {{ errors[0] }}
                            </div>
                          </b-form-group>
                        </ValidationProvider>
                      </b-col>
                      <b-col md="4" sm="12">
                        <ValidationProvider name="Dealership Name (BN)" vid="other_dealer_name_bn" rules="required">
                          <b-form-group
                            class="row"
                            label-for="other_dealer_name_bn"
                            slot-scope="{ valid, errors }">
                            <template v-slot:label>
                              {{ $t('dealer.dealer_name_bn') }} <span class="text-danger">*</span>
                            </template>
                            <b-form-input
                              id="other_dealer_name_bn"
                              v-model="form.other_dealer_name_bn"
                              :state="errors[0] ? false : (valid ? true : null)"
                            ></b-form-input>
                            <div class="invalid-feedback">
                              {{ errors[0] }}
                            </div>
                          </b-form-group>
                        </ValidationProvider>
                      </b-col>
                      <b-col md="4" sm="12">
                        <ValidationProvider name="Company Name (EN)" vid="other_company_name" rules="required">
                          <b-form-group
                            class="row"
                            label-for="other_company_name"
                            slot-scope="{ valid, errors }">
                            <template v-slot:label>
                              {{ $t('dealer.company_name') }} <span class="text-danger">*</span>
                            </template>
                            <b-form-input
                              id="other_company_name"
                              v-model="form.other_company_name"
                              :state="errors[0] ? false : (valid ? true : null)"
                            ></b-form-input>
                            <div class="invalid-feedback">
                              {{ errors[0] }}
                            </div>
                          </b-form-group>
                        </ValidationProvider>
                      </b-col>
                      <b-col md="4" sm="12">
                        <ValidationProvider name="Company Name (BN)" vid="other_company_name_bn" rules="required">
                          <b-form-group
                            class="row"
                            label-for="other_company_name_bn"
                            slot-scope="{ valid, errors }">
                            <template v-slot:label>
                              {{ $t('dealer.company_name_bn') }} <span class="text-danger">*</span>
                            </template>
                            <b-form-input
                              id="other_company_name_bn"
                              v-model="form.other_company_name_bn"
                              :state="errors[0] ? false : (valid ? true : null)"
                            ></b-form-input>
                            <div class="invalid-feedback">
                              {{ errors[0] }}
                            </div>
                          </b-form-group>
                        </ValidationProvider>
                      </b-col>
                      <b-col xl="4" lg="4" md="4" sm="12">
                          <ValidationProvider name="Division" vid="other_company_division_id" rules="required|min_value:1" v-slot="{ errors }">
                              <b-form-group
                                  class="row"
                                  label-for="other_company_division_id"
                              >
                                  <template v-slot:label>
                                      {{ $t('globalTrans.division')}} <span class="text-danger">*</span>
                                  </template>
                                  <b-form-select
                                      plain
                                      v-model="form.other_company_division_id"
                                      :options="divisionList"
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
                      <b-col xl="4" lg="4" md="4" sm="12">
                          <ValidationProvider name="District" vid="other_company_district_id" rules="required|min_value:1" v-slot="{ errors }">
                              <b-form-group
                                  class="row"
                                  label-for="other_company_district_id"
                              >
                                  <template v-slot:label>
                                      {{ $t('globalTrans.district')}} <span class="text-danger">*</span>
                                  </template>
                                  <b-form-select
                                      plain
                                      v-model="form.other_company_district_id"
                                      :options="otherDistrictList"
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
                      <b-col xl="4" lg="4" md="4" sm="12">
                          <ValidationProvider name="Upazilla" vid="other_company_upazilla_id" rules="required|min_value:1" v-slot="{ errors }">
                              <b-form-group
                                  class="row"
                                  label-for="other_company_upazilla_id"
                              >
                                  <template v-slot:label>
                                      {{ $t('globalTrans.upazila')}} <span class="text-danger">*</span>
                                  </template>
                                  <b-form-select
                                      plain
                                      v-model="form.other_company_upazilla_id"
                                      :options="otherUpazillaList"
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
                    </b-row>
                  </b-col>
                  <b-col md="12" sm="12">
                    <b-row>
                      <b-col md="4" sm="12">
                        <ValidationProvider name="Company Name (EN)" vid="company_name" rules="required">
                          <b-form-group
                            class="row"
                            label-for="company_name"
                            slot-scope="{ valid, errors }">
                            <template v-slot:label>
                              {{ $t('dealer.company_name') }} <span class="text-danger">*</span>
                            </template>
                            <b-form-input
                              id="company_name"
                              v-model="form.company_name"
                              :state="errors[0] ? false : (valid ? true : null)"
                            ></b-form-input>
                            <div class="invalid-feedback">
                              {{ errors[0] }}
                            </div>
                          </b-form-group>
                        </ValidationProvider>
                      </b-col>
                      <b-col md="4" sm="12">
                        <ValidationProvider name="Company Name (BN)" vid="company_name_bn" rules="required">
                          <b-form-group
                            class="row"
                            label-for="company_name_bn"
                            slot-scope="{ valid, errors }">
                            <template v-slot:label>
                              {{ $t('dealer.company_name_bn') }} <span class="text-danger">*</span>
                            </template>
                            <b-form-input
                              id="company_name_bn"
                              v-model="form.company_name_bn"
                              :state="errors[0] ? false : (valid ? true : null)"
                            ></b-form-input>
                            <div class="invalid-feedback">
                              {{ errors[0] }}
                            </div>
                          </b-form-group>
                        </ValidationProvider>
                      </b-col>
                      <b-col xl="4" lg="4" md="4" sm="12">
                          <ValidationProvider name="Division" vid="company_division_id" rules="required|min_value:1" v-slot="{ errors }">
                              <b-form-group
                                  class="row"
                                  label-for="company_division_id"
                              >
                                  <template v-slot:label>
                                      {{ $t('globalTrans.division')}} <span class="text-danger">*</span>
                                  </template>
                                  <b-form-select
                                      plain
                                      v-model="form.company_division_id"
                                      :options="divisionList"
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
                      <b-col xl="4" lg="4" md="4" sm="12">
                          <ValidationProvider name="District" vid="company_district_id" rules="required|min_value:1" v-slot="{ errors }">
                              <b-form-group
                                  class="row"
                                  label-for="company_district_id"
                              >
                                  <template v-slot:label>
                                      {{ $t('globalTrans.district')}} <span class="text-danger">*</span>
                                  </template>
                                  <b-form-select
                                      plain
                                      v-model="form.company_district_id"
                                      :options="comDistrictList"
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
                      <b-col xl="4" lg="4" md="4" sm="12">
                          <ValidationProvider name="Upazilla" vid="company_upazilla_id" rules="required|min_value:1" v-slot="{ errors }">
                              <b-form-group
                                  class="row"
                                  label-for="company_upazilla_id"
                              >
                                  <template v-slot:label>
                                      {{ $t('globalTrans.upazila')}} <span class="text-danger">*</span>
                                  </template>
                                  <b-form-select
                                      plain
                                      v-model="form.company_upazilla_id"
                                      :options="comUpazillaList"
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
                      <b-col xl="4" lg="4" md="4" sm="12">
                          <ValidationProvider name="Office" vid="office_id" rules="required|min_value:1" v-slot="{ errors }">
                              <b-form-group
                                  class="row"
                                  label-for="office_id"
                              >
                                  <template v-slot:label>
                                      {{ $t('globalTrans.office')}} <span class="text-danger">*</span>
                                  </template>
                                  <b-form-select
                                      plain
                                      v-model="form.office_id"
                                      :options="officeList"
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
                    </b-row>
                  </b-col>
                  <b-col md="12" sm="12">
                    <b-row>
                      <b-col sm="12">
                        <h6 class="mb-3 tag">{{ $t('dealer.permanent_address') }}</h6>
                      </b-col>
                      <b-col md="4" sm="12">
                          <ValidationProvider name="Division" vid="division_id" rules="required|min_value:1" v-slot="{ errors }">
                              <b-form-group
                                  class="row"
                                  label-for="division_id"
                              >
                                  <template v-slot:label>
                                      {{ $t('globalTrans.division')}} <span class="text-danger">*</span>
                                  </template>
                                  <b-form-select
                                      plain
                                      v-model="form.division_id"
                                      :options="divisionList"
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
                      <b-col md="4" sm="12">
                          <ValidationProvider name="District" vid="district_id" rules="required|min_value:1" v-slot="{ errors }">
                              <b-form-group
                                  class="row"
                                  label-for="district_id"
                              >
                                  <template v-slot:label>
                                      {{ $t('globalTrans.district')}} <span class="text-danger">*</span>
                                  </template>
                                  <b-form-select
                                      plain
                                      v-model="form.district_id"
                                      :options="districtList"
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
                      <b-col md="4" sm="12">
                          <ValidationProvider name="Upazilla" vid="upazilla_id" rules="required|min_value:1" v-slot="{ errors }">
                              <b-form-group
                                  class="row"
                                  label-for="upazilla_id"
                              >
                                  <template v-slot:label>
                                      {{ $t('globalTrans.upazila')}} <span class="text-danger">*</span>
                                  </template>
                                  <b-form-select
                                      plain
                                      v-model="form.upazilla_id"
                                      :options="upazillaList"
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
                      <b-col md="4" sm="12">
                          <ValidationProvider name="Union" vid="union_id" rules="required|min_value:1" v-slot="{ errors }">
                              <b-form-group
                                  class="row"
                                  label-for="union_id"
                              >
                                  <template v-slot:label>
                                      {{ $t('globalTrans.union')}} <span class="text-danger">*</span>
                                  </template>
                                  <b-form-select
                                      plain
                                      v-model="form.union_id"
                                      :options="unionList"
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
                      <b-col md="4" sm="12">
                        <ValidationProvider name="Village (EN)" vid="village" rules="required">
                          <b-form-group
                            class="row"
                            label-for="village"
                            slot-scope="{ valid, errors }">
                            <template v-slot:label>
                              {{ $t('dealer.village') }} <span class="text-danger">*</span>
                            </template>
                            <b-form-input
                              id="village"
                              v-model="form.village"
                              :state="errors[0] ? false : (valid ? true : null)"
                            ></b-form-input>
                            <div class="invalid-feedback">
                              {{ errors[0] }}
                            </div>
                          </b-form-group>
                        </ValidationProvider>
                      </b-col>
                      <b-col md="4" sm="12">
                        <ValidationProvider name="Village (BN)" vid="village_bn" rules="required">
                          <b-form-group
                            class="row"
                            label-for="village_bn"
                            slot-scope="{ valid, errors }">
                            <template v-slot:label>
                              {{ $t('dealer.village_bn') }} <span class="text-danger">*</span>
                            </template>
                            <b-form-input
                              id="village_bn"
                              v-model="form.village_bn"
                              :state="errors[0] ? false : (valid ? true : null)"
                            ></b-form-input>
                            <div class="invalid-feedback">
                              {{ errors[0] }}
                            </div>
                          </b-form-group>
                        </ValidationProvider>
                      </b-col>
                    </b-row>
                  </b-col>
                  <b-col xs="12" sm="12" md="4" lg="4" xl="4">
                  <ValidationProvider name="Date Of Bitrh" vid="dob" rules="required">
                    <b-form-group
                      class="row"
                      label-for="dob"
                      slot-scope="{ valid, errors }">
                      <template v-slot:label>
                        {{ $t('dealer.dob') }}  <span class="text-danger">*</span>
                      </template>
                      <b-form-datepicker
                        b-form-datepicker
                        id="dob"
                        v-model="form.dob"
                        :state="errors[0] ? false : (valid ? true : null)"
                      >
                      </b-form-datepicker>
                      <div class="invalid-feedback">
                        {{ errors[0] }}
                      </div>
                    </b-form-group>
                  </ValidationProvider>
                  </b-col>
                  <b-col md="4" sm="12">
                      <ValidationProvider name="NID No" vid="nid_no" rules="required">
                        <b-form-group
                          class="row"
                          label-for="nid_no"
                          slot-scope="{ valid, errors }">
                          <template v-slot:label>
                            {{ $t('dealer.nid_no') }} <span class="text-danger">*</span>
                          </template>
                          <b-form-input
                            id="nid_no"
                            type="number"
                            v-model="form.nid_no"
                            :state="errors[0] ? false : (valid ? true : null)"
                          ></b-form-input>
                          <div class="invalid-feedback">
                            {{ errors[0] }}
                          </div>
                        </b-form-group>
                      </ValidationProvider>
                  </b-col>
                  <b-col lg="4" sm="12">
                    <ValidationProvider name="Merital Status" vid="marital_status" rules="required" v-slot="{ errors }">
                        <b-form-group
                            class="row"
                            label-cols-sm="12"
                            label-for="marital_status"
                        >
                        <template v-slot:label>
                            <div >
                                {{ $t('dealer.marital_status') }} <span class="text-danger">*</span>
                            </div>
                        </template>
                          <b-form-radio-group
                            id="marital_status"
                            v-model="form.marital_status"
                            value="1"
                            :options="options"
                            name="Merital Status"
                          ></b-form-radio-group>
                          <div class="invalid-feedback">
                              {{ errors[0] }}
                          </div>
                        </b-form-group>
                    </ValidationProvider>
                  </b-col>
                  <b-col md="4" sm="12" v-if="form.marital_status == 1">
                      <ValidationProvider name="Spouse NID" vid="spouse_nid_no" rules="required">
                        <b-form-group
                          class="row"
                          label-for="spouse_nid_no"
                          slot-scope="{ valid, errors }">
                          <template v-slot:label>
                            {{ $t('dealer.spouse_nid_no') }} <span class="text-danger">*</span>
                          </template>
                          <b-form-input
                            id="spouse_nid_no"
                            type="number"
                            v-model="form.spouse_nid_no"
                            :state="errors[0] ? false : (valid ? true : null)"
                          ></b-form-input>
                          <div class="invalid-feedback">
                            {{ errors[0] }}
                          </div>
                        </b-form-group>
                      </ValidationProvider>
                  </b-col>
                  <b-col md="4" sm="12" v-if="form.marital_status == 2">
                      <ValidationProvider name="Spouse NID" vid="father_nid_no" rules="required">
                        <b-form-group
                          class="row"
                          label-for="father_nid_no"
                          slot-scope="{ valid, errors }">
                          <template v-slot:label>
                            {{ $t('dealer.father_nid_no') }} <span class="text-danger">*</span>
                          </template>
                          <b-form-input
                            id="father_nid_no"
                            type="number"
                            v-model="form.father_nid_no"
                            :state="errors[0] ? false : (valid ? true : null)"
                          ></b-form-input>
                          <div class="invalid-feedback">
                            {{ errors[0] }}
                          </div>
                        </b-form-group>
                      </ValidationProvider>
                  </b-col>
                  <b-col md="4" sm="12">
                      <ValidationProvider name="Email" vid="email" rules="">
                        <b-form-group
                          class="row"
                          label-for="email"
                          slot-scope="{ valid, errors }">
                          <template v-slot:label>
                            {{ $t('dealer.email') }}
                          </template>
                          <b-form-input
                            id="email"
                            v-model="form.email"
                            :state="errors[0] ? false : (valid ? true : null)"
                          ></b-form-input>
                          <div class="invalid-feedback">
                            {{ errors[0] }}
                          </div>
                        </b-form-group>
                      </ValidationProvider>
                  </b-col>
                  <b-col md="4" sm="12">
                      <ValidationProvider name="TIN No" vid="tin_no" rules="required">
                        <b-form-group
                          class="row"
                          label-for="tin_no"
                          slot-scope="{ valid, errors }">
                          <template v-slot:label>
                            {{ $t('dealer.tin_no') }} <span class="text-danger">*</span>
                          </template>
                          <b-form-input
                            id="tin_no"
                            v-model="form.tin_no"
                            :state="errors[0] ? false : (valid ? true : null)"
                          ></b-form-input>
                          <div class="invalid-feedback">
                            {{ errors[0] }}
                          </div>
                        </b-form-group>
                      </ValidationProvider>
                  </b-col>
                  <b-col sm="12">
                    <h6 class="m-0 tag mb-3">{{ $t('dealer.important_document') }}</h6>
                  </b-col>
                  <b-col xs="12" sm="12" md="4" lg="4" xl="4">
                    <ValidationProvider name="Applicant Photo" vid="applicant_image" :rules="required" v-slot="{ errors }">
                      <b-form-group
                        label-for="applicant_image">
                        <template v-slot:label>
                          {{ $t('dealer.applicant_image') }} <span class="text-danger">*</span>
                        </template>
                        <b-input-group>
                          <b-form-file
                            name="applicant_image"
                            v-model="form.applicant_image"
                            @change="onChange($event)"
                            :state="errors[0] ? false : (valid ? true : null)"
                          ></b-form-file>
                            <b-input-group-append v-if="form.applicant_image_url">
                            <a target="_blank" :href="licenseRegistrationServiceBaseUrl+form.applicant_image_url" style="padding: 2px 10px;" class="btn btn-primary btn-sm" ><i class="ri-download-2-line"></i></a>
                          </b-input-group-append>
                        </b-input-group>
                        <div class="invalid-feedback">
                          {{ errors[0] }}
                        </div>
                      </b-form-group>
                    </ValidationProvider>
                  </b-col>
                  <b-col xs="12" sm="12" md="4" lg="4" xl="4">
                    <ValidationProvider name="Trade License (Grocery business)" vid="trade_license" v-slot="{ errors }">
                      <b-form-group
                        label-for="trade_license">
                        <template v-slot:label>
                          {{ $t('dealer.trade_license') }}
                        </template>
                        <b-input-group>
                        <b-form-file
                          name="trade_license"
                          v-model="form.trade_license"
                          @change="onChange"
                          :state="errors[0] ? false : (valid ? true : null)"
                        ></b-form-file>
                          <b-input-group-append v-if="form.trade_license_url">
                            <a target="_blank" :href="licenseRegistrationServiceBaseUrl+form.trade_license_url" style="padding: 2px 10px;" class="btn btn-primary btn-sm" ><i class="ri-download-2-line"></i></a>
                          </b-input-group-append>
                        </b-input-group>
                        <div class="invalid-feedback">
                          {{ errors[0] }}
                        </div>
                      </b-form-group>
                    </ValidationProvider>
                  </b-col>
                  <b-col xs="12" sm="12" md="4" lg="4" xl="4">
                    <ValidationProvider name="Bank Solvency Certificate" vid="bank_solvency" :rules="required" v-slot="{ errors }">
                      <b-form-group
                        label-for="bank_solvency">
                        <template v-slot:label>
                          {{ $t('dealer.bank_solvency') }} <span class="text-danger">*</span>
                        </template>
                        <b-input-group>
                        <b-form-file
                          name="bank_solvency"
                          v-model="form.bank_solvency"
                          @change="onChange"
                          :state="errors[0] ? false : (valid ? true : null)"
                        ></b-form-file>
                          <b-input-group-append v-if="form.bank_solvency_url">
                            <a target="_blank" :href="licenseRegistrationServiceBaseUrl+form.bank_solvency_url" style="padding: 2px 10px;" class="btn btn-primary btn-sm" ><i class="ri-download-2-line"></i></a>
                          </b-input-group-append>
                        </b-input-group>
                        <div class="invalid-feedback">
                          {{ errors[0] }}
                        </div>
                      </b-form-group>
                    </ValidationProvider>
                  </b-col>
                  <b-col xs="12" sm="12" md="4" lg="4" xl="4">
                    <ValidationProvider name="NID Copy" vid="nid" :rules="required" v-slot="{ errors }">
                      <b-form-group
                        label-for="nid">
                        <template v-slot:label>
                          {{ $t('dealer.nid') }} <span class="text-danger">*</span>
                        </template>
                        <b-input-group>
                        <b-form-file
                          name="nid"
                          v-model="form.nid"
                          @change="onChange"
                          :state="errors[0] ? false : (valid ? true : null)"
                        ></b-form-file>
                          <b-input-group-append v-if="form.nid_url">
                            <a target="_blank" :href="licenseRegistrationServiceBaseUrl+form.nid_url" style="padding: 2px 10px;" class="btn btn-primary btn-sm" ><i class="ri-download-2-line"></i></a>
                          </b-input-group-append>
                        </b-input-group>
                        <div class="invalid-feedback">
                          {{ errors[0] }}
                        </div>
                      </b-form-group>
                    </ValidationProvider>
                  </b-col>
                  <b-col xs="12" sm="12" md="4" lg="4" xl="4">
                    <ValidationProvider name="TIN Certificate" vid="tin" :rules="required" v-slot="{ errors }">
                      <b-form-group
                        label-for="tin">
                        <template v-slot:label>
                          {{ $t('dealer.tin') }} <span class="text-danger">*</span>
                        </template>
                        <b-input-group>
                        <b-form-file
                          name="tin"
                          v-model="form.tin"
                          @change="onChange"
                          :state="errors[0] ? false : (valid ? true : null)"
                        ></b-form-file>
                          <b-input-group-append v-if="form.tin_url">
                            <a target="_blank" :href="licenseRegistrationServiceBaseUrl+form.tin_url" style="padding: 2px 10px;" class="btn btn-primary btn-sm" ><i class="ri-download-2-line"></i></a>
                          </b-input-group-append>
                        </b-input-group>
                        <div class="invalid-feedback">
                          {{ errors[0] }}
                        </div>
                      </b-form-group>
                    </ValidationProvider>
                  </b-col>
                  <b-col xs="12" sm="12" md="4" lg="4" xl="4">
                    <ValidationProvider name="Shop Rent/Ownership Document" vid="shop_document" :rules="required" v-slot="{ errors }">
                      <b-form-group
                        label-for="shop_document">
                        <template v-slot:label>
                          {{ $t('dealer.shop_document') }} <span class="text-danger">*</span>
                        </template>
                        <b-input-group>
                        <b-form-file
                          name="shop_document"
                          v-model="form.shop_document"
                          @change="onChange"
                          :state="errors[0] ? false : (valid ? true : null)"
                        ></b-form-file>
                          <b-input-group-append v-if="form.shop_document_url">
                            <a target="_blank" :href="licenseRegistrationServiceBaseUrl+form.shop_document_url" style="padding: 2px 10px;" class="btn btn-primary btn-sm" ><i class="ri-download-2-line"></i></a>
                          </b-input-group-append>
                        </b-input-group>
                        <div class="invalid-feedback">
                          {{ errors[0] }}
                        </div>
                      </b-form-group>
                    </ValidationProvider>
                  </b-col>
                  <b-col xs="12" sm="12" md="4" lg="4" xl="4">
                    <ValidationProvider name="VAT Registration Certificate (If)" vid="vat_certificate" rules="" v-slot="{ errors }">
                      <b-form-group
                        label-for="vat_certificate">
                        <template v-slot:label>
                          {{ $t('dealer.vat_certificate') }}
                        </template>
                        <b-input-group>
                        <b-form-file
                          name="vat_certificate"
                          v-model="form.vat_certificate"
                          @change="onChange"
                          :state="errors[0] ? false : (valid ? true : null)"
                        ></b-form-file>
                          <b-input-group-append v-if="form.vat_certificate_url">
                            <a target="_blank" :href="licenseRegistrationServiceBaseUrl+form.vat_certificate_url" style="padding: 2px 10px;" class="btn btn-primary btn-sm" ><i class="ri-download-2-line"></i></a>
                          </b-input-group-append>
                        </b-input-group>
                        <div class="invalid-feedback">
                          {{ errors[0] }}
                        </div>
                      </b-form-group>
                    </ValidationProvider>
                  </b-col>
                  <b-col xs="12" sm="12" md="4" lg="4" xl="4">
                    <ValidationProvider name="Citizenship Certificate" vid="citizen_certificate" :rules="required" v-slot="{ errors }">
                      <b-form-group
                        label-for="citizen_certificate">
                        <template v-slot:label>
                          {{ $t('dealer.citizen_certificate') }} <span class="text-danger">*</span>
                        </template>
                        <b-input-group>
                        <b-form-file
                          name="citizen_certificate"
                          v-model="form.citizen_certificate"
                          @change="onChange"
                          :state="errors[0] ? false : (valid ? true : null)"
                        ></b-form-file>
                          <b-input-group-append v-if="form.citizen_certificate_url">
                            <a target="_blank" :href="licenseRegistrationServiceBaseUrl+form.citizen_certificate_url" style="padding: 2px 10px;" class="btn btn-primary btn-sm" ><i class="ri-download-2-line"></i></a>
                          </b-input-group-append>
                        </b-input-group>
                        <div class="invalid-feedback">
                          {{ errors[0] }}
                        </div>
                      </b-form-group>
                    </ValidationProvider>
                  </b-col>
              </b-row>
              <b-row class="text-right">
                <b-col>
                    <b-button type="submit" @click="form.save_status = 2 " variant="primary" class="mr-2">Final Save</b-button>
                    &nbsp;
                    <b-button type="submit" @click="form.save_status = 1 " variant="warning" class="mr-2">Save Draft</b-button>
                    <b-button variant="danger" class="btn-sm" @click="$bvModal.hide('modal-form')">{{ $t('globalTrans.cancel') }}</b-button>
                  </b-col>
              </b-row>
            </b-form>
          </ValidationObserver>
        </b-col>
      </b-row>
    </b-overlay>
  </div>
</template>
<script>
import RestApi, { licenseRegistrationServiceBaseUrl } from '@/config/api_config'
import { applicationStore, applicationUpdate } from '../../api/routes'
export default {
  name: 'Form',
  props: ['appDetail', 'isRenew'],
  components: {
  },
  data () {
    return {
      licenseRegistrationServiceBaseUrl: licenseRegistrationServiceBaseUrl,
      loading: false,
      required: 'required',
      form: {
        org_id: 0,
        region_id: 0,
        applicant_name: '',
        applicant_name_bn: '',
        fasp_name: '',
        fasp_name_bn: '',
        mobile: '',
        other_family_license: 0,
        other_dealer_name: '',
        other_dealer_name_bn: '',
        other_company_name: '',
        other_company_name_bn: '',
        other_company_division_id: 0,
        other_company_district_id: 0,
        other_company_upazilla_id: 0,
        company_name: '',
        company_name_bn: '',
        company_division_id: 0,
        company_district_id: 0,
        company_upazilla_id: 0,
        office_id: 0,
        division_id: 0,
        district_id: 0,
        upazilla_id: 0,
        union_id: 0,
        village: '',
        village_bn: '',
        dob: '',
        nid_no: '',
        marital_status: 1,
        father_nid_no: '',
        spouse_nid_no: '',
        email: '',
        tin_no: '',
        applicant_image: [],
        trade_license: [],
        bank_solvency: [],
        nid: [],
        tin: [],
        shop_document: [],
        vat_certificate: [],
        citizen_certificate: [],
        save_status: 2
      },
      districtList: [],
      upazillaList: [],
      unionList: [],
      otherDistrictList: [],
      otherUpazillaList: [],
      comDistrictList: [],
      comUpazillaList: [],
      officeList: []
    }
  },
  created () {
    if (this.appDetail) {
      this.required = ''
      this.form = this.getEditData(this.appDetail)
    } else {
      this.required = 'required'
    }
  },
  watch: {
    'form.division_id': function (n, o) {
      if (o !== n) {
        this.districtList = this.getDistrictList(n)
      }
    },
    'form.district_id': function (n, o) {
      if (o !== n) {
        this.upazillaList = this.getUpazillaList(n)
      }
    },
    'form.upazilla_id': function (n, o) {
      if (o !== n) {
        this.unionList = this.getUnionList(n)
      }
    },
    'form.other_company_division_id': function (n, o) {
      if (o !== n) {
        this.otherDistrictList = this.getDistrictList(n)
      }
    },
    'form.other_company_district_id': function (n, o) {
      if (o !== n) {
        this.otherUpazillaList = this.getUpazillaList(n)
      }
    },
    'form.company_division_id': function (n, o) {
      if (o !== n) {
        this.comDistrictList = this.getDistrictList(n)
      }
    },
    'form.company_district_id': function (n, o) {
      if (o !== n) {
        this.officeList = this.getOfficeList(n)
        this.comUpazillaList = this.getUpazillaList(n)
      }
    }
  },
  computed: {
    options () {
      const datas = this.$store.state.LicenseRegistrationService.commonObj.maritalStatusList
      return datas.map(item => {
        if (this.$i18n.locale === 'bn') {
          return { text: item.text_bn, value: item.value }
        } else {
          return { text: item.text_en, value: item.value }
        }
      })
    },
    orgList: function () {
      return this.$store.state.CommonService.commonObj.componentOrgList.filter(item => item.status === 1)
    },
    divisionList: function () {
      return this.$store.state.CommonService.commonObj.divisionList.filter(item => item.status === 1)
    }
  },
  methods: {
    onChange (e) {
      const selectedFile = e.target.files[0]
      const reader = new FileReader()
      reader.onload = (event) => {
        this.form[e.target.name] = event.target.result
      }
      reader.readAsDataURL(selectedFile)
    },
    async saveUpdate () {
      var formData = new FormData()
      Object.keys(this.form).map(key => {
          formData.append(key, this.form[key])
      })
      let result = null
      this.loading = true
      if (this.isRenew && this.appDetail) {
        formData.append('type', 2)
        result = await RestApi.postData(licenseRegistrationServiceBaseUrl, applicationStore, formData)
      } else if (this.appDetail) {
        formData.append('_method', 'PUT')
        result = await RestApi.postData(licenseRegistrationServiceBaseUrl, `${applicationUpdate}/${this.appDetail.tcb_application_id}`, formData)
      } else {
        result = await RestApi.postData(licenseRegistrationServiceBaseUrl, applicationStore, formData)
      }
      this.loading = false
      if (result.success) {
        this.$toast.success({
          title: 'Success',
          message: this.appDetail ? this.$t('globalTrans.update_msg') : this.$t('globalTrans.save_msg'),
          color: '#D6E09B'
        })
        this.$emit('submitForm')
      } else {
        this.$refs.form.setErrors(result.errors)
      }
    },
    getUpazillaList (districtId) {
      return this.$store.state.CommonService.commonObj.upazilaList.filter(item => item.status === 1 && item.district_id === districtId)
    },
    getDistrictList (divisionId) {
      return this.$store.state.CommonService.commonObj.districtList.filter(item => item.status === 1 && item.division_id === divisionId)
    },
    getUnionList (upazilaId) {
      return this.$store.state.CommonService.commonObj.unionList.filter(item => item.status === 1 && item.upazila_id === upazilaId)
    },
    getOfficeList (districtId) {
      return this.$store.state.CommonService.commonObj.officeList.filter(item => item.status === 1 && item.district_id === districtId && item.is_regional_office === 1)
    },
    getEditData (item) {
      const finalItem = Object.assign(item, Object.assign(item.details,
      {
        applicant_image_url: item.details.applicant_image,
        trade_license_url: item.details.trade_license,
        bank_solvency_url: item.details.bank_solvency,
        nid_url: item.details.nid,
        tin_url: item.details.tin,
        shop_document_url: item.details.shop_document,
        vat_certificate_url: item.details.vat_certificate,
        citizen_certificate_url: item.details.citizen_certificate,
        applicant_image: [],
        trade_license: [],
        bank_solvency: [],
        nid: [],
        tin: [],
        shop_document: [],
        vat_certificate: [],
        citizen_certificate: []
      }))
      return JSON.parse(JSON.stringify(finalItem))
    }
  }
}
</script>
<style scoped>
  .tag {
    font-weight: 600;
    border-left: 4px solid #1c4261;
    padding-left: 6px;
  }
</style>
