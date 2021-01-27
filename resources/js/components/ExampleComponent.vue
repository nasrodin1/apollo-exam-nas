<template>
    <div style="padding: 10px" class="card">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Breakdown</div>
                    <div class="card-body">
                       <div class="container-">
                            <div class="circleText">
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
            <!-- <div class="col-md-6">
                <div class="card">
                    <div class="card-header">breakdown</div>
                    <div class="card-body">
                        {{breakdown}}
                    </div>
                </div>
            </div> -->
        </div>
        <div class="row">
            <p>
                <button class="btn" @click="onCreate()">Make New Random</button>
                <button class="btn" @click="getRandom()">Display New Random</button>
            </p>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    // import { API_BASE_URL } from '../../views/src/config'

    export default {
        data() {
            return {
                random: '',
                breakdown: '',
                isLoading: false
            }
        },
        methods: {
            onCreate() {
                this.isLoading = true
                this.make()
            },
            async make() {
                axios.get('/make')
                    .then(response => {
                        console.log(response)
                        this.name = ''
                        this.isLoading = false
                    })
                    .catch(function (error) {
                        console.log(error.response.status) // 401
                        console.log(error.response.data.error) //Please Authenticate or whatever returned from server
                        if(error.response.status==401){
                            //redirect to login
                        }
                    })
            },
            getRandom() {
                axios.get('/get-random')
                .then(response => {
                    console.log(response)
                    this.random = response.data.random;
                    this.breakdown = response.data.breakdown;
                    this.isLoading = false
                    var circleText = document.getElementsByClassName('circleText')[0];
                    console.log(circleText);
                    var       text = this.breakdown;
                    circleText.innerText = '';
                    var style = getComputedStyle(circleText);
                    var start = +style.getPropertyValue('--start');
                    var end = +style.getPropertyValue('--end');
                    var radius;
                    var radius_wid = parseInt(style.width);
                    var arcintval = (end - start) / text.length;
                    var origin;
                    var radius_mult = 0.50;
                    for (let i = 0; i < text.length; i++) {
                        origin = 90 - start + (i * arcintval);
                        radius_mult = radius_mult - 0.0005;
                        radius = radius_mult * radius_wid;
                        circleText.innerHTML += `<div style='height:${radius}px;position:absolute;transform:rotate(${origin}deg);transform-origin:0 100%'>${text[i]}</div>`;
                    }
                })
                .catch(function (error) {
                    console.log(error.response.status) // 401
                    console.log(error.response.data.error) //Please Authenticate or whatever returned from server
                    if(error.response.status==401){
                        //redirect to login
                    }
                })
            },

        }
    }
</script>
<style>
    p{
        text-align: center;
        margin: 0px;
        width: 100%;
        padding: 10px;
    }
    .btn{
        background-color: #0462dd;
        color: white;
    }
  
    .container- {
    display         : flex;        /* Use 'flex' to centre on the screen */
    flex-direction  : row;
    justify-content : center;      /* Centre text  vertically  inside the logo */
    align-items     : center;      /* Centre text horizontally inside the logo */
    margin          : 0;
    width           : 100%;
    height          : 100%;
    }

    div.circleText {
    transform       : translateX(50%);
    width           : 800px;
    height          : 800px;
    --start         :   -90;        /* Start of the arc (in degrees) */
    --end           :   500;        /*  End  of the arc (in degrees) */
    
    }


    @keyframes rotate {
        0% {transform: rotateZ(  0deg);}
    100% {transform: rotateZ(360deg);}
    }
</style>
