<template>
  <div class="login">
    <div class="container" id="container">
      <div class="form-container sign-up-container">
        <form>
          <h1>Criar Conta</h1>
          <ErrorList v-if="errors" :errors="errors" />
          <input v-model="form.name" type="text" placeholder="Nome" />
          <input v-model="form.email" type="email" placeholder="Email" />
          <input v-model="form.password" type="password" placeholder="Senha" />
          <input
            v-model="form.password_confirmation"
            type="password"
            placeholder="Confirmar Senha"
          />
          <button @click.prevent="register">Cadastrar</button>
        </form>
      </div>
      <div class="form-container sign-in-container">
        <div class="form">
          <h1>Login</h1>
          <ErrorList v-if="errors" :errors="errors" />
          <input v-model="loginForm.email" type="email" placeholder="Email" />
          <input
            v-model="loginForm.password"
            type="password"
            placeholder="Senha"
          />
          <!-- <a href="#">Esqueceu sua senha?</a> -->
          <button @click.prevent="login">Entrar</button>
          <button @click="signInWithGoogle" class="gsi-material-button">
            <div class="gsi-material-button-state"></div>
            <div class="gsi-material-button-content-wrapper">
              <div class="gsi-material-button-icon">
                <svg
                  version="1.1"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 48 48"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                  style="display: block"
                >
                  <path
                    fill="#EA4335"
                    d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"
                  ></path>
                  <path
                    fill="#4285F4"
                    d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"
                  ></path>
                  <path
                    fill="#FBBC05"
                    d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"
                  ></path>
                  <path
                    fill="#34A853"
                    d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"
                  ></path>
                  <path fill="none" d="M0 0h48v48H0z"></path>
                </svg>
              </div>
              <span class="gsi-material-button-contents">Login com Google</span>
              <span style="display: none">Login com Google</span>
            </div>
          </button>
        </div>
      </div>
      <div class="overlay-container">
        <div class="overlay">
          <div class="overlay-panel overlay-left">
            <h1>Bem Vindo!</h1>
            <p>
              Para voltar à suas tarefas conecte-se novamente com suas
              informações pessoais!
            </p>
            <button @click="errors = null" class="ghost" id="signIn">
              Login
            </button>
          </div>
          <div class="overlay-panel overlay-right">
            <h1>Olá, Muito Prazer!</h1>
            <p>
              Entre com suas informações pessoais para começar a organizar suas
              tarefas de forma inteligente!
            </p>
            <button @click="errors = null" class="ghost" id="signUp">
              Cadastrar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import authApi from "@api/auth";
import ErrorList from "@components/ErrorList";
import firebase from "firebase/compat/app";
import "firebase/compat/auth";
import "firebase/compat/firestore";

export default {
  components: {
    ErrorList,
  },
  data() {
    return {
      form: {},
      loginForm: {},
      errors: null,
    };
  },
  methods: {
    register() {
      this.errors = null;
      authApi
        .register(this.form)
        .then((result) => {
          this.$store.commit("setUser", result.data);
          this.$router.push({ name: "Home" });
        })
        .catch((errors) => {
          if (errors.response.status === 422) {
            this.errors = errors.response.data.errors;
          }
        });
    },
    login() {
      this.errors = null;
      authApi
        .login(this.loginForm)
        .then((result) => {
          this.$store.commit("setUser", result.data);
          this.$router.push({ name: "Home" });
        })
        .catch((errors) => {
          if (errors.response.status === 422) {
            this.errors = errors.response.data.errors;
          }
        });
    },
    async signInWithGoogle() {
      try {
        const provider = new firebase.auth.GoogleAuthProvider();
        const result = await firebase.auth().signInWithPopup(provider);
        const user = result.user;
        const existsUser = await authApi.verifyUserByEmail(user.email);
        console.log(existsUser.data);
        if (existsUser.data) {
          authApi
            .login({
              email: user.email,
              password: user.uid,
            })
            .then((result) => {
              this.$store.commit("setUser", result.data);
              this.$router.push({ name: "Home" });
            })
            .catch((errors) => {
              if (errors.response.status === 422) {
                this.errors = errors.response.data.errors;
              }
            });
        } else {
          authApi
            .register({
              name: user.displayName,
              email: user.email,
              password: user.uid,
              password_confirmation: user.uid,
            })
            .then((result) => {
              this.$store.commit("setUser", result.data);
              this.$router.push({ name: "Home" });
            })
            .catch((errors) => {
              if (errors.response.status === 422) {
                this.errors = errors.response.data.errors;
              }
            });
        }
      } catch (error) {
        this.errors = errors.response.data.errors;
      }
    },
  },
  mounted() {
    const signUpButton = document.getElementById("signUp");
    const signInButton = document.getElementById("signIn");
    const container = document.getElementById("container");

    signUpButton.addEventListener("click", () => {
      container.classList.add("right-panel-active");
    });

    signInButton.addEventListener("click", () => {
      container.classList.remove("right-panel-active");
    });
  },
};
</script>

