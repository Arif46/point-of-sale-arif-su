<template>
    <div class="home-component-wrapper">
        <div class="main-wrapper">
            <div class="main-content-section home-logo-wrapper">
                <Header :layout="'Home'"></Header>
            </div>
        </div>
        <div class="component-wrapper">
            <b-container fluid>
                <b-row>
                    <b-col v-if="loader" class="col-md-12 text-center">
                        <div class="spinner-border" role="status">
                        <span class="sr-only"></span>
                        </div>
                        <br/>
                        <p class="loading-text">{{ $t('authentication.loadingMenus') }}</p>
                    </b-col>
                    <b-col v-else sm="12" md="4" v-for="item in shopList" :key="item.id">
                        <b-card class="mc-db-card">
                            <div class="d-flex justify-content-start align-items-center"  @click="setShop(item.id)">
                                <img :class="mr-3" :src="item.logo" :alt="item.name">
                                <h5>{{ item.name }}</h5>
                            </div>
                        </b-card>
                    </b-col>
                </b-row>
            </b-container>
        </div>
        <Footer></Footer>
  </div>
</template>
<script>
    import { mapGetters, mapActions } from 'vuex'
    import RestApi, { apiBaseUrl } from '@/config/api_config'
    import { sidebarMenusApi } from '../api/routes'
    import Header from '@/components/Header.vue'
    import Footer from '@/components/Footer.vue'
    export default {
        name: 'Dashboard',
        components: {
            Header,
            Footer
        },
        data () {
            return {
                loader: false,
                orgList: [],
                shopId: 0,
                shopList: [],
                destinationUri: '',
                menus: [],
                authorizedURIs: []
            }
        },
        created () {
            this.setActiveMenus([])
            this.setShopList()
        },
        computed: {
            currentLocale: function () {
                return this.$i18n.locale
            },
            ...mapGetters({
                authorizedShops: 'Auth/authorizedShops',
                activeRole: 'Auth/getActiveRole',
                authUserActiveRoleId: 'Auth/getActiveRole',
                authUserRoles: 'Auth/getAuthUserRoles',
                authUser: 'Auth/authUser'
            })
        },
        methods: {
            setShopList () {
                if (this.authorizedShops.length === 0) {
                    this.shopList = []
                    return
                }
                const tmpShopList = this.authorizedShops.map(item => ({ icon: '', ...item }))
                this.shopList = tmpShopList
            },
            setShop (shopId) {
                // this.setActiveShopId(shopId)
                this.getMenusByShop(shopId)
                this.$router.push('/common-service/dashboard')
            },
            getMenusByShop (shopId) {
                this.loader = true
                RestApi.getData(apiBaseUrl, `${sidebarMenusApi}/${this.authUser.type}/${this.authUser.role_id}`).then(response => {
                    if (!response.success) {
                        this.$toast.error({
                            title: 'Error',
                            message: this.$t('authentication.noPrivilege')
                        })
                        this.$router.push('/auth/login')
                        return
                    }
                    this.menus = response.data
                    this.formatActiveMenus(shopId)
                    // this.loader = false
                }, error => {
                    if (error) {
                        this.loader = false
                    }
                })
            },
            formatActiveMenus (shopId) {
                // const shopInfo = this.authorizedShops.find(item => item.id === shopId)
                const menusByShop = this.menus.modules.map(item => {
                    const formatedMenu = this.getFormatedModuleMenu(item)
                    const serviceMenus = this.getServiceMenusByModuleId(item.id)
                    const childMenus = this.getMenusByModuleId(item.id)
                    if (childMenus.length) {
                        formatedMenu.children.push(...childMenus)
                    }
                    if (serviceMenus.length) {
                        formatedMenu.children.push(...serviceMenus)
                    }
                    return formatedMenu
                })

                // menusByShop.unshift({
                //     title: shopInfo.name,
                //     name: shopInfo.name,
                //     is_heading: false,
                //     is_active: false,
                //     link: this.destinationUri,
                //     class_name: '',
                //     is_icon_class: false,
                //     sorting_order: shopInfo.sorting_order,
                //     icon: 'ri-record-circle-line'
                // })
                // menusByShop.unshift({
                //     title: 'Home',
                //     name: lang === 'en' ? 'Home' : 'হোম',
                //     is_heading: false,
                //     is_active: false,
                //     link: '/auth/dashboard',
                //     class_name: '',
                //     is_icon_class: true,
                //     icon: 'ri-home-4-line'
                // })
                this.setAuthorizedUris(this.authorizedURIs)
                this.setActiveMenus(menusByShop)
                if (this.shopId !== 0) {
                    this.$router.push(this.dashboardUrl)
                } else {
                    this.$router.push(this.destinationUri)
                }
            },
            getServiceMenusByModuleId (moduleId) {
                const services = this.menus.services.filter(item => item.module_id === moduleId)
                if (!services.length) {
                    return []
                }
                const serviceMenus = services.map(item => this.getMenusByServiceId(item))
                return serviceMenus
            },
            getMenusByServiceId (service) {
                // Menus belog to services
                const menus = this.menus.menus.filter(item => item.service_id === service.id)
                if (!menus.length) {
                    return []
                }
                const formatedMenu = this.getFormatedServiceMenu(service)
                const formatedChildMenus = menus.map(item => this.getFormatedMenu(item))
                formatedMenu.children.push(...formatedChildMenus)
                return formatedMenu
            },
            getMenusByModuleId (moduleId) {
                // Menu which does not belong to services
                const menus = this.menus.menus.filter(item => !item.service_id && item.module_id === moduleId)
                if (!menus.length) {
                    return []
                }
                const formatedMenus = menus.map(item => this.getFormatedMenu(item))
                return formatedMenus
            },
            getFormatedMenu (menuItem) {
                let url = menuItem.url.trim()
                url = url.startsWith('/') ? url : `/${url}`
                this.authorizedURIs.push(url)
                return {
                    title: menuItem.name,
                    name: menuItem.name,
                    is_heading: false,
                    is_active: false,
                    link: url,
                    class_name: '',
                    is_icon_class: true,
                    icon: 'ri-record-circle-line'
                }
            },
            getFormatedModuleMenu (item) {
                return {
                    title: item.name,
                    name: item.name,
                    is_heading: false,
                    is_active: false,
                    link: '',
                    class_name: '',
                    is_icon_class: true,
                    icon: 'ri-record-circle-line',
                    children: []
                }
            },
            getFormatedServiceMenu (item) {
                return {
                    title: item.name,
                    name: item.name,
                    is_heading: false,
                    is_active: false,
                    link: '',
                    class_name: 'iq-submenu-data',
                    is_icon_class: true,
                    icon: 'ri-record-circle-line',
                    children: []
                }
            },
            ...mapActions({
                // setActiveshopId: 'Auth/setActiveshopId',
                setActiveMenus: 'Auth/setActiveMenus',
                setAuthorizedUris: 'Auth/setAuthorizedMenus'
            })
        }
    }
</script>
