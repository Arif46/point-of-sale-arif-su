<template>
  <div class="section-wrapper">
    <div class="breadcrumb-wrapper">
      <b-breadcrumb class="custom-bread" :items="breadcrumbs"></b-breadcrumb>
      <p class="time-logger">Welcome, Mohiuddin | <i class="ri-time-line"></i> Last Login: 1 min ago</p>
    </div>
    <div class="form-wrapper">
      <b-card title="Bazar Monitoring Details">
        <b-card-text>
          <b-row>
            <b-col sm="12" md="3">
              <div class="mc-report-card p-3 bg-primary text-light">
                <p>Total Market</p>
                <h4>500</h4>
                <div class="icon-wrapper">
                  <i class="ri-store-2-line"></i>
                </div>
              </div>
            </b-col>
            <b-col sm="12" md="3">
              <div class="mc-report-card p-3 bg-warning text-light">
                <p>Total Cases</p>
                <h4>5,000</h4>
                <div class="icon-wrapper">
                  <i class="ri-file-damage-line"></i>
                </div>
              </div>
            </b-col>
            <b-col sm="12" md="3">
              <div class="mc-report-card p-3 bg-success text-light">
                <p>Total Fine Amount</p>
                <h4>50,000</h4>
                <div class="icon-wrapper">
                  <i class="ri-exchange-funds-fill"></i>
                </div>
              </div>
            </b-col>
            <b-col sm="12" md="3">
              <div class="mc-report-card p-3 bg-info text-light">
                <p>Total Commodity</p>
                <h4>50</h4>
                <div class="icon-wrapper">
                  <i class="ri-picture-in-picture-line"></i>
                </div>
              </div>
            </b-col>
          </b-row>
        </b-card-text>
      </b-card>
    </div>
      <b-card class="mt-3" title="Bazar Monitoring Data Chart">
        <b-card-text>
            <img src="@/assets/images/charts.png" class="img-fluid" alt="">
        </b-card-text>
      </b-card>
  </div>
</template>
<script>
export default {
  data () {
    return {
      // breadcrumb data
      breadcrumbs: [
        {
          text: 'Home',
          href: '#'
        },
        {
          text: 'Bazar Monitoring System',
          href: '/'
        },
        {
          text: 'Dashboard',
          active: true
        }
      ]
    }
  }
}
</script>
<style>
  .mc-report-card {
    position: relative;
    margin-bottom: 10px;
    border-radius: var(--border-radius-md);
  }
  .icon-wrapper {
    position: absolute;
    top: 50%;
    right: 5px;
    transform: translate(0, -50%);
    color: rgba(255, 255, 255, .3);
    font-size: 3.6rem;
  }
</style>
