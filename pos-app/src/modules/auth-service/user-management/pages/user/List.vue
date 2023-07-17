<template>
  <div class="inner-section">
    <card>
      <!-- search section start -->
      <template v-slot:searchHeaderTitle>
        <h4 class="card-title">{{ $t('userManagement.user') }}</h4>
      </template>
      <template v-slot:searchBody>
        <b-row>
          <b-col xs="12" sm="6" md="4">
            <b-form-group
              class="row"
              label-cols-sm="5"
              label-for="name"
            >
              <template v-slot:label>
                {{ $t('userManagement.namel') }}
              </template>
              <b-form-input
                  id="name"
                  type="text"
                  v-model="search.name"
              ></b-form-input>
            </b-form-group>
          </b-col>
          <b-col xs="12" sm="6" md="4">
            <b-form-group
              class="row"
              label-cols-sm="5"
              label-for="org_id"
              :label="$t('globalTrans.organization')"
            >
              <b-form-select
                  plain
                  v-model="search.org_id"
                  :options="orgList"
                >
                <template v-slot:first>
                  <b-form-select-option :value="0">{{$t('globalTrans.select')}}</b-form-select-option>
                </template>
              </b-form-select>
            </b-form-group>
          </b-col>
          <b-col xs="12" sm="12" md="4">
            <b-button type="button" variant="primary" @click="searchData">{{ $t('globalTrans.search')}}</b-button>
          </b-col>
        </b-row>
      </template>
      <!-- search section end -->
    </card>

    <body-card>
      <!-- table section start -->
      <template v-slot:headerTitle>
        <h4 class="card-title">{{ $t('userManagement.user_list') }}</h4>
      </template>
      <template v-slot:headerAction>
        <a href="javascript:" class="btn-add" @click="resetId" v-b-modal.modal-form><i class="ri-add-fill"></i> {{ $t('globalTrans.add_new') }}</a>
      </template>
      <template v-slot:body>
        <b-overlay :show="loadingState">
          <base-table v-on:editMethodInParent="editMethodInParent" :labelData="labelData" :columns="columns" :search="search" :searchData="searchData" :paginations="pagination" :actions="actions" />
        </b-overlay>
      </template>
      <!-- table section end -->
    </body-card>
    <b-modal id="modal-form" size="xl" :title="formTitle" hide-footer :ok-title="$t('globalTrans.close')" ok-only ok-variant="danger">
      <Form :id="editItemId" :key="editItemId" :secretQuestionList="secretQuestionList"/>
    </b-modal>
    <b-modal id="details" size="xl" :title="$t('globalTrans.user') + ' ' + $t('globalTrans.details')"  hide-footer :ok-title="$t('globalTrans.close')" ok-only ok-variant="danger">
      <Details :id="editItemId" :key="editItemId" :secretQuestionList="secretQuestionList"/>
    </b-modal>
  </div>
</template>
<script>
import Form from './Form.vue'
import Details from './Details.vue'
import RestApi, { authServiceBaseUrl } from '@/config/api_config'
import { secretQuestionAllList, userList, userToggle } from '../../api/routes'
import ModalBaseMasterList from '@/mixins/list'
import i18n from '@/i18n'

