<script>
import WeatherIcon from "@/components/WeatherIcon.vue";

export default {
  data: () => ({
    visible: true,
  }),
  components: {
    WeatherIcon,
  },

  props: {
    weather: {
      type: Object,
      default() {
        return {
          id: null,
          name: null,
          location: {
            city: null,
            country: null,
          },
          weather: {
            title: null,
            description: null,
            icon: "04d",
            clouds: null,
          },
          temprature: {
            actual: null,
            feelsLike: null,
          },
          climate: {
            pressure: null,
            humidity: null,
            seaLevel: null,
            groundLevel: null,
          },
          wind: {
            speed: null,
            direction: null,
          },
          rain: {
            rain1h: null,
            rain3h: null,
          },
          snow: {
            snow1h: null,
            snow3h: null,
          },
          updatedAt: null,
          calculatedAt: null,
        };
      },
    },
  },
};
</script>
<template>
  <Sidebar
    v-model:visible="visible"
    position="right"
    header="Header"
    @hide="$emit('hide')"
    :style="{ width: '50vw' }"
  >
    <template #header> </template>
    <h2>
      <b>#{{ weather.id }} - {{ weather.name }}</b> ( City -
      {{ weather.location.city }} / Country - {{ weather.location.country }})
      icon - <WeatherIcon :icon="weather.weather.icon" />
    </h2>
    <table>
      <tbody>
        <tr>
          <td>
            <b>{{ weather.weather.title }}</b>
          </td>
          <td>
            {{ weather.weather.description }} (clouds -
            {{ weather.weather.clouds }}% )
          </td>
        </tr>
        <tr>
          <td colspan="2"><b>Temprature</b></td>
        </tr>
        <tr>
          <td>Actual</td>
          <td>{{ weather.temprature.actual }}</td>
        </tr>
        <tr>
          <td>Feels like</td>
          <td>{{ weather.temprature.feelsLike }}</td>
        </tr>
        <tr>
          <td colspan="2"><b>Climate</b></td>
        </tr>
        <tr>
          <td>Pressure</td>
          <td>{{ weather.climate.pressure }}</td>
        </tr>
        <tr>
          <td>Humidity</td>
          <td>{{ weather.climate.humidity }}</td>
        </tr>
        <tr>
          <td>SseaLevel</td>
          <td>{{ weather.climate.seaLevel }}</td>
        </tr>
        <tr>
          <td>Ground Level</td>
          <td>{{ weather.climate.groundLevel }}</td>
        </tr>
        <tr>
          <td colspan="2"><b>Rain/Snow</b></td>
        </tr>
        <tr>
          <td>Rain</td>
          <td>{{ weather.rain.rain1h }} / {{ weather.rain.rain3h }}</td>
        </tr>
        <tr>
          <td>Snow</td>
          <td>{{ weather.snow.snow1h }} / {{ weather.snow.snow3h }}</td>
        </tr>

        <tr>
          <td>Last Updated</td>
          <td>{{ weather.updatedAt }}</td>
        </tr>

        <tr>
          <td>Last Calculated</td>
          <td>{{ weather.calculatedAt }}</td>
        </tr>
      </tbody>
    </table>
  </Sidebar>
</template>
