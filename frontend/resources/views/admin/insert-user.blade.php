@extends('layout.app')

@section('scripts')
    <title>
        Insert User
    </title>
@endsection

@section('content')
    <div class="nav-body w-full px-[10vw] py-[2vh] min-h-[80vh]">
        <h1 class="mb-10 mt-10 text-4xl font-bold">Add New User</h1>

        <form action="{{ route('postInsertUser') }}" method="POST">
            @csrf
            <div class="field mb-[3vh]">
                @error('username')
                    <div class="mb-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" id="username-error">
                        <strong class="font-bold">{{ $message }}</strong>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3" id="close-username">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                        </svg>
                        </span>
                    </div>
                    <script>
                        closeUsernameError();
                    </script>
                @enderror
                <div class="border border-black shadow-md rounded-md overflow-hidden">
                    <input class="w-full border-x-0 border-t-0" value="" type="text"
                        id="" name="username" placeholder="Username"/>
                    <p class="py-[1vh] px-[1vw] font-bold">Input your username</p>
                </div>
            </div>

            @error('role')
                <div class="mb-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" id="role-error">
                    <strong class="font-bold">{{ $message }}</strong>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" id="close-role">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                    </span>
                </div>
                <script>
                    closeRoleError();
                </script>
            @enderror

            <div class="field mb-[3vh]">
                <div class="shadow-md rounded-md overflow-hidden">
                    <select id="select-option" name="role" class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                        <option value="0" disabled selected>Select a Role</option>
                        @foreach ($roles as $r)
                            <option value="{{ $r->id }}">{{ ucfirst($r->role_name) }}</option>
                        @endforeach
                    </select>
                    <p class="py-[1vh] px-[1vw] font-bold">Select a role</p>
                </div>
            </div>

            @error('email')
                <div class="mb-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" id="email-error">
                    <strong class="font-bold">{{ $message }}</strong>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" id="close-email">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                    </span>
                </div>
                <script>
                    closeEmailError();
                </script>
            @enderror
            <div class="field mb-[3vh]">
                <div class="border border-black shadow-md rounded-md overflow-hidden">
                    <input class="w-full border-x-0 border-t-0" value="" type="text"
                        id="" name="email" placeholder="Email"/>
                    <p class="py-[1vh] px-[1vw] font-bold">Input your email</p>
                </div>
            </div>

            @error('password')
                <div class="mb-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" id="password-error">
                    <strong class="font-bold">{{ $message }}</strong>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" id="close-password">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                    </span>
                </div>
                <script>
                    closePasswordError();
                </script>
            @enderror
            <div class="field mb-[3vh]">
                <div class="border border-black shadow-md rounded-md overflow-hidden">
                    <input class="w-full border-x-0 border-t-0" value="" type="password"
                        id="" name="password" placeholder="Password"/>
                    <p class="py-[1vh] px-[1vw] font-bold">Input your password</p>
                </div>
            </div>

            @error('university')
                <div class="mb-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" id="university-error">
                    <strong class="font-bold">{{ $message }}</strong>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" id="close-university">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                    </span>
                </div>
                <script>
                    closeUniversityError();
                </script>
            @enderror
            <div class="field mb-[3vh]">
                <div class="shadow-md rounded-md overflow-hidden">
                    <select id="select-option" name="university" class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                        <option value="0" disabled selected>Select a University</option>
                        @foreach ($universities as $uni)
                            <option value="{{ $uni->id }}">{{ $uni->university_name }}</option>
                        @endforeach
                    </select>
                    <p class="py-[1vh] px-[1vw] font-bold">Select a university</p>
                </div>
            </div>

            <div class="w-full border border-black shadow-md rounded-md overflow-hidden">
                <input class="cursor-pointer w-full bg-primary text-white px-[1vw] py-[1vh] rounded-md shadow-md" value="Add User" type="submit">
            </div>
        </form>
    </div>
@endsection

<script>
    function closeUsernameError() {
        document.getElementById('close-username').addEventListener('click', function () {
            document.getElementById('username-error').style.display = 'none';
        });
    }

    function closeRoleError() {
        document.getElementById('close-role').addEventListener('click', function () {
            document.getElementById('role-error').style.display = 'none';
        });
    }

    function closeEmailError() {
        document.getElementById('close-email').addEventListener('click', function () {
            document.getElementById('email-error').style.display = 'none';
        });
    }

    function closePasswordError() {
        document.getElementById('close-password').addEventListener('click', function () {
            document.getElementById('password-error').style.display = 'none';
        });
    }

    function closeUniversityError() {
        document.getElementById('close-university').addEventListener('click', function () {
            document.getElementById('university-error').style.display = 'none';
        });
    }
</script>