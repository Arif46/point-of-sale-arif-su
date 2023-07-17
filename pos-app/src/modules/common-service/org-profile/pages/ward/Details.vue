<template>
  <b-row>
   <b-row>
        <b-col lg="12" sm="12">
          <iq-card>
            <template>
                <b-row>
                  <b-col lg="12" sm="12">
                    <b-row>
                      <b-col lg="12" sm="12">
                        <div>
                          <b-table-simple striped bordered small>
                              <b-tr>
                                <b-th>{{ $t('orgProfile.type') }}</b-th>
                                <b-td>{{ (this.$i18n.locale=='bn')? ward.type_bn : ward.type_en }}</b-td>
                              </b-tr>
                              <b-tr>
                                <b-th v-if="ward.type === 2 || ward.type === 3">{{ $t('orgProfile.division_name') }}</b-th>
                                <b-td v-if="ward.type === 2 || ward.type === 3">{{ (this.$i18n.locale=='bn')? ward.division_name_bn : ward.division_name }}</b-td>
                                <b-th v-if="ward.type === 2 || ward.type === 3">{{ $t('orgProfile.district_name') }}</b-th>
                                <b-td v-if="ward.type === 2 || ward.type === 3">{{ (this.$i18n.locale=='bn')? ward.district_name_bn : ward.district_name }}</b-td>
                              </b-tr>
                              <b-tr>
                                <b-th v-if="ward.type === 2 || ward.type === 3">{{ $t('orgProfile.upazila_name') }}</b-th>
                                <b-td v-if="ward.type === 2 || ward.type === 3">{{ (this.$i18n.locale=='bn') ? ward.upazila_name_bn : ward.upazila_name }}</b-td>
                                <b-th v-if="ward.type === 3">{{ $t('orgProfile.union_name') }}</b-th>
                                <b-td v-if="ward.type === 3">{{ (this.$i18n.locale=='bn')? ward.union_name_bn : ward.union_name }}</b-td>
                                <b-th v-if="ward.type === 2">{{ $t('orgProfile.municipality_name') }}</b-th>
                                <b-td v-if="ward.type === 2">{{ (this.$i18n.locale=='bn')? ward.municipality_bn : ward.municipality }}</b-td>
                              </b-tr>
                            <b-tr>
                              <b-th v-if="ward.type === 1">{{ $t('orgProfile.city_corporation') }}</b-th>
                              <b-td v-if="ward.type === 1">{{ (this.$i18n.locale=='bn')? ward.city_corporation_bn : ward.city_corporation }}</b-td>
                            </b-tr>
                          </b-table-simple>
                          <template>
                            <div style="font-size:12px; background-color: #77a0cb; padding:6px">
                              <h5 class="text-white text-center"> {{ $t('orgProfile.ward_name') }}</h5>
                            </div>
                          </template>
                          <b-table bordered hover :items="ward.ward_details" :fields="columns" aria-hidden="loading | listReload ? 'true' : null">
                                <template v-slot:cell(index)="data">
                                {{ $n(data.index + 1) }}
                                </template>
                          </b-table>
                        </div>
                      </b-col>
                    </b-row>
                  </b-col>
              </b-row>
            </template>
          </iq-card>
        </b-col>
      </b-row>
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
      ward: {
        type: 0,
        city_corporation_id: 0,
        division_id: 0,
        district_id: 0,
        upazila_id: 0,
        union_id: 0,
        pauroshoba_id: 0,
        municipality_id: 0,
        ward_details: [
          {
            master_ward_id: 0,
            ward_name: '',
            ward_name_bn: ''
          }
        ]
      }
    }
  },
  created () {
    if (this.id) {
      const tmp = this.getWardDetails()
      this.ward = tmp
    }
  },
  computed: {
    columns () {
      const labels = [
          { label: this.$t('globalTrans.sl_no'), class: 'text-center' },
          { label: this.$t('orgProfile.ward_name'), class: 'text-center' },
          { label: this.$t('orgProfile.ward_name_bn'), class: 'text-center' }
        ]

      let keys = []

      if (this.$i18n.locale === 'bn') {
        keys = [
          { key: 'index' },
          { key: 'ward_name_bn' }
        ]
      } else {
        keys = [
          { key: 'index' },
          { key: 'ward_name' }
        ]
      }

      return labels.map((item, index) => {
          return Object.assign(item, keys[index])
      })
    }
  },
  methods: {
    getWardDetails () {
      const tmpData = this.$store.state.list.find(item => item.id === this.id)
      return JSON.parse(JSON.stringify(tmpData))
    }
  }
}
</script>
