<template>
  <div class="inner-section">
    <bread-cumb />
    <body-card>
      <template v-slot:headerTitle>
        <h4 class="card-title">{{ $t('sideBar.profile') }} {{ $t('globalTrans.update') }}</h4>
      </template>
      <!-- <template v-slot:headerAction>
        <b-link class="btn-add" to="/external-user/profile-update">
            <i class="ri-pencil-fill"></i>{{ $t('globalTrans.update_profile') }}
        </b-link>
      </template> -->
      <template v-slot:body>
        <b-overlay :show="loading">
        <b-row>
            <b-col md="3" class="text-center align-top iq-border-r-5 pt-3">
                <img v-if="profile.image" class="img-thumbnail w-50" style="height: 130px;" :src="baseUrl + 'download-attachment?file=app/public/' + profile.image" alt="Profile Image">
                <img v-else class="img-thumbnail w-50" style="height: 130px" :src="preview" alt="Image">
            </b-col>
            <b-col md="9">
                <table class="table table-sm table-borderless">
                    <tr>
                        <th width="15%">{{$t('globalTrans.name')}}</th>
                        <td width="35%">: {{ currentLocale === 'bn' ? commonInfo.name_bn : commonInfo.name }}</td>
                        <th width="15%">{{$t('globalTrans.email')}}</th>
                        <td width="35%">: {{ commonInfo.email }}</td>
                    </tr>
                    <tr>
                        <th>{{$t('globalTrans.mobile')}}</th>
                        <td>: {{currentLocale == 'bn'? commonInfo.mobile.replace(/\d/g, d => '০১২৩৪৫৬৭৮৯'[d]) : commonInfo.mobile}}</td>
                        <th>{{ $t('globalTrans.nid') }}</th>
                        <td>: {{ $n(profile.nid_no, { useGrouping: false }) }}</td>
                    </tr>
                    <tr>
                        <th>{{$t('globalTrans.father_name')}}</th>
                        <td>: {{ currentLocale === 'bn' ? profile.father_name_bn : profile.father_name_en }}</td>
                        <th>{{$t('globalTrans.mother_name')}}</th>
                        <td>: {{ currentLocale === 'bn' ? profile.mother_name_bn : profile.mother_name_en }}</td>
                    </tr>
                    <tr>
                        <th>{{$t('globalTrans.gender')}}</th>
                        <td>: {{ profile.gender ? getGenderName(profile.gender) : '' }}</td>
                        <th>{{$t('globalTrans.dob')}}</th>
                        <td>: {{ profile.dob | dateFormat }}</td>
                    </tr>
                    <tr>
                        <th>{{$t('externalUser.birth_place')}}</th>
                        <td>: {{ currentLocale === 'bn' ? profile.birth_place_bn : profile.birth_place_en }}</td>
                        <th>{{$t('globalTrans.nationality')}}</th>
                        <td>: {{ currentLocale === 'bn' ? profile.nationality_bn : profile.nationality_en }}</td>
                    </tr>
                    <tr>
                        <th>{{$t('globalTrans.occupation')}}</th>
                        <td colspan="3">: {{ currentLocale === 'bn' ? profile.occupation_bn : profile.occupation_en }}</td>
                    </tr>
                </table>
                <b-row>
                    <b-col lg="12" sm="12">
                        <p class="text-black" style="border-bottom: 1px solid #ddd; font-weight: bold">
                            {{ $t('globalTrans.present_address') + ' :' }}
                        </p>
                    </b-col>
                    <b-col lg="12" sm="12">
                        <table class="table table-sm table-borderless">
                          <tr>
                              <th width="15%">{{$t('globalTrans.division')}}</th>
                              <td width="35%">: {{ AddressHelper.getDivisionName(profile.pr_division_id) }}</td>
                              <th width="15%">{{$t('globalTrans.district')}}</th>
                              <td width="35%">: {{ AddressHelper.getDistrictName(profile.pr_division_id) }}</td>
                          </tr>
                          <tr>
                              <th>{{$t('globalTrans.upazila')}}</th>
                              <td>: {{ profile.pr_upazila_id ? AddressHelper.getUpazilaName(profile.pr_upazila_id) : 'N/A' }}</td>
                              <th>{{$t('globalTrans.city_corporation')}}</th>
                              <td>: {{ profile.pr_city_corporation_id ? AddressHelper.getCityCorporationName(profile.pr_city_corporation_id) : 'N/A' }}</td>
                          </tr>
                          <tr>
                              <th>{{$t('globalTrans.pouroshova')}}</th>
                              <td>: {{ profile.pr_pauroshoba_id ? AddressHelper.getPauroshobaName(profile.pr_pauroshoba_id) : 'N/A' }}</td>
                              <th>{{$t('globalTrans.union')}}</th>
                              <td>: {{ profile.pr_union_id ? AddressHelper.getUnionName(profile.pr_union_id) : 'N/A' }}</td>
                          </tr>
                          <tr>
                              <th>{{$t('globalTrans.ward')}}</th>
                              <td>: {{ profile.pr_ward_id ? AddressHelper.getWardName(profile.pr_ward_id) : 'N/A' }}</td>
                              <th>{{$t('globalTrans.village_address')}}</th>
                              <td>: {{ currentLocale === 'bn' ? profile.pr_village_bn : profile.pr_village_en }}</td>
                          </tr>
                        </table>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col lg="12" sm="12">
                        <p class="text-black" style="border-bottom: 1px solid #ddd; font-weight: bold">
                            {{ $t('globalTrans.permanent_address') + ' :' }}
                        </p>
                    </b-col>
                    <b-col lg="12" sm="12">
                        <table class="table table-sm table-borderless">
                          <tr>
                              <th width="15%">{{$t('globalTrans.division')}}</th>
                              <td width="35%">: {{ AddressHelper.getDivisionName(profile.pm_division_id) }}</td>
                              <th width="15%">{{$t('globalTrans.district')}}</th>
                              <td width="35%">: {{ AddressHelper.getDistrictName(profile.pm_division_id) }}</td>
                          </tr>
                          <tr>
                              <th>{{$t('globalTrans.upazila')}}</th>
                              <td>: {{ profile.pm_upazila_id ? AddressHelper.getUpazilaName(profile.pm_upazila_id) : 'N/A' }}</td>
                              <th>{{$t('globalTrans.city_corporation')}}</th>
                              <td>: {{ profile.pm_city_corporation_id ? AddressHelper.getCityCorporationName(profile.pm_city_corporation_id) : 'N/A' }}</td>
                          </tr>
                          <tr>
                              <th>{{$t('globalTrans.pouroshova')}}</th>
                              <td>: {{ profile.pm_pauroshoba_id ? AddressHelper.getPauroshobaName(profile.pm_pauroshoba_id) : 'N/A' }}</td>
                              <th>{{$t('globalTrans.union')}}</th>
                              <td>: {{ profile.pm_union_id ? AddressHelper.getUnionName(profile.pm_union_id) : 'N/A' }}</td>
                          </tr>
                          <tr>
                              <th>{{$t('globalTrans.ward')}}</th>
                              <td>: {{ profile.pm_ward_id ? AddressHelper.getWardName(profile.pm_ward_id) : 'N/A' }}</td>
                              <th>{{$t('globalTrans.village_address')}}</th>
                              <td>: {{ currentLocale === 'bn' ? profile.pm_village_bn : profile.pm_village_en }}</td>
                          </tr>
                        </table>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col lg="4" sm="12">
                        <p class="text-black" style="border-bottom: 1px solid #ddd; font-weight: bold">
                            {{ $t('globalTrans.permanent_address') + ' :' }}
                        </p>
                    </b-col>
                    <b-col lg="12" sm="12">
                      <p>{{ AddressHelper.getPermanentAddress(profile) }}</p>
                    </b-col>
                </b-row>
            </b-col>
        </b-row>
        </b-overlay>
      </template>
    </body-card>
  </div>