<style scoped>
h1 {
  font-weight: bold;
  margin: 0;
  margin-bottom: 10px;
}

p {
  font-size: 14px;
  font-weight: 100;
  line-height: 20px;
  letter-spacing: 0.5px;
  margin: 20px 0 30px;
}

span {
  font-size: 12px;
}

a {
  color: #333;
  font-size: 14px;
  text-decoration: none;
  margin: 15px 0;
}

button {
  border-radius: 20px;
  border: 1px solid var(--primary);
  background-color: var(--primary);
  color: #ffffff;
  font-size: 12px;
  font-weight: bold;
  padding: 12px 45px;
  letter-spacing: 1px;
  text-transform: uppercase;
  transition: transform 80ms ease-in;
}

button:active {
  transform: scale(0.95);
}

button:focus {
  outline: none;
}

button.ghost {
  background-color: transparent;
  border-color: #ffffff;
}

form,
.form {
  background-color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  padding: 0 50px;
  height: 100%;
  text-align: center;
}

input {
  background-color: #eee;
  border: none;
  padding: 12px 15px;
  margin: 8px 0;
  width: 100%;
}

.container {
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  position: relative;
  overflow: hidden;
  width: 768px;
  max-width: 100%;
  min-height: 480px;
}

.form-container {
  position: absolute;
  top: 0;
  height: 100%;
  transition: all 0.6s ease-in-out;
}

.sign-in-container {
  left: 0;
  width: 50%;
  z-index: 2;
}

.container.right-panel-active .sign-in-container {
  transform: translateX(100%);
}

.sign-up-container {
  left: 0;
  width: 50%;
  opacity: 0;
  z-index: 1;
}

.container.right-panel-active .sign-up-container {
  transform: translateX(100%);
  opacity: 1;
  z-index: 5;
  animation: show 0.6s;
}

@keyframes show {
  0%,
  49.99% {
    opacity: 0;
    z-index: 1;
  }

  50%,
  100% {
    opacity: 1;
    z-index: 5;
  }
}

.overlay-container {
  position: absolute;
  top: 0;
  left: 50%;
  width: 50%;
  height: 100%;
  overflow: hidden;
  transition: transform 0.6s ease-in-out;
  z-index: 100;
}

.container.right-panel-active .overlay-container {
  transform: translateX(-100%);
}

.overlay {
  background: #ff416c;
  background: -webkit-linear-gradient(
    to right,
    var(--primary),
    var(--secondary)
  );
  background: linear-gradient(to right, var(--primary), var(--secondary));
  background-repeat: no-repeat;
  background-size: cover;
  background-position: 0 0;
  color: #ffffff;
  position: relative;
  left: -100%;
  height: 100%;
  width: 200%;
  transform: translateX(0);
  transition: transform 0.6s ease-in-out;
}

