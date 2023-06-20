<template>
    <div class="juego">
        <div class="nombre-juego">{{ juego.nombre }}</div>
        <div class="costo-juego" style="color: #00cc00;">$ {{ juego.costo_inscripcion.toFixed(2) }}</div>
    </div>
</template>
  
<script>
export default {
    props: ['juego']
}
</script>
  
<style scoped>
.juego {
    background: #1f21228c;
    border: 1px solid #6a057f;
    border-radius: 4px;
    padding: 10px;
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
}

.nombre-juego {
    color: #8b008b;
}

.costo-juego {
    color: #00cc00;
}
</style>
  