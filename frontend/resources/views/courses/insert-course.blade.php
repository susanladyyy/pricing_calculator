@extends('layout.app')

@section('scripts')
    <title>
        Insert Course
    </title>
@endsection
    
@section('content')
    <div class="nav-body w-full px-[10vw] py-[2vh] min-h-[80vh]">
        <h1 class="mb-10 mt-10 text-4xl font-bold">Add New Course</h1>

        <form method="POST" action="{{ route('postInsertCourse') }}">
            @csrf
            @error('courseName')
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

            @error('numberOfSession')
                <div class="mb-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" id="session-error">
                    <strong class="font-bold">{{ $message }}</strong>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" id="close-session">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                    </span>
                </div>
                <script>
                    closeSessionError();
                </script>
            @enderror
            <div class="field mb-[3vh] flex gap-x-[1vw]">
                <div class="w-full border border-black shadow-md rounded-md overflow-hidden">
                    <input class="w-full border-x-0 border-t-0" value=""
                        type="text" name="courseName"
                        id="" placeholder="Example: Introduction to Programming">
                    <p class="py-[1vh] px-[1vw] font-bold">Course Name</p>
                </div>

                <div class="w-full border border-black shadow-md rounded-md overflow-hidden">
                    <input class="w-full border-x-0 border-t-0" value=""
                        type="text" name="numberOfSession"
                        id="" placeholder="Example: 12">
                    <p class="py-[1vh] px-[1vw] font-bold">Number of Session</p>
                </div>
            </div>

            <div class="w-full border border-black shadow-md rounded-md overflow-hidden">
                <input class="cursor-pointer w-full bg-primary text-white px-[1vw] py-[1vh] rounded-md shadow-md" value="Add Course" type="submit" name="" id="">
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

    function closeSessionError() {
        document.getElementById('close-session').addEventListener('click', function () {
            document.getElementById('session-error').style.display = 'none';
        });
    }
</script>