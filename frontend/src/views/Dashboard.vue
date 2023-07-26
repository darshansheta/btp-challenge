<script>
import { getUsersByPage } from "@/service/userService";
import MyTable from "@/components/MyTable.vue";
import WeatherDialog from "@/views/WeatherDialog.vue";
import { mapState, mapActions } from "pinia";
import { useWeatherStore } from "@/stores/weather";

export default {
  data: () => ({
    paginatedResponse: null,
    fields: [
      { field: "id", header: "#" },
      { field: "name", header: "Name" },
      { field: "email", header: "Email" },
      {
        header: "Weather",
        render(props) {
          return `${props.main} - Temp: ${props.main_temp}, feels like: ${props.main_feels_like}`;
        },
      },
      { header: "Action" },
    ],
    activeUserWeatherId: null,
  }),
  components: {
    MyTable,
    WeatherDialog,
  },
  async mounted() {
    this.fetchData(1, 5);
  },

  computed: {
    pageNumber() {
      return Array.from({ length: this.lastPage }, (_, i) => i + 1);
    },
    ...mapState(useWeatherStore, ["activeUserWeather"]),
  },

  methods: {
    async fetchData(page, perPageRow) {
      this.paginatedResponse = await getUsersByPage(page, perPageRow);
    },

    onPageChange({ page, rows }) {
      this.fetchData(page, rows);
    },
    pageChance({ page, perPage }) {
      this.fetchData(page, perPage);
    },

    setActiveUserWeather(userId) {
      this.activeUserWeatherId = userId;
      this.getWeatherByUser(userId);
    },
    onDialogHide() {
      this.activeUserWeatherId = null;
    },
    ...mapActions(useWeatherStore, ["getWeatherByUser"]),
  },
};
</script>

<template>
  <div class="card">
    <MyTable
      :response="paginatedResponse"
      :fields="fields"
      @onPageChange="pageChance"
    >
      <template v-slot:columns>
        <template v-for="(field, fieldIndex) in fields">
          <template v-if="field.header == 'Action'">
            <Column :key="fieldIndex" :header="field.header">
              <template #body="slotProps">
                <Button @click="setActiveUserWeather(slotProps.data.id)">
                  <!-- <WeatherIcon :icon="slotProps.data.icon" /> -->
                  Show
                </Button>
              </template>
            </Column>
          </template>
          <template v-else-if="field.render">
            <Column :key="fieldIndex" :header="field.header">
              <template #body="slotProps">
                {{ field.render(slotProps.data) }}
              </template>
            </Column>
          </template>

          <template v-else>
            <Column
              :field="field.field"
              :key="fieldIndex"
              :header="field.header"
            />
          </template>
        </template>
      </template>
    </MyTable>

    <WeatherDialog
      v-if="activeUserWeatherId"
      :weather="activeUserWeather"
      @hide="onDialogHide"
    />
  </div>
</template>
