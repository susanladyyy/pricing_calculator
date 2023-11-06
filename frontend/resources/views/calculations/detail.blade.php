@extends('layout.app')

@section('scripts')
    <title>
        Course Detail
    </title>
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
@endsection

@section('content')
    <div class="sticky top-0 bg-white z-10">
        <!-- Course Detail -->
        <div class="course-detail mx-[7vw] pt-[5vh] flex justify-between">
            <div class="left">
                <h1 class="text-3xl font-bold pb-[2vh]">{{ $version->course->course_name }}</h1>
                <p class="pb-[1vh] text-md">Course Version: {{ $version->course_version }}</p>
                <p id="mulmed_num" class="pb-[1vh] text-md">Number of Multimedia: {{ $version->multimedia_number }}</p>
                <p class="pb-[1vh] text-md">Number of Tutorial Session: {{ $version->course->session_number }}</p>
            </div>
            <div class="right flex">
                <div class="btn">
                    <div class="border border-gray-200 px-[1vw] py-[1vh] rounded-full">
                        <a href="{{ route('updateCourse', ['id' => $version->id]) }}"><i
                                class="text-2xl text-blue-500 fa-solid fa-pencil"></i></a>
                    </div>
                </div>
                <div class="btn ml-[2vw]">
                    <div class="border border-gray-200 px-[1vw] py-[1vh] rounded-full">
                        <a onclick="deleteCourse({{ $version->course->id }})"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline"><i
                                class="text-2xl text-red-600 fa-regular fa-trash-can cursor-pointer"></i></a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Navigation Bar --}}
        <div class="nav border border-y-gray-700 flex justify-around items-center my-[3vh] px-[5vw] py-[2vh] text-lg">
            <div class="nav-item cursor-pointer hover:scale-105 font-bold text-xl" data-tab="market-research">
                <p>Market Research</p>
            </div>
            <i class="fa-solid fa-arrow-right"></i>
            <div class="nav-item cursor-pointer hover:scale-105" data-tab="preparation">
                <p>Preparation</p>
            </div>
            <i class="fa-solid fa-arrow-right"></i>
            <div class="nav-item cursor-pointer hover:scale-105" data-tab="implementation">
                <p>Implementation</p>
            </div>
            <i class="fa-solid fa-arrow-right"></i>
            <div class="nav-item cursor-pointer hover:scale-105" data-tab="evaluation">
                <p>Evaluation</p>
            </div>
            <i class="fa-solid fa-arrow-right"></i>
            <div class="nav-item cursor-pointer hover:scale-105" data-tab="infrastructure">
                <p>Infrastructure</p>
            </div>
            <i class="fa-solid fa-arrow-right"></i>
            <div class="nav-item cursor-pointer hover:scale-105" data-tab="enrollment">
                <p>Enrollment and Cost Fee</p>
            </div>
            <p class="font-bold">|</p>
            <div class="nav-item cursor-pointer hover:scale-105" data-tab="history">
                <p>History</p>
            </div>
        </div>

    </div>

    {{-- Loading --}}
    <div class="loading-animation">
        <div class="loader"></div>
        <p>Loading...</p>
    </div>
    <div id="loading-container" class="hidden">
        <x-loading />
    </div>

    <div class="tab-containers min-h-[45vh]">
        <!-- Market Research Tab -->
        @include('calculations.partials.market-research')

        {{-- Preparation Tab --}}
        @include('calculations.partials.preparation')

        {{-- Implementation Tab --}}
        @include('calculations.partials.implementation')

        {{-- Evaluation Tab --}}
        @include('calculations.partials.evaluation')

        {{-- Infrastucture Tab --}}
        @include('calculations.partials.infrastructure')

        {{-- Enrollment and Cost Fee Tab --}}
        @include('calculations.partials.enrollment')

        {{-- History Tab --}}
        @include('calculations.partials.history')
    </div>
@endsection

