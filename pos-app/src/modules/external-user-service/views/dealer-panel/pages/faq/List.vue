<template>
  <div class="inner-section">
    <card>
    </card>

    <body-card>
      <!-- table section start -->
      <template v-slot:headerTitle>
        <h4 class="card-title">{{ $t('dealer.faq') }} {{ $t('globalTrans.list') }}</h4>
      </template>
      <template v-slot:body>
        <b-overlay :show="loadingState">
        <div>
          <p class="text-danger">{{ QaList.lenght }}</p>
        </div>
         <!-- <div v-for="qa in QaList" :key="qa.id">
          <h1 style="border-left: 1rem solid red;"><span style="color:red">Q.</span> {{ qa.question }}</h1>
          <h1 v-if="qa.answer != null" style="border-left: 1rem solid green;"><span style="color:green">A.</span> {{ qa.answer }}</h1>
         </div> -->
          <template>
            <div class="accordion" role="tablist">
              <b-card v-for="qa in QaList" :key="qa.id"  no-body class="mb-1">
                <b-card-header header-tag="header" class="p-1" role="tab">
                  <b-button class="text-left" block  v-b-toggle="`accordion-${qa.id}`" variant="info">{{ qa.question }} </b-button>
                </b-card-header>
                <b-collapse :id="`accordion-${qa.id}`" visible accordion="my-accordion" role="tabpanel">
                  <b-card-body>
                    <b-card-text> {{ qa.answer }}</b-card-text>
                  </b-card-body>
                </b-collapse>
              </b-card>

              <!-- <b-card no-body class="mb-1">
                <b-card-header header-tag="header" class="p-1" role="tab">
                  <b-button block v-b-toggle.accordion-2 variant="info">Accordion 2</b-button>
                </b-card-header>
                <b-collapse id="accordion-2" accordion="my-accordion" role="tabpanel">
                  <b-card-body>
                    <b-card-text>{{ text }}</b-card-text>
                  </b-card-body>
                </b-collapse>
              </b-card>

              <b-card no-body class="mb-1">
                <b-card-header header-tag="header" class="p-1" role="tab">
                  <b-button block v-b-toggle.accordion-3 variant="info">Accordion 3</b-button>
                </b-card-header>
                <b-collapse id="accordion-3" accordion="my-accordion" role="tabpanel">
                  <b-card-body>
                    <b-card-text>{{ text }}</b-card-text>
                  </b-card-body>
                </b-collapse>
              </b-card> -->
            </div>
          </template>
        </b-overlay>
      </template>
      <!-- table section end -->
    </body-card>
  </div>
</template>
<style scoped>
  table#table-transition-example .flip-list-move {
    transition: transform 1s;
  }
</style>
<script>
  import RestApi, { licenseRegistrationServiceBaseUrl } from '@/config/api_config'
  import { faqList } from '../../api/routes'
  import ModalBaseMasterList from '@/mixins/list'
  export default {
    mixins: [ModalBaseMasterList],
    data () {
      return {
        sortBy: '',
        item: '',
        sortDesc: true,
        sortDirection: 'desc',
        labelData: [],
        editItem: [],
        QaList: [],
        text: 'dfaslfkl fdsdaflk',
        editItemId: 0
      }
    },
    created () {
      this.labelData = this.labelList
      this.loadData()
    },
    watch: {
    },
    computed: {
      currentLocale () {
        return this.$i18n.locale
      }
    },
    methods: {
      async loadData () {
        this.$store.dispatch('mutateCommonProperties', { loading: true, listReload: false })
        const result = await RestApi.getData(licenseRegistrationServiceBaseUrl, faqList)
        if (result.success) {
          this.$store.dispatch('setList', result.data)
          this.QaList = result.data
        } else {
          this.$store.dispatch('setList', [])
          this.paginationData([])
        }
        this.$store.dispatch('mutateCommonProperties', { loading: false, listReload: false })
      },
      details (item) {
        this.item = item
      }
    }
  }
</script>