</template>
<script>
import RestApi, { authServiceBaseUrl, commonServiceBaseUrl } from '@/config/api_config'
import BreadCumb from '../../../components/BreadCumb.vue'
import NoImage from '../../../assets/images/user/no-image.jpg'
import { mapGetters } from 'vuex'
import AddressHelper from '../../../utils/area-type-address'
import { EventBus } from '@/EventBusLayout'
export default {
  components: { BreadCumb },
  name: 'ProfileShow',
  data () {
    return {
        loader: false,
        baseUrl: authServiceBaseUrl,
        preview: NoImage,
        isLoaded: false,
        AddressHelper: AddressHelper,
        commonInfo: {
            email: '',
            mobile: '',
            name: '',
            name_bn: ''
        },
        profile: {}
    }
  },
  created () {
    // load external panel list
    this.loadPanels()
    // load profile data
    if (Object.values(this.authUser).length > 0) {
        this.commonInfo = this.authUser
        this.loadData(this.authUser.user_id)
    }
  },
  computed: {
    loading: function () {
      return this.$store.state.commonObj.loading
    },
    currentLocale () {
        return this.$i18n.locale
    },
    ...mapGetters({
        authUser: 'Auth/authUser'
    })
  },
  watch: {
  },
  methods: {
    getGenderName (val) {
      const Obj = this.$store.state.commonObj.genderList.find(el => el.value === val)
      return this.$i18n.locale === 'bn' ? Obj.text_bn : Obj.text_en
    },
    async loadPanels () {
        this.loader = true
        const result = await RestApi.getData(commonServiceBaseUrl, 'external/external-panel/get-all')
        if (result.success) {
          this.$store.dispatch('ExternalUserService/setExternalPanels', result.data)
        } else {
          this.$store.dispatch('ExternalUserService/setExternalPanels', [])
        }
        this.loader = false
    },
    async loadData (userId) {
        this.loader = true
        this.$store.dispatch('mutateCommonProperties', { loading: true })
        const result = await RestApi.getData(authServiceBaseUrl, `common-profile/show/${userId}`)
        if (!result.success) {
            this.$store.dispatch('Auth/setCommonProfile', {})
            /** initially menus will be common for all new user
            * [In future it will be handle from login page or any other parent page] */
            EventBus.$emit('RESET_EXTERNAL_MENUS')
            /** redirect to profie update page */
            this.$router.push('/external-user/profile-update')
        } else {
            this.$store.dispatch('Auth/setCommonProfile', result.data)
            this.profile = result.data
            this.setRoute()
        }
        this.$store.dispatch('mutateCommonProperties', { loading: false })
        this.loader = false
    },
    setRoute () {
      // none
    }
  }
}
</script>
<style scope='css'>
  .blink_me {
    animation: blinker 1.3s linear infinite;
    color: red;
  }
  @keyframes blinker {
    50% {
      opacity: .09;
      /* background-color: green; */
    }
  }
</style>
