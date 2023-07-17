<template>
    <div>
      <b-row>
      <b-col class="sm">
        <b-button variant="primary" @click="pdfExport" class="mb-2 float-right">
          {{  $t('globalTrans.export_pdf') }}
        </b-button>
      </b-col>
    </b-row>
      <b-card>
        <b-overlay>
         <b-row>
            <b-col>
              <list-report-head :base-url="exportTrophyCIPServiceBaseUrl" uri="/configuration/report-heading/detail" :org-id="2">
                <template v-slot:projectNameSlot>
                  {{ }}
                </template>
                <div class="text-center mt-3"> “{{ (this.$i18n.locale == 'bn') ? detailsExportData.title_bn : detailsExportData.title_en }}” </div>
              </list-report-head>
            </b-col>
          </b-row>
          <b-row>
              <b-col sm="12"> <h3 class="text-center mt-3">{{ (this.$i18n.locale == 'bn') ? 'আন্তরিকভাবে আমন্ত্রণ' : 'Cordially Invite' }} {{ (this.$i18n.locale == 'bn') ? 'প্রতি' : 'To' }} {{ getAwardTypeStatus(detailsExportData.award_type) }}</h3> </b-col>
              <b-col sm="12"> <h3 class="text-center mt-3">{{ $t('globalTrans.date')}} : {{ formatted(detailsExportData.date_time) }}</h3></b-col>
          </b-row>
          <b-row>
              <b-col sm="12" class="mt-4" style="font-size:27px"> <div class="text-center">{{ (this.$i18n.locale == 'bn') ? detailsExportData.description_bn : detailsExportData.description_en }}</div></b-col>
          </b-row>
          <b-row>
              <b-col sm="12" style="text-transform:capitalize"><h4 class="text-center mt-3"> {{ $t('eventManage.venue')}} : {{ getVenueNameList(detailsExportData.venue_id) }}</h4> </b-col>
          </b-row>
        </b-overlay>
      </b-card>
    </div>
</template>
<script>
import { exportTrophyCIPServiceBaseUrl } from '@/config/api_config'
import ExportPdf from './export_pdf_details'
import ListReportHead from '@/components/custom/ListReportHead.vue'

export default {
  name: 'Details',
  props: ['id', 'item'],
  components: {
    ListReportHead
  },
  data () {
    return {
      exportTrophyCIPServiceBaseUrl: exportTrophyCIPServiceBaseUrl
    }
  },
  created () {
    if (this.id) {
      const tmp = this.item.invitation_card_export_trophy
      this.detailsExportData = tmp
    }
  },
  computed: {
    currentLocale () {
      return this.$i18n.locale
    }
  },
  methods: {
    pdfExport () {
      const reportTitle = this.$t('externalUser.export_trophy_award_invitation') + ' ' + this.$t('globalTrans.details')
      ExportPdf.exportPdfDetails(exportTrophyCIPServiceBaseUrl, '/configuration/report-heading/detail', 2, reportTitle, this, this.detailsExportData, this.getVenueNameList, this.formatted)
    },
    getAwardTypeStatus (type) {
      if (type === 1) {
        return this.currentLocale === 'en' ? 'CIP' : 'সিআইপি'
      } else if (type === 2) {
        return this.currentLocale === 'en' ? 'Export Trophy' : 'রপ্তানি ট্রফি'
      }
    },
    formatted (value) {
      return new Date(value).toLocaleString(this.$i18n.locale + '-GB', {
        day: 'numeric', // numeric, 2-digit
        year: 'numeric', // numeric, 2-digit
        month: 'long' // numeric, 2-digit, long, short, narrow
      })
    },
    EngBangNum (n) {
      if (this.$i18n.locale === 'bn') {
        return n.toString().replace(/\d/g, d => '০১২৩৪৫৬৭৮৯'[d])
      } else {
        return n.toString().replace(/[০-৯]/g, d => '০১২৩৪৫৬৭৮৯'.indexOf(d))
      }
    },
    getVenueNameList (Id) {
      const venueListObj = this.$store.state.ExternalUserService.cipPanel.commonObj.venueList.find(item => item.value === Id)
      if (this.currentLocale === 'bn') {
        return venueListObj.text_bn
      } else {
        return venueListObj.text_en
      }
    }
  }
}
</script>
