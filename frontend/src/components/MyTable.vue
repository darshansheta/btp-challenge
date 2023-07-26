<script>
export default {
  props: {
    response: {
      type: Object,
      default() {
        return {
          data: [],
          currentPage: 1,
          lastPage: 1,
          total: 0,
          perPage: 15,
        };
      },
    },
    fields: {
      types: Object,
      default() {
        return [
          {
            field: "id",
            header: "#",
          },
        ];
      },
    },
  },

  methods: {
    onPageChange({ page, rows }) {
      this.$emit("onPageChange", { page: page + 1, perPage: rows });
    },
  },
};
</script>
<template>
  <div v-if="response">
    <DataTable :value="response.data" tableStyle="min-width: 50rem">
      <slot name="columns"></slot>
    </DataTable>
    <Paginator
      :rows="response.perPage"
      :totalRecords="response.total"
      :rowsPerPageOptions="[5, 10, 20]"
      @page="onPageChange"
    ></Paginator>
  </div>
</template>
