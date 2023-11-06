<div id="enrollment" class="nav-body mb-[3vh] hidden w-full px-[10vw] py-[2vh]">
    <div class="pb-[2vh] flex justify-between items-center">
        <div class="title">
            <h1 class="text-2xl font-bold">Enrollment and Cost Fee</h1>
        </div>
    </div>


    <div class="all-results pt-[1vh] pb-[2vh] px-[2vw] border border-gray-800 rounded-lg mt-[2vh] mb-[5vh]">
        <div class="course-div-final flex items-center justify-between">
            <p class="font-bold text-lg">Calculated Course Fee</p>
            <input id="course-fee-final" type="text" class=" border-none text-lg font-bold text-right"
                @if ($courseFeeRes) value="{{ 'Rp. ' . intval($courseFeeRes->result) }}" @else value="{{ 'Rp. 0' }}" @endif
                disabled />
        </div>
        <div class="certificate-div-final flex items-center justify-between">
            <p class="font-bold text-lg">Calculated Certificate Fee</p>
            <input id="certificate-fee-final" type="text" class=" border-none text-lg font-bold text-right"
                @if ($certificateFeeRes) value="{{ 'Rp. ' . intval($certificateFeeRes->result) }}" @else value="{{ 'Rp. 0' }}" @endif
                disabled />
        </div>
        <div class="mt-[1vh] flex justify-end">
            <button type="button" id="save-calculation"
                class="py-[1vh] px-[2vw] rounded-lg bg-primary hover:bg-blue-500 text-white"
                onclick="saveToHistory('{{ $version->id }}')">Save Calculation</button>
        </div>
    </div>


    <div class="tabs flex border rounded-tl-md rounded-tr-md overflow-hidden w-1/3">
        <div class="tab-tab w-full text-center text-white bg-primary hover:bg-secondary-600 active"
            data-tab="course-fee" id="tab-course-fee">
            <p class="text-lg py-[1vh] px-[1vw] cursor-pointer">Course Fee</p>
        </div>
        <div class="tab-tab w-full text-center text-white bg-disabled hover:bg-disabled-200"
            data-tab="certificate-fee" id="tab-certificate-fee">
            <p class="text-lg py-[1vh] px-[1vw] cursor-pointer">Certificate Fee</p>
        </div>
    </div>

    <div class="tab-content border box-border border-black rounded-lg rounded-tl-none py-[5vh] px-[4vw] block"
        id="course-fee">

        {{-- Course Fee Student Enrollment --}}
        <h2 class="text-2xl font-bold pb-[2vh]">Student Enrollment</h2>

        <form id="course-enrollment-form" action="{{ route('detail.update', $version) }}" method="POST">
            @csrf
            <input type="hidden" name="calculation-type" id="calculation-type"
                value={{ $courseFeeStudentEnrollment->first()->calculation_type_id }}>
            @foreach ($courseFeeStudentEnrollment as $p)
                <div class="field mb-[3vh]">
                    <div class="border border-black shadow-md rounded-md overflow-hidden">
                        <input name="{{ $p->id }}" id="{{ $p->id }}"
                            class="@if ($loop->first) course-seek-changes @endif
                {{ $p->parameterType->parameter_type_name }} w-full border-x-0 border-t-0"
                            type="text" value="{{ $p->parameter_content }}"
