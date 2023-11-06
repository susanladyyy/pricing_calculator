@extends('layout.app')

@section('scripts')
    <title>
        Insert University
    </title>
@endsection

@section('content')
    <div class="nav-body w-full px-[10vw] py-[2vh] min-h-[80vh]">
        <h1 class="mb-10 mt-10 text-4xl font-bold">Add New University</h1>

        <form action="{{ route('postInsertUniversity') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @error('name')
                <div class="mb-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" id="name-error">
                    <strong class="font-bold">{{ $message }}</strong>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" id="close-name">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                    </span>
                </div>
                <script>
                    closeNameError();
                </script>
            @enderror
            <div class="field mb-[3vh]">
                <div class="border border-black shadow-md rounded-md overflow-hidden">
                    <input class="w-full border-x-0 border-t-0" value="" type="text"
                        id="" name="name" placeholder="University Name"/>
                    <p class="py-[1vh] px-[1vw] font-bold">Input university name</p>
                </div>
            </div>

            @error('address')
                <div class="mb-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" id="address-error">
                    <strong class="font-bold">{{ $message }}</strong>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" id="close-address">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                    </span>
                </div>
                <script>
                    closeAddressError();
                </script>
            @enderror
            <div class="field mb-[3vh]">
                <div class="border border-black shadow-md rounded-md overflow-hidden">
                    <input class="w-full border-x-0 border-t-0" value="" type="text"
                        id="" name="address" placeholder="University Address"/>
                    <p class="py-[1vh] px-[1vw] font-bold">Input university address</p>
                </div>
            </div>

            @error('logo')
                <div class="mb-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" id="logo-error">
                    <strong class="font-bold">{{ $message }}</strong>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" id="close-logo">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                    </span>
                </div>
                <script>
                    closeLogoError();
                </script>
            @enderror
            <div class="field mb-[3vh]">
                <div class="border border-black shadow-md rounded-md overflow-hidden">
                    <input class="w-full border-x-0 border-t-0" value="" type="file" name="logo"/>
                    <p class="py-[1vh] px-[1vw] font-bold">Input university logo</p>
                </div>
            </div>

            <div class="w-full border border-black shadow-md rounded-md overflow-hidden">
                <input class="cursor-pointer w-full bg-primary text-white px-[1vw] py-[1vh] rounded-md shadow-md" value="Add University" type="submit">
            </div>
        </form>
    </div>
@endsection

<script>
    function closeNameError() {
        document.getElementById('close-name').addEventListener('click', function () {
            document.getElementById('name-error').style.display = 'none';
        });
    }

    function closeAddressError() {
        document.getElementById('close-address').addEventListener('click', function () {
            document.getElementById('address-error').style.display = 'none';
        });
    }

    function closeLogoError() {
        document.getElementById('close-logo').addEventListener('click', function () {
            document.getElementById('logo-error').style.display = 'none';
        });
    }
</script>