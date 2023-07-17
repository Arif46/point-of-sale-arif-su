<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit, reset }">
    <b-overlay :show="loading">
    <b-form @submit.prevent="handleSubmit(saveUpdate)" @reset.prevent="reset" autocomplete="off">
      <b-row>
        <b-col sm="12">
          <ValidationProvider name="Dialogue (En)" vid="dialogue" rules="required" v-slot="{ errors }">
            <b-form-group
              label-for="dialogue">
              <template v-slot:label>
                {{ $t('orgProfile.dialogue_en') }} <span class="text-danger">*</span>
              </template>
              <b-form-input
                id="dialogue"
                v-model="dialogue.dialogue"
                :state="errors[0] ? false : (valid ? true : null)"
              ></b-form-input>
              <div class="invalid-feedback">
                {{ errors[0] }}
              </div>
            </b-form-group>
          </ValidationProvider>
        </b-col>
        <b-col sm="12">
          <ValidationProvider name="Dialogue (Bn)" vid="dialogue_bn" rules="required" v-slot="{ errors }">
            <b-form-group
              label-for="dialogue_bn">
              <template v-slot:label>
                {{ $t('orgProfile.dialogue_bn') }} <span class="text-danger">*</span>
              </template>
              <b-form-input
                id="dialogue_bn"
                v-model="dialogue.dialogue_bn"
                :state="errors[0] ? false : (valid ? true : null)"
              ></b-form-input>
              <div class="invalid-feedback">
                {{ errors[0] }}
              </div>
            </b-form-group>
          </ValidationProvider>
        </b-col>
         <b-col sm="12">
          <ValidationProvider name="Position" vid="position" rules="required">
            <b-form-group
            class="row"
            label-for="position"
            slot-scope="{ valid, errors }"
            >
            <template v-slot:label>
              {{$t('orgProfile.position')}} <span class="text-danger">*</span>
            </template>
            <b-form-select
            plain
            id="position"
            v-model="dialogue.position"
            :options="positionList"
            :state="errors[0] ? false : (valid ? true : null)"
            >
            <template v-slot:first>
              <b-form-select-option :value="0" disabled>{{$t('globalTrans.select')}}</b-form-select-option>
            </template>
            </b-form-select>
            <div class="invalid-feedback">
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
import RestApi, { commonServiceBaseUrl } from '@/config/api_config'
import { dialogueInfoStore, dialogueInfoUpdate } from '../../api/routes'
export default {
  name: 'Form',
  props: ['id'],
  data () {
    return {
      valid: null,
      saveBtnName: this.id ? this.$t('globalTrans.update') : this.$t('globalTrans.save'),
      errors: [],
      dialogue: {
         id: '',
        dialogue: '',
        dialogue_bn: '',
        position: ''
      },
       position: [
        {
          text: 'Left Bottom',
          text_bn: 'বামে-নিচে',
          value: 1
        },
        {
          text: 'Left Top',
          text_bn: 'বামে-উপরে',
          value: 2
        }
      ]
    }
  },
  computed: {
    positionList () {
      return this.position.map(item => {
        if (this.$i18n.locale === 'bn') {
          return { value: item.value, text: item.text_bn }
        } else {
          return { value: item.value, text: item.text }
        }
      })
    }
  },
  loading: function () {
      return this.$store.state.commonObj.loading
  },
  created () {
    if (this.id) {
      const tmp = this.getDialogue()
      this.dialogue = tmp
    }
  },
  methods: {
    async saveUpdate () {
      this.$store.dispatch('mutateCommonProperties', { loading: true })
      let result = null
      const loadingState = { loading: false, listReload: false }

      if (this.id) {
        result = await RestApi.putData(commonServiceBaseUrl, `${dialogueInfoUpdate}/${this.id}`, this.dialogue)
      } else {
        result = await RestApi.postData(commonServiceBaseUrl, dialogueInfoStore, this.dialogue)
      }

      loadingState.listReload = true
      this.$store.dispatch('mutateCommonProperties', loadingState)

      if (result.success) {
        this.$store.dispatch('CommonService/mutateCommonObj', { hasDropdownLoaded: false })
        this.$toast.success({
          title: 'Success',
          message: this.id ? this.$t('globalTrans.update_msg') : this.$t('globalTrans.save_msg'),
          color: '#D6E09B'
        })

        this.$bvModal.hide('modal-form')
      } else {
        this.$refs.form.setErrors(result.errors)
      }
    },
    getDialogue () {
      const tmpData = this.$store.state.list.find(item => item.id === this.id)
      return JSON.parse(JSON.stringify(tmpData))
    }
  }
}
</script>
