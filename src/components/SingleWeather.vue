<template>
    <div class="Weather">
            <router-link :to="{ name: 'Home' }">Home</router-link>
        <h1>{{ msg }}</h1>
        <div class="row">
            
            <div v-for="data ,key in dataList" :key="data.key" class="col-md-2">
                <div class="card" style="width: 12rem;">
                    <div class="card-head">
                        {{ DayName(data.applicable_date)}}
                    </div>
                <img class="card-img-top" :src="'https://www.metaweather.com/static/img/weather/'+data.weather_state_abbr+'.svg'" style="height:125px;width:125px" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">{{data.city}}</h5>
                    <p class="card-text"><b>&#176;</b>{{(data.the_temp).toFixed()}} ({{data.weather_state_name}})</p>
                    <p class="card-text"><b>&#176;</b>{{(data.min_temp).toFixed()}} (Max)</p>
                    <p class="card-text"><b>&#176;</b>{{(data.max_temp).toFixed()}} (Mix) </p>

                </div>
                </div>
            </div>
           <div class="col-md-3 offset-md-3" v-if="!dataList.length">
                <img :src="this.imgloader" alt="">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'SingleWeather',
        data () {
            return {
                msg: 'Innovative Frontend',
                woeid : this.$route.params.id,
                dataSingle : [],
                dataList:[],
                imgloader: 'https://static-steelkiwi-dev.s3.amazonaws.com/media/filer_public/2b/3b/2b3b2d3a-437b-4e0a-99cc-d837b5177baf/7d707b62-bb0c-4828-8376-59c624b2937b.gif',

            }
        },
        methods : {
            DayName(date){
                var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                var date = new Date(date);
                var day = days[date.getDay()];
                return day;
            }
        },
        created: function () {
            let self=this;
           const baseURI = 'api/weather.php?command=location&request=single&woeid='+this.woeid;
                    this.$http.get(baseURI , {

                })
                    .then((result) => {
                        this.dataList =  result.data.consolidated_weather;
                        this.msg = result.data.title
                    })
                
        },
        computed:{

        },
        mounted(){

        }

    }
</script>