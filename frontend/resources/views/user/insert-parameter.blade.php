@extends('layout.app')

@section('scripts')
    <title>
        Insert Parameter
    </title>
@endsection

@section('content')
    <div class="nav-body w-full px-[10vw] py-[2vh] min-h-[80vh]">
        <div class="title mb-10">
            <h1 class="mb-1 mt-10 text-4xl font-bold">Add New Parameter</h1>
            <h2 class="text-xl pl-8">for <span class="mb-10 mt-10 text-2xl font-bold">Cost of
                    {{ $calculation_type->calculation_type_name }}</span></h2>
        </div>

        <!-- parameter table -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-10">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Parameter ID
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
                    @foreach ($parameters as $p)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600" id="row-{{ $p->id }}">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $p->id }}
                            </th>
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
                                            @if($c->user_id == null)
                                                <p>{{ $c->parameter_name }} (Default)</p>
                                            @else
                                                <p>{{ $c->parameter_name }}</p>
                                            @endif
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

        <!-- add parameter form -->
        <form
            action="{{ route('addNewParameterPost', ['versionId' => $versionId, 'calculationTypeId' => $calculation_type->id]) }}"
            method="POST">
            @csrf
            <!-- parameter id input -->
            @error('parameterId')
                <div class="mb-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"
                    id="id-error">
                    <strong class="font-bold">{{ $message }}</strong>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" id="close-id">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </div>
                <script>
                    closeParameterIdError();
                </script>
            @enderror
            <div class="flex-start items-center">
                <div class="field mb-[3vh] flex">
                    <label for="parameterId" class="font-bold mt-2 mr-7">Parameter ID</label>
                    <div class="flex-grow ml-10 border border-black shadow-md rounded-md overflow-hidden">
                        <input class="w-full border-x-0 border-t-0" type="text" id="parameterId" name="parameterId"
                            placeholder="Maximum 10 characters" />
                    </div>
                </div>
            </div>
            <!-- parameter name input -->
            @error('parameterName')
                <div class="mb-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"
                    id="name-error">
                    <strong class="font-bold">{{ $message }}</strong>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" id="close-name">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </div>
                <script>
                    closeParameterNameError();
                </script>
            @enderror
            <div class="flex-start items-center">
                <div class="field mb-[3vh] flex">
                    <label for="parameterName" class="font-bold mt-2">Parameter Name</label>
                    <div class="flex-grow ml-10 border border-black shadow-md rounded-md overflow-hidden">
                        <input class="w-full border-x-0 border-t-0" type="text" id="parameterName"
                            name="parameterName" />
                    </div>
                </div>
            </div>

            <!-- parameter type dropdown -->
            @error('parameterType')
                <div class="mb-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"
                    id="type-error">
                    <strong class="font-bold">{{ $message }}</strong>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" id="close-type">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </div>
                <script>
                    closeParameterTypeError();
                </script>
            @enderror
            <div class="flex items-center">
                <div class="field mb-[3vh] flex">
                    <label for="parameterType" class="font-bold mt-2">Parameter Type</label>
                    <div class="flex-grow ml-12 border border-black shadow-md rounded-md overflow-hidden">
                        <select name="parameterType" id="parameterType" class="cursor-pointer">
                            <option value="" disabled selected>Select Parameter Type</option>
                            @foreach ($parameter_type as $p_t)
                                @if ($p_t->parameter_type_name != 'Result')
                                    <option value="{{ $p_t->id }}">{{ $p_t->parameter_type_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- parameter content -->
            <div class="flex-start items-center">
                <div class="field mb-[3vh] flex">
                    <label for="" class="font-bold mt-2">Parameter Content</label>

                    <!-- singular -->
                    <div class="hidden w-1/3 mt-2 ml-6" id="singular">
                        <p class="text-gray-600">-</p>
                    </div>

                    <!-- multiple -->
                    <div class="hidden flex w-1/3" id="multiple">
                        <div class="flex-grow ml-6 border border-black shadow-md rounded-md overflow-hidden">
                            <input class="w-full border-x-0 border-t-0" value="" type="text" id="multipleInput"
                                name="multipleInput" placeholder="New sub parameter name" />
                        </div>
                        <a id="add"
                            class="bg-blue-800 text-white text-3xl ml-3 px-3 shadow-md rounded-md cursor-pointer"
                            onclick="newSubParameter()">+</a>
                    </div>

                    <!-- label -->
                    <div class="flex-grow ml-6" id="none_selected">
                        <p class="font-bold mt-2 text-red-800">Please select a parameter type.</p>
                    </div>
                </div>
            </div>

            <div class="multiple-error hidden" id="multiple-error">
                <p class="mb-2 font-bold text-red-800">Please input new sub parameter name first!</p>
            </div>

            <!-- Default Parameter -->
            <!-- <div class="flex-start items-center">
                    <div class="field mb-[3vh] flex">
                        <label for="parameterName" class="font-bold mt-2">Current Formula</label>
                        <div class="flex-grow ml-10 border border-black shadow-md rounded-md overflow-hidden">
                            <input class="w-full border-x-0 border-t-0" value="{{ $str_formula }}" type="text" id="parameterName" name="parameterName" />
                        </div>
                    </div>
                </div> -->
            <input type="hidden" name="childrenArray" id="childrenArray" value="">
            <input type="hidden" name="childrenArrayNoSpace" id="childrenArrayNoSpace" value="">

            <div class="sub-param" id="sub"></div>

            <div class="flex">
                <input type="submit" value="Add Parameter"
                    class="bg-blue-800 text-white px-5 py-2 shadow-md rounded-md cursor-pointer">
            </div>
        </form>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/detail/calculations.js') }}"></script>
<script>
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

    function closeParameterIdError() {
        document.getElementById('close-id').addEventListener('click', function() {
            document.getElementById('id-error').style.display = 'none';
        });
    }

    function closeParameterNameError() {
        document.getElementById('close-name').addEventListener('click', function() {
            document.getElementById('name-error').style.display = 'none';
        });
    }

    function closeParameterTypeError() {
        document.getElementById('close-type').addEventListener('click', function() {
            document.getElementById('type-error').style.display = 'none';
        });
    }

    let arr_children = []
    let arr_children_no_space = []

    function removeSubParameter(paramName) {
        var containerId = 'container-' + paramName
        var container = document.getElementById(containerId)
        console.log(container)
        container.parentNode.removeChild(container)
    }

    function newSubParameter() {
        let error = document.getElementById('multiple-error')
        let subParam = document.getElementById('multipleInput').value

        if (subParam != "") {
            error.classList.add("hidden")

            let subDiv = document.getElementById("sub")

            let word = subParam.split(" ")

            for (let i = 0; i < word.length; i++) {
                word[i] = word[i][0].toUpperCase() + word[i].substr(1)
            }

            subParam = word.join(" ")
            subParamNoSpace = subParam.replaceAll(' ', '')

            console.log(`name="cost${subParamNoSpace}"`)

            subDiv.innerHTML += `
            <div class=container id="container-${subParamNoSpace}">
                <p id="param-name" class="ml-6 mb-2">${subParam} Contents:</p>
                <div class="flex mb-5">
                    <div class="flex-grow ml-6 border border-black shadow-md rounded-md overflow-hidden">
                        <label for="parameterContent" class="font-bold mt-2 ml-2">Cost of ${subParam}</label>
                        <hr />
                        <input class="w-full border-x-0 border-t-0 bg-gray-200" value="0" type="text" id="cost${subParamNoSpace}" name="cost${subParamNoSpace}" disabled/>
                    </div>
                    <div class="flex-grow ml-6 border border-black shadow-md rounded-md overflow-hidden">
                        <label for="parameterContent" class="font-bold mt-2 ml-2">Number of ${subParam}</label>
                        <hr />
                        <input class="w-full border-x-0 border-t-0 bg-gray-200" value="0" type="text" id="number${subParamNoSpace}" name="number${subParamNoSpace}" disabled/>
                    </div>
                    <button class="bg-red-800 text-white font-semibold px-[1vw] py-[1vh] rounded-md shadow-md hover:bg-red-600 ml-4" type="button" onclick="removeSubParameter('${subParamNoSpace}')">
                        -
                    </button>
                </div>
            </div>
            `

            arr_children.push(subParam)
            arr_children_no_space.push(subParamNoSpace)

            console.log(arr_children)
            console.log(arr_children_no_space)

            serialized = JSON.stringify(arr_children)
            serialized_no_space = JSON.stringify(arr_children_no_space)

            document.getElementById('childrenArray').value = serialized
            document.getElementById('childrenArrayNoSpace').value = serialized_no_space

            document.getElementById('multipleInput').value = ""
        } else {
            error.classList.remove("hidden")
        }
    }

    $(document).ready(function() {
        let parameterType = document.getElementById('parameterType')
        let noneSelected = document.getElementById('none_selected')
        let singular = document.getElementById('singular')
        let multiple = document.getElementById('multiple')

        parameterType.addEventListener('change', () => {
            if (parameterType.value == 1) {
                noneSelected.classList.add('hidden')
                multiple.classList.add('hidden')
                singular.classList.remove('hidden')
                singular.classList.remove('disabled')
            } else if (parameterType.value == 2) {
                noneSelected.classList.add('hidden')
                singular.classList.add('hidden')
                singular.classList.add('disabled')
                multiple.classList.remove('hidden')
            } else {
                noneSelected.classList.remove('hidden')
                singular.classList.add('hidden')
                singular.classList.add('disabled')
                multiple.classList.add('hidden')
            }
        })
    })
</script>
