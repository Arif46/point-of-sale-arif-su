<template>
    <div>
      <b-card>
        <b-row>
            <b-col sm="6" class="mt-2">
              <b> {{ $t('globalTrans.fiscal_year')}} </b> : {{ getFiscalYear(form.fiscal_year_id) }}
            </b-col>
            <b-col sm="6" class="mt-2">
              <b> {{ $t('exportTrophyCircular.memo_no')}} </b> : {{ form.memo_no }}
            </b-col>
            <b-col sm="6" class="mt-2">
              <b> {{ $t('globalTrans.date')}} </b> : {{ form.date | dateFormat }}
            </b-col>
            <b-col sm="6" class="mt-2">
              <b> {{ $t('exportTrophyCircular.deadline')}} </b> : {{ form.deadline | dateFormat }}
            </b-col>
            <b-col sm="6" class="mt-2">
              <b> {{ $t('globalTrans.title') }} </b> : {{ currentLocale === 'bn' ? form.title_bn : form.title_en }}
            </b-col>
            <b-col sm="6" class="mt-2">
              <b> {{ $t('globalTrans.description') }} </b> : {{ currentLocale === 'bn' ? form.description_bn : form.description_en }}
            </b-col>
            <b-col sm="6" class="mt-2">
              <a :href="baseUrl + 'download-attachment?file=' + form.attachment" class="badge badge-primary">
                <i class="ri-cloud-fill"></i>{{ $t('globalTrans.attachment') }}
              </a>
            </b-col>
        </b-row>
      </b-card>
        <b-row class="mt-3">
          <b-col sm="12">
            <h5 class="card-title"><b>{{ $t('exportTrophyCircular.contact_person_details') }}</b></h5>
          </b-col>
          <b-col sm="12">
            <div class="table-wrapper table-responsive">
              <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                      <th scope="col"> {{ $t('globalTrans.organization') }} </th>
                      <th scope="col"> {{ $t('globalTrans.designation') }} </th>
                      <th scope="col"> {{ $t('exportTrophyCircular.contact_person_name') }} </th>
                      <th scope="col"> {{ $t('exportTrophyCircular.contact_person_mobile') }} </th>
                      <th scope="col"> {{ $t('exportTrophyCircular.contact_person_email') }} </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                      <td>{{ getOrg(form.org_id) }}</td>
                      <td>{{ getDesignation(form.designation_id) }}</td>
                      <td>{{ currentLocale === 'bn' ? form.contact_person_name_bn : form.contact_person_name_en }}</td>
                      <td>{{ form.contact_person_mobile | mobileNumber }}</td>
                      <td>{{ form.contact_person_email }}</td>
                    </tr>
                </tbody>
              </table>
            </div>
          </b-col>
        </b-row>
        <b-row class="text-right">
          <b-col>
            <b-button variant="danger" class="btn-sm" @click="$bvModal.hide('modal-form-details')">{{ $t('globalTrans.cancel') }}</b-button>
          </b-col>
      </b-row>
    </div>
</template>
<script>
import { exportTrophyCIPServiceBaseUrl } from '@/config/api_config'
export default {
  name: 'Details',
  props: ['id'],
  data () {
    return {
      baseUrl: exportTrophyCIPServiceBaseUrl,
      form: {}
    }
  },
  created () {
    if (this.id) {
      const tmp = this.getCircular()
      this.form = tmp
    }
  },
  computed: {
    currentLocale () {
      return this.$i18n.locale
    }
  },
  methods: {
    getCircular () {
      const tmpData = this.$store.state.list.find(item => item.id === this.id)
      return JSON.parse(JSON.stringify(tmpData))
    },
    getFiscalYear (fiscalYear) {
      const fiscalYearObj = this.$store.state.CommonService.commonObj.fiscalYearList.find(fiscal => fiscal.value === parseInt(fiscalYear))
      if (fiscalYearObj !== 'undefined') {
        return this.currentLocale === 'bn' ? fiscalYearObj.text_bn : fiscalYearObj.text_en
      }
    },
    getOrg (orgId) {
      const orgObj = this.$store.state.CommonService.commonObj.orgProfileList.find(org => org.value === parseInt(orgId))
      if (orgObj !== 'undefined') {
        return this.currentLocale === 'bn' ? orgObj.text_bn : orgObj.text_en
      }
    },
    getDesignation (designationId) {
      const designationObj = this.$store.state.CommonService.commonObj.designationList.find(deg => deg.value === parseInt(designationId))
      if (designationObj !== 'undefined') {
        return this.currentLocale === 'bn' ? designationObj.text_bn : designationObj.text_en
      }
    }
  }
}
</script>
