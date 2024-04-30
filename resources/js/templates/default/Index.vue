<template>
  <v-app>
    <v-navigation-drawer width="300" app v-model="drawer">
      <v-list>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title class="text-h6">
              {{ $store.state.user.name }}
            </v-list-item-title>
            <v-list-item-subtitle>{{
              $store.state.user.email
            }}</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-list>

      <v-divider></v-divider>

      <v-list nav dense>
        <v-list-item>
          <v-date-picker locale="pt-BR" v-model="date"></v-date-picker>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-main class="main">
      <v-app-bar class="primary" dark app>
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
        <v-toolbar-title></v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn icon @click="logout">
          <v-icon>mdi-export</v-icon>
        </v-btn>
      </v-app-bar>

      <div class="home">
        <v-container fluid class="mt-4">
          <router-view />
        </v-container>
      </div>
    </v-main>
  </v-app>
</template>

<script>
import authApi from "@api/auth";
import store from "../../store/store";

export default {
  data: () => ({
    drawer: true,
    date: new Date().toISOString().slice(0, 10),
  }),
  watch: {
    date(val) {
      this.$store.commit("setSelectedDate", val);
    },
  },
  methods: {
    logout() {
      authApi.logout().then(() => {
        this.$store.commit("setUser", null);
        localStorage.removeItem("vuex");
        this.$router.push({ name: "Login" });
      });
    },
  },
  mounted() {
	if (this.$store.state.selectedDate) {
		this.date = this.$store.state.selectedDate;
	}
  }
};
</script>
<style>
.main {
  background-color: #f4f5fa;
  width: 100vw;
}

.icon {
  font-size: 15px;
  margin-right: 10px;
}

.nome {
  color: #626262;
  font-weight: bold;
  text-transform: uppercase;
  font-size: 13px;
}

.notificacao {
  color: white;
  font-size: 10px;
  height: 15px;
  width: 15px;
  background-color: var(--vermelho);
  border-radius: 15px;
  display: flex;
  justify-content: center;
  align-content: center;
  position: relative;
  top: 5px;
  right: 10px;
}

.notificacao p {
  margin-top: 2px;
  margin-left: 1px;
}

.mensagem.v-btn:before {
  right: 4px !important;
  left: -9px !important;
}
</style>

