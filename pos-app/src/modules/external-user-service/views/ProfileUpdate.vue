<template>
  <div class="inner-section">
    <bread-cumb />
    <body-card>
      <template v-slot:headerTitle>
        <h4 class="card-title">{{ $t('sideBar.profile') }} {{ $t('globalTrans.update') }}</h4>
      </template>
      <template v-slot:headerAction>
          <b-link v-if="profile.id" class="btn-add" to="/external-user/profile">
            <i class="ri-eye-fill"></i>{{ ' ' + $t('globalTrans.details') }}
        </b-link>
      </template>
      <template v-slot:body>
        <ValidationObserver ref="form" v-slot="{ handleSubmit, reset }">
            <b-overlay :show="loading">
                <b-form @submit.prevent="handleSubmit(saveUpdate)" @reset.prevent="reset" autocomplete="off">
                    <b-row>
                        <b-col lg="6" md="6" sm="12">
                            <b-row>
                                <b-col xl="12" lg="12" sm="12">
                                    <ValidationProvider name="Name (En)" vid="name" rules="required" v-slot="{ errors }">
                                        <b-form-group
                                        label-for="name"
                                        label-cols-sm="5"
                                        >
                                        <template v-slot:label>
                                            {{ $t('globalTrans.name_en') }} <span class="text-danger">*</span>
                                        </template>
                                        <b-form-input
                                            id="name"
                                            disabled
                                            v-model="commonInfo.name"
                                            :state="errors[0] ? false : (valid ? true : null)"
                                        ></b-form-input>
                                        <div class="invalid-feedback">
                                            {{ errors[0] }}
                                        </div>
                                        </b-form-group>
                                    </ValidationProvider>
                                </b-col>
                                <b-col xl="12" lg="12" sm="12">
                                    <ValidationProvider name="Name (Bn)" vid="name_bn" rules="required" v-slot="{ errors }">
                                        <b-form-group
                                        label-for="name_bn"
                                        label-cols-sm="5"
                                        >
                                        <template v-slot:label>
                                            {{ $t('globalTrans.name_bn') }} <span class="text-danger">*</span>
                                        </template>
                                        <b-form-input
                                            id="name_bn"
                                            disabled
                                            v-model="commonInfo.name_bn"
                                            :state="errors[0] ? false : (valid ? true : null)"
                                        ></b-form-input>
                                        <div class="invalid-feedback">
                                            {{ errors[0] }}
                                        </div>
                                        </b-form-group>
                                    </ValidationProvider>
                                </b-col>
                                <b-col xl="12" lg="12" sm="12">
                                    <ValidationProvider name="Email" vid="email" rules="" v-slot="{ errors }">
                                        <b-form-group
                                            class="row"
                                            label-cols-sm="5"
                                            label-for="email"
                                        >
                                        <template v-slot:label>
                                            {{ $t('globalTrans.email') }}
                                            </template>
                                            <b-form-input
                                            id="org_bn"
                                            disabled
                                            type="email"
                                            v-model="commonInfo.email"
                                            :state="errors[0] ? false : (valid ? true : null)"
                                            ></b-form-input>
                                            <div class="invalid-feedback">
                                            {{ errors[0] }}
                                            </div>
                                        </b-form-group>
                                    </ValidationProvider>
                                </b-col>
                            </b-row>
                        </b-col>
                        <!-- image  -->
                        <b-col lg="6" sm="12">
                            <b-row>
                                <b-col lg="12" md="12" sm="12">
                                    <ValidationProvider name="Photo" vid="photo" v-slot="{ errors }">
                                        <b-form-group
                                            class="mb-0"
                                            label-cols-sm="5"
                                            label-for="photo"
                                        >
                                            <template v-slot:label>
                                                {{$t('globalTrans.photo')}}
                                            </template>
                                            <b-form-file
                                                v-on:change="handlePhoto"
                                                accept="image/*"
                                                v-model="photo"
                                                plain
                                                :state="errors[0] ? false : (valid ? true : null)"
                                            ></b-form-file>
                                            <div class="invalid-feedback">
                                                {{ errors[0] }}
                                            </div>
                                        </b-form-group>
                                    </ValidationProvider>
                                </b-col>
                                <b-col lg="12" md="12" sm="12" >
                                    <b-form-group
                                        label-for="photo"
                                        label-cols-sm="5"
                                    >
                                        <template v-slot:label>
                                        </template>
                                        <img v-if="profile.pre_image && isShow && !profile.image" class="img-thumbnail w-50" style="height: 130px;" :src="baseUrl + 'download-attachment?file=app/public/' + profile.pre_image" alt="">
                                        <img v-else class="img-thumbnail w-50" style="height: 130px" :src="profile.image ? profile.image : preview" alt="Image">
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col xl="6" lg="6" sm="12">
                            <ValidationProvider name="Mobile No" vid="mobile" v-slot="{ errors }" rules="required|min:11|max:11">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="mobile"
                                >
                                <template v-slot:label>
                                    {{ $t('globalTrans.mobile') }} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        disabled
                                        v-model="commonInfo.mobile"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                        <b-col xl="6" lg="6" sm="12">
                            <ValidationProvider name="NID No" vid="nid_no" rules="required|min:8" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="nid"
                                >
                                <template v-slot:label>
                                    {{ $t('globalTrans.nid') }} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-input
                                        v-model="profile.nid_no"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    ></b-form-input>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                        <b-col lg="6" sm="12">
                            <ValidationProvider name="Father's Name (En)" vid="father_name_en" rules="required" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="father_name_en"
                                >
                                <template v-slot:label>
                                    {{ $t('globalTrans.father_name') + ' ' + $t('globalTrans.en')}} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    v-model="profile.father_name_en"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                        <b-col lg="6" sm="12">
                            <ValidationProvider name="Father's Name (Bn)" vid="father_name_bn" rules="required" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="father_name_bn"
                                >
                                <template v-slot:label>
                                    {{ $t('globalTrans.father_name') + ' ' + $t('globalTrans.bn')}} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    v-model="profile.father_name_bn"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                        <b-col lg="6" sm="12">
                            <ValidationProvider name="Mother's Name (En)" vid="mother_name_en" rules="required" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="mother_name_en"
                                >
                                <template v-slot:label>
                                    {{ $t('globalTrans.mother_name') + ' ' + $t('globalTrans.en')}} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    v-model="profile.mother_name_en"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                        <b-col lg="6" sm="12">
                            <ValidationProvider name="Mother's Name (Bn)" vid="mother_name_bn" rules="required" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="mother_name_bn"
                                >
                                <template v-slot:label>
                                    {{ $t('globalTrans.mother_name') + ' ' + $t('globalTrans.bn')}} <span class="text-danger">*</span>
                                </template>
                                <b-form-input
                                    v-model="profile.mother_name_bn"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col lg="6" sm="12">
                            <ValidationProvider name="Gender" vid='gender' rules="required|min_value:1" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="gender"
                                >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.gender') }} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-select
                                        plain
                                        v-model="profile.gender"
                                        :options="genderList"
                                        id="gender"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    >
                                    <template v-slot:first>
                                        <b-form-select-option :value="0">{{$t('globalTrans.select')}}</b-form-select-option>
                                    </template>
                                    </b-form-select>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                        <b-col lg="6" sm="12">
                            <ValidationProvider name="Date of Birth" vid="dob" rules="required" v-slot="{ errors }">
                                <b-form-group
                                    label-for="dob"
                                    label-cols-sm="5"
                                    >
                                    <template v-slot:label>
                                        {{ $t('globalTrans.dob') }} <span class="text-danger">*</span>
                                    </template>
                                    <b-form-datepicker
                                        id="dob"
                                        v-model="profile.dob"
                                        value=""
                                        class="form-control"
                                        :placeholder="$t('globalTrans.select_date')"
                                        :state="errors[0] ? false : (valid ? true : null)"
                                    >
                                    </b-form-datepicker>
                                    <div class="invalid-feedback">
                                        {{ errors[0] }}
                                    </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col lg="6" sm="12">
                            <ValidationProvider name="Birth Place (En)" vid="birth_place_en" rules="max:100" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="birth_place_en"
                                >
                                <template v-slot:label>
                                    {{ $t('externalUser.birth_place') + ' ' + $t('globalTrans.en')}}
                                </template>
                                <b-form-input
                                    v-model="profile.birth_place_en"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                        <b-col lg="6" sm="12">
                            <ValidationProvider name="Birth Place (Bn)" vid="birth_place_bn" rules="max:100" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="birth_place_bn"
                                >
                                <template v-slot:label>
                                    {{ $t('externalUser.birth_place') + ' ' + $t('globalTrans.bn')}}
                                </template>
                                <b-form-input
                                    v-model="profile.birth_place_bn"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                        <b-col lg="6" sm="12">
                            <ValidationProvider name="Nationality (En)" vid="nationality_en" rules="max:50" v-slot="{ errors }">
                                <b-form-group
                                    class="row"
                                    label-cols-sm="5"
                                    label-for="nationality_en"
                                >
                                <template v-slot:label>
                                    {{$t('globalTrans.nationality') + ' ' + $t('globalTrans.en')}}
                                </template>
                                <b-form-input
                                    v-model="profile.nationality_en"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                    <div class="invalid-feedback">
                                    {{ errors[0] }}
                                    </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                        <b-col lg="6" sm="12">
                            <ValidationProvider name="Nationality (Bn)" vid="nationality_bn" rules="max:50" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="nationality_bn"
                                >
                                <template v-slot:label>
                                    {{$t('globalTrans.nationality') + ' ' + $t('globalTrans.bn')}}
                                </template>
                                <b-form-input
                                    v-model="profile.nationality_bn"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                    <div class="invalid-feedback">
                                    {{ errors[0] }}
                                    </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                        <b-col lg="6" sm="12">
                            <ValidationProvider name="Occupation (En)" vid="occupation_en" rules="max:50" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="occupation_en"
                                >
                                <template v-slot:label>
                                    {{$t('globalTrans.occupation') + ' ' + $t('globalTrans.en')}}
                                </template>
                                <b-form-input
                                    v-model="profile.occupation_en"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                        <b-col lg="6" sm="12">
                            <ValidationProvider name="Occupation (Bn)" vid="occupation_bn" rules="max:50" v-slot="{ errors }">
                                <b-form-group
                                    label-cols-sm="5"
                                    label-for="occupation_bn"
                                >
                                <template v-slot:label>
                                    {{$t('globalTrans.occupation') + ' ' + $t('globalTrans.bn')}}
                                </template>
                                <b-form-input
                                    v-model="profile.occupation_bn"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                ></b-form-input>
                                    <div class="invalid-feedback">
                                    {{ errors[0] }}
                                    </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                    </b-row>
                    <!-- Present Address -->
                    <b-row>
                        <b-col sm="12" style="max-width: 22%">
                            <p class="text-black" style="border-bottom: 1px solid #ddd; font-weight: bold">
                                {{ $t('globalTrans.present_address') + ' :' }}
                            </p>
                        </b-col>
                        <b-col v-if="isShow" lg="12" md="12" sm="12">
                            <Address :data="pr_address" :addressType="'present'" :param="fieldObj" @pr-address-data="receivePrAddress" title="Present Address"/>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col lg="6" sm="12">
                            <ValidationProvider name="Address Status" vid="is_same" v-slot="{ errors }">
                                <b-form-group
                                    class="row mb-0"
                                    label-cols-sm="5"
                                    label-for="is_same"
                                >
                                <template v-slot:label>
                                    <div style="border-bottom: 1px solid #ddd; font-weight: bold">
                                        {{ $t('globalTrans.permanent_address') + ' :' }}
                                    </div>
                                </template>
                                <b-form-checkbox
                                    v-model="profile.is_same"
                                    @change="isSameAsPermanent($event)"
                                    value="1"
                                    unchecked-value="0"
                                    :state="errors[0] ? false : (valid ? true : null)"
                                >
                                <span class="text-black">{{ $t('globalTrans.same') + ' ?' }}</span>
                                </b-form-checkbox>
                                <div class="invalid-feedback">
                                    {{ errors[0] }}
                                </div>
                                </b-form-group>
                            </ValidationProvider>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col v-if="isShow" lg="12" md="12" sm="12">
                            <Address :data="pm_address" :addressType="'permanent'" :param="fieldObj" @pm-address-data="receivePmAddress" title="Permanent Address"/>
                        </b-col>
                    </b-row>
                    <b-row class="text-right">
                        <b-col>
                            <b-button type="submit" variant="success" class="mr-2 btn-sm">{{ saveBtnName }}</b-button>
                            <b-button variant="danger" class="btn-sm" @click="cancel">{{ $t('globalTrans.cancel') }}</b-button>
                        </b-col>
                    </b-row>
                </b-form>
            </b-overlay>
        </ValidationObserver>
      </template>
    </body-card>
  </div>
