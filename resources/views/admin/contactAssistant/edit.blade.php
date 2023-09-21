<x-admin>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="container-fluid">
        <a href="{{ url()->previous() }}" class="btn btn-outline-dark rounded-pill mb-4"><i class="ti ti-arrow-left"></i> Back</a>
          <div class="card">
            <div class="card-body">
            <p class="fw-semibold mb-4"><span class="card-title mr-4">Edit Kontak Asisten</span></p>
            <form method="POST" action="{{ route('admin.contact-assistant.update', $contactAssistant->id) }}">
                @csrf
                @method('PATCH')
                <!-- Nama -->
                <div class="mb-3">
                    <x-input-label for="name" :value="__('Nama Asisten')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$contactAssistant->name" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Nomor Telepon -->
                <div class="mb-3">
                    <x-input-label for="phone_number" :value="__('Nomor Telepon')" />
                    <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="$contactAssistant->phone_number" required autofocus autocomplete="phone_number" />
                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                </div>

                <!-- Select Option  -->
                <div class="mb-3">
                    <x-input-label for="course" :value="__('Nama Kursus')" />
                    <select class="form-select" name="course">
                        <option>Pilih Kursus</option>
                        @foreach($courses as $course)
                        <option value="{{$course->id}}" @if($course->id==$contactAssistant->id_kursus) selected @endif>{{$course->id}} - {{$course->judul}}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('course')" class="mt-2" />
                </div>

                <!-- Select Option Student -->
                <div class="mb-3">
                    <x-input-label for="student" :value="__('Nama Mahasiswa')" />
                    <select class="form-select" name="student">
                        <option disabled>Pilih Mahasiswa</option>
                        @foreach($students as $student)
                        <option value="{{$student->id}}" @if($student->id==$contactAssistant->id_mahasiswa) selected @endif>{{$student->name}}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('student')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">

                    <x-primary-button class="ml-4">
                        {{ __('Edit Kontak Asisten') }}
                    </x-primary-button>
                </div>
            </form>
            </div>
          </div>
        </div>
    </div>
</x-admin>
