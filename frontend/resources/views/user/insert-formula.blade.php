@extends('layout.app')

@section('scripts')
    <title>
        Insert Formula
    </title>
@endsection

@section('content')
    <div class="nav-body w-full px-[10vw] py-[2vh] min-h-[80vh]">
        <div class="title mb-10">
            <h1 class="mb-1 mt-10 text-3xl font-bold">Edit Formula</h1>
            <h2 class="text-md pl-8">for <span class="mb-10 mt-10 text-2xl font-bold">Cost of
                    {{ $calculation_type->calculation_type_name }}</span></h2>
        </div>

        <!-- parameter table -->
        <p class="font-bold pb-[1vh]">{{ $calculation_type->calculation_type_name }} Formula</p>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-10 h-[40vh] overflow-scroll">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="itemTable">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Parameter Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Parameter Type
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Parameter Content
                        </th>
                        <th scope="col" class="px-6 py-3 text-right">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1
                    @endphp
                    @foreach ($parameters as $p)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer" data-item="{{ $p->id }}" id="row-{{ $p->id }}">
                            <td class="text-center">{{ $p->id }}</td>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $p->parameter_name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $p->parameterType->parameter_type_name }}
                            </td>
                            @if ($p->parameterType->parameter_type_name == 'Single' || $p->parameterType->parameter_type_name == 'Result')
                                <td class="px-6 py-4" id="insert-parametercontent-format">
                                    {{ number_format($p->parameter_content, 0, ',', '.') }}
                                </td>
                            @else
                                <td class="px-6 py-4">
                                    @foreach ($children as $c)
                                        @if ($c->parameter_id == $p->id)
                                            <p>{{ $c->parameter_name }}</p>
                                        @endif
                                    @endforeach
                                </td>
                            @endif

                            @if ($p->user_id != null && $p->user_id == Auth::id())
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('updateParameter', ['parameterId' => $p->id]) }}"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline"><i
                                            class="text-2xl text-blue-500 fa-solid fa-pencil"></i></a>
                                    <a onclick="deleteParameter('{{ $p->id }}', '{{ $p->parameter_name }}')"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline ml-[1vw]"><i
                                            class="text-2xl text-red-600 fa-regular fa-trash-can cursor-pointer"></i></a>
                                </td>
                            @else
                                <td class="px-6 py-4 text-right">
                                    -
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="insert">
            <form action="{{ route('editFormula', ['version' => $version, 'calculationTypeId' => $calculation_type->id]) }}" method="POST">
                @csrf
                <p class="font-bold pb-[1vh]">{{ $calculation_type->calculation_type_name }} Formula</p>
                
                @error('formulaInput')
                    <div class="mb-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" id="formula-error">
                        <strong class="font-bold">{{ $message }}</strong>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3" id="close-formula">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                        </svg>
                        </span>
                    </div>
                    <script>
                        document.getElementById('close-formula').addEventListener('click', function () {
                            document.getElementById('formula-error').style.display = 'none';
                        });
                    </script>
                @enderror
                <input class="border-gray-300 shadow-lg rounded-lg w-full" type="text" value="{{ $formula->formula }}" id="formulaInput" name="formulaInput">
                
                <input type="submit" value="Save Changes" class="bg-blue-800 px-5 py-2 mt-3 text-white font-xl shadow-md rounded-md ml-2 cursor-pointer">
            </form>

            <div class="flex mt-8 ml-2">
                <button class="bg-blue-800 mr-3 flex-grow text-white rounded-md shadow-md text-xl" id="plus">+</button>
                <button class="bg-blue-800 mr-3 flex-grow text-white rounded-md shadow-md text-xl" id="minus">-</button>
                <button class="bg-blue-800 mr-3 flex-grow text-white rounded-md shadow-md text-xl" id="times">*</button>
                <button class="bg-blue-800 mr-3 flex-grow text-white rounded-md shadow-md text-xl" id="divide">/</button>
                <button class="bg-blue-800 mr-3 flex-grow text-white rounded-md shadow-md text-xl" id="open">(</button>
                <button class="bg-blue-800 mr-3 flex-grow text-white rounded-md shadow-md text-xl" id="close">)</button>
            </div>
        </div>
    </div>
<script>
    let cursorPosition = 0; // Initialize cursor position
    const inputField = document.getElementById('formulaInput');
    const plusButton = document.getElementById('plus');
    const minusButton = document.getElementById('minus');
    const timesButton = document.getElementById('times');
    const divideButton = document.getElementById('divide');
    const openButton = document.getElementById('open');
    const closeButton = document.getElementById('close');
    const table = document.getElementById('itemTable');

    function removeTableRow(parameterId) {
        const rowElement = document.getElementById(`row-${parameterId}`)

        if(rowElement) {
            rowElement.remove()
        }
    }

    function deleteParameter(deletedParameterId, deletedParameterName) {
        if (confirm(`Are you sure you want to delete sub parameter: ${deletedParameterName}?`)) {
            fetch(`/delete-sub-parent-parameter/${deletedParameterId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.message)
                removeTableRow(deletedParameterId)
            })
            .catch(error => {
                console.error('Error deleting param:', error);
            });
        }
    }

    formulaInput.addEventListener('click', () => {
        cursorPosition = formulaInput.selectionStart;
        console.log('Cursor position:', cursorPosition);
    });

    itemTable.addEventListener('click', (event) => {
        const target = event.target;
        if (target.tagName === 'TD') {
            const newText = target.parentElement.dataset.item;
            const currentValue = formulaInput.value;

            // Insert the new text at the cursor position
            const updatedValue = currentValue.slice(0, cursorPosition) +
                                newText +
                                currentValue.slice(cursorPosition);

            // Update the input field value
            formulaInput.value = updatedValue;

            // Update cursor position after insertion
            cursorPosition += newText.length;

            // Move cursor to the updated position
            formulaInput.setSelectionRange(cursorPosition, cursorPosition);

            console.log('New value:', formulaInput.value);
        }
    });

    plusButton.addEventListener('click', () => {
        const newText = ' + ';
        const currentValue = formulaInput.value;

        // Insert the new text at the cursor position
        const updatedValue = currentValue.slice(0, cursorPosition) +
                            newText +
                            currentValue.slice(cursorPosition);

        // Update the input field value
        formulaInput.value = updatedValue;

        // Update cursor position after insertion
        cursorPosition += newText.length;

        // Move cursor to the updated position
        formulaInput.setSelectionRange(cursorPosition, cursorPosition);

        console.log('New value:', formulaInput.value);
    });

    minusButton.addEventListener('click', () => {
        const newText = ' - ';
        const currentValue = formulaInput.value;

        // Insert the new text at the cursor position
        const updatedValue = currentValue.slice(0, cursorPosition) +
                            newText +
                            currentValue.slice(cursorPosition);

        // Update the input field value
        formulaInput.value = updatedValue;

        // Update cursor position after insertion
        cursorPosition += newText.length;

        // Move cursor to the updated position
        formulaInput.setSelectionRange(cursorPosition, cursorPosition);

        console.log('New value:', formulaInput.value);
    });

    timesButton.addEventListener('click', () => {
        const newText = ' * ';
        const currentValue = formulaInput.value;

        // Insert the new text at the cursor position
        const updatedValue = currentValue.slice(0, cursorPosition) +
                            newText +
                            currentValue.slice(cursorPosition);

        // Update the input field value
        formulaInput.value = updatedValue;

        // Update cursor position after insertion
        cursorPosition += newText.length;

        // Move cursor to the updated position
        formulaInput.setSelectionRange(cursorPosition, cursorPosition);

        console.log('New value:', formulaInput.value);
    });

    divideButton.addEventListener('click', () => {
        const newText = ' / ';
        const currentValue = formulaInput.value;

        // Insert the new text at the cursor position
        const updatedValue = currentValue.slice(0, cursorPosition) +
                            newText +
                            currentValue.slice(cursorPosition);

        // Update the input field value
        formulaInput.value = updatedValue;

        // Update cursor position after insertion
        cursorPosition += newText.length;

        // Move cursor to the updated position
        formulaInput.setSelectionRange(cursorPosition, cursorPosition);

        console.log('New value:', formulaInput.value);
    });

    openButton.addEventListener('click', () => {
        const newText = '(';
        const currentValue = formulaInput.value;

        // Insert the new text at the cursor position
        const updatedValue = currentValue.slice(0, cursorPosition) +
                            newText +
                            currentValue.slice(cursorPosition);

        // Update the input field value
        formulaInput.value = updatedValue;

        // Update cursor position after insertion
        cursorPosition += newText.length;

        // Move cursor to the updated position
        formulaInput.setSelectionRange(cursorPosition, cursorPosition);

        console.log('New value:', formulaInput.value);
    });

    closeButton.addEventListener('click', () => {
        const newText = ')';
        const currentValue = formulaInput.value;

        // Insert the new text at the cursor position
        const updatedValue = currentValue.slice(0, cursorPosition) +
                            newText +
                            currentValue.slice(cursorPosition);

        // Update the input field value
        formulaInput.value = updatedValue;

        // Update cursor position after insertion
        cursorPosition += newText.length;

        // Move cursor to the updated position
        formulaInput.setSelectionRange(cursorPosition, cursorPosition);

        console.log('New value:', formulaInput.value);
    });
</script>
@endsection