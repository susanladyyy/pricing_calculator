@extends('layout.app')

@section('scripts')
    <title>
        Users List
    </title>
@endsection

@section('content')
    <div class="text-center mx-[5vw] mt-[2vw] py-[2vh] border-y mb-10 flex space-x-4">
        <p id="users-tab" class="block w-full px-4 py-2 rounded-lg font-bold text-xl hover:underline cursor-pointer">Users
            List</p>
        <p id="universities-tab" class="block w-full px-4 py-2 rounded-lg font-bold text-xl hover:underline cursor-pointer">
            Universities
            List</p>
    </div>

    <div class="pb-[3vh] min-h-[80vh]">
        <!-- USERS LIST STARTS HERE -->
        <div class="courses mx-[5vw]" id="users">
            <div class="header flex flex-row items-center justify-between mx-[7vw] mb-[3vh]">
                <div class="title">
                    <h1 class="text-3xl font-bold">Users List</h1>
                </div>
                <div class="action">
                    <a class="bg-primary text-white px-[1vw] py-[1vh] rounded-md shadow-md"
                        href="{{ route('insertUser') }}">
                        Add New User
                    </a>
                </div>
            </div>

            <form action="GET" id="search-user">
                <div class="actions py-[2vh] border-y mb-10">
                    <div class="search-bar mx-[5vw]">
                        <input class="rounded border-gray-200 shadow w-full md:w-1/4" type="text" name="search_user"
                            placeholder="Search User">
                    </div>
                </div>
            </form>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-[2vw]">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Username
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                University
                            </th>
                            <th scope="col" class="px-6 py-3 text-right">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody id="user-table-body">
                        @foreach ($user as $u)
                            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600"
                                id="user-{{ $u->id }}">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $u->username }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $u->email }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $u->university->university_name }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('updateUser', ['id' => $u->id]) }}"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline"><i
                                            class="text-2xl text-blue-500 fa-solid fa-pencil"></i></a>
                                    @if (Auth::id() != $u->id)
                                        <a onclick="deleteUser({{ $u->id }})"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline ml-[1vw]"><i
                                                class="text-2xl text-red-600 fa-regular fa-trash-can cursor-pointer"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- USERS LIST ENDS HERE -->

        <!-- UNIVERSITIES LIST STARTS HERE -->
        <div class="courses mx-[5vw] hidden" id="universities">
            <div class="header flex flex-row items-center justify-between mx-[7vw] mb-[3vh]">
                <div class="title">
                    <h1 class="text-3xl font-bold">Universities List</h1>
                </div>
                <div class="action">
                    <a class="bg-primary text-white px-[1vw] py-[1vh] rounded-md shadow-md"
                        href="{{ route('insertUniversity') }}">
                        Add New University
                    </a>
                </div>
            </div>

            <form action="GET" id="search-university">
                <div class="actions py-[2vh] border-y mb-10">
                    <div class="search-bar mx-[5vw]">
                        <input class="rounded border-gray-200 shadow w-full md:w-1/4" type="text"
                            name="search_university" placeholder="Search University">
                    </div>
                </div>
            </form>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-[2vw]">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                University Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                University Address
                            </th>
                            <th scope="col" class="px-6 py-3">
                                University Logo
                            </th>
                            <th scope="col" class="px-6 py-3 text-right">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody id="university-table-body">
                        @foreach ($university as $uni)
                            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600"
                                id="university-{{ $uni->id }}">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $uni->university_name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $uni->university_address }}
                                </td>
                                <td class="px-6 py-4">
                                    <img src="{{ $uni->logo_path }}" alt="" class="w-35 h-12 mr-2">
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('updateUniversity', ['id' => $uni->id]) }}"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline"><i
                                            class="text-2xl text-blue-500 fa-solid fa-pencil"></i></a>
                                    @if (Auth::user()->university_id != $uni->id)
                                        <a onclick="deleteUniversity({{ $uni->id }})"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline ml-[1vw]"><i
                                                class="text-2xl text-red-600 fa-regular fa-trash-can cursor-pointer"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- UNIVERSITIES LIST ENDS HERE -->
    </div>

    <!-- FLOATING BUTTON STARTS HERE -->
    <div class="fixed bottom-4 right-4">
        <button id="backToTop" class="bg-primary text-white px-4 py-2 rounded-full shadow-md">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18">
                </path>
            </svg>
        </button>
    </div>
    <!-- FLOATING BUTTON ENDS HERE -->
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const backToTop = document.getElementById("backToTop");

        backToTop.addEventListener("click", function() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });

        const userTabLink = document.querySelector("#users-tab");
        const universityTabLink = document.querySelector("#universities-tab");
        const usersSection = document.querySelector("#users");
        const universitiesSection = document.querySelector("#universities");

        userTabLink.addEventListener("click", function() {
            usersSection.style.display = "block";
            universitiesSection.style.display = "none";

            userTabLink.classList.add("underline");
            universityTabLink.classList.remove("underline");
        });

        universityTabLink.addEventListener("click", function() {
            universitiesSection.style.display = "block";
            usersSection.style.display = "none";

            universityTabLink.classList.add("underline");
            userTabLink.classList.remove("underline");
        });
    });

    function deleteUser(userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            fetch(`/delete-user/${userId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.message);

                const deletedUserElement = document.getElementById(`user-${userId}`);
                if (deletedUserElement) {
                    deletedUserElement.remove();
                }
            })
            .catch(error => {
                console.error('Error deleting user:', error);
            });
        }
    }

    function deleteUniversity(universityId) {
        if (confirm('Are you sure you want to delete this university?')) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'DELETE',
                url: '/delete-university/' + universityId,
                data: {
                    _token: csrfToken
                },
                success: function(data) {
                    console.log(data.success)
                    if (data.success) {
                        $('#university-' + universityId).remove();
                        if (data.user_ids.length > 0) {

                            data.user_ids.forEach(userId => {
                                $('#user-' + userId).remove();
                            });
                        } else {
                            console.log('No associated users found.');
                        }
                    } else {
                        alert('Failed to delete the university: ' + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('An error occurred while deleting the university.');
                }
            });
        }
    }

    $(document).ready(function() {
        $('#search-user input[name="search_user"]').on('keyup', function() {
            var searchQuery = $(this).val();

            $.ajax({
                type: 'GET',
                url: '/search-user',
                data: {
                    search_user: searchQuery
                },
                success: function(data) {
                    var tableRows = data.table_rows;
                    if (tableRows.length === 0) {
                        $('#user-table-body').html(
                            '<tr><td colspan="4" class="text-center px-6 py-4 text-lg">No data found</td></tr>'
                        );
                    } else {
                        $('#user-table-body').html(tableRows);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });

    $(document).ready(function() {
        $('#search-university input[name="search_university"]').on('keyup', function() {
            var searchQuery = $(this).val();

            $.ajax({
                type: 'GET',
                url: '/search-university',
                data: {
                    search_university: searchQuery
                },
                success: function(data) {
                    var tableRows = data.table_rows;
                    if (tableRows.length === 0) {
                        $('#university-table-body').html(
                            '<tr><td colspan="4" class="text-center px-6 py-4 text-lg">No data found</td></tr>'
                        );
                    } else {
                        $('#university-table-body').html(tableRows);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>
