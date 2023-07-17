<template>
  <b-row>
    <b-col>
      <div class="table-wrapper">
        <b-table-simple hover small caption-top responsive striped bordered>
          <b-tbody>
            <b-tr>
              <b-td style="width:30%"><b>{{ $t('menu.component_name') }}</b></b-td>
              <b-td style="width:5%" class="text-center">:</b-td>
              <b-td class="text-left">
                {{ ($i18n.locale==='bn') ? details.component_name_bn : details.component_name }}
              </b-td>
            </b-tr>
            <b-tr>
              <b-td><b>{{ $t('globalTrans.description') }}</b></b-td>
              <b-td>:</b-td>
              <b-td class="text-left">
                {{ ($i18n.locale==='bn') ? details.description_bn : details.description }}
              </b-td>
            </b-tr>
            <b-tr>
              <b-td><b> {{ $t('globalTrans.status') }}</b></b-td>
              <b-td class="text-center">:</b-td>
              <b-td class="text-left">
                <span class="badge badge-success" v-if="details.status === 1">{{$t('globalTrans.active')}}</span>
                <span class="badge badge-danger" v-else>{{$t('globalTrans.inactive')}}</span>
              </b-td>
            </b-tr>
          </b-tbody>
        </b-table-simple>
      </div>
    </b-col>
  </b-row>
</template>
<script>
export default {
  name: 'Details',
  props: ['id'],
  data () {
    return {
      valid: null,
      errors: [],
      details: {
        component_name: '',
        component_name_bn: '',
        description: '',
        description_bn: '',
        sorting_order: ''
      }
    }
  },
  created () {
    if (this.id) {
      const tmp = this.getComponent()
      this.details = tmp
    }
  },
  methods: {
    getComponent () {
      const tmpData = this.$store.state.list.find(item => item.id === this.id)
      return JSON.parse(JSON.stringify(tmpData))
    }
  }
}
</script>
