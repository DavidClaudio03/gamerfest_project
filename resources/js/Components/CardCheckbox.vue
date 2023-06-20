<template>

    <div :class="['card', { 'card--selected': selected }]" @click="toggleSelection">
      <div class="card__image" :class="{ 'inscrito': estaInscrito }">
        <img :src="imageUrl" alt="Game Image" width="200px" height="200px" />
        <span class="inscrito-label" v-if="estaInscrito">INSCRITO</span>
      </div>
      <div class="card__details">
        <h3 class="card__title">{{ gameName }}</h3>
        <p class="card__price">{{ (gamePrice > 0) ? '$'+gamePrice : "Gratis" }}</p>
      </div>
    </div>
    
</template>



<script>
export default {
  name: 'CardCheckbox',
  props: {
    gameId: {
      type: Number,
      required: true
    },
    gameName: {
      type: String,
      required: true
    },
    gamePrice: {
      type: [Number, String],
      required: true
    },
    imageUrl: {
      type: String,
      required: true
    },
    imageId: {
      type: String,
      required: true
    },
    estaInscrito: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      selected: false
    };
  },
  methods: {
    toggleSelection() {
      if(this.estaInscrito){
          return;
      }

      this.selected = !this.selected;
      const juegosInscritos = JSON.parse(localStorage.getItem('juegosInscritos')) || [];

      if (this.selected) {
        const juego = {
          id: this.gameId
        };
        juegosInscritos.push(juego);
      } else {
        const index = juegosInscritos.findIndex(juego => juego.id === this.gameId);
        if (index > -1) {
          juegosInscritos.splice(index, 1);
        }
      }

      localStorage.setItem('juegosInscritos', JSON.stringify(juegosInscritos));

      this.$emit('selectionChange', this.selected);
      this.$emit('showAlert', this.gameName, this.gameId);
    }
  },
  created() {
    const juegosInscritos = JSON.parse(localStorage.getItem('juegosInscritos')) || [];
    const juegoSeleccionado = juegosInscritos.find(juego => juego.id === this.gameId);
    this.selected = juegoSeleccionado !== undefined;
  }
};
</script>

<style scoped>
.card {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
  margin: 20px;
  background-color: #2f2f2f;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
  padding: 20px;
  cursor: pointer;
  transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.card:hover {
  transform: translateY(-10px);
  
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
  transition: all 200ms ease-in-out;
}

.card__image {
  position: relative;
  overflow: hidden;
}

.card__image img {
  width: 200px;
  height: 200px;
  border-radius: 8px;
  object-fit: cover;
  transform: scale(1);
  transition: transform 0.3s ease-in-out, filter 0.3s ease-in-out;
}

.card__image.inscrito img {
  filter: grayscale(100%);
}

.card__details {
  text-align: center;
}

.card__title {
  font-size: 18px;
  margin-top: 5px;
  color: #ffffff;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}

.card__price {
  font-size: 16px;
  margin: 0;
  color: #4E9F3D;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}

.card--selected {
  background-color: #273a4d;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}

.inscrito-label {
  font-family: 'Bebas Neue', sans-serif;
  letter-spacing: 1px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%) rotate(-45deg);
  color: #ED2B2A;
  font-size: 34px;
  font-weight: bold;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
  background: rgba(255, 255, 255, 0.8);
  padding: 10px;
  border-radius: 8px;
}
</style>
