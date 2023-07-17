<template>
  <b-overlay>
      <b-row>
        <b-col md="10" class="text-right mb-3" offset-md="1">
            <div class="tagTwo">
              {{ $t('dealer.document_verified') }}
            </div>
        </b-col>
        <b-col md="10" offset-md="1">
            <div class="stepper-wrapper">
              <div :class="item.value <= appDetail.status ? `stepper-item completed` : `stepper-item`" v-for="(item, index) in stepList" :key="index">
                <div class="step-counter">
                  <i v-if="item.value < appDetail.status || appDetail.agreement_no" class="ri-check-fill"></i>
                  <span v-else>{{ index+1 }}</span>
                </div>
                <div class="step-name">{{ item.text }}</div>
              </div>
            </div>
        </b-col>
      </b-row>
      <b-row>
        <b-col md="10" offset-md="1">
          <div class="text-center mb-4 mt-2">
            <h5 class="card-title" style="border-bottom: 2px solid gray;font-weight: 600">{{ $t('dealer.application_form') }} ({{ appDetail.type === 1 ? $t('dealer.new') : $t('globalTrans.renew') }})</h5>
          </div>
          <div>
            <p>{{ $t('dealer.chairman') }}</p>
            <p>{{ $t('dealer.tcb') }}</p>
            <p>{{ $t('dealer.tcb_address') }}</p>
            <p style="font-weight: 600">{{ $t('dealer.subject') }}</p>
            <span>{{ $t('dealer.sir') }},</span>
            <p>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              {{ $t('dealer.tcb_description_header') }}
            </p>
          </div>
          <div class="table-wrapper table-responsive mt-2">
            <table class="table table-striped table-hover table-bordered">
              <tbody>
                <tr>
                  <td width="20%">
                    {{ $t('dealer.applicant_name') }}
                  </td>
                  <td>{{ $i18n.locale ==  'bn' ? appDetail.details.applicant_name_bn : appDetail.details.applicant_name }}</td>
                  <td width="20%">
                    {{ $t('dealer.father_spouse_name') }}
                  </td>
                  <td>{{ $i18n.locale ==  'bn' ? appDetail.details.father_spouse_name_bn : appDetail.details.father_spouse_name }}</td>
                </tr>
                <tr>
                  <td>
                    {{ $t('dealer.company_name') }}
                  </td>
                  <td>{{ $i18n.locale ==  'bn' ? appDetail.details.company_name_bn : appDetail.details.company_name }}</td>
                  <td>
                    {{ $t('dealer.dob') }}
                  </td>
                  <td>{{ appDetail.details.dob | dateFormat }}</td>
                </tr>
                <tr>
                  <td>
                    {{ $t('dealer.nid_no') }}
                  </td>
                  <td>{{ appDetail.details.nid_no }}</td>
                  <td>
                    {{ $t('dealer.marital_status') }}
                  </td>
                  <td>{{ getMeritalStatus(appDetail.details.marital_status) }}</td>
                </tr>
                <tr>
                  <td>
                    {{ $t('dealer.spouse_nid_no') }}
                  </td>
                  <td>{{ appDetail.details.spouse_nid_no }}</td>
                  <td>
                    {{ $t('dealer.father_nid_no') }}
                  </td>
                  <td>{{ appDetail.details.father_nid_no }}</td>
                </tr>
                <tr>
                  <td>
                    {{ $t('dealer.email') }}
                  </td>
                  <td>{{ appDetail.details.email }}</td>
                  <td>
                    {{ $t('dealer.tin_no') }}
                  </td>
                  <td>{{ appDetail.details.tin_no }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div>
            <h6 class="mb-3 tag">{{ $t('dealer.dealer_condition_msg') }} <span class="ml-3">:</span> <span class="ml-3">হ্যাঁ।</span></h6>
          </div>
          <div class="table-wrapper table-responsive">
            <table class="table table-striped table-hover table-bordered">
              <tbody>
                <tr>
                  <td width="20%">
                    {{ $t('dealer.dealer_name') }}
                  </td>
                  <td>{{ $i18n.locale ==  'bn' ? appDetail.details.other_dealer_name_bn : appDetail.details.other_dealer_name }}</td>
                  <td width="20%">
                    {{ $t('dealer.company_name') }}
                  </td>
                  <td>{{ $i18n.locale ==  'bn' ? appDetail.details.other_company_name_bn : appDetail.details.other_company_name }}</td>
                </tr>
                <tr>
                  <td>
                    {{ $t('globalTrans.division') }}
                  </td>
                  <td>{{ getDivisionName(appDetail.details.other_company_division_id) }}</td>
                  <td>
                    {{ $t('globalTrans.district') }}
                  </td>
                  <td>{{ getDistrictName(appDetail.details.other_company_district_id) }}</td>
                </tr>
                <tr>
                  <td>
                    {{ $t('globalTrans.upazila') }}
                  </td>
                  <td colspan="3">{{ getUpazillaName(appDetail.details.other_company_upazilla_id) }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div>
            <h6 class="mb-3 tag">{{ $t('dealer.company_details') }}</h6>
          </div>
          <div class="table-wrapper table-responsive">
            <table class="table table-striped table-hover table-bordered">
              <tbody>
                <tr>
                  <td width="20%">
                    {{ $t('dealer.company_name') }}
                  </td>
                  <td>{{ $i18n.locale ==  'bn' ? appDetail.details.company_name_bn : appDetail.details.company_name }}</td>
                  <td>
                    {{ $t('globalTrans.division') }}
                  </td>
                  <td>{{ getDivisionName(appDetail.details.company_division_id) }}</td>
                </tr>
                <tr>
                  <td>
                    {{ $t('globalTrans.district') }}
                  </td>
                  <td>{{ getDistrictName(appDetail.details.company_district_id) }}</td>
                  <td>
                    {{ $t('globalTrans.upazila') }}
                  </td>
                  <td>{{ getUpazillaName(appDetail.details.company_upazilla_id) }}</td>
                </tr>
                <tr>
                  <td>
                    {{ $t('globalTrans.office') }}
                  </td>
                  <td colspan="4">{{ getOfficeName(appDetail.office_id) }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div>
            <h6 class="mb-3 tag">{{ $t('dealer.permanent_address') }}</h6>
          </div>
          <div class="table-wrapper table-responsive">
            <table class="table table-striped table-hover table-bordered">
              <tbody>
                <tr>
                  <td>
                    {{ $t('globalTrans.division') }}
                  </td>
                  <td>{{ getDivisionName(appDetail.details.division_id) }}</td>
                  <td>
                    {{ $t('globalTrans.district') }}
                  </td>
                  <td>{{ getDistrictName(appDetail.details.district_id) }}</td>
                </tr>
                <tr>
                  <td>
                    {{ $t('globalTrans.upazila') }}
                  </td>
                  <td>{{ getUpazillaName(appDetail.details.upazilla_id) }}</td>
                  <td>
                    {{ $t('globalTrans.union') }}
                  </td>
                  <td>{{ getUnionName(appDetail.details.union_id) }}</td>
                </tr>
                <tr>
                  <td>
                    {{ $t('dealer.village') }}
                  </td>
                  <td colspan="4">{{ $i18n.locale == 'bn' ? appDetail.details.village : appDetail.details.village_bn }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </b-col>
        <b-col md="10" offset-md="1">
          <p>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            {{ $t('dealer.tcb_description_footer') }}
          </p>
          <b-row>
            <b-col md="8">
            </b-col>
            <b-col md="4">
              <div>
                <p class="text-center">{{ $t('dealer.sincerely_yours') }}</p>
                <span>{{ $t('dealer.name') }}......................................</span><br>
                <span>{{ $t('dealer.phone_no') }}......................................</span>
              </div>
            </b-col>
          </b-row>
        </b-col>
        <b-col md="6" offset-md="1">
          <div>
            <h6 class="mb-3 tag">{{ $t('dealer.important_document') }}</h6>
          </div>
          <div>
            <ul>
              <li>
                <div class="d-flex justify-content-between">
                  <span>{{ $n(1) }}. {{ $t('dealer.applicant_image') }}</span>
                  <div class="list-btn">
                    <div v-if="appDetail.details.applicant_image">
                      <i class="ri-check-line yes-btn" style="font-weight: 700"></i>
                      <a target="_blank" :href="licenseRegistrationServiceBaseUrl+appDetail.details.applicant_image"><i style="font-weight:bold" class="ri-download-line download-btn"></i></a>
                    </div>
                    <i v-else class="ri-close-line no-btn" style="font-weight: 700"></i>
                  </div>
                </div>
              </li>
              <li>
                <div class="d-flex justify-content-between">
                  <span>{{ $n(2) }}. {{ $t('dealer.trade_license') }}</span>
                  <div class="list-btn">
                    <div v-if="appDetail.details.trade_license">
                      <i class="ri-check-line yes-btn" style="font-weight: 700"></i>
                      <a target="_blank" :href="licenseRegistrationServiceBaseUrl+appDetail.details.trade_license"><i style="font-weight:bold" class="ri-download-line download-btn"></i></a>
                    </div>
                    <i v-else class="ri-close-line no-btn" style="font-weight: 700"></i>
                  </div>
                </div>
              </li>
              <li>
                <div class="d-flex justify-content-between">
                  <span>{{ $n(2) }}. {{ $t('dealer.bank_solvency') }}</span>
                  <div class="list-btn">
                    <div v-if="appDetail.details.bank_solvency">
                      <i class="ri-check-line yes-btn" style="font-weight: 700"></i>
                      <a target="_blank" :href="licenseRegistrationServiceBaseUrl+appDetail.details.bank_solvency"><i style="font-weight:bold" class="ri-download-line download-btn"></i></a>
                    </div>
                    <i v-else class="ri-close-line no-btn" style="font-weight: 700"></i>
                  </div>
                </div>
              </li>
              <li>
                <div class="d-flex justify-content-between">
                  <span>{{ $n(3) }}. {{ $t('dealer.nid') }}</span>
                  <div class="list-btn">
                    <div v-if="appDetail.details.nid">
                      <i class="ri-check-line yes-btn" style="font-weight: 700"></i>
                      <a target="_blank" :href="licenseRegistrationServiceBaseUrl+appDetail.details.nid"><i style="font-weight:bold" class="ri-download-line download-btn"></i></a>
                    </div>
                    <i v-else class="ri-close-line no-btn" style="font-weight: 700"></i>
                  </div>
                </div>
              </li>
              <li>
                <div class="d-flex justify-content-between">
                  <span>{{ $n(4) }}. {{ $t('dealer.tin') }}</span>
                  <div class="list-btn">
                    <div v-if="appDetail.details.tin">
                      <i class="ri-check-line yes-btn" style="font-weight: 700"></i>
                      <a target="_blank" :href="licenseRegistrationServiceBaseUrl+appDetail.details.tin"><i style="font-weight:bold" class="ri-download-line download-btn"></i></a>
                    </div>
                    <i v-else class="ri-close-line no-btn" style="font-weight: 700"></i>
                  </div>
                </div>
              </li>
              <li>
                <div class="d-flex justify-content-between">
                  <span>{{ $n(6) }}. {{ $t('dealer.vat_certificate') }}</span>
                  <div class="list-btn">
                    <div v-if="appDetail.details.vat_certificate">
                      <i class="ri-check-line yes-btn" style="font-weight: 700"></i>
                      <a target="_blank" :href="licenseRegistrationServiceBaseUrl+appDetail.details.vat_certificate"><i style="font-weight:bold" class="ri-download-line download-btn"></i></a>
                    </div>
                    <i v-else class="ri-close-line no-btn" style="font-weight: 700"></i>
                  </div>
                </div>
              </li>
              <li>
                <div class="d-flex justify-content-between">
                  <span>{{ $n(5) }}. {{ $t('dealer.shop_document') }}</span>
                  <div class="list-btn">
                    <div v-if="appDetail.details.shop_document">
                      <i class="ri-check-line yes-btn" style="font-weight: 700"></i>
                      <a target="_blank" :href="licenseRegistrationServiceBaseUrl+appDetail.details.shop_document"><i style="font-weight:bold" class="ri-download-line download-btn"></i></a>
                    </div>
                    <i v-else class="ri-close-line no-btn" style="font-weight: 700"></i>
                  </div>
                </div>
              </li>
              <li>
                <div class="d-flex justify-content-between">
                  <span>{{ $n(7) }}. {{ $t('dealer.citizen_certificate') }}</span>
                  <div class="list-btn">
                    <div v-if="appDetail.details.citizen_certificate">
                      <i class="ri-check-line yes-btn" style="font-weight: 700"></i>
                      <a target="_blank" :href="licenseRegistrationServiceBaseUrl+appDetail.details.citizen_certificate"><i style="font-weight:bold" class="ri-download-line download-btn"></i></a>
                    </div>
                    <i v-else class="ri-close-line no-btn" style="font-weight: 700"></i>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </b-col>
      </b-row>
  </b-overlay>
</template>
<script>
import { licenseRegistrationServiceBaseUrl } from '@/config/api_config'
export default {
  name: 'Details',
  props: ['appDetail'],
  components: {
  },
  data () {
    return {
      licenseRegistrationServiceBaseUrl: licenseRegistrationServiceBaseUrl
    }
  },
  created () {
  },
  computed: {
    stepList () {
      const tcbStepList = this.$store.state.LicenseRegistrationService.commonObj.tcbStepList.filter(item => item.value !== 5).map(item => {
        return this.$i18n.locale === 'bn' ? { value: item.value, text: item.text_bn } : { value: item.value, text: item.text_en }
      })
      return tcbStepList
    }
  },
  methods: {
     getMeritalStatus (id) {
      const maritalStatus = this.$store.state.LicenseRegistrationService.commonObj.maritalStatusList.find(item => item.value === parseInt(id))
      if (typeof maritalStatus !== 'undefined') {
        return this.$i18n.locale === 'bn' ? maritalStatus.text_bn : maritalStatus.text_en
      } else {
        return ''
      }
    },
    getDivisionName (id) {
      const data = this.$store.state.CommonService.commonObj.divisionList.find(item => item.value === id)
      if (typeof data !== 'undefined') {
        return this.$i18n.locale === 'bn' ? data.text_bn : data.text_en
      } else {
        return ''
      }
    },
    getUpazillaName (id) {
      const data = this.$store.state.CommonService.commonObj.upazilaList.find(item => item.value === id)
      if (typeof data !== 'undefined') {
        return this.$i18n.locale === 'bn' ? data.text_bn : data.text_en
      } else {
        return ''
      }
    },
    getDistrictName (id) {
      const data = this.$store.state.CommonService.commonObj.districtList.find(item => item.value === id)
      if (typeof data !== 'undefined') {
        return this.$i18n.locale === 'bn' ? data.text_bn : data.text_en
      } else {
        return ''
      }
    },
    getUnionName (id) {
      const data = this.$store.state.CommonService.commonObj.unionList.find(item => item.value === id)
      if (typeof data !== 'undefined') {
        return this.$i18n.locale === 'bn' ? data.text_bn : data.text_en
      } else {
        return ''
      }
    },
    getOfficeName (id) {
      const data = this.$store.state.CommonService.commonObj.officeList.find(item => item.value === id)
      if (typeof data !== 'undefined') {
        return this.$i18n.locale === 'bn' ? data.text_bn : data.text_en
      } else {
        return ''
      }
    }
  }
}
</script>
<style scoped>
  .table tr td {
    text-align: left !important;
  }
  .tag {
    font-weight: 600;
    border-left: 4px solid #1c4261;
    padding-left: 6px;
  }
  .download-btn {
    color: green;
    border: 1px solid gray;
    margin-left: 5px;
    font-size: 18px;
    padding: 2px 4px;
  }
  .yes-btn {
    color: green;
    border: 1px solid gray;
    margin-left: 5px;
    font-size: 18px;
    padding: 1px 3px;
  }
  .no-btn {
    color: red;
    border: 1px solid gray;
    margin-left: 5px;
    font-size: 18px;
    padding: 1px 3px;
    margin-right: 33px !important;
  }

.stepper-wrapper {
    margin-top: auto;
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    }
    .stepper-item {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 1;

    @media (max-width: 768px) {
        font-size: 12px;
    }
    }

    .stepper-item::before {
    position: absolute;
    content: "";
    border-bottom: 2px solid #ccc;
    width: 100%;
    top: 20px;
    left: -50%;
    z-index: 2;
    }

    .stepper-item::after {
    position: absolute;
    content: "";
    border-bottom: 2px solid #ccc;
    width: 100%;
    top: 20px;
    left: 50%;
    z-index: 2;
    }

    .stepper-item .step-counter {
    position: relative;
    z-index: 5;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #ccc;
    margin-bottom: 6px;
    color: white;
    }

    .stepper-item.active {
    font-weight: bold;
    }

    .stepper-item.completed .step-counter {
    background-color: #4bb543;
    color:white;
    }

    .stepper-item.completed::after {
    position: absolute;
    content: "";
    border-bottom: 2px solid #4bb543;
    width: 100%;
    top: 20px;
    left: 50%;
    z-index: 3;
    }

    .stepper-item:first-child::before {
    content: none;
    }
    .stepper-item:last-child::after {
    content: none;
    }
    .step-name {
        color: black;
        font-weight: bold;
        font-size: 11px;
    }
.tagTwo {
  position: relative;
  display: inline-block;
  border-radius: 6px;
  clip-path: polygon(20px 0px, 100% 0px, 100% 100%, 0% 100%, 0% 20px);
  background: hsl(250deg, 100%, 40%);
  padding: 5px 25px;
  font-weight: 600;
  font-size: 12px;
  color: #FFF;
  transition: clip-path 500ms;
}
.tagTwo:after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 20px;
  height: 20px;
  background: hsl(252deg, 100%, 60%);
  box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.1);
  border-radius: 0 0 6px 0;
  transition: transform 500ms;
}
</style>
