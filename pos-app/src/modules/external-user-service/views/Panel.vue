<template>
    <div class="ext-dash-wrapper">
        <b-overlay :show="loading">
            <b-container fluid>
                <b-row>
                    <b-col sm="4" class="panel-item" v-for="(panel, index) in panels" :key="index">
                        <b-card>
                            <div class="item" @click="setPanel(panel.id)">
                                <i class="ri-cloud-line panel-icon"></i>
                                <h5 class="title">{{ lang === 'bn' ? panel.name_bn : panel.name }}</h5>
                            </div>
                        </b-card>
                    </b-col>
                </b-row>
            </b-container>
        </b-overlay>
    </div>
</template>
<script>
import { mapGetters } from 'vuex'
import RestApi, { commonServiceBaseUrl } from '@/config/api_config'
import { externalPanelMenusApi } from './export-trophy-cip-panel/api/routes'
export default {
  data () {
    return {
      loading: false,
      menus: [],
    //   panels: [],
      commonMenus: [
        {
            title: 'Profile',
            title_bn: 'প্রোফাইল',
            name: this.lang === 'en' ? 'Profile' : 'প্রোফাইল',
            is_heading: false,
            is_active: false,
            link: '/external-user/profile',
            class_name: '',
            is_icon_class: true,
            icon: 'ri-bank-line'
        },
        {
            title: 'Panel',
            title_bn: 'প্যানেল',
            name: this.lang === 'en' ? 'Panel' : 'প্যানেল',
            is_heading: false,
            is_active: false,
            link: '/external-user/panel',
            class_name: '',
            is_icon_class: true,
            icon: 'ri-dashboard-line'
        }
      ]
    }
  },
  computed: {
    lang: function () {
        return this.$i18n.locale
    },
    ...mapGetters({
        panels: 'ExternalUserService/externalPanels',
        commonProfile: 'Auth/commonProfile'
    })
  },
  methods: {
    async setPanel (panelId) {
        this.loading = true
        if (Object.values(this.commonProfile).length <= 0) {
            this.$toast.error({
                title: this.$i18n.locale === 'en' ? 'Permission Denied..!' : 'অনুমতি অস্বীকার করা হয়েছে..!',
                message: this.$i18n.locale === 'en' ? 'Please, Update your profile.' : 'অনুগ্রহপূর্বক, আপনার প্রোফাইল হালনাগাদ করুন।',
                color: 'red'
            })
            this.loading = false
            return
        }
        const response = await RestApi.getData(commonServiceBaseUrl, `${externalPanelMenusApi}/${panelId}`)
        this.loading = false
        if (response.success) {
            this.menus = response.data.map(item => {
                return Object.assign({}, this.getFormatedMenu(item))
            })
            this.$store.dispatch('ExternalUserService/setExternalMenus', this.formatWithCommonTwoMenu(this.menus))
            this.$store.dispatch('ExternalUserService/isInsidePanel', true)

            // go to first menu automatically
            this.$router.push(response.data[0].url)
        } else {
            this.menus = []
            this.$store.dispatch('ExternalUserService/setExternalMenus', [])
        }
    },
    getFormatedMenu (item) {
        return {
            title: item.name,
            title_bn: item.name_bn,
            name: this.lang === 'en' ? item.name : item.name_bn,
            is_heading: false,
            is_active: false,
            link: item.url,
            class_name: 'iq-submenu-data',
            is_icon_class: true,
            icon: 'ri-home-line'
        }
    },
    formatWithCommonTwoMenu (panelMenus) {
        return this.commonMenus.concat(panelMenus)
    }
  }
}
</script>
<style scoped>
    .ext-dash-wrapper {
        padding-top: 30px;
    }
    .ext-dash-wrapper .panel-item .card {
        border: none;
        border-radius: 10px;
        box-shadow: rgba(99, 99, 99, 0.5) 0px 2px 8px 0px;
        cursor: pointer;
        transition: all .5s ease;
    }
    .ext-dash-wrapper .panel-item .card:hover {
        box-shadow: rgb(0 0 0 / 25%) 0px 14px 28px, rgb(0 0 0 / 22%) 0px 10px 10px;
    }
    .ext-dash-wrapper .panel-item .card:hover  .panel-icon {
        transform: rotate(-20deg);
    }
    .ext-dash-wrapper .panel-item:nth-child(1) .card {
        background: linear-gradient(180deg, rgba(114,96,237,1) 30%, rgba(53,33,190,1) 100%);
    }
    .ext-dash-wrapper .panel-item:nth-child(2) .card {
        background: linear-gradient(180deg, rgba(87,206,102,1) 30%, rgba(31,143,46,1) 100%);
    }
    .ext-dash-wrapper .panel-item:nth-child(3) .card {
        background: linear-gradient(180deg, rgba(0,158,250,1) 30%, rgba(9,93,142,1) 100%);
    }
    .ext-dash-wrapper .panel-item .item {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: var(--white);
    }
    .ext-dash-wrapper .panel-item .item .panel-icon {
        font-size: 49px;
        transition: all .5s ease;
    }
    .ext-dash-wrapper .panel-item .item .title {
        margin-bottom: 12px;
        font-weight: 300;
    }
</style>
