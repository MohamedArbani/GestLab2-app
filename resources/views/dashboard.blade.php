<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12" id="laboratories">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form class="flex items-center justify-center" v-on:submit.prevent="fetchLaboratories">
                <x-input class="py-4 px-6 w-1/2" placeholder="Find a laboratory near you" v-model="labName" />
                <x-button class="ml-4 py-4">Search</x-button>
            </form>

            <div class="mt-8 shadow-sm sm:rounded-lg">
                <div v-show="locationErrorMessage" class="text-center">@{{ locationErrorMessage }}</div>
                <div v-show="loading" class="text-center">Loading...</div>
                <div v-show="!loading" class="grid grid-cols-3 gap-4" style="display: none;">
                    <div class="p-6 bg-white border-b border-gray-200" v-for="laboratory in laboratories" :key="laboratory.id">
                        <div class="text-xl">@{{ laboratory.name }}</div>
                        <div class="mt-4 text-gray-500" v-if="laboratory.distance">@{{ parseInt(laboratory.distance).toLocaleString() }}m away</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/vue@next"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
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
    @endpush
</x-app-layout>
