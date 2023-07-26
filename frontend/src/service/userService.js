import axios from "axios";

export const getUsersByPage = async (page, perPageRow) => {
  const { data, currentPage, lastPage, total, perPage } = await (
    await axios({
      url: "/users?page=" + page + "&perPage=" + perPageRow,
      method: "GET",
    })
  ).data;

  return {
    data,
    currentPage,
    lastPage,
    total,
    perPage,
  };
};

export const getUserWeather = async (userId) => {
  return (
    await axios({
      url: "/users/" + userId + "/weather",
      method: "GET",
    })
  ).data;
};
