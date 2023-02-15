
<template>
  <div class="digitalClock">
    <h1>{{ time }}</h1>
  </div>
</template>

<script>
export default {
  data() {
    return {
      time: ''
    }
  },
  mounted() {
    this.updateTime();
    this.timer = setInterval(this.updateTime, 1000);
  },
  beforeDestroy() {
    clearInterval(this.timer);
  },
  methods: {
    updateTime() {
      const currentDate = new Date();
      const hour = currentDate.getHours().toString().padStart(2, '0');
      const minute = currentDate.getMinutes().toString().padStart(2, '0');
      const second = currentDate.getSeconds().toString().padStart(2, '0');
      this.time = `${hour}:${minute}:${second}`;
    }
  }
}
</script>

<style scoped>
.digitalClock {
  height: 100px;
  width: 300px;
  padding: 10px;
  background-color: #444;
  color: #FFF;
  border-radius: 10px;
  text-align: center;
  font-size: 2em;
}
</style>
  