<template>
   <b-container fluid class="px-0 mc-login-bg">
     <b-row align-v="center" no-gutters>
        <b-col md="6" class="d-none d-md-block">
            <img class="img-fluid d-block mx-auto" width="100" src="@/assets/images/pos.png" alt="">
            <h4 class="text-center mt-3 mb-2">{{ $t('globalTrans.pos') }}</h4>
        </b-col>
        <b-col sm="12" md="6" style="background: #15273B">
            <div class="login-wrapper">
              <b-overlay :show="loading">
                <b-card>
                  <img class="img-fluid d-block mx-auto" width="70" src="@/assets/images/pos.png" alt="">
                  <h5 class="form-logo-text text-center mt-2 mb-3">{{ $t('globalTrans.pos') }}</h5>
                  <div class="text-center mb-2">
                    <LangButton />
                    <b-alert show dismissible fade variant="danger" v-if="errorAlert">{{ errorMsg }}</b-alert>
                  </div>
                  <ValidationObserver ref="form" v-slot="{ handleSubmit, reset }">
                    <b-form @submit.prevent="handleSubmit(login)" @reset.prevent="reset" autocomplete="off">
                      <ValidationProvider name="Mobile/Email" vid="mobile_email" rules="required">
                        <b-form-group
                            id="user"
                            :label="$t('globalTrans.mobileOrEmail')"
                            label-for="username"
                        >
                          <b-form-input
                            id="mobile_email"
                            v-model="creds.mobile_email"
                            required
                          ></b-form-input>
                        </b-form-group>
                      </ValidationProvider>
                      <ValidationProvider name="password" rules="required">
                        <b-form-group
                        class="mb-3"
                        id="password"
                        :label="$t('globalTrans.password')"
                        label-for="password">
                          <b-form-input
                            class="mb-0"
                            id="input-2"
                            v-model="creds.password"
                            type="password"
                            required
                          ></b-form-input>
                        </b-form-group>
                      </ValidationProvider>
                      <p class="forgot-text"><router-link to="/auth/forgot-password">{{ $t('globalTrans.forgot_your_password') }}</router-link></p>
                      <b-button block type="submit" class="login-btn mb-2" variant="primary">{{ $t('globalTrans.login') }}</b-button>
                      <!-- <p class="have-account-text">{{ $t('globalTrans.dont_have_an_account') }} <router-link to="/auth/sign-up"> {{ $t('globalTrans.sign_up') }}</router-link></p> -->
                    </b-form>
                  </ValidationObserver>
                </b-card>
              </b-overlay>
            </div>
        </b-col>
   </b-row>
   </b-container>
</template>

<script>
import RestApi, { apiBaseUrl } from '@/config/api_config'
import { loginApi, shopListApi } from '../api/routes'
import LangButton from '@/components/LangButton.vue'
export default {
  components: {
    LangButton
  },
  data () {
    return {
      loading: false,
      errorAlert: false,
      errorMsg: '',
      creds: {
        mobile_email: '',
        password: ''
      }
    }
  },
  methods: {
    async login () {
      this.loading = true
      this.errorAlert = false
      const result = await RestApi.postData(apiBaseUrl, loginApi, this.creds)
      this.loading = false
      if (typeof result === 'undefined') {
        this.errorAlert = true
        this.errorMsg = this.$t('globalTrans.login_failed')
      }
      if (result.success) {
        localStorage.setItem('access_token', result.access_token)
        this.$store.dispatch('Auth/setAccessToken', result.access_token)
        localStorage.setItem('userDetail', result.user)
        this.$store.dispatch('Auth/updateAuthUser', result.user)
        this.roleWiseShop(result.user)
      } else {
        this.errorAlert = true
        this.errorMsg = this.$t('globalTrans.login_failed')
      }
    },
    async roleWiseShop (data) {
      this.loading = true
      const params = { user_id: data.id, role_id: data.role_id, shop_id: data.shop_id }
      const response = await RestApi.getData(apiBaseUrl, shopListApi, params)
      this.loading = false
      this.$store.dispatch('Auth/setAuthorizedShops', response.data)
      this.$router.push('/auth/dashboard')
    }
  }
}
</script>

<style scoped>
  /* .login-bg {
    width: 100%;
    height: 100vh;
    background: linear-gradient(to bottom, rgb(50 50 50 / 50%), rgb(50 50 50 / 50%)),url(../../../../assets/images/login-bg.jpg);
    background-position: center;
    background-size: cover;
  } */
  .mc-login-bg{
    background: url(../../../../assets/images/sidebar-bg.png);
    background-position: center;
  }
  .login-wrapper{
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
  }
  .login-wrapper .form-group label{
    color: var(--white);
  }
  .login-wrapper .card{
    backdrop-filter: blur(2px);
    background: rgba(255, 255, 255, 0.1);
    /* border: 1px solid rgba(255, 255, 255, 1); */
  }
</style>
