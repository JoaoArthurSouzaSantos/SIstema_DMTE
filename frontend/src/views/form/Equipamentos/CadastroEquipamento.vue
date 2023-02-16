<template>
    <v-form @submit.prevent="salvar" >
      <div style="border: 6px solid white; border-radius: 10px; background-color:#E0F2F1; width: auto; padding: 5px;">
      <v-container fluid text-xs-center>
        <v-layout row wrap>
          <v-flex xs12 sm5 md3> 
            <v-text-field
              v-model="form.name"
              :rules="nameRules"
              :counter="10"
              label="Nome"
              required
              filled
            ></v-text-field>
          </v-flex>
          <v-flex xs12 sm5 md3>
            <v-text-field
              v-model="form.marca"
              :counter="30"
              label="MARCA"
              required
              filled
            ></v-text-field>
          </v-flex>
          <v-flex xs12 sm5 md3>
            <v-text-field
              v-model="form.modelo"
              :counter="10"
              label="MODELO"
              required
              filled
            ></v-text-field>
          </v-flex>
          <v-flex xs12 sm5 md3>
            <v-text-field
              v-model="form.estado"
              :counter="10"
              label="ESTADO"
              required
              filled
            ></v-text-field>
          </v-flex>
          
          <v-flex xs12 sm5 md3>
            <v-text-field
              v-model="form.valor"
              :counter="10"
              label="VALOR"
              required
            ></v-text-field>      
          </v-flex>
          <v-flex xs12 sm5 md3>
            <v-text-field
              v-model="form.descricao"
              :counter="10"
              label="DESCRIÇÂO"
              required
            ></v-text-field>      
          </v-flex>
          <div class="col-md-5" >
              <label >
              <div class="select-button">
              <span v-if="file!=''">Foto selecionada</span>
              <span v-else>Selecione uma foto</span>
              </div>
              <input 
              type="file" 
              accept="image/*"
              />
          </label>
          </div>
          <br><br><br><br>
          <v-flex xs12 >
              <canvas style="float: left;"  id="canvas" width=64 height=64></canvas>
          </v-flex>
        </v-layout>
      </v-container>
    </div>
      <v-btn class="primary " style="float:right" type="submit">salvar</v-btn>
    </v-form>
</template>

<script>
  export default {
    data: () => ({
      valid: false,
      form:{
        descricao:"",
        estado:"",
        name:"",	
        modelo:"",
        valor:"",	
        file:"",	
        marca:"",		
      },
      fullscreen: {
          dialog: false,
          notifications: false,
          sound: true,
          widgets: false
        },
      lastname: '',
    }),
    methods: {

    limparCampos:function(){
      this.basic.dialog = false;
      this.form.reset();
      this.form.errors={};    
    },
    salvar: function() {
          this.$Progress.start();
          this.$http.post("/api/Equipamento",this.form).then(data => {
              this.limparCampos();
              window.getApp.$emit("APP_SAVE");
              loader.hide();
            })
            .catch((e) => {
              this.form.errors = e.response.data.errors;
              console.log(e.response.data.errors);
            });
          this.$Progress.finish();
        }
      }
  }

</script>