const defaultColumn = [
  { label_en: i18n.messages.en.globalTrans.sl_no, label_bn: i18n.messages.bn.globalTrans.sl_no, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 1, thStyle: { width: '9%' } },
  { label_en: i18n.messages.en.userManagement.namel, label_bn: i18n.messages.bn.userManagement.namel, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 2, thStyle: { width: '20%' } },
  { label_en: i18n.messages.en.globalTrans.email, label_bn: i18n.messages.bn.globalTrans.email, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 3, thStyle: { width: '20%' } },
  { label_en: i18n.messages.en.userManagement.username, label_bn: i18n.messages.bn.userManagement.username, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 4, thStyle: { width: '10%' } },
  { label_en: i18n.messages.en.globalTrans.organization, label_bn: i18n.messages.bn.globalTrans.organization, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 5, thStyle: { width: '20%' } },
  { label_en: i18n.messages.en.globalTrans.status, label_bn: i18n.messages.bn.globalTrans.status, class: 'text-left', sortable: true, stickyColumn: true, show: '1', order: 6 },
  { label_en: i18n.messages.en.globalTrans.action, label_bn: i18n.messages.bn.globalTrans.action, class: 'text-left', show: '1', order: 7 }
]
export default {
  mixins: [ModalBaseMasterList],
  components: {
    Form,
    Details
  },
  data () {
    return {
      search: {
        name: '',
        org_id: 0,
        user_type: 1,
        limit: 20
      },
      labelData: [],
      actions: {
        edit: true,
        details: true,
        toogle: true,
        delete: false
      },
      secretQuestionList: []
    }
  },
  created () {
    this.labelData = this.labelList
    this.loadData()
    this.getSecretQuestionList()
  },
  watch: {
    'search.limit': function (newVal, oldVal) {
      if (newVal !== oldVal) {
        this.loadData()
      }
    }
  },
  computed: {
    labelList: function () {
      const dataList = defaultColumn
      return dataList.map(item => {
        if (this.$i18n.locale === 'bn') {
          const data = { value: item.label_en, text: item.label_bn }
          return Object.assign({}, item, data)
        } else {
          const data = { value: item.label_en, text: item.label_en }
          return Object.assign({}, item, data)
        }
      })
    },
    columns () {
      const labelData = this.labelData
      const labels = labelData.map((item, index) => {
        const labelData = {}
        labelData.label = this.$i18n.locale === 'bn' ? item.label_bn : item.label_en
        return Object.assign(item, labelData)
      })
      let keys = []
      if (this.$i18n.locale === 'bn') {
        keys = [
          { key: 'serial' },
          { key: 'name_bn' },
          { key: 'email' },
          { key: 'username' },
          { key: 'org_name_bn' },
          { key: 'status' },
          { key: 'action' }
        ]
      } else {
        keys = [
          { key: 'serial' },
          { key: 'name' },
          { key: 'email' },
          { key: 'username' },
          { key: 'org_name' },
          { key: 'status' },
          { key: 'action' }
        ]
      }
      return labels.map((item, index) => {
        return Object.assign(item, keys[index])
      })
    },
    orgList: function () {
      return this.$store.state.CommonService.commonObj.orgProfileList
    },
    formTitle () {
      return (this.editItemId === 0) ? this.$t('userManagement.user') + ' ' + this.$t('globalTrans.entry') : this.$t('userManagement.user') + ' ' + this.$t('globalTrans.modify')
    }
  },
  methods: {
    editMethodInParent (item, type) {
      if (type === 1) {
        this.edit(item)
      } else if (type === 2) {
        this.changeStatus(1, authServiceBaseUrl, userToggle, item)
      }
    },
    searchData () {
      this.loadData()
    },
    getSecretQuestionList () {
      RestApi.getData(authServiceBaseUrl, secretQuestionAllList).then(response => {
        const questionList = response.data.map(item => {
          if (this.$i18n.locale === 'bn') {
            return Object.assign(item, { value: item.id, text: item.question_name })
          } else {
            return Object.assign(item, { value: item.id, text: item.question_name_bn })
          }
        })
        this.secretQuestionList = questionList
      })
    },
    async loadData () {
      const params = Object.assign({}, this.search, { page: this.pagination.currentPage, per_page: this.pagination.perPage })
      this.$store.dispatch('mutateCommonProperties', { loading: true, listReload: false })
      const result = await RestApi.getData(authServiceBaseUrl, userList, params)
      if (result.success) {
        this.$store.dispatch('setList', this.getRelationalData(result.data.data))
        this.paginationData(result.data, this.search.limit)
      } else {
        this.$store.dispatch('setList', [])
        this.paginationData([])
      }
      this.$store.dispatch('mutateCommonProperties', { loading: false, listReload: false })
    },
    getRelationalData (data) {
      return data.map((item, index) => {
        let answer = ''
        if (item.answer === null) {
          answer = {
            user_id: item.id,
            secret_question_id: 0,
            answer: ''
          }
        } else {
          answer = {
            id: item.answer.id,
            user_id: item.answer.user_id,
            secret_question_id: item.answer.secret_question_id,
            answer: item.answer.answer
          }
        }
        const org = this.orgList.find(org => org.value === item.details.org_id)
        return Object.assign({}, item, {
          org_name: typeof org !== 'undefined' ? org.text_en : '',
          org_name_bn: typeof org !== 'undefined' ? org.text_bn : '',
          password: '',
          answer: answer,
          serial: index
        })
      })
    }
  }
}
</script>
