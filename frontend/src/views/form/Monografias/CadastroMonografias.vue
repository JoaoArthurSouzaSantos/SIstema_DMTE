<template>
    <v-form @submit.prevent="salvar">
      <v-container fluid text-xs-center>
        <div style="border: 6px solid white; border-radius: 10px; background-color:#E0F2F1; width: auto; padding: 5px;">
        <v-layout row wrap>
          <v-flex xs12>
          <v-select
          :items="Professor"
          v-model="form.fk_professor"
          label="Selecione o nome do professor"
          item-text="professor"
          item-value="id"
          clearable
          filled
          single-line                              
          ></v-select>                                         
          </v-flex> 
          <v-flex xs12>
            <v-text-field
              v-model="form.nome"
              name="name"
              label="Nome"                            
              ></v-text-field>
          </v-flex> 
        </v-layout>
      </div>
      </v-container>
      <v-btn class="primary" style="float:right" type="submit">salvar</v-btn>
    </v-form>
</template>
<script>
  export default {
    data: () => ({
      valid: false,
      form:{
        name:'',
        valor:'',
        marca:'',
        descricao:'',
      },
      lastname: '',
      nameRules: [
        v => !!v || 'Name is required',
        v => v.length <= 10 || 'Name must be less than 10 characters',
      ],
      setorRules: [
        v => !!v || 'E-mail is required',
        v => v.length <= 12 || 'Name must be less than 10 characters',
      ],
    }),
    methods: {
    salvar: function() {
          this.$Progress.start();  
          this.$http.post("/api/Monografia",this.form).then(data => {
              this.limparCampos();
              window.getApp.$emit("APP_SAVE");
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