.container.right-panel-active .overlay {
  transform: translateX(50%);
}

.overlay-panel {
  position: absolute;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  padding: 0 40px;
  text-align: center;
  top: 0;
  height: 100%;
  width: 50%;
  transform: translateX(0);
  transition: transform 0.6s ease-in-out;
}

.overlay-left {
  transform: translateX(-20%);
}

.container.right-panel-active .overlay-left {
  transform: translateX(0);
}

.overlay-right {
  right: 0;
  transform: translateX(0);
}

.container.right-panel-active .overlay-right {
  transform: translateX(20%);
}

.social-container {
  margin: 20px 0;
}

.social-container a {
  border: 1px solid #dddddd;
  border-radius: 50%;
  display: inline-flex;
  justify-content: center;
  align-items: center;
  margin: 0 5px;
  height: 40px;
  width: 40px;
}

.gsi-material-button {
  -moz-user-select: none;
  -webkit-user-select: none;
  -ms-user-select: none;
  -webkit-appearance: none;
  background-color: WHITE;
  background-image: none;
  border: 1px solid #747775;
  -webkit-border-radius: 20px;
  border-radius: 20px;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  color: #1f1f1f;
  cursor: pointer;
  font-family: "Roboto", arial, sans-serif;
  font-size: 14px;
  height: 40px;
  letter-spacing: 0.25px;
  outline: none;
  overflow: hidden;
  padding: 0 12px;
  position: relative;
  text-align: center;
  -webkit-transition: background-color 0.218s, border-color 0.218s,
    box-shadow 0.218s;
  transition: background-color 0.218s, border-color 0.218s, box-shadow 0.218s;
  vertical-align: middle;
  white-space: nowrap;
  width: auto;
  max-width: 400px;
  min-width: min-content;
  margin-top: 30px;
}

.gsi-material-button .gsi-material-button-icon {
  height: 20px;
  margin-right: 12px;
  min-width: 20px;
  width: 20px;
}

.gsi-material-button .gsi-material-button-content-wrapper {
  -webkit-align-items: center;
  align-items: center;
  display: flex;
  -webkit-flex-direction: row;
  flex-direction: row;
  -webkit-flex-wrap: nowrap;
  flex-wrap: nowrap;
  height: 100%;
  justify-content: space-between;
  position: relative;
  width: 100%;
}

.gsi-material-button .gsi-material-button-contents {
  -webkit-flex-grow: 1;
  flex-grow: 1;
  font-family: "Roboto", arial, sans-serif;
  font-weight: 500;
  overflow: hidden;
  text-overflow: ellipsis;
  vertical-align: top;
}

.gsi-material-button .gsi-material-button-state {
  -webkit-transition: opacity 0.218s;
  transition: opacity 0.218s;
  bottom: 0;
  left: 0;
  opacity: 0;
  position: absolute;
  right: 0;
  top: 0;
}

.gsi-material-button:disabled {
  cursor: default;
  background-color: #ffffff61;
  border-color: #1f1f1f1f;
}

.gsi-material-button:disabled .gsi-material-button-contents {
  opacity: 38%;
}

.gsi-material-button:disabled .gsi-material-button-icon {
  opacity: 38%;
}

.gsi-material-button:not(:disabled):active .gsi-material-button-state,
.gsi-material-button:not(:disabled):focus .gsi-material-button-state {
  background-color: #303030;
  opacity: 12%;
}

.gsi-material-button:not(:disabled):hover {
  -webkit-box-shadow: 0 1px 2px 0 rgba(60, 64, 67, 0.3),
    0 1px 3px 1px rgba(60, 64, 67, 0.15);
  box-shadow: 0 1px 2px 0 rgba(60, 64, 67, 0.3),
    0 1px 3px 1px rgba(60, 64, 67, 0.15);
}

.gsi-material-button:not(:disabled):hover .gsi-material-button-state {
  background-color: #303030;
  opacity: 8%;
}
</style>