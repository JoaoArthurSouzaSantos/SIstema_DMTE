<template>
  <div style="border: 6px solid white; border-radius: 10px; background-color:#ECEFF1; width: auto; padding: 5px;">
    <v-form @submit.prevent="salvar" >
      <v-container fluid text-xs-center>
        <v-layout row wrap>  
          <v-flex xs12 sm6 md4> 
            <v-text-field
              v-model="form.name"
              :rules="nameRules"
              :counter="30"
              label="name"
              required
            ></v-text-field>
          </v-flex>
          <v-flex xs12 sm6 md4> 
            <v-text-field
              v-model="form.Titulacao"
              :counter="30"
              label="Titulacao"
              required
            ></v-text-field>
          </v-flex>
          <v-flex xs12 sm6 md4> 
            <v-text-field
              v-model="form.Situacao"
              :counter="30"
              label="Situacao"
              required
            ></v-text-field>
          </v-flex>
          <v-flex xs12 sm6 md4> 
            <v-text-field
              v-model="form.Nivel"
              :counter="30"
              label="Nivel"
              required
            ></v-text-field>
          </v-flex>
          <v-flex xs12 sm6 md4> 
            <v-text-field
              v-model="form.Email"
              :rules="EmailRules"
              :counter="30"
              label="Email"
              required
            ></v-text-field>
          </v-flex>
            <v-flex xs12 sm6 md4> 
            <v-text-field
              v-model="form.Email_Institucional"
              :counter="30"
              label="Email_Institucional"
              required
            ></v-text-field>
            </v-flex>
            <v-flex xs12 sm6 md4> 
            <v-text-field
              v-model="form.Lattes"
              :counter="30"
              label="Lattes"
              required
            ></v-text-field>
          </v-flex>
        </v-layout>
      </v-container>
      <v-btn class="primary" style="float:right" type="submit">salvar</v-btn>
    </v-form>
  </div>
</template>

<script>
  export default {
    data: () => ({
      valid: false,
      fullscreen: {
          dialog: false,
          notifications: false,
          sound: true,
          widgets: false
        },
      form:{
        id:'',
        name:'',	
        Titulacao:'',	
        Situacao:'',	
        Nivel:'',	
        Email:'',	
        Email_Institucional:'',	
        Lattes:'',	
      },
      lastname: '',
      //regra de requerimento
      nameRules: [
        v => !!v || 'Name is required',
        v => v.length <= 30 || 'Name must be less than 10 characters',
      ],
    }),
    mounted(){

    },
    methods: {

    limparCampos:function(){
    //this.basic.dialog = false;
    Object.assign(this.$data.form,this.$options.data().form)
    this.form.errors={};    
    },

    salvar: function() {
          this.$Progress.start();
          this.$http.post("/api/Professor",this.form).then(data => {
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