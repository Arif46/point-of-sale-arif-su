<template>
  <div class="section-wrapper">
    <b-row>
      <b-col lg="12" sm="12">
        <body-card>
          <template v-slot:headerTitle>
            <h5 class="card-title" style="font-weight:550;"> {{ $t('bfti.research_and_other_request') }}</h5>
          </template>
          <template v-slot:body>
            <b-row>
              <b-col lg="12" sm="12">
                <table class="table table-borderless">
                  <tr>
                    <th style="width: 20%"> {{$t('bfti.doc_type')}}</th>
                    <th style="width: 2%">:</th>
                    <td style="width: 78%">{{currentLocale === 'bn'? item.doc_type.document_type_bn : item.doc_type.document_type_en}}</td>
                  </tr>
                  <tr>
                    <th style="width: 20%"> {{$t('bfti.topic')}}</th>
                    <th style="width: 2%">:</th>
                    <td style="width: 78%">{{ ($i18n.locale === 'bn') ? item.topic_bn : item.topic }}</td>
                  </tr>
                  <tr>
                    <th style="width: 20%"> {{$t('bfti.description')}}</th>
                    <th style="width: 2%">:</th>
                    <td style="width: 78%">{{ ($i18n.locale === 'bn') ? item.description_bn : item.description }}</td>
                  </tr>
                  <tr>
                    <th style="width: 20%"> {{ $t('bfti.budget')}}</th>
                    <th style="width: 2%">:</th>
                    <td style="width: 78%">{{$n(item.budget)}}</td>
                  </tr>
                  <tr>
                    <th style="width: 20%"> {{ $t('bfti.budget_source')}}</th>
                    <th style="width: 2%">:</th>
                    <td style="width: 78%">{{ ($i18n.locale === 'bn') ? item.budget_source_bn : item.budget_source }}</td>
                  </tr>
                  <tr>
                    <th style="width: 20%"> {{ $t('globalTrans.date_from')}}</th>
                    <th style="width: 2%">:</th>
                    <td style="width: 78%">{{ item.duration_start_date | dateFormat }}</td>
                  </tr>
                   <tr>
                    <th style="width: 20%"> {{ $t('globalTrans.date_to')}}</th>
                    <th style="width: 2%">:</th>
                    <td style="width: 78%">{{ item.duration_end_date | dateFormat }}</td>
                  </tr>
                  <tr>
                    <th style="width: 20%"> {{ $t('bfti.duration')}}</th>
                    <th style="width: 2%">:</th>
                    <td style="width: 78%">{{item.duration}}</td>
                  </tr>
                  <tr>
                    <th style="width: 20%"> {{ $t('bfti.attachment')}}</th>
                    <th style="width: 2%">:</th>
                    <td style="width: 78%">
                      <a target="_blank" v-if="item.attachment" :href="bftiResReportServiceBaseUrl + item.attachment">{{ $t('bfti.attachment_down')}}</a>
                    </td>
                  </tr>
                </table>
              </b-col>
            </b-row>
          </template>
        </body-card>
        <body-card>
          <template v-slot:headerTitle>
            <h5 class="card-title" style="font-weight:550;"> {{ $t('bfti.contact_information') }}</h5>
          </template>
          <template v-slot:body>
            <b-row>
              <b-col lg="12" sm="12">
                <table class="table table-sm table-borderless">
                  <tr>
                    <th style="width: 18%"> {{$t('bfti.contact_person')}}</th>
                    <th style="width: 2%">:</th>
                    <td style="width: 30%">{{ ($i18n.locale === 'bn') ? item.name_bn : item.name }}</td>
                  <th style="width: 18%"> {{$t('bfti.designation')}}</th>
                    <th style="width: 2%">:</th>
                  <td style="width: 30%">{{ ($i18n.locale === 'bn') ? item.designation_bn : item.designation }}</td>
                  </tr>
                  <tr>
                    <th style="width: 18%"> {{ $t('globalTrans.organization')}}</th>
                    <th style="width: 2%">:</th>
                    <td style="width: 30%">{{ ($i18n.locale === 'bn') ? item.organization_bn : item.organization }}</td>
                    <th style="width: 18%"> {{ $t('bfti.email')}}</th>
                    <th style="width: 2%">:</th>
                    <td style="width: 30%">{{item.email}}</td>
                  </tr>
                  <tr>
                    <th style="width: 18%"> {{ $t('bfti.contact_number')}}</th>
                    <th style="width: 2%">:</th>
                    <td style="width: 30%">{{ ($i18n.locale === 'bn') ? '০' : '0' }}{{ $n(item.contact_no, { useGrouping: false }) }}</td>
                    <th style="width: 18%"> {{ $t('bfti.submission_date')}}</th>
                    <th style="width: 2%">:</th>
                    <td style="width: 30%">
                      {{item.submission_date|dateFormat}}
                    </td>
                  </tr>
                </table>
              </b-col>
            </b-row>
          </template>
        </body-card>
      </b-col>
    </b-row>
  </div>
</template>
<script>
import RestApi, { bftiResReportServiceBaseUrl } from '@/config/api_config'
import { bftiResearchRequestApproveRejectApi } from '../../api/routes'
export default {
  name: 'Details',
  props: ['item'],
  data () {
    return {
      bftiResReportServiceBaseUrl: bftiResReportServiceBaseUrl,
      valid: null,
      loading: false,
      errors: [],
      detailsData: [],
      detailsItemId: ''
    }
  },
  computed: {
    currentLocale () {
      return this.$i18n.locale
    }
  },
  methods: {
    Approval (item, type) {
      let msg = ''
      if (type === 1) {
        msg = window.vm.$t('globalTrans.approveMsg')
      } else {
        msg = window.vm.$t('globalTrans.rejectMsg')
      }
      window.vm.$swal({
        title: msg,
        showCancelButton: true,
        confirmButtonText: window.vm.$t('globalTrans.yes'),
        cancelButtonText: window.vm.$t('globalTrans.no'),
        focusConfirm: false
      }).then((result) => {
        if (result.isConfirmed) {
          this.acceptReject(item.id, type)
        }
      })
    },
    acceptReject (id, type) {
      const params = {
        id: id,
        status: type
      }
      this.$store.dispatch('mutateCommonProperties', { loading: true })
      const loadingState = { loading: false, listReload: false }
      RestApi.getData(bftiResReportServiceBaseUrl, bftiResearchRequestApproveRejectApi, params)
      .then(response => {
        if (response.success) {
        loadingState.listReload = true
        this.$store.dispatch('mutateCommonProperties', loadingState)
        this.$store.dispatch('CommonService/mutateCommonObj', { hasDropdownLoaded: false })
          window.vm.$toast.success({
            title: 'Success',
            message: 'Data Updated Successfully',
            color: '#D6E09B'
          })
          this.$bvModal.hide('modal-form-details')
          this.loadData()
        } else {
          window.vm.$toast.error({
            title: 'Error',
            message: 'Operation failed! Please, try again.'
          })
        }
      })
    }
  }
}
</script>
