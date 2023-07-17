<template>
    <div>
        <h4>CIP Panel Dashboard</h4>
    </div>
</template>
<script>
    import { mapGetters } from 'vuex'
    export default {
        computed: {
            ...mapGetters({
                authUser: 'Auth/authUser'
            })
        }
    }
</script>
