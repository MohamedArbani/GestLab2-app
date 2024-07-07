
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <x-app-layout>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
            </x-slot>

            <div class="py-12" id="laboratories">
                <div class="container">
                    <form class="row g-3 align-items-center justify-content-center mb-4" v-on:submit.prevent="fetchLaboratories">
                        <div class="col-auto">
                            <input type="text" class="form-control" placeholder="Find a laboratory near you" v-model="labName">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>

                    <div class="mt-8 shadow-sm sm:rounded-lg">
                        <div v-show="locationErrorMessage" class="text-center text-danger">@{{ locationErrorMessage }}</div>
                        <div v-show="loading" class="text-center">Loading...</div>
                        <div v-show="!loading" class="row">
                            <div class="col-md-4" v-for="laboratory in laboratories" :key="laboratory.id">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title">@{{ laboratory.name }}</h5>
                                        <p class="card-text" v-if="laboratory.distance">@{{ parseInt(laboratory.distance).toLocaleString() }}m away</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-app-layout>
    </div>

    @stack('scripts')
    <script src="https://unpkg.com/vue@next"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>
   
    <script>
        Vue.createApp({
            data() {
                return {
                    labName: "",
                    long: "",
                    lat: "",
                    laboratories: [],
                    loading: false,
                    locationErrorMessage: "",
                }
            },
            methods: {
                fetchLaboratories() {
                    this.loading = true;
                    axios.get(`/dashboard`, {
                        params: {
                            labName: this.labName,
                            long: this.long,
                            lat: this.lat,
                        }
                    }).then(res => {
                        this.laboratories = res.data.laboratories;
                    }).finally(() => {
                        this.loading = false;
                    })
                },

                getLocation(closure) {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition((position) => {
                            this.long = position.coords.longitude;
                            this.lat = position.coords.latitude;
                            this.locationErrorMessage = "";

                            closure()
                        }, (error) => {
                            if (error.code === 1) {
                                this.locationErrorMessage = "Please allow location access.";
                            }
                        });
                    } else {
                        x.innerHTML = "Geolocation is not supported by this browser.";
                    }
                },
            },
            mounted() {
                this.getLocation(() => {
                    this.fetchLaboratories();
                });
            },
        }).mount('#laboratories');
    </script>
</body>
</html>

    
