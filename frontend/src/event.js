export default [
  {
    name: "APP_LOGIN_SUCCESS",
    callback: function(e) {
      this.$router.push({ path: "dashboard" });
    }
  },
  {
    name: "APP_ERRO_DELETE",
    callback: function(e) {
      this.snackbar = {
        show: true,
        color: "red",
        text: "O registro do login atual não pode ser excluí­do."
      };
      //this.$router.replace({ path: '/login' });
    }
  },  
  {
    name: "APP_ERRO_SAVE",
    callback: function(e) {
      this.snackbar = {
        show: true,
        color: "red",
        text: "O sistema não conseguiu salvar, tente mais tarde."
      };
      //this.$router.replace({ path: '/login' });
    }
  },
  {
    name: "APP_ERRO_SAVE_UNIQUE",
    callback: function(e) {
      this.snackbar = {
        show: true,
        color: "red",
        text: "Registro único já cadastrado."
      };
      //this.$router.replace({ path: '/login' });
    }
  },  
  {
    name: "APP_SAVE",
    callback: function(e) {
      this.snackbar = {
        show: true,
        color: "green",
        text: "Registro salvo com sucesso."
      };
      //this.$router.replace({ path: '/login' });
    }
  },
  {
    name: "APP_DELETE",
    callback: function(e) {
      this.snackbar = {
        show: true,
        color: "green",
        text: "Registro excluí­do com sucesso."
      };
      //this.$router.replace({ path: '/login' });
    }
  },
  {
    name: "ERROR_LOGIN",
    callback: function(e) {
      this.snackbar = {
        show: true,
        color: "red",
        text: "Senha ou usuário incorretos!"
      };
      //this.$router.replace({ path: '/login' });
    }
  },
  {
    name: "APP_EDIT",
    callback: function(e) {
      this.snackbar = {
        show: true,
        color: "green",
        text: "Registro alterado com sucesso."
      };
      //this.$router.replace({ path: '/login' });
    }
  },
  {
    name: "APP_LOGOUT",
    callback: function(e) {
      this.snackbar = {
        show: true,
        color: "green",
        text: "Logout efetuado com sucesso."
      };
      localStorage.removeItem("token_sistema");
      let dados_configuracoes = this.$session.get("dados_configuracoes");
      this.$session.destroy();
      this.$session.start();
      this.$session.set("dados_configuracoes", dados_configuracoes);
      this.$router.replace({ path: "/login" });
      window.location.replace("#/login")
      this.$router.go("/login");
    }
  },
  {
    name: "APP_LOGOUT_EXPIRE",
    callback: function (e) {
      this.snackbar = {
        show: true,
        color: "green",
        text: "A sessão expirou."
      };
      localStorage.removeItem("token_sistema");
      let dados_configuracoes = this.$session.get("dados_configuracoes");
      this.$session.destroy();
      this.$session.start();
      this.$session.set("dados_configuracoes", dados_configuracoes);
      //this.$router.replace({ path: "/login" });
      this.$router.go("/login");
    }
  },  
  {
    name: "APP_PAGE_LOADED",
    callback: function(e) {}
  },
  {
    name: "APP_AUTH_FAILED",
    callback: function(e) {
      this.$router.push("/login");
      this.$message.error("Token has expired");
    }
  },
  {
    name: "APP_BAD_REQUEST",
    // @error api response data
    callback: function(msg) {
      this.$message.error(msg);
    }
  },
  {
    name: "APP_ACCESS_DENIED",
    // @error api response data
    callback: function(msg) {
      this.$message.error(msg);
      this.$router.push("/forbidden");
    }
  },
  {
    name: "APP_RESOURCE_DELETED",
    // @error api response data
    callback: function(msg) {
      this.$message.success(msg);
    }
  },
  {
    name: "APP_RESOURCE_UPDATED",
    // @error api response data
    callback: function(msg) {
      this.$message.success(msg);
    }
  }
];
