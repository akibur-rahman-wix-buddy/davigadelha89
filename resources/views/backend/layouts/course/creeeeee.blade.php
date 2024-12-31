@extends('backend.app')

{{-- Title for the Vocabulary --}}
@section('title', 'Vocabulary')
@section('title_url')
    <a href="{{ route('vocabularies.index') }}">Vocabulary</a>
@endsection
@section('tabName')
    Add New
@endsection

{{-- Push additional styles if needed --}}
@push('styles')
    {{-- Add any specific styles for the User Dashboard page here --}}
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">
    {{-- CKEditor CDN --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>

    <style>
        .text-center {
            text-align: end;
        }

        .table-topbar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .ck-editor__editable[role="textbox"] {
            min-height: 150px;
        }
    </style>
@endpush



{{-- Main content of the User Dashboard page --}}
@section('content')
    <div class="card">
        <div class="card-body max-sm:overflow-scroll">
            <h1>Create Vocavbulary Group</h1>
            <div class="flex justify-end mb-6">
                <a href="{{ route('vocabularies.index') }}"
                    class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">Back</a>
            </div>
            <form action="{{ route('vocabularies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 gap-5 xl:grid-cols-12">
                    {{-- -------------------Vocabulary Group name Input Field ------------- --}}
                    <div class="xl:col-span-12">
                        <label for="name" class="inline-block mb-2 text-base font-medium">Vocabulary Group name<span
                                style="color: red">*</span></label>
                        <input type="text" name="name"
                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 @error('name') is-invalid @enderror"
                            placeholder="Enter Vocabulary Group name Here" value="{{ old('name') }}">
                        @error('name')
                            <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div><!--end col-->
                </div><!--end grid-->

                <div class="grid grid-cols-1 gap-5 xl:grid-cols-12">
                    {{-- -------------------Vocabulary Group word Input Field ------------- --}}
                    <div class="xl:col-span-4">
                        <label for="words" class="inline-block mb-2 text-base font-medium">Vocabulary Word<span
                                style="color: red">*</span></label>
                        <input type="text" name="words[]"
                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 @error('words') is-invalid @enderror"
                            placeholder="Enter Word Here 1" value="{{ old('words.0') }}">
                        @error('words.0')
                            <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div><!--end col-->
                    {{-- -------------------Vocabulary Word Definision Input Field ------------- --}}
                    <div class="xl:col-span-7">
                        <label for="definitions" class="inline-block mb-2 text-base font-medium">Vocabulary Word
                            Definision<span style="color: red">*</span></label>
                        <input type="text" name="definitions[]"
                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 @error('definitions.0') is-invalid @enderror"
                            placeholder="Enter Word Definision Here 1" value="{{ old('definitions.0') }}">
                        @error('definitions.0')
                            <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div><!--end col-->
                    <div class="flex items-center justify-end">
                        <div class="">
                            <button type="button"
                                class="addMoreInput text-white bg-green-500 border-green-500 btn hover:bg-green-600 !p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div><!--end grid-->


                <div class="grid grid-cols-1 gap-5 " id="vocabulary-Word-section">
                    {{-- here show append feild  --}}
                    {{-- Additional Items Section --}}
                    @if (old('words') || old('definitions'))
                        @foreach (old('words') as $key => $itemType)
                            @if ($key > 0)
                                {{-- Ensure only additional items are shown here --}}
                                <div class="grid grid-cols-1 gap-5 xl:grid-cols-12">
                                    <div class="xl:col-span-4">
                                        <label for="words" class="inline-block mb-2 text-base font-medium">Vocabulary
                                            Word<span style="color: red">*</span></label>
                                        <input type="text" name="words[{{ $key }}]"
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 @error('words.' . $key) is-invalid @enderror"
                                            placeholder="Enter Word Here {{ $key }}" value="{{ old('words.' . $key) }}">
                                        @error('words.' . $key)
                                            <div style="color: red">{{ $message }}</div>
                                        @enderror
                                    </div><!--end col-->

                                    <div class="xl:col-span-7">
                                        <label for="definitions" class="inline-block mb-2 text-base font-medium">Vocabulary
                                            Word Definition<span style="color: red">*</span></label>
                                        <input type="text" name="definitions[{{ $key }}]"
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 @error('definitions.' . $key) is-invalid @enderror"
                                            placeholder="Enter Word Definition Here {{ $key }}"
                                            value="{{ old('definitions.' . $key) }}">
                                        @error('definitions.' . $key)
                                            <div style="color: red">{{ $message }}</div>
                                        @enderror
                                    </div><!--end col-->

                                    <!-- Inline button -->
                                    <div class="flex items-center justify-end">
                                        <button type="button"
                                            class="remove-vocabulary-section p-0.5 rounded-full bg-red-600 text-white flex items-center justify-center w-6 h-6">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div><!--end col-->
                                </div>
                            @endif
                        @endforeach
                    @endif

                </div>

                {{-- ------------------- Form Buttons ------------- --}}
                <div class="flex justify-start mt-6 gap-x-4">
                    <button type="submit"
                        class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">Submit</button>
                </div>
            </form><!--end form-->
        </div>

    </div>
@endsection




@push('scripts')
    <script>
        $(document).ready(function() {
            // Add gallery image
            let WordSectionFeild = 1;

            // Adding more input fields when the button is clicked
            $('.addMoreInput').click(function() {
                WordSectionFeild++;
                console.log(WordSectionFeild);

                // Get the old values for words and definitions if they exist
                const oldWords = @json(old('words', []));
                const oldDefinitions = @json(old('definitions', []));

                // Create the HTML for the new section, using the correct old value
                $('#vocabulary-Word-section').append(`
                <div class="grid grid-cols-1 gap-5 xl:grid-cols-12">
                    <div class="xl:col-span-4">
                        <label for="words" class="inline-block mb-2 text-base font-medium">Vocabulary Word<span style="color: red">*</span></label>
                        <input type="text" name="words[${WordSectionFeild}]" 
                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 @error('words') is-invalid @enderror"
                            placeholder="Enter Word Here ${WordSectionFeild}" value="${oldWords[WordSectionFeild] || ''}">
                        @error('words')
                            <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div><!--end col-->

                    <div class="xl:col-span-7">
                        <label for="definitions" class="inline-block mb-2 text-base font-medium">Vocabulary Word Definition<span style="color: red">*</span></label>
                        <input type="text" name="definitions[${WordSectionFeild}]" 
                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 @error('definitions') is-invalid @enderror"
                            placeholder="Enter Word Definition Here ${WordSectionFeild}" value="${oldDefinitions[WordSectionFeild] || ''}">
                        @error('definitions')
                            <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div><!--end col-->

                    <!-- Inline button -->
                    <div class="flex items-center justify-end">
                        <button type="button" class="remove-vocabulary-section p-0.5 rounded-full bg-red-600 text-white flex items-center justify-center w-6 h-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                            </svg>
                        </button>
                    </div><!--end col-->
                </div>
            `);
            });

            // Remove the entire vocabulary section when the remove button is clicked
            $(document).on('click', '.remove-vocabulary-section', function() {
                $(this).closest('.grid').remove(); // This will remove the entire grid section
            });
        });
    </script>
@endpush