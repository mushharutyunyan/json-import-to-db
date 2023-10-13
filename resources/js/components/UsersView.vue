<template>
    <div class="container">
        <div v-if="last_import.status">
            <h4>Последний импорт</h4>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Статус</th>
                    <th scope="col">УРЛ</th>
                    <th scope="col">Процент завершения (если статус failed)</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">{{ last_import.status }}</th>
                    <td>{{ last_import.file_url }}</td>
                    <td>{{ last_import.done_pct }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-row mt-5">
            <button v-if="!loading" @click="importUsers()" type="button" class="btn btn-primary">Импортировать
                пользователей
            </button>
            <button v-else class="btn btn-primary" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...
            </button>
            <div class="p-2">Всего <span class="fw-bold">{{ summary.qty }}</span></div>
            <div class="p-2">Добавлено <span class="fw-bold">{{ summary.new }}</span></div>
            <div class="p-2">Обновлено <span class="fw-bold">{{ summary.updated }}</span></div>
        </div>
    </div>
</template>
<script>
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/src/sweetalert2.scss'
export default {
    data() {
        return {
            loading: false,
            last_import: {
                import_id: null,
                status: null,
                file_url: null,
                done_pct: null,
            },
            summary: {
                qty: null,
                updated: null,
                new: null
            },
        }
    },
    methods: {
        async getLastImport() {
            let self = this;
            await axios.get("/api/import/users/last").then(function (response) {
                self.last_import = response.data.data
            });
        },
        async getSummary() {
            let self = this;
            await axios.get("/api/users/summary").then(function (response) {
                self.summary = response.data.data
            });
        },

        async importUsers() {
            let self = this;
            self.loading = true;
            await axios.post("/api/import/users").then(function (response) {
                self.loading = false;
                Swal.fire({
                    title: 'успех!',
                    text: response.data.data.message,
                    icon: 'success',
                })
                self.importIntervalUpdate();
            }).catch(function (error) {
                Swal.fire({
                    title: 'Error!',
                    text: error.response.data.message,
                    icon: 'error',
                })
                self.loading = false;
            });
        },
        // a substitute for broadcast
        importIntervalUpdate() {
            let self = this;
            self.getLastImport();
            let intervalId = setInterval(function () {
                self.getLastImport().then(function() {
                    if(self.last_import.status !== 'pending') {
                        self.getSummary();
                        clearInterval(intervalId);
                    }
                })
            }, 10000);
        }
    },
    mounted() {
        this.importIntervalUpdate();
        this.getSummary();
    }
}
</script>
