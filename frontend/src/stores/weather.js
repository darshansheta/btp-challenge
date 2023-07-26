import { defineStore } from "pinia";
import { getUserWeather } from "@/service/userService";

export const useWeatherStore = defineStore("weather", {
  state: () => ({
    weathers: [],
    userId: null,
  }),
  getters: {
    activeUserWeather: (state) =>
      state.weathers.find((user) => user.id === state.userId),
  },
  actions: {
    async getWeatherByUser(userId) {
      try {
        this.userId = userId;
        const found = this.$state.weathers.find((user) => user.id === userId);
        if (found) {
          return;
        }
        this.weathers.push((await getUserWeather(userId)).data);
      } catch (error) {
        return error;
      }
    },
    updateUserWeather(userWeather) {
      this.weathers = this.weathers.map((user) =>
        user.id != userWeather.id ? user : userWeather
      );
    },
  },
});
