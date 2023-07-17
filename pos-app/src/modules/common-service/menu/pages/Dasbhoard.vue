<template>
  <div class="section-wrapper">
    <breadcumb />
    <b-card class="mt-3" :title="$t('menu.welcome_ms_common_service_dashboard')">
      <h2>Main Dashboard</h2>
    </b-card>
  </div>
</template>
<script>
export default {
  data () {
    return {
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