>
                        <p class="py-[1vh] px-[1vw] font-bold">{{ $p->parameter_name }}</p>
                    </div>
                </div>
            @endforeach
            <div class="field mb-[3vh]">
                <div class="border border-black shadow-md rounded-md overflow-hidden">
                    <input class="w-full border-x-0 border-t-0 bg-disabled-100 text-disabled-200" type="text"
                        name="course-enrollment-result" id="course-enrollment-result"
                        @if ($courseEnrollmentRes) value="{{ intval($courseEnrollmentRes->result) }}"
                        @else value="{{ '0' }}" @endif
                        disabled>
                    <p class="py-[1vh] px-[1vw] bg-disabled-100 font-bold">Estimated Number of Semester to reach Break
                        Even Point
                    </p>
                </div>
            </div>
        </form>

        {{-- Course Fee --}}
        <form id="course-fee-form" action="{{ route('detail.update', $version) }}" method="POST">
            @csrf
            <input type="hidden" name="calculation-type" id="calculation-type"
                value={{ $courseFee->first()->calculation_type_id }}>
            <input type="hidden" name="status" id="status" value={{ true }}>
            <h2 class="text-2xl font-bold pb-[2vh]">Course Fee</h2>
            <div id="course-result-div" class="result flex gap-x-[1.5vw] items-center mb-[3vh]">
                <div class="w-full field ">
                    <div class="border border-black shadow-md rounded-md overflow-hidden bg-primary">
                        <input id="course-result"
                            class="w-full border-x-0 border-t-0 font-bold bg-disabled-100 text-disabled-200"
                            type="text"
                            @if ($courseFeeRes) value="{{ 'Rp. ' . intval($courseFeeRes->result) }}"
                        @else value="{{ 'Rp. 0' }}" @endif
                            disabled>
                        <p class="py-[1vh] px-[1vw] font-bold text-white">Estimated Course Fee</p>
                    </div>
                </div>
                <div class="h-full">
                    <button type="button" id="course-seek-toggle"
                        class="bg-primary hover:bg-blue-500 h-full w-full px-[1vw] py-[1vh] text-white rounded-lg font-bold text-md">Set
                        Desired Fee</button>
                </div>
            </div>
            <div id="course-seek-form" class="hidden">
                <div class="flex gap-x-[1.5vw] items-center mb-[3vh]">
                    <div class="w-full field">
                        <div class="border border-black shadow-md rounded-md overflow-hidden bg-primary">
                            <input id="desired-course-result"
                                class="w-full border-x-0 border-t-0 font-bold bg-white text-black" type="text"
                                @if ($courseFeeRes) value="{{ 'Rp. ' . intval($courseFeeRes->result) }}"
                            @else value="{{ 'Rp. 0' }}" @endif>
                            <p class="py-[1vh] px-[1vw] font-bold text-white">Desired Course Fee</p>
                        </div>
                    </div>
                    <div class="h-full">
                        <button type="button" id="recalculate-course"
                            class="bg-primary hover:bg-blue-500 h-full w-full px-[1vw] py-[1vh] text-white rounded-lg font-bold text-md">Recalculate</button>
                    </div>
                </div>
                <p class="text-red-700" id="course-seek-error"></p>
            </div>
            @foreach ($courseFee as $p)
                <div class="field mb-[3vh]">
                    <div class="border border-black shadow-md rounded-md overflow-hidden">
                        <input
                            class="@if ($p->parameter_type_id == 3) bg-disabled-100 text-disabled-200 @endif  w-full border-x-0 border-t-0"
                            type="text" name="{{ $p->id }}" id="{{ $p->id }}"
                            value="{{ $p->parameter_content }}"

                            @if ($p->parameter_type_id == 3) disabled @endif>
                        <p class="@if ($p->parameter_type_id == 3) bg-disabled-100 @endif py-[1vh] px-[1vw] font-bold">
                            {{ $p->parameter_name }}</p>
                    </div>
                </div>
            @endforeach
            <button type="button" class="py-[1vh] px-[2vw] rounded-lg bg-primary hover:bg-blue-500 text-white"
                onclick="calculateSingleResultForEnrollment(this)">Calculate Course Fee</button>
        </form>
    </div>

    <div class="tab-content border border-black rounded-lg rounded-tl-none py-[5vh] px-[4vw] hidden"
        id="certificate-fee">
        {{-- Certificate Fee Student Enrollment --}}

        <h2 class="text-2xl font-bold pb-[2vh]">Student Enrollment</h2>

        <form id="certificate-enrollment-form" action="{{ route('detail.update', $version) }}" method="POST">
            @csrf
            <input type="hidden" name="calculation-type" id="calculation-type"
                value={{ $certificateFeeStudentEnrollment->first()->calculation_type_id }}>

            @foreach ($certificateFeeStudentEnrollment as $p)
                <div class="field mb-[3vh]">
                    <div class="border border-black shadow-md rounded-md overflow-hidden">
                        <input
                            class="@if ($loop->first) certificate-seek-changes @endif @if ($p->parameter_type_id == 3) bg-disabled-100 text-disabled-200 @endif  w-full border-x-0 border-t-0"
                            type="text" name="{{ $p->id }}" id="{{ $p->id }}"
                            value="{{ $p->parameter_content }}"
                            @if ($p->parameter_type_id == 3) disabled @endif>
                        <p
                            class="@if ($p->parameter_type_id == 3) bg-disabled-100 @endif py-[1vh] px-[1vw] font-bold">
                            {{ $p->parameter_name }}</p>
                    </div>
                </div>
            @endforeach
            <div class="field mb-[3vh]">
                <div class="border border-black shadow-md rounded-md overflow-hidden">
                    <input class="w-full border-x-0 border-t-0 bg-disabled-100 text-disabled-200    " type="text"
                        name="certificate-enrollment-result" id="certificate-enrollment-result"
                        @if ($certificateEnrollmentRes) value="{{ intval($certificateEnrollmentRes->result) }}"
                        @else
                            value="{{ '0' }}" @endif
                        disabled>
                    <p class="py-[1vh] px-[1vw] font-bold bg-disabled-100 text-disabled-200">Estimated Number of
                        Semester to reach Break Even Point
                    </p>
                </div>
            </div>
        </form>

        {{-- Ceritificate Fee --}}
        <form id="certificate-fee-form" action="{{ route('detail.update', $version) }}" method="POST">
            @csrf
            <input type="hidden" name="calculation-type" id="calculation-type"
                value={{ $certificateFee->first()->calculation_type_id }}>
            <input type="hidden" name="status" id="status" value={{ true }}>

            <h2 class="text-2xl font-bold pb-[2vh]">Certificate Fee</h2>
            <div id="certificate-result-div" class="result flex gap-x-[1.5vw] items-center mb-[3vh]">
                <div class="w-full field ">
                    <div class="border border-black shadow-md rounded-md overflow-hidden bg-primary">
                        <input id="certificate-result"
                            class="w-full border-x-0 border-t-0 font-bold bg-disabled-100 text-disabled-200"
                            type="text"
                            @if ($certificateFeeRes) value="{{ 'Rp. ' . intval($certificateFeeRes->result) }}"
                        @else value="{{ 'Rp. 0' }}" @endif
                            disabled>
                        <p class="py-[1vh] px-[1vw] font-bold text-white">Estimated Certificate Fee</p>
                    </div>
                </div>
                <div class="h-full">
                    <button type="button" id="certificate-seek-toggle"
                        class="bg-primary hover:bg-blue-500 h-full w-full px-[1vw] py-[1vh] text-white rounded-lg font-bold text-md">Set
                        Desired Fee</button>
                </div>
            </div>
            <div id="certificate-seek-form" class="hidden">
                <div class="flex gap-x-[1.5vw] items-center mb-[3vh]">
                    <div class="w-full field">
                        <div class="border border-black shadow-md rounded-md overflow-hidden bg-primary">
                            <input id="desired-certificate-result"
                                class="w-full border-x-0 border-t-0 font-bold bg-white text-black" type="text"
                                @if ($certificateFeeRes) value="{{ 'Rp. ' . intval($certificateFeeRes->result) }}"
                            @else value="{{ 'Rp. 0' }}" @endif>
                            <p class="py-[1vh] px-[1vw] font-bold text-white">Desired Course Fee</p>
                        </div>
                    </div>
                    <div class="h-full">
                        <button type="button" id="recalculate-certificate"
                            class="bg-primary hover:bg-blue-500 h-full w-full px-[1vw] py-[1vh] text-white rounded-lg font-bold text-md">Recalculate</button>
                    </div>
                </div>
            </div>
            @foreach ($certificateFee as $p)
                <div class="field mb-[3vh]">
                    <div class="border border-black shadow-md rounded-md overflow-hidden">
                        <input
                            class="@if ($p->parameter_type_id == 3) bg-disabled-100 text-disabled-200 @endif w-full border-x-0 border-t-0"
                            type="text" name="{{ $p->id }}" id="{{ $p->id }}"
                            value="{{ $p->parameter_content }}"

                            @if ($p->parameter_type_id == 3) disabled @endif>
                        <p
                            class="@if ($p->parameter_type_id == 3) bg-disabled-100 @endif py-[1vh] px-[1vw] font-bold">
                            {{ $p->parameter_name }}</p>
                    </div>
                </div>
            @endforeach
            <button type="button" class="py-[1vh] px-[2vw] rounded-lg bg-primary hover:bg-blue-500 text-white"
                onclick="calculateSingleResultForEnrollment(this)">Calculate Certificate Fee</button>
        </form>
    </div>

