<template>
    <div>
        <div class="row">
            <div class="col-md-8 col-sm-8">
                <div class="form-group">
                    <input v-model="filePath" type="text" placeholder="/var/tmp/file.log" class="form-control">
                    <p class="help-block">Please add path file in your server then click view</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="form-group">
                    <button class="btn btn-info btn-block"
                        :class = "{ disabled : (filePath.length == '')}"
                        @click="clickView()"
                    >
                        View
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div v-show="error" class="alert alert-danger">{{ error }}</div>
            </div>
            <div class="col-md-12">
                <div v-show="this.logs.length === 0" class="alert alert-info">No data</div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <table
                    v-if="this.logs.length > 0 && !error"
                    class="table table-striped table-hover table-bordered"
                >
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th class="text-center">Log message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(log, index) in logs">
                            <td class="text-center">{{ getLineNumber(index) }}</td>
                            <td>{{ log }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination" v-if="this.logs.length > 0 && !error">
            <div class="col-xs-3">
                <button class="btn btn-block btn-success"
                    :class = "{ disabled : (this.currentPage === 1)}"
                    @click="updatePage(1)">|<</button>
            </div>
            <div class="col-xs-3">
                <button class="btn btn-block btn-success"
                    :class = "{ disabled : (this.currentPage === 1)}"
                    @click="updatePage(currentPage - 1)"><</button>
            </div>
            <div class="col-xs-3">
                <button class="btn btn-block btn-success"
                    :class = "{ disabled : (this.currentPage === this.lastPage)}"
                    @click="updatePage(currentPage + 1)">></button>
            </div>
            <div class="col-xs-3">
                <button class="btn btn-block btn-success"
                    :class = "{ disabled : (this.currentPage === this.lastPage)}"
                    @click="updatePage(lastPage)">>|</button>
            </div>
        </div>

    </div>
</template>

<style lang="scss" scoped>
    .table {
        tr > th:first-child {
            width: 60px;
        }
    }
    .pagination {
        position: fixed;
        max-width: 900px;
        left: 0;
        right: 0;
        margin: 0 auto;
        bottom: 15px;
    }
</style>

<script>
    export default {
        data() {
            return {
                logs: [],
                filePath: '',
                error: '',
                currentPage: 1,
                lastPage: 1
            }
        },

        methods: {
            /**
             * Gets line number of current content
             *
             * @param {Number} index
             * @return {Number} line number
             */
            getLineNumber(index) {
                return ((this.currentPage - 1) * 10) + index + 1;
            },

            /**
             * View button listener
             */
            clickView() {
                this.currentPage = 1;
                this.getLogData();
            },

            /**
             * Update data by page
             *
             * @param {Number} page
             */
            updatePage(page) {
                if (page >= 1 && page <= this.lastPage) {
                    this.currentPage = page;
                    this.getLogData();
                }
            },

            /**
             * Send request to read log data from server
             */
            getLogData() {
                if (this.filePath === '') return;

                axios.get(`/get-log-file-data?file_path=${this.filePath}&page=${this.currentPage}`)
                    .then(({data}) => {
                        if (data.status === 'error') {
                            this.error = data.message;
                            return;
                        }
                        this.error = '';
                        this.logs = data.logs;
                        this.lastPage = data.totalPages;
                    });
            },
        }
    }
</script>
