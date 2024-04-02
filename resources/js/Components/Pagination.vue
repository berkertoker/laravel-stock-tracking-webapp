<template>
    <div class="pagination">
      <button @click="prevPage" :disabled="currentPage === 1">Previous</button>
      <span>{{ currentPage }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages">Next</button>
    </div>
  </template>

  <script>
  export default {
    props: {
      currentPage: {
        type: Number,
        required: true,
      },
      totalPages: {
        type: Number,
        required: true,
      },
    },
    methods: {
      prevPage() {
        if (this.currentPage > 1) {
          this.$emit('pagination', this.currentPage - 1);
        }
      },
      nextPage() {
        if (this.currentPage < this.totalPages) {
          this.$emit('pagination', this.currentPage + 1);
        }
      },
    },
  };
  </script>

  <style scoped>
  .pagination {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .pagination button {
    margin: 0 5px;
  }
  </style>
