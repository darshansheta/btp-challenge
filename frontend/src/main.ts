import { createApp } from "vue";
import { createPinia } from "pinia";
import axios from "axios";
import PrimeVue from "primevue/config";
import Button from "primevue/button";
import Card from "primevue/card";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ColumnGroup from "primevue/columngroup";
import Row from "primevue/row";
import Paginator from "primevue/paginator";
import Dialog from "primevue/dialog";
import Sidebar from "primevue/sidebar";
import TabView from "primevue/tabview";
import TabPanel from "primevue/tabpanel";
import Echo from "laravel-echo";
import Pusher from "pusher-js";

import App from "./App.vue";
import router from "./router";
import { useWeatherStore } from "@/stores/weather";

import "@/assets/main.css";
import "primevue/resources/primevue.min.css";
import "primevue/resources/themes/lara-light-indigo/theme.css";
import "primeicons/primeicons.css";

const app = createApp(App);

app.use(createPinia());
app.use(router);
app.use(PrimeVue);
app.component("Button", Button);
app.component("Card", Card);
app.component("DataTable", DataTable);
app.component("Column", Column);
app.component("ColumnGroup", ColumnGroup);
app.component("Row", Row);
app.component("Paginator", Paginator);
app.component("Dialog", Dialog);
app.component("Sidebar", Sidebar);
app.component("TabView", TabView);
app.component("TabPanel", TabPanel);

const weatherStore = useWeatherStore();

axios.defaults.baseURL = "http://localhost/";

const echoObject = new Echo({
  broadcaster: "pusher",
  key: "b5c88eef7de8c8221792",
  cluster: "ap2",
  forceTLS: true,
});

echoObject.channel("weather-update").listen(".weather.updated", (event) => {
  weatherStore.updateUserWeather(event.data);
});

app.mount("#app");