</template>
<script>
import RestApi, { authServiceBaseUrl } from '@/config/api_config'
import BreadCumb from '../../../components/BreadCumb.vue'
import NoImage from '../../../assets/images/user/no-image.jpg'
import Address from '@/components/Address.vue'
import { EventBus } from '@/EventBusLayout'
import { mapGetters } from 'vuex'
export default {
  components: { BreadCumb, Address },
  name: 'Form',
  data () {
    return {
        fieldObj: {
            xl: 6,
            lg: 6,
            md: 6,
            sm: 12,
            labelCols: 5
        },
        isShow: false,
        baseUrl: 'http://moc-auth-service.local/',
        valid: null,
        preview: NoImage,
        saveBtnName: this.$t('globalTrans.update'),
        errors: [],
        id: 0,
        commonInfo: {
            email: '',
            mobile: '',
            name: '',
            name_bn: ''
        },
        profile: {
            is_same: '0',
            nid_no: '',
            image: '',
            father_name_en: '',
            father_name_bn: '',
            mother_name_en: '',
            mother_name_bn: '',
            birth_place_en: '',
            birth_place_bn: '',
            nationality_en: '',
            nationality_bn: '',
            gender: 0,
            occupation_en: '',
            occupation_bn: '',
            dob: ''
        },
        pr_address: {},
        pm_address: {},
        photo: [],
        profile_image: []
    }
  },
  created () {
    if (Object.values(this.authUser).length > 0) {
        this.commonInfo = this.authUser
        this.loadData(this.authUser.user_id)
    }
  },
  computed: {
    genderList: function () {
        return this.$store.state.commonObj.genderList.map(el => {
            return Object.assign({ value: el.value, text: this.$i18n.locale === 'bn' ? el.text_bn : el.text_en })
        })
    },
    loading: function () {
        return this.$store.state.commonObj.loading
    },
    ...mapGetters({
        authUser: 'Auth/authUser'
    })
  },
  watch: {
  },
  methods: {
    isSameAsPermanent (val) {
        const Obj = {
            is_same: val,
            pr_address: this.pr_address
        }
        EventBus.$emit('SAME_ADDRESS', Obj)
    },
    receivePrAddress (address) {
        this.pr_address = address
    },
    receivePmAddress (address) {
        this.pm_address = address
    },
    cancel () {
        this.$router.push({ path: '/external-user/profile' })
    },
    handlePhoto (e) {
        const input = e.target
        if (input.files && input.files[0]) {
            const reader = new FileReader()
            reader.onload = (e) => {
                this.profile.image = e.target.result
            }
            reader.readAsDataURL(input.files[0])
        } else {
            this.profile.image = null
        }
    },
    async loadData (userId) {
        this.$store.dispatch('mutateCommonProperties', { loading: true })
        const result = await RestApi.getData(authServiceBaseUrl, `common-profile/show/${userId}`)
        if (result.success) {
            const data = result.data
            this.id = data.id
            const profileObj = {}
            Object.keys(data).forEach(key => {
                const keyName = key
                if (!keyName.match('pm_') && !keyName.match('pr_')) {
                    profileObj[key] = data[key]
                }
                if (keyName.match('pr_')) {
                    this.pr_address[key] = data[key]
                }
                if (keyName.match('pm_')) {
                    this.pm_address[key] = data[key]
                }
            })
            this.profile = profileObj
            this.profile.pre_image = data.image
            this.profile.image = null
            this.isShow = true
        } else {
            this.isShow = true
        }
        this.$store.dispatch('mutateCommonProperties', { loading: false })
    },
    async saveUpdate () {
        this.$store.dispatch('mutateCommonProperties', { loading: true })
        let result = null
        this.profile.pr_address = this.pr_address
        this.profile.pm_address = this.pm_address
        this.profile.user_id = this.authUser.user_id
        const loadingState = { loading: false, listReload: false }
        if (this.id) {
            result = await RestApi.putData(authServiceBaseUrl, `common-profile/update/${this.id}`, this.profile)
        } else {
            result = await RestApi.postData(authServiceBaseUrl, 'common-profile/store', this.profile)
        }

        loadingState.listReload = true
        this.$store.dispatch('mutateCommonProperties', loadingState)

        if (result.success) {
            const userData = Object.assign(result.data, { name: this.authUser.name, name_en: this.authUser.name, name_bn: this.authUser.name_bn, mobile: this.authUser.mobile, email: this.authUser.email })

            this.$store.dispatch('Auth/updateAuthUser', Object.assign({ user_detail: userData }))
            this.$store.dispatch('mutateCommonProperties', { hasDropdownLoaded: false })
            this.$toast.success({
                title: 'Success',
                message: this.id ? this.$t('globalTrans.update_msg') : this.$t('globalTrans.save_msg'),
                color: '#D6E09B'
            })
            this.$router.push({ path: '/external-user/profile' })
        } else {
            this.$refs.form.setErrors(result.errors)
        }
    }
  }
}
</script>
