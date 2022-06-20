<template>
  <div>
    <h1 class="text-center mt-3 mb-3">Ultimes Valoracions</h1>
    <div class="card w-50 mx-auto mb-2" v-for="valoracio in valoracions">
      <div class="card-header">
        <star-rating :read-only="true" :rating="valoracio.numValoracio" :star-size="20" :show-rating="false"/>
      </div>
      <div class="card-body">
        {{ valoracio.textValoracio }}
      </div>
    </div>
  </div>
</template>

<script>
import StarRating from 'vue-star-rating'

export default {
  name: "five-ratings",
  components: {
    StarRating
  },
  data() {
    return {
      valoracions: []
    }
  },
  mounted() {
    axios.get('/five-valoracions').then((response) => {
      console.log(response.data)
      this.valoracions = response.data;
    })
  }
}
</script>

<style scoped>

</style>