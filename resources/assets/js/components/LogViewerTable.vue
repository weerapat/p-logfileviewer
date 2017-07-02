<template>
    <div>
        <div class="row">
            <div class="col-md-8 col-sm-8">
                <div class="form-group">
                    <input v-model="fileLocation" type="text" placeholder="/var/tmp/file.log" class="form-control">
                    <p class="help-block">Please add path file in your server then click view</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="form-group">
                    <button class="btn btn-info btn-block"
                        :class = "{ disabled : (fileLocation.length == '')}"
                        @click="getLogData()"
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
                            <td class="text-center">{{ index + 1 }}</td>
                            <td>{{ log }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .table {
        tr > th:first-child {
            width: 40px;
        }
    }
</style>

<script>
    export default {
        data () {
            return {
                logs: [],
                fileLocation: '',
                error: '',
            }
        },

        methods: {
            getLogData () {
                if (this.fileLocation === '') return;

                axios.get(`/get-log-file-data?file_location=${this.fileLocation}`)
                    .then(({data}) => {
                        if (data.status === 'error') {
                            this.error = data.message;
                            return;
                        }
                        this.error = '';
                        this.logs = data.logs;
                    });
            },
        }
    }
</script>