</div>

<script>
    window.onload = function () {
        // Function to activate a specific tab
        function activateTab(tabId) {
            // Deactivate all tabs
            document.querySelectorAll('.tab-tab').forEach(function (tab) {
                tab.classList.add('bg-disabled-300')
                tab.classList.add('hover:bg-disabled-200')
                tab.classList.remove('active');
            });

            // Deactivate all tab contents
            document.querySelectorAll('.tab-content').forEach(function (content) {
                if (content.classList.contains("block")) {
                    content.classList.remove("block")
                }
                if (content.classList.contains("hidden") == false) {
                    content.classList.add('hidden');
                }
            });

            // Activate the selected tab
            var selectedTab = document.getElementById('tab-' + tabId);
            if (selectedTab) {
                selectedTab.classList.add('bg-primary');
                selectedTab.classList.add('hover:bg-secondary-600');
                selectedTab.classList.add('active');
            }

            // Activate the corresponding tab content
            var selectedTabContent = document.getElementById(tabId);
            if (selectedTabContent) {
                selectedTabContent.classList.add('block')
                selectedTabContent.classList.remove('hidden');
            }
        }

        // Retrieve the last selected tab from localStorage
        var lastSelectedTab = localStorage.getItem('lastSelectedTab');

        // If a tab was previously selected, activate it with a slight delay
        if (lastSelectedTab) {
            setTimeout(function () {
                activateTab(lastSelectedTab);
            }, 100);
        } else {
            // If no tab was previously selected, set a default tab
            activateTab('course-fee');
        }

        // Attach click event to tab elements
        document.querySelectorAll('.tab-tab').forEach(function (tab) {
            tab.addEventListener('click', function () {
                var dataTabValue = tab.getAttribute('data-tab');

                // Store the selected tab in localStorage
                localStorage.setItem('lastSelectedTab', dataTabValue);

                // Activate the clicked tab with a slight delay
                setTimeout(function () {
                    activateTab(dataTabValue);
                }, 100);
            });
        });
    };

</script>