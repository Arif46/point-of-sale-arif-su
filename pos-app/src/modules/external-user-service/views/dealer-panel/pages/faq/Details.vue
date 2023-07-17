<template>
      <b-row>
        <b-col lg="12" sm="12">
          <body-card>
            <template>
                <b-row>
                  <b-col md="12 text-center pt-2">
                    <span class="badge badge-primary card-title"><h5>{{ $t('bfti.research_and_other_request') }}</h5></span>
                  </b-col>
                  <b-col lg="12" sm="12">
                   <table class="table table-borderless">
                     <tr>
                       <th style="width: 30%"> {{$t('bfti.doc_type')}}</th>
                       <td style="width: 70%">{{currentLocale === 'bn'? item.doc_type.document_type_bn : item.doc_type.document_type_en}}</td>
                     </tr>
                     <tr>
                       <th> {{$t('bfti.topic')}}</th>
                       <td>{{ item.topic}}</td>
                     </tr> <tr>
                     <th> {{$t('bfti.description')}}</th>
                     <td>{{ item.description}}</td>
                   </tr>
                     <tr>
                       <th> {{ $t('bfti.budget')}}</th>
                       <td>{{$n(item.budget)}}</td>
                     </tr>
                     <tr>
                       <th> {{ $t('bfti.budget_source')}}</th>
                       <td>{{item.budget_source}}</td>
                     </tr>
                     <tr>
                       <th> {{ $t('bfti.duration')}}</th>
                       <td>{{item.duration}}</td>
                     </tr>
                     <tr>
                       <th> {{ $t('bfti.attachment')}}</th>
                       <td>
                         <a :href="'/'+item.attachment">{{ $t('bfti.attachment_down')}}</a>
                       </td>
                     </tr>
                   </table>
                  </b-col>
                  <b-col md="12 text-center">
                    <span class="badge badge-primary card-title"><h5>{{ $t('bfti.contact_information') }}</h5></span>
                  </b-col>
                  <b-col lg="12" sm="12">
                    <table class="table table-sm table-borderless">
                      <tr>
                        <th style="width: 30%"> {{$t('bfti.contact_person')}}</th>
                        <td style="width: 70%">{{ item.name}}</td>
                      </tr>
                      <tr>
                      <th> {{$t('bfti.designation')}}</th>
                      <td>{{ item.designation}}</td>
                    </tr>
                      <tr>
                        <th> {{ $t('bfti.organization')}}</th>
                        <td>{{item.organization}}</td>
                      </tr>
                      <tr>
                        <th> {{ $t('bfti.email')}}</th>
                        <td>{{item.email}}</td>
                      </tr>
                      <tr>
                        <th> {{ $t('bfti.contact_number')}}</th>
                        <td>{{item.contact_no}}</td>
                      </tr>
                      <tr>
                        <th> {{ $t('bfti.submission_date')}}</th>
                        <td>
                         {{item.submission_date}}
                        </td>
                      </tr>
                    </table>
                  </b-col>
              </b-row>
            </template>
          </body-card>
        </b-col>
      </b-row>
</template>
<script>
export default {
  name: 'Details',
  props: ['item'],
  data () {
    return {
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
  }
}
</script>
