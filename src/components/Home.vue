
<template>
    <div class="Home">
        <h1>{{ msg }}</h1>
        <div class="row">
            <div class="col-md-4 offset-md-4">
                        <form @submit="formSubmit">
                        <div class="input-group mb-3">
                            <input type="text" v-model="search" class="form-control" placeholder="Enter City" aria-label="Enter City" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-outline-info" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
        <div class="row">
            <div v-for="item ,key in items" :key="item.key" class="col-md-2">
                <div class="card" style="width: 12rem;">
                <img class="card-img-top" :src="'https://www.metaweather.com/static/img/weather/'+item.consolidated_weather.weather_state_abbr+'.svg'" style="height:125px;width:125px" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">{{item.city}}</h5>
                    <p class="card-text"><b>&#176;</b>{{(item.consolidated_weather.the_temp).toFixed()}} ({{item.consolidated_weather.weather_state_name}})</p>
                    <p class="card-text"><b>&#176;</b>{{(item.consolidated_weather.min_temp).toFixed()}} (Max)</p>
                    <p class="card-text"><b>&#176;</b>{{(item.consolidated_weather.max_temp).toFixed()}} (Mix) </p>
                    <a :href="'/#/weather/'+item.woeid">View Details!</a>
                </div>
                </div>
            </div>
            <div class="col-md-3 offset-md-3" v-if="!items.length">
                <img :src="this.imgloader" alt="">
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: 'Home',
        components: {
        },
        data () {
            return {
                imgloader: 'https://static-steelkiwi-dev.s3.amazonaws.com/media/filer_public/2b/3b/2b3b2d3a-437b-4e0a-99cc-d837b5177baf/7d707b62-bb0c-4828-8376-59c624b2937b.gif',
                msg: 'Innovative Frontend',
                items : [],
                search :'',
                img: 'https://img.pngio.com/cloud-sun-sunny-weather-icon-weather-icons-png-512_512.png'
            }
        },

        created: function () {
            const baseURI = 'api/weather.php?command=location&woeid[]=2344116&woeid[]=638242&woeid[]=44418&woeid[]=565346&woeid[]=560743&woeid[]=9807';

            this.$http.get(baseURI , {})
                .then((result) => {
                    this.items =  result.data;
                })
            },

        methods: {
            formSubmit(e) {
                e.preventDefault();
                let search = this.search;
                this.$router.push({
                    name: 'Search',
                    params: { id: search }
                });
            },
            // searchWeather(){
            //     const baseURI = 'api/weather.php?command=search&keyword='+this.search;
            //    this.$http.get(baseURI , {
            //    })
            //     .then((result) => {
            //         if(result.length != 0){
            //         this.items.push(result.data);
            //         }
                    
            //     })
            // }

        }
    }
</script>