@section('js-scripts')
    <script>
        let courseVersion = @json($version);
        let formulas = @json($version->formulas);

        // JavaScript to handle accordion functionality
        function toggleAccordion(id) {
            let content = document.getElementById(id);
            if (content.classList.contains("hidden")) {
                let num = id.split("-")
                let button = document.getElementById(`button-${num[1]}`)
                content.classList.toggle('hidden');
                button.innerHTML = "Hide Detail"
            } else {
                let num = id.split("-")
                let button = document.getElementById(`button-${num[1]}`)
                content.classList.toggle('hidden');
                button.innerHTML = "Show Detail"
            }
        }

        function deleteHistory(historyId) {
            if (confirm("Are you sure you want to delete this history?")) {
                fetch(`/delete-history/${historyId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data.message);

                        const deletedHistoryElement = document.getElementById(`history-${historyId}`);

                        if (deletedHistoryElement) {
                            deletedHistoryElement.remove();
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting history:', error);
                    });
            }
        }

        function deleteCourse(courseId) {
            if (confirm("Are you sure you want to delete this course?")) {
                fetch(`/delete-course/${courseId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data.message);
                        window.location.href = 'http://localhost:8000/';
                    })
                    .catch(error => {
                        console.error('Error deleting course:', error);
                    });
            }
        }

        function saveToHistory(versionId) {
            // console.log(versionId);
            fetch(`/save-calculation/${versionId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message)
                    location.reload()
                })
                .catch(error => {
                    console.error('Error inserting history:', error);
                });
        }

        function loadHistories() {
            fetch('/history')
                .then(response => response.json())
                .then(data => {
                    const historyContainer = document.getElementById('history');
                    historyContainer.innerHTML = ''; // Clear existing content
                    if (data.histories.length > 0) {
                        document.getElementById("history").innerHTML += createHistoryElement()
                    } else {
                        historyContainer.innerHTML = `<div class="title mb-10">
                            <h1 class="mb-1 mt-2 text-2xl font-bold text-red-800 text-center">No history yet.</h1>
                        </div>`;
                    }
                })
                .catch(error => {
                    console.error('Error loading histories:', error);
                });
        }

        function createHistoryElement() {
            const historyElement = `
                @foreach ($histories as $h)
                    @if ($h->version_id == $version->id)
                        <div class="history mb-10" id="history-{{ $h->id }}">
                            <button class="accordion-button bg-blue-800 px-4 py-2 text-white rounded-lg mb-2" onclick="toggleAccordion('content-{{ $h->id }}')" id="button-{{ $h->id }}">
                                Show Detail
                            </button>

                            <button class="bg-red-800 px-4 py-2 text-white rounded-lg mb-2" onclick="deleteHistory('{{ $h->id }}')" id="delete-{{ $h->id }}">
                                Delete
                            </button>

                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-2">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            @foreach ($courses as $c)
                                                @if ($c->id == $h->version->course_id)
                                                    <th colspan=5 scope="col" class="px-6 py-3 text-center text-xl">Date: {{ date('d F Y', strtotime($h->created_at)) }}
                                                    <span class=" ml-5 flex gap-[45vw]">
                                                        <p>Course Fee:
                                                        @foreach ($details as $d)
                                                            @if ($d->history_id == $h->id && $d->calculation_type_id == 7)
                                                                Rp {{ number_format($d->result, 0, ',', '.') }}
@break

@endif
                                            @endforeach
                                            </p>
                                            <p> Certificate Fee:
                                            @foreach ($details as $d)
                                                @if ($d->history_id == $h->id && $d->calculation_type_id == 9)
                                                    Rp {{ number_format($d->result, 0, ',', '.') }}
@break

@endif
                                                                                                        @endforeach
                                                                                                        </p>
                                                                                                    </span>
                                                                                                    </th>
@break

@endif
                                                                                            @endforeach
                                                                                        </tr>
                                                                                    </thead>
                                                                                </table>
                                                                            </div>

                                                                            <div class="content hidden" id="content-{{ $h->id }}">
                                                                            @foreach ($calculation_types as $ct)
                                                                                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-2">
                                                                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                                                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                                                            <tr>
                                                                                                <th colspan=2 scope="col" class="px-6 py-3 text-center text-[1rem] border-solid border-0 border-b border-black">{{ $ct->calculation_type_name }}


                                                                                                    @foreach ($formula as $f)
                                                                                                        @if ($ct->id <= 5)
                                                                                                            @if ($f->calculation_type_id == $ct->id)
                                                                                                            <p class="pt-2 text-[0.8rem]">Formula : {{ $f->formula_name }}</p>
                                                                                                            @endif
                                                                                                        @endif
                                                                                                    @endforeach

                                                                                                </th>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="col" class="px-6 py-3">
                                                                                                    Parameter Name
                                                                                                </th>
                                                                                                <th scope="col" class="px-6 py-3 text-right">
                                                                                                    Value
                                                                                                </th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            @foreach ($parameter_histories as $ph)
                                                                                                @if ($ph->parameter_type_id == 1)
                                                                                                    @if ($ph->version_id == $h->version_id)
                                                                                                        @if ($ph->calculation_type_id == $ct->id)
                                                                                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                                                                                <td class="px-6 py-3">
                                                                                                                    {{ $ph->parameter_name }}
                                                                                                                </td>
                                                                                                                <td class="px-6 py-3 text-right">
                                                                                                                    {{ number_format($ph->parameter_content, 0, ',', '.') }}
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        @endif
                                                                                                    @endif
                                                                                                @else
                                                                                                    @if ($ph->version_id == $h->version_id)
                                                                                                        @if ($ph->calculation_type_id == $ct->id)
                                                                                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                                                                                <td class="px-6 py-3">
                                                                                                                    {{ $ph->parameter_name }}
                                                                                                                </td>
                                                                                                                <td class="px-6 py-3 text-right">
                                                                                                                    {{ number_format($ph->parameter_content, 0, ',', '.') }}
                                                                                                                </td>

                                                                                                                @foreach ($children as $c)
                                                                                                                    @if ($c->parameter_history_id == $ph->id)
                                                                                                                        <tbody class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                                                                                            <tr>
                                                                                                                                <td scope="col" colspan="2" class="px-6 py-3">
                                                                                                                                    {{ $c->parameter_name }}
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td scope="col" class="px-6 py-3" width="30%">
                                                                                                                                    Cost: {{ number_format($c->parameter_cost, 0, ',', '.') }}
                                                                                                                                </td>
                                                                                                                                <td scope="col" class="px-6 py-3" width="70%">
                                                                                                                                    Number: {{ $c->parameter_number }}
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </tbody>
                                                                                                                    @endif
                                                                                                                @endforeach
                                                                                                            </tr>
                                                                                                        @endif
                                                                                                    @endif
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </tbody>
                                                                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                                                            @foreach ($details as $d)
                                                                                                @if ($d->history_id == $h->id && $d->calculation_type_id == $ct->id)
                                                                                                    <tr>
                                                                                                        <th class="px-6 py-3">
                                                                                                            Result
                                                                                                        </th>
                                                                                                        <th class="px-6 py-3 text-right">
                                                                                                            Rp {{ number_format($d->result, 0, ',', '.') }}
                                                                                                        </th>
                                                                                                    </tr>
@break

@endif
                                            @endforeach
                                        </thead>
                                    </table>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            `
            return historyElement;
        }

        // Add an event listener to the "History" tab button
        document.addEventListener('DOMContentLoaded', function() {
            // const historyTabButton = document.querySelector('[data-tab="history"]');
            // if (historyTabButton) {

            // }
            loadHistories();
        });
    </script>
    <script src="{{ asset('js/detail/animations.js') }}"></script>
    <script src="{{ asset('js/detail/calculations.js') }}"></script>
@endsection
