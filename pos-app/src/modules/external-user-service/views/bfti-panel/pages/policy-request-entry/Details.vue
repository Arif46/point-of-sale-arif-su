<template>
      <b-row>
        <b-col lg="12" sm="12">
          <body-card>
            <template>
              <b-row>
                <b-col md="12 text-left">
                    <span class="btn btn-primary"><h5>{{ $t('policy_advocacy.policy_information') }}</h5></span>
                  </b-col>
                  <b-col lg="12" sm="12">
                   <b-table-simple hover small caption-top responsive striped bordered>
                     <b-tr>
                      <b-th style="width:20%">{{ $t('meeting_management.memo_no') }}</b-th>
                      <b-td style="width:30%">{{ item.memo_no }}</b-td>
                      <b-th style="width:20%">{{ $t('bfti.submission_date') }}</b-th>
                      <b-td style="width:30%">{{ item.submission_date | dateFormat }}</b-td>
                    </b-tr>
                     <tr>
                        <th> {{$t('policy_advocacy.policy_title')}}</th>
                       <td>{{currentLocale === 'bn'? item.policy_title_bn : item.policy_title}}</td>
                       <th> {{ $t('bfti.attachment')}}</th>
                       <td>
                         <a v-if="item.attachment" class="btn btn-success btn-sm rounded-pill mr-1" target="_blank" :href="baseUrl + 'download-attachment?file=' + item.attachment" title="attachment"><i class="ri-download-cloud-fill"></i></a>
                         <a target="_blank" v-if="item.attachment" :href="baseUrl +item.attachment">{{ $t('bfti.attachment_down')}}</a>
                       </td>
                     </tr>
                      <tr>
                       <th> {{$t('policy_advocacy.description_instruction')}}</th>
                       <td colspan="3">{{currentLocale === 'bn'? item.description_bn : item.description}}</td>
                     </tr>
                   </b-table-simple>
                  </b-col>
                    <b-col md="12 text-left">
                     <span class="btn btn-primary"><h5>{{ $t('policy_advocacy.focal_point_information') }}</h5></span>
                  </b-col>
                  <b-col lg="12" sm="12">
                    <b-table-simple hover small caption-top responsive striped bordered>
                      <tr>
                       <th style="width: 20%"> {{$t('globalTrans.name')}}</th>
                       <td style="width: 30%">{{currentLocale === 'bn'? item.name_bn : item.name}}</td>
                       <th style="width: 20%"> {{$t('globalTrans.designation')}}</th>
                       <td style="width: 30%">{{currentLocale === 'bn'? item.designation_bn : item.designation}}</td>
                      </tr>
                      <tr>
                        <th> {{ $t('bfti.organization')}}</th>
                        <td>{{currentLocale === 'bn'? item.organization_bn : item.organization}}</td>
                        <th> {{ $t('bfti.contact_number')}}</th>
                        <td>{{item.contact_no | mobileNumber}}</td>
                      </tr>
                      <tr>
                        <th> {{ $t('bfti.email')}}</th>
                        <td colspan="3">{{item.email}}</td>
                      </tr>
                     </b-table-simple>
                  </b-col>
              </b-row>
            </template>
          </body-card>
        </b-col>
      </b-row>
</template>
<script>
import { bftiResReportServiceBaseUrl } from '@/config/api_config'
export default {
  name: 'Details',
  props: ['item'],
  data () {
    return {
      loading: false,
      errors: [],
      baseUrl: bftiResReportServiceBaseUrl,
      detailsData: [],
      detailsItemId: ''
    }
  },
  computed: {
    currentLocale () {
      return this.$i18n.locale
    }
  }
}
</script>
