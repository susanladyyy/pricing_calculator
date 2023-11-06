<nav class="w-full border-b-2 border-b-grey-200 shadow-md z-0">
    <div class="bg-white flex items-center px-[5vw] py-[3vh]">
        <div class="left flex items-center">
            <div class="logo w-1/4 flex">
                <a href="{{ route('index') }}" class="flex">
                    <img class="flex-1 w-[80%]" src="https://info.icei.ac.id/assets/new/images/LOGOICE.png" alt="">
                    @auth
                        <img class="flex-1 w-[30%] h-[100%] ml-5" src="{{ $path }}" alt="">
                    @endauth
                </a>
            </div>
        </div>

        <div class="w-full navigations flex justify-end">
            <div class="w-full time">
                <p id="time"></p>
            </div>
            @if (Auth::check())
                <div class="nav-icon">
                    <a href="{{ route('logout') }}" class="text-lg font-bold"><i class="fa fa-sign-out"
                            aria-hidden="true"></i>
                    </a>
                    </div>
            @else
                <div class="nav-icon">
                    <a href="{{ route('login') }}" class="text-lg font-bold">Login</a>
                </div>
            @endif
        </div>
    </div>
</nav>

<script>
    function clock_date() {
        let months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]

        let days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"]

        let date = new Date()
        let ampm = date.getHours() >= 12 ? 'PM' : 'AM'
        let hours = date.getHours() % 12 // set 12 as max num in clock
        let minutes = date.getMinutes().toString()
        let seconds = date.getSeconds().toString()

        hours = hours ? hours : 12 // if % 12 == 0 then set it as 12

        // add 0 prefix to one digit number
        hours = hours.toString().length == 1 ? `0${hours}` : hours 
        minutes = minutes.length == 1 ? `0${minutes}` : minutes
        seconds = seconds.length == 1 ? `0${seconds}` : seconds

        let res = `${days[date.getDay()]}, ${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`

        res = `${res} ${hours}:${minutes}:${seconds} ${ampm}`
        
        document.getElementById('time').innerHTML = res

        refresh_clock_date()
    }
    
    function refresh_clock_date(){
        let refresh = 1000;
        mytime = setTimeout('clock_date()',refresh)
    }

    refresh_clock_date()
</script>