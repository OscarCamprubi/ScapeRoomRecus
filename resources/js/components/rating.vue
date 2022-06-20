<template>
  <div>
    <form v-on:submit="novaValoracio($event)">
      <div class="mb-3">
        <label class="mb-2 mt-2">Puntua la Teva Experiencia</label>
        <star-rating :star-size="30" v-model="numValoracio"/>
      </div>
      <div class="mb-3">
        <label class="form-label" for="desc">Descriu la Teva Experiencia</label>
        <textarea class="form-control border-dark" id="desc" v-model="textValoracio"></textarea>
      </div>
      <input type="submit" value="Envia" class="btn btn-success">
    </form>
  </div>
</template>

<script>
import StarRating from 'vue-star-rating'

export default {
  name: "rating",
  components: {
    StarRating
  },
  data() {
    return {
      numValoracio: null,
      textValoracio: null,
      idReserva: null
    }
  },
  mounted() {
    let uri = window.location.href.split('/');
    this.idReserva = uri[4];
    console.log("IDReserva", this.idReserva)
  },
  methods: {
    async novaValoracio(e) {
      e.preventDefault();
      let req = await axios.post('/save-valoracio', {
        numValoracio: this.numValoracio,
        textValoracio: this.textValoracio,
        idReserva: this.idReserva
      })
      console.log(req.data[1].idUser);
      if (req.status === 200 || 201) {
        console.log("SUCCESFUL")
        window.location.href = "http://127.0.0.1:8000/show-user/" + req.data[1].idUser;
      }

    }
  }
}
</script>

<style scoped>

</style>