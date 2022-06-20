<template>
  <div class="app">
    <carousel class="carousel" :perPage="1" :autoplay="true" :loop="true" :adjustableHeight="true">
      <slide v-for="joc in jocs" :key="joc">
        <img class="w-100 img" :src="joc.image_path" alt="joc.image_path">
      </slide>
    </carousel>
  </div>
</template>

<script>
import {Carousel, Slide} from 'vue-carousel';

export default {
  name: "carrusel",
  data() {
    return {
      jocs: []
    }
  },
  mounted() {
    axios.get('/welcome').then((response) => {
      this.jocs = response.data;
    })
  },
  components: {
    Carousel,
    Slide
  }
}
</script>

<style>
.app {
  display: flex;
  justify-content: center;
}

.carousel {
  overflow: hidden;
  width: 800px;
  z-index: 10;
}

.carousel-slider img {
  width: 100%;
  height: 100%;
}

.img {
  height: 500px;
}

</style>