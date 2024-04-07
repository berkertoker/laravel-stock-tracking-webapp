<template>
    <div class="pagination-container">
      <div class="pagination">
        <ul>
          <li @click="previousPage" v-if="pagination.current_page > 1">
            &lt;
          </li>
          <li v-for="page in displayedPages" :key="page" @click="changePage(page)" :class="{ active: page === pagination.current_page }">
            {{ page }}
          </li>
          <li @click="nextPage" v-if="pagination.current_page < pagination.last_page">
            &gt;
          </li>
        </ul>
      </div>
    </div>
  </template>

  <script>
  export default {
    props: {
      pagination: Object,
    },
    computed: {
      displayedPages() {
        const lastPage = this.pagination.last_page;
        const currentPage = this.pagination.current_page;
        let pages = [];
        if (lastPage > 10) {
          if (currentPage <= 5) {
            for (let i = 1; i <= 10; i++) {
              pages.push(i);
            }
            pages.push('...');
            pages.push(lastPage - 1);
            pages.push(lastPage);
          } else if (currentPage >= lastPage - 4) {
            pages.push(1);
            pages.push(2);
            pages.push('...');
            for (let i = lastPage - 7; i <= lastPage; i++) {
              pages.push(i);
            }
          } else {
            pages.push(1);
            pages.push(2);
            pages.push('...');
            for (let i = currentPage - 2; i <= currentPage + 2; i++) {
              pages.push(i);
            }
            pages.push('...');
            pages.push(lastPage - 1);
            pages.push(lastPage);
          }
        } else {
          for (let i = 1; i <= lastPage; i++) {
            pages.push(i);
          }
        }
        return pages;
      }
    },
    methods: {
      changePage(page) {
        window.location.href = `${this.pagination.path}?page=${page}`;
      },
      previousPage() {
        if (this.pagination.current_page > 1) {
          const prevPage = this.pagination.current_page - 1;
          this.changePage(prevPage);
        }
      },
      nextPage() {
        if (this.pagination.current_page < this.pagination.last_page) {
          const nextPage = this.pagination.current_page + 1;
          this.changePage(nextPage);
        }
      }
    }
  }
  </script>

  <style scoped>
  .pagination-container {
    display: flex;
    justify-content: center;
    margin-bottom: 40px;
  }

  .pagination {
    margin-top: 20px;
  }

  .pagination ul {
    list-style: none;
    padding: 0;
  }

  .pagination li {
    background-color: #ffffff;
    display: inline-block;
    padding: 5px 10px;
    cursor: pointer;
  }

  .pagination li.active {
    background-color: #007bff;
    color: #fff;
  }
  </style>
