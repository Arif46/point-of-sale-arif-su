<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit, reset }">
    <b-overlay :show="loading">
      <b-form @submit.prevent="handleSubmit(apply)" @reset.prevent="reset" autocomplete="off">
        <b-row>
          <b-col xl="12" lg="12" sm="12">
            <ValidationProvider name="Type" vid="type" rules="required|min:1">
                <b-form-group
                    label-for="type"
                    slot-scope="{ valid, errors }"
                >
                    <b-form-radio-group
                    class="text-left"
                    v-model="app_type"
                    :options="applicationTypeList"
                    :state="errors[0] ? false : (valid ? true : null)"
                    ></b-form-radio-group>
                    <div class="invalid-feedback d-block">
                    {{ errors[0] }}
                </div>
                </b-form-group>
            </ValidationProvider>
            </b-col>
        </b-row>
        <b-row class="text-right">
          <b-col>
            <b-button type="submit" variant="success" class="mr-2 btn-sm">{{ saveBtnName }}</b-button>
            <b-button variant="danger" class="btn-sm" @click="$bvModal.hide('modal-form')">{{ $t('globalTrans.cancel') }}</b-button>
          </b-col>
        </b-row>
      </b-form>
    </b-overlay>
  </ValidationObserver>
</template>
<script>
export default {
  name: 'Form',
  props: ['id', 'item'],
  data () {
    return {
        valid: null,
        saveBtnName: this.$t('globalTrans.ok'),
        errors: [],
        app_type: 1
    }
  },
  computed: {
    loading: function () {
      return this.$store.state.commonObj.loading
    },
    applicationTypeList () {
      return this.$store.state.ExportTrophyCipService.commonObj.applicationTypeList.map(el => {
        return Object.assign({}, el, { text: this.$i18n.locale === 'bn' ? el.text_bn : el.text_en })
      })
    }
  },
  methods: {
    apply () {
      if (this.id) {
        if (this.app_type === 1) {
            this.$router.push(`/export-trophy-cip-panel/cip-application-form?circular_id=${this.id}`)
        } else {
            this.$router.push(`/export-trophy-cip-panel/export-trophy-application-form?circular_id=${this.id}`)
        }
      }
    }
  }
}
</script>
