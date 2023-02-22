<template>
  <div style="border: 6px solid white; border-radius: 10px; background-color:#E0F2F1; width: auto; padding: 5px;">
    <v-form @submit.prevent="salvar" >
      <v-container fluid text-xs-center>
        <v-layout row wrap> 
          <v-flex xs12 sm6 md4> 
            <v-text-field
              v-model="form.username"
              :rules="nameRules"
              :counter="30"
              label="username"
              required
            ></v-text-field>
          </v-flex>
            <v-flex xs12 sm6 md4> 
            <v-text-field
              v-model="form.email"
              :rules="emailRules"
              :counter="30"
              label="email"
              required
            ></v-text-field>
          </v-flex>
          
          <v-flex xs12 sm6 md4> 
            <v-text-field
              v-model="form.Type"
              label="Nv do usuario"
              required
            ></v-text-field>
          </v-flex>
          <v-flex xs12 sm6 md4> 
            <v-text-field
              v-model="form.perfil"
              label="perfil"
              required
            ></v-text-field>
          </v-flex>
          <v-flex xs12 sm6 md4> 
            <v-text-field
              v-model="form.password"
              label="password"
              required
            ></v-text-field>
          </v-flex>
          <v-flex xs12 sm6 md4> 
          <v-text-field
              v-model="form.name"
              :rules="nameRules"
              :counter="30"
              label="name"
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
                type="file" @change="onFilePicked"
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
      <v-btn class="primary" style="float:right" type="submit">salvar</v-btn>
    </v-form>
</div>
</template>

<script>
export default {
  data: () => ({
    valid: false,
    file:"",
    imageUrl:[],
    form:{
      id:'',
      name:'',
      Type:'',
      username: '',
      email: '',
      Type:'',
      perfil:'',
      password:'',
      file:"",
    },
    lastname: '',
    //regra de requerimento
    nameRules: [
      v => !!v || 'Name is required',
      v => v.length <= 30 || 'Name must be less than 10 characters',
    ],
    emailRules: [
      v => !!v || 'E-mail is required',
      v => /.+@.+/.test(v) || 'E-mail must be valid',
    ],
  }),
  methods: {
    onChange(e) {
              this.form.file = e.target.files[0];
          },      
    onFilePicked (e) {
      let campo = e.target.name;
      
      let file = e.target.files[0];
      if(file) {
        let reader = new FileReader();
        this.file = file.name 
        let tipo = file['type'].split('/')[0];
        let limit = 1024 * 1024 * 2;
        if(tipo=='image'){
            if(file['size'] > limit){
                  alert('Sua imagem é maior que 2MB')
                return false;
            }
        }else{
              alert('Somente imagens')
            return false;
        }
        var canvas=document.getElementById("canvas");
        var ctx=canvas.getContext("2d");  
        var img = new Image;
        var maxW=130;
        var maxH=130;        
        
        reader.onloadend = (file) => {
            console.log("file imagem",file)
            this.form.file = reader.result;
            img.onload = function() {
              var iw=img.width;
              var ih=img.height;
              var scale=Math.min((maxW/iw),(maxH/ih));
              var iwScaled=iw*scale;
              var ihScaled=ih*scale;
              canvas.width=iwScaled;
              canvas.height=ihScaled;
              ctx.drawImage(img,0,0,iwScaled,ihScaled);
            }
            img.src = reader.result;            
        }
        reader.readAsDataURL(file);
      }

  }, 
  limparCampos:function(){
    Object.assign(this.$data.form,this.$options.data().form)
    this.form.errors={};    
  },
  salvar: function(e) {
        this.$Progress.start();              
        this.$http.post("/api/User",this.form).then(data => {
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