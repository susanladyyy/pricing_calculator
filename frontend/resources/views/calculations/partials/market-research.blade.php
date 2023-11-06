<div id="market-research" class="nav-body w-full px-[10vw] py-[2vh]">
    <div class="pb-[4vh] flex justify-between">
        <div class="title">
            <h1 class="text-2xl font-bold">Cost of Market Research</h1>
        </div>
        <div class="flex gap-x-[1vw]">
            <button class="bg-primary text-white font-semibold px-[1vw] py-[1vh] rounded-md shadow-md hover:bg-blue-600">
                <a
                    href="{{ route('addNewParameter', ['versionId' => $version->id, 'calculationTypeId' => $market->first()->calculation_type_id]) }}">Add
                    New Parameter</a>
            </button>

            <button class="bg-primary text-white font-semibold px-[1vw] py-[1vh] rounded-md shadow-md hover:bg-blue-600">
                <a
                    href="{{ route('editFormulaView', ['version' => $version, 'calculationTypeId' => $market->first()->calculation_type_id]) }}">Edit
                    Formula</a>
            </button>
        </div>
    </div>

    <form id="market-research-form" action="{{ route('detail.update', $version) }}" method="POST">
        @csrf
        <input type="hidden" name="calculation-type" id="calculation-type"
            value={{ $market->first()->calculation_type_id }}>
        @foreach ($market as $m)
            @if ($m->parameterType->parameter_type_name == 'Multiple')
                <div class="multiple">
                    <div class="field mb-[3vh] flex gap-x-[1vw]">
                        <div class="w-full border border-black shadow-md rounded-md overflow-hidden bg-disabled-100">
                            <input class="cost-result w-full border-x-0 border-t-0 bg-disabled-100" type="text"
                                id="{{ $m->id }}" name="{{ $m->id }}"
                                value="{{ $m->parameter_content ? 'Rp. ' . number_format($m->parameter_content, 0, ',', '.') : 'Rp. 0' }}"
                                readonly>
                            <p class="py-[1vh] px-[1vw] font-bold text-disabled-200">Cost of
                                {{ $m->parameter_name }}</p>
                        </div>
                        <div class="w-full border border-black shadow-md rounded-md overflow-hidden bg-disabled-100">
                            <input class="total-result w-full border-x-0 border-t-0 bg-disabled-100" type="text"
                                name="" id="" disabled>
                            <p class="py-[1vh] px-[1vw] font-bold text-disabled-200">Total of
                                {{ $m->parameter_name }}</p>
                        </div>
                    </div>
                    @foreach ($m->childParameters as $child)
                        <div class="child-parameter field mb-[3vh] flex gap-x-[1vw]">
                            <div class="w-full border border-black shadow-md rounded-md overflow-hidden">
                                <input class="cost w-full border-x-0 border-t-0" type="text"
                                    name="{{ 'cost_' . $child->id }}" id="{{ 'cost_' . $child->id }}"
                                    value="{{ number_format($child->parameter_cost, 0, ',', '.') }}"
                                    onchange="calculatePluralResult(this)" required>
                                <p class="py-[1vh] px-[1vw] font-bold">Cost of
                                    {{ $child->parameter_name }}
                                </p>
                            </div>
                            <div class="w-full border border-black shadow-md rounded-md overflow-hidden">
                                <input class="total w-full border-x-0 border-t-0" type="text"
                                    name="{{ 'total_' . $child->id }}" id="{{ 'total_' . $child->id }}"
                                    value="{{ number_format($child->parameter_number, 0, ',', '.') }}"
                                    onchange="calculatePluralResult(this)" required>
                                <p class="py-[1vh] px-[1vw] font-bold">Total of
                                    {{ $child->parameter_name }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                    <p id="{{ $m->id }}_warning" class="mb-[2vh] text-yellow-300 font-semibold text-md hidden">
                        This
                        parameter
                        is
                        not yet added to the calculation formula.</p>
                    <button
                        class="bg-primary text-white font-semibold px-[1vw] py-[1vh] rounded-md shadow-md hover:bg-blue-600 mb-5"
                        type="button" onclick="() => {event.preventDefault()}">
                        <a href="{{ route('addNewSubParameter', ['parameterId' => $m->id, 'calculationTypeId' => $market->first()->calculation_type_id, 'versionId' => $version->id]) }}"
                            class="mb-3">Add Sub Parameter Add New Sub Parameter ({{ $m->parameter_name }})</a>
                    </button>
                </div>
            @else
                <div class="field mb-[3vh]">
                    <div class="border border-black shadow-md rounded-md overflow-hidden">
                        <input class="w-full border-x-0 border-t-0"
                            value={{ number_format($m->parameter_content, 0, ',', '.') }} type="text"
                            id="{{ $m->id }}" name="{{ $m->id }}" required
                            onchange="calculateSingleResult(this)">
                        <p class="py-[1vh] px-[1vw] font-bold">{{ $m->parameter_name }}</p>
                    </div>
                    <p id="{{ $m->id }}_warning"
                        class="mt-[1.5vh] text-yellow-300 font-semibold text-md hidden">This
                        parameter
                        is
                        not yet added to the calculation formula.</p>
                </div>
            @endif
        @endforeach

        <div class="pt-[5vh] py-[3vh] w-full flex justify-between gap-x-[1vw]">
            <div class="border shadow-md px-[1vw] py-[2vh] border-black w-full rounded-md prompt">
                <p class="font-bold text-lg">Cost of Market Research per Course</p>
            </div>
            <div class="w-full">
                <input type="text" name="market-research-result" id="market-research-result"
                    value="{{ $marketRes ? 'Rp. ' . $marketRes->result : 'Rp. 0' }}"
                    class="border shadow-md px-[1vw] py-[2vh] w-full rounded-md result bg-primary font-bold text-white text-right text-lg"
                    readonly>
            </div>
        </div>

        <div class="next flex justify-end pb-[3vh]">
            <div class="flex items-center gap-x-[2vw]">
                <p class="text-xl font-bold">Next: Calculate Cost of Preparation</p>

                <button type="button" id="save-market-research" data-tab="preparation"
                    class="continue-to bg-primary text-white font-semibold px-[4vw] py-[2vh] rounded-md shadow-md text-xl hover:bg-blue-600">
                    Continue
                </button>
            </div>
        </div>
    </form>
</div>
