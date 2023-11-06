<div id="evaluation" class="nav-body mb-[3vh] hidden w-full px-[10vw] py-[2vh]">
    <div class="pb-[4vh] flex justify-between">
        <div class="title">
            <h1 class="text-2xl font-bold">Cost of Evaluation</h1>
        </div>
        <div class="flex gap-x-[1vw]">
            <button class="bg-primary text-white font-semibold px-[1vw] py-[1vh] rounded-md shadow-md hover:bg-blue-600">
                <a
                    href="{{ route('addNewParameter', ['versionId' => $version->id, 'calculationTypeId' => $evaluation->first()->calculation_type_id]) }}">Add
                    New Parameter</a>
            </button>

            <button class="bg-primary text-white font-semibold px-[1vw] py-[1vh] rounded-md shadow-md hover:bg-blue-600">
                <a
                    href="{{ route('editFormulaView', ['version' => $version->id, 'calculationTypeId' => $evaluation->first()->calculation_type_id]) }}">Edit
                    Formula</a>
            </button>
        </div>
    </div>

    {{-- Prompt Evaluation --}}
    @php
        $flag = $evaluationRes ? $evaluationRes->status : false;
    @endphp
    <div class="prompt py-[2vh] px-[1vw] mb-[3vh] border border-black shadow-md rounded-md">
        <p class="pb-[1vh] font-bold text-lg">Does this course need an evaluation?</p>
        <div class="flex gap-x-2">
            <button id="yesBtn"
                class="text-white py-[0.5vh] px-[1vw] rounded-lg
                @if ($flag == false) bg-gray-400 @else
                bg-blue-600 hover:bg-blue-500 @endif
                ">Yes</button>
            <button id="noBtn"
                class="text-white py-[0.5vh] px-[1vw] rounded-lg  @if ($flag == false) bg-red-600 hover:bg-red-500 @else
                bg-gray-400 @endif">No</button>
        </div>
    </div>

    <form id="evaluation-form" action="{{ route('detail.update', $version) }}" method="POST">
        @csrf
        <input type="hidden" name="calculation-type" id="calculation-type"
            value={{ $evaluation->first()->calculation_type_id }}>

        @foreach ($evaluation as $e)
            @if ($e->parameterType->parameter_type_name == 'Multiple')
                <div class="multiple">
                    <div class="mb-[3vh] flex gap-x-[1vw]">
                        <div class="w-full border border-black shadow-md rounded-md overflow-hidden bg-disabled-100">
                            <input class="cost-result w-full border-x-0 border-t-0 bg-disabled-100" type="text"
                                value="0" id="{{ $e->id }}" name="{{ $e->id }}" readonly>
                            <p class="py-[1vh]
                                px-[1vw] font-bold text-disabled-200">
                                Cost of
                                {{ $e->parameter_name }}</p>
                        </div>
                        <div class="w-full border border-black shadow-md rounded-md overflow-hidden bg-disabled-100">
                            <input class="total-result w-full border-x-0 border-t-0 bg-disabled-100" type="text"
                                value="0" name="" id="" disabled>
                            <p class="py-[1vh] px-[1vw] font-bold text-disabled-200">Total of
                                {{ $e->parameter_name }}</p>
                        </div>
                    </div>
                    @foreach ($e->childParameters as $child)
                        <div class="child-parameter mb-[3vh] flex gap-x-[1vw]">
                            <div class="w-full border border-black shadow-md rounded-md overflow-hidden ">
                                <input
                                    class="field cost w-full border-x-0 border-t-0 @if ($flag == 0) bg-disabled-100 @endif"
                                    type="text" name="{{ 'cost_' . $child->id }}" id="{{ 'cost_' . $child->id }}"
                                    value="{{ number_format($child->parameter_cost, 0, ',', '.') }}"
                                    onchange="calculatePluralResult(this)" required
                                    @if ($flag == 0) disabled @endif>
                                <p
                                    class="field py-[1vh] px-[1vw] font-bold @if ($flag == 0) bg-disabled-100 @endif">
                                    Cost of
                                    {{ $child->parameter_name }}
                                </p>
                            </div>
                            <div class="w-full border border-black shadow-md rounded-md overflow-hidden">
                                <input
                                    class="field total w-full border-x-0 border-t-0 @if ($flag == 0) bg-disabled-100 @endif"
                                    type="text" name="{{ 'total_' . $child->id }}" id="{{ 'total_' . $child->id }}"
                                    value="{{ number_format($child->parameter_number, 0, ',', '.') }}"
                                    onchange="calculatePluralResult(this)" required
                                    @if ($flag == 0) disabled @endif>
                                <p
                                    class="field py-[1vh] px-[1vw] font-bold @if ($flag == 0) bg-disabled-100 @endif">
                                    Total of
                                    {{ $child->parameter_name }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                    <p id="{{ $e->id }}_warning" class="mb-[2vh] text-yellow-300 font-semibold text-md hidden">
                        This
                        parameter
                        is
                        not yet added to the calculation formula.</p>
                    <button
                        class="bg-primary text-white font-semibold px-[1vw] py-[1vh] rounded-md shadow-md hover:bg-blue-600 mb-5">
                        <a
                            href="{{ route('addNewSubParameter', ['parameterId' => $e->id, 'calculationTypeId' => $evaluation->first()->calculation_type_id, 'versionId' => $version->id]) }}">Add
                            New Sub Parameter ({{ $e->parameter_name }})</a>
                    </button>
                </div>
            @else
                <div class="field mb-[3vh]">
                    <div class="border border-black shadow-md rounded-md overflow-hidden">
                        <input
                            class="field w-full border-x-0 border-t-0  @if ($flag == 0) bg-disabled-100 @endif"
                            type="text" name="{{ $e->id }}" id="{{ $e->id }}"
                            value="{{ $e->parameter_content }}" onchange="calculateSingleResult(this)"
                            @if ($flag == 0) disabled @endif>
                        <p
                            class="py-[1vh] px-[1vw] font-bold @if ($flag == 0) bg-disabled-100 @endif">
                            {{ $e->parameter_name }}</p>
                    </div>
                    <p id="{{ $e->id }}_warning"
                        class="mt-[1.5vh] text-yellow-300 font-semibold text-md hidden ">This
                        parameter
                        is
                        not yet added to the calculation formula.</p>
                </div>
            @endif
        @endforeach

        <div class="pt-[5vh] py-[3vh] w-full flex justify-between gap-x-[1vw]">
            <div class="border shadow-md px-[1vw] py-[2vh] border-black w-full rounded-md prompt">
                <p class="font-bold text-lg">Cost of Implementation per Course</p>
            </div>
            <div class="w-full">
                <input type="text" name="evaluation-result" id="evaluation-result"
                    class="border shadow-md px-[1vw] py-[2vh] w-full rounded-md result bg-primary font-bold text-white text-right text-lg"
                    readonly>
            </div>
        </div>

        <div class="next flex justify-end pb-[3vh]">
            <div class="flex items-center gap-x-[2vw]">
                <p class="text-xl font-bold">Next: Calculate Cost of Infrastructure</p>

                <p id="save-evaluation" data-tab="infrastructure"
                    class="continue-to bg-primary text-white font-semibold px-[4vw] py-[2vh] rounded-md shadow-md text-xl hover:bg-blue-600">
                    Continue
                </p>
            </div>
        </div>
    </form>
</div>
