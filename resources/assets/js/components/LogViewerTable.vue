<template>
    <div>
        <div class="row">
            <div class="col-md-8 col-sm-8">
                <div class="form-group">
                    <input v-model="filePath" type="text" placeholder="/var/log/apache2/error_log" class="form-control">
                    <p class="help-block">Please add path file in your server then click view</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="form-group">
                    <button class="btn btn-info btn-block"
                        :class="{ disabled : (filePath.length == '')}"
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

        <div class="row" v-if="this.logs.length > 0 && !error">
            <div class="col-md-12">
                <div class="page text-right">Page <span class="text-info">{{ currentPage | numberFormat }}</span></div>
                <p class="help-block">For protecting app crash, limit maximum 1,000 pages per time.</p>
                <table
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
                            <td class="text-center">{{ getLineNumber(index) | numberFormat }}</td>
                            <td>{{ log }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination" v-if="this.logs.length > 0 && !error">
            <div class="col-xs-3">
                <button class="btn btn-block btn-success"
                    :class="{ disabled : (this.currentPage === 1)}"
                    @click="updatePage(1)">|<</button>
            </div>
            <div class="col-xs-3">
                <button class="btn btn-block btn-success"
                    :class = "{ disabled : (this.currentPage === 1)}"
                    @click="updatePage(currentPage - 1)"><</button>
            </div>
            <div class="col-xs-3">
                <button class="btn btn-block btn-success"
                    :class = "{ disabled : this.isLastPage() && this.currentPage === this.lastPage}"
                    @click="updatePage(currentPage + 1)">></button>
            </div>
            <div class="col-xs-3">
                <button class="btn btn-block btn-success"
                    :class = "{ disabled : (this.currentPage === this.lastPage)}"
                    @click="updatePage(lastPage)">>|</button>
            </div>
        </div><!-- /.pagination -->
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
    .text-info {
        width: 60px;
        display: inline-block;
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
                lastPage: 1,
                currentPointer: 0,
                pointers: [{ page: 1000, pointer: 0 }]
            }
        },

        filters: {
            /**
             * @param {Number} value
             **/
            numberFormat(value) {
                if (!value) return '';

                let parts = value.toString().split('.');
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                return parts.join(".");
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
             * Check is it last page
             */
            isLastPage() {
                return !this.currentPointer;
            },

            /**
             * Update data by page
             *
             * @param {Number} page
             */
            updatePage(nextPage) {

                if (nextPage > 1000) {
                    this.currentPage = nextPage;
                    let cursor = _.find(this.pointers, { page: Math.ceil(this.currentPage / 1000) * 1000 });
                    this.getLogData(cursor.pointer);
                }
                else if (nextPage >= 1 && nextPage <= this.lastPage) {
                    this.currentPage = nextPage;
                    this.getLogData();
                }
            },

            /**
             * Send request to read log data from server
             */
            getLogData(pointer = 0) {
                if (this.filePath === '') return;

                axios.get(`/get-log-file-data?file_path=${this.filePath}&page=${this.currentPage}&pointer=${pointer}`)
                    .then(({data}) => {
                        if (data.status === 'error') {
                            this.error = data.message;
                            return;
                        }
                        this.error = '';
                        this.logs = data.logs;
                        this.lastPage = data.totalPages;
                        this.currentPointer = data.currentPointer;

                        // Insert pointer to this stack if not exists
                        if (!_.find(this.pointers, { page: data.totalPages }))
                            this.pointers.push({ page : data.totalPages, pointer : data.currentPointer });
                    });
            },
        }
    }
</script>
