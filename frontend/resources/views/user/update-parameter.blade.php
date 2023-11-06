@extends('layout.app')

@section('scripts')
    <title>
        Update Parameter
    </title>
@endsection

@section('content')
    <div class="nav-body w-full px-[10vw] py-[2vh] min-h-[80vh]">
        <div class="title mb-10">
            <h1 class="mb-1 mt-10 text-4xl font-bold">Update Parameter</h1>
            <h2 class="text-xl pl-8">for <span class="mb-10 mt-10 text-2xl font-bold">{{ $parameter->parameter_name }}</span></h2>
        </div>

        <form
            action="{{ route('updateParameterPost', ['parameterId' => $parameter->id]) }}"
            method="POST">
            @csrf
            <!-- parameter id input -->
            <div class="flex-start items-center">
                <div class="field mb-[3vh] flex">
                    <label for="parameterId" class="font-bold mt-2 mr-7">Parameter ID</label>
                    <div class="flex-grow ml-10 border border-black shadow-md rounded-md overflow-hidden">
                        <input class="w-full border-x-0 border-t-0 bg-gray-300" type="text" id="parameterId" name="parameterId"
                            value="{{ $parameter->id }}" disabled/>
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
                            name="parameterName" value="{{ $parameter->parameter_name }}"/>
                    </div>
                </div>
            </div>

            <!-- parameter type dropdown -->
            <div class="flex items-center">
                <div class="field mb-[3vh] flex">
                    <label for="parameterType" class="font-bold mt-2">Parameter Type</label>
                    <div class="flex-grow ml-12 border border-black shadow-md rounded-md overflow-hidden">
                        <select name="parameterType" id="parameterType" class="cursor-pointer bg-gray-300" disabled>
                            @foreach ($parameter_type as $p_t)
                                @if ($p_t->parameter_type_name != 'Result')
                                    @if($p_t->id == $parameter->parameter_type_id)
                                        <option value="{{ $p_t->id }}" selected>{{ $p_t->parameter_type_name }}</option>
                                    @else   
                                        <option value="{{ $p_t->id }}">{{ $p_t->parameter_type_name }}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            @error('parameterContent')
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
            <!-- parameter content -->
            <div class="flex-start items-center">
                <div class="field mb-[3vh] flex">
                    <label for="parameterContent" class="font-bold mt-2">Parameter Content</label>
                    @if($parameter->parameter_type_id == 1)
                        <div class="flex-grow ml-6 border border-black shadow-md rounded-md overflow-hidden">
                            <input class="w-full border-x-0 border-t-0" type="text" id="parameterContent" name="parameterContent"
                                placeholder="Maximum 10 characters" value="{{ $parameter->parameter_content }}"/>
                        </div>                        
                    @endif
                </div>
            </div>

            @if($parameter->parameter_type_id == 2)
                <div class="sub-param" id="sub">
                    @foreach($children as $c)
                        <div class="container" id="container-{{ $c->parameter_name }}">
                            <p id="param-name" class="ml-6 mb-2">{{ $c->parameter_name }}</p>
                            @if($c->user_id == null)
                                <div class="flex mb-5">
                                    <div class="flex-grow ml-6 border border-black shadow-md rounded-md overflow-hidden">
                                        <input class="w-full border-x-0 border-t-0 bg-gray-300" type="text" id="cost{{ $c->parameter_name }}" name="cost$c->parameter_name" value="{{ $c->parameter_cost }}" disabled/>
                                    </div>
                                    <div class="flex-grow ml-6 border border-black shadow-md rounded-md overflow-hidden">
                                        <input class="w-full border-x-0 border-t-0 bg-gray-300" type="text" id="number{{ $c->parameter_name }}" name="number$c->parameter_name" value="{{ $c->parameter_number }}" disabled/>
                                    </div>
                                </div>
                            @else
                                <div class="flex mb-5">
                                    <div class="flex-grow ml-6 border border-black shadow-md rounded-md overflow-hidden">
                                        <input class="w-full border-x-0 border-t-0 bg-gray-300" type="text" id="cost{{ $c->parameter_name }}" name="cost$c->parameter_name" value="{{ $c->parameter_cost }}" disabled/>
                                    </div>
                                    <div class="flex-grow ml-6 border border-black shadow-md rounded-md overflow-hidden">
                                        <input class="w-full border-x-0 border-t-0 bg-gray-300" type="text" id="number{{ $c->parameter_name }}" name="number$c->parameter_name" value="{{ $c->parameter_number }}" disabled/>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="flex">
                <input type="submit" value="Update Parameter"
                    class="bg-blue-800 text-white px-5 py-2 shadow-md rounded-md cursor-pointer">
            </div>
        </form>
    </div>
@endsection

<script>
    function closeParameterNameError() {
        document.getElementById('close-name').addEventListener('click', function() {
            document.getElementById('name-error').style.display = 'none';
        });
    }
</script>