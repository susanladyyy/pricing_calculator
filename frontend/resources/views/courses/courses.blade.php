@extends('layout.app')

@section('scripts')
    <title>
        Courses List
    </title>
@endsection

@section('content')
    <div class="courses py-[5vh] min-h-[80vh] rounded-xl">
        <div class="header flex flex-row items-center justify-between mx-[7vw] mb-[3vh]">
            <div class="title">
                <h1 class="text-3xl font-bold">Courses List</h1>
            </div>
            <div class="action">
                <a class="bg-primary text-white px-[1vw] py-[1vh] rounded-md shadow-md"
                    href="{{ route('insertCourseView') }}">
                    Add New Course
                </a>
            </div>
        </div>

        <form action="GET" id="search-course">
            <div class="actions py-[2vh] border-y mb-10">
                <div class="search-bar mx-[5vw]">
                    <input id="searchInput" class="rounded border-gray-200 shadow w-full md:w-1/4" type="text"
                        name="search_course" placeholder="Search Course">
                </div>
            </div>
        </form>

        <div class="mx-[5vw]" id="course-container">
            <div class="courses border rounded-xl overflow-hidden my-[3vh]" id="accordion" data-accordion="collapse"
                data-active-classes="bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-white">
                @foreach ($courses as $c)
                    <div class="accordion rounded-t rounded-b" id="accordion-{{ $c->id }}">
                        <h2 class="accordion-heading">
                            <button type="button"
                                class="flex items-center justify-between w-full p-5 text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800">
                                <span class="font-semibold text-md text-black">{{ $c->course_name }}</span>
                                <div class="flex items-center gap-x-[2vw]">
                                    <form method="POST" action="{{ route('insertNewVersion') }}"
                                        class="bg-primary text-white px-[1vw] py-[1vh] rounded-md shadow-md mr-10">
                                        @csrf
                                        <input type="hidden" name="courseId" value="{{ $c->id }}" />
                                        <input type="submit" value="Add New Version" class="cursor-pointer" />
                                    </form>
                                    <svg data-accordion-icon class="w-3 h-3 shrink-0" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 1 5 5 9 1" />
                                    </svg>
                                </div>
                            </button>
                        </h2>
                        <div class="accordion-body hidden">
                            @foreach ($c->courseVersions as $v)
                                <div
                                    class="w-full px-[3vw] py-[2vh] border border-gray-200 dark:border-gray-700 dark:bg-gray-900 flex justify-between items-center">
                                    <div class="left flex gap-x-[10vw] items-center">
                                        <p class="font-semibold mb-2 text-gray-500 dark:text-gray-400">
                                            Version Number : {{ $v->course_version }}
                                        </p>
                                        <div class="course font-semibold text-gray-500 dark:text-gray-400">
                                            @php
                                                $courseFee = $v->calculations
                                                    ->where('calculation_type_id', 7)
                                                    ->where('status', true)
                                                    ->first();
                                            @endphp
                                            <h3>Course Fee</h3>
                                            @if($courseFee)
                                                <p>Rp {{ number_format($courseFee->result, 0, ',', '.') }}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                            
                                        </div>
                                        <div class="certificate font-semibold text-gray-500 dark:text-gray-400">
                                            @php
                                                $certificateFee = $v->calculations
                                                    ->where('calculation_type_id', 9)
                                                    ->where('status', true)
                                                    ->first();
                                            @endphp
                                            <h3>Certificate Fee</h3>
                                            @if($certificateFee)
                                                <p>Rp {{ number_format($certificateFee->result, 0, ',', '.') }}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="right">
                                        <a href="{{ route('detail', $v) }}"><i
                                                class="text-primary fa-solid fa-arrow-right-long"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $courses->links() }}
        </div>

    </div>

    <script>
        $(document).ready(function() {
            function initializeAccordion() {
                $('.accordion').off('click').on('click', function() {
                    const clickedAccordion = $(this);
                    const accordionBody = clickedAccordion.find('.accordion-body');
                    const accordionIcon = clickedAccordion.find('[data-accordion-icon]');

                    const isVisible = accordionBody.is(':visible');

                    $('.accordion-body').slideUp();
                    $('[data-accordion-icon]').removeClass('rotate-180');
                    $('.accordion-heading').removeClass('bg-blue-100');

                    if (!isVisible) {
                        accordionBody.slideDown();
                        accordionIcon.addClass('rotate-180');
                        clickedAccordion.find('.accordion-heading').addClass('bg-blue-100');
                    }
                });
            }

            initializeAccordion();

            const notFoundMessage = $('<p class="text-center text-xl font-bold">Course not found.</p>').hide();
            $('#course-container').append(notFoundMessage);

            $('#search-course input[name="search_course"]').on('keyup', function() {
                var searchQuery = $(this).val();
                $.ajax({
                    type: 'GET',
                    url: '/search-course',
                    data: {
                        search_course: searchQuery
                    },
                    success: function(data) {
                        var tableRows = data.table_rows.join('');
                        if (!tableRows.trim()) {
                            notFoundMessage.show();
                            $('#course-container .courses').hide();
                        } else {
                            notFoundMessage.hide();
                            $('#course-container .courses').html(tableRows).show();
                        }

                        initializeAccordion();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endsection
