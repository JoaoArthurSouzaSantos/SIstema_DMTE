<template>
    <v-form @submit.prevent="salvar" >
      <div style="border: 6px solid white; border-radius: 10px; background-color:#ECEFF1; width: auto; padding: 5px;">
      <v-container fluid text-xs-center>
        <v-layout row wrap>
          <v-flex xs12 sm6 md4>
            <v-text-field
              v-model="form.name"
              :counter="50"
              label="name"
              required
              filled
            ></v-text-field>
          </v-flex>
          <v-flex xs12 sm6 md4>
            <v-text-field type="datetime-local"
              v-model="form.Data"
              :counter="20"
              label="Data"
              required
              filled
            ></v-text-field>
          </v-flex>
          <v-flex xs12 sm6 md4> 
          <v-select
          :items="professores"
          v-model="form.fk_professor"
          label="Selecione o nome funcionario"
          item-text="Nome"
          item-value="id"
          clearable
          single-line                              
          ></v-select>                                         
        </v-flex>
          <v-flex xs12 sm6 md4>
            <v-text-field
              v-model="form.Titulo"
              :counter="50"
              label="Titulo"
              required
              filled
            ></v-text-field>
          </v-flex>
          <v-flex xs12 sm6 md4>
            <v-text-field
              v-model="form.Campus"
              :counter="30"
              label="Campus"
              required
              filled
            ></v-text-field>
          </v-flex>
          
          <v-flex xs12 sm6 md4>
            <v-text-field
              v-model="form.Link"
              :counter="100"
              label="Link"
              required
            ></v-text-field>
          </v-flex>
          <v-flex xs12 sm6 md4>
            <v-text-field
              v-model="form.Tipo"
              :counter="100"
              label="Tipo"
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
      <v-btn class="primary " style="float:right" type="submit">salvar</v-btn>
    </div>
    </v-form>
</template>

<script>
  export default {
    data: () => ({
      valid: false,
      professores:[],
      form:{
        name:'',	
        fk_professor:'',	
        Data:'',	
        Titulo:'',	
        Campus:'',	
        Link:'',	
        Tipo:'',	
      },
      fullscreen: {
          dialog: false,
          notifications: false,
          sound: true,
          widgets: false
        },
      lastname: '',
    }),
    mounted(){
      this.$http.get("/api/Professor").then( data => {
          this.professores=data.data
          console.log('this.professores',this.professores)
      })
    },
    methods: {

    limparCampos:function(){
      this.basic.dialog = false;
      this.form.reset();
      this.form.errors={};    
    },
    salvar: function() {
          this.$Progress.start();
          this.$http.post("/api/Evento",this.form).then(data => {
              console.log("teste",data)
              window.getApp.$emit("APP_SAVE");
              this.limparCampos();
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