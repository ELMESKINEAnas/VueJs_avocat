<template>

    <DashClient/>
</template>

<script>
import { onBeforeMount } from '@vue/runtime-core'
import DashClient from '../components/DashClient.vue'

export default {
  name: 'App',
  components: {DashClient},
  methods:{
        async ifLogged(){
          let id = localStorage.getItem("token")
          const res = await fetch('http://localhost/vue-brief/project_6/test/Controller/checkRefUser.php',{
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                id: id,
                })
            })
            const result = await res.json()
            if(result.message === 'client doesnt exist'){
              window.location.replace('/Create')
            }
            return result
    }
  },
  beforeMount(){
    this.ifLogged()
  }
}
</script>