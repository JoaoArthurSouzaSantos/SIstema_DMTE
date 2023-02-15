<template>
    <div class="callout calendar-day">
        <div class="grid-x align-middle align-middle">
            <!-- <div class="shrink cell">
                <h6>{{ this.momentInstance.format('DD') }} {{ this.momentInstance.format('[de] MMMM [de] YYYY') }}</h6>
            </div>
            <div class="auto cell">
                <h5 class="light">{{ this.momentInstance.format('dddd[.] HH:mm:ss') }} </h5>
            </div> -->
            <div class="container">
                <div id="horas"></div>
                <div id="minutos"></div>
                <div id="segundos"></div>
                <div id="centro"></div>
            </div>

        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            momentInstance: moment()
        }
    },
    mounted() {
        setInterval(() => {
            this.momentInstance = moment()
        }, 1000)

  const getElement = el => document.querySelector(el);
  
  const addRotate = (element, rotacao) => element.style.transform = `rotate(${rotacao}deg)`;

  function relogio () {
    let date = new Date();

    let s = date.getSeconds() * 6,
        m = date.getMinutes() * 6 + (s / 60),
        h = date.getHours()  * 30 + (m / 12);

    addRotate(secEl, s);
    addRotate(minEl, m);
    addRotate(houEl, h);
  }
  
  const secEl = getElement('#segundos'),
        minEl = getElement('#minutos'),
        houEl = getElement('#horas');

  setInterval(relogio, 1000);        
    }
}
</script>

<style scoped>
h5 {
    font-size: 14px !important; 
    font-weight: 500 !important;
    letter-spacing: normal !important;
}

.callout.calendar-day { padding: 3px 3px; }
.callout.calendar-day h1 {
    margin: 0 1rem 0 0;
    color: #2540F4;
}
.callout.calendar-day h6 { margin: 0; font-size: 12px; }
.callout.calendar-day h6.light { color: #A8B4CB; }
*, *::before, *::after {
	 margin: 0;
	 padding: 0;
	 outline: 0 none;
	 list-style: none;
	 text-decoration: none;
}
 html, body {
	 width: 100%;
	 height: 100%;
}
 body {
	 display: flex;
	 position: relative;
	 align-items: center;
	 justify-content: center;
	 background-color: gainsboro;
}
 body .container {
	 overflow: hidden;
	 position: relative;
	 background-size: cover;
	 border: 25px solid black;
	 background-position: center;
	 -webkit-border-radius: 50%;
	 -moz-border-radius: 50%;
	 -ms-border-radius: 50%;
	 -o-border-radius: 50%;
	 border-radius: 50%;
	 background-repeat: no-repeat;
	 box-shadow: 0px 0px 7px black;
	 width: 400px;
	 height: 400px;
	 background-color: #483dc1;
	 background-image: url('https://1.bp.blogspot.com/-yEovcKTuoC0/U5TrBtVCNyI/AAAAAAAA1pw/L1_u1P-GTNg/s1600/8.png');
}
 body .container #centro {
	 position: absolute;
	 top: 0px;
	 left: 0px;
	 right: 0px;
	 bottom: 0px;
	 z-index: 10;
	 margin: auto;
	 box-shadow: 0px 0px 2px;
	 -webkit-border-radius: 50%;
	 -moz-border-radius: 50%;
	 -ms-border-radius: 50%;
	 -o-border-radius: 50%;
	 border-radius: 50%;
	 width: 25px;
	 height: 25px;
	 background-color: #000;
}
 body .container #segundos {
	 z-index: 8;
	 position: absolute;
	 margin: 7px 173px;
     
	 box-shadow: 0px 0px 2px;
	 -webkit-border-radius: 6px;
	 -moz-border-radius: 6px;
	 -ms-border-radius: 6px;
	 -o-border-radius: 6px;
	 border-radius: 6px;
	 transform-origin: 3px bottom;
	 width: 5px;
	 height: 170px;
	 background-color: #bc0a24;
}
 body .container #minutos {
	 z-index: 6;
	 position: absolute;
	 margin: 14px 172px;
	 box-shadow: 0px 0px 2px;
	 -webkit-border-radius: 6px;
	 -moz-border-radius: 6px;
	 -ms-border-radius: 6px;
	 -o-border-radius: 6px;
	 border-radius: 6px;
	 transform-origin: 5px bottom;
	 width: 10px;
	 height: 160px;
	 background-color: #000;
}
 body .container #horas {
	 z-index: 4;
	 margin: 50px 170px;
	 position: absolute;
	 box-shadow: 0px 0px 2px;
	 -webkit-border-radius: 6px;
	 -moz-border-radius: 6px;
	 -ms-border-radius: 6px;
	 -o-border-radius: 6px;
	 border-radius: 6px;
	 transform-origin: 5px bottom;
	 width: 10px;
	 height: 125px;
	 background-color: #000;
}
 
</style>