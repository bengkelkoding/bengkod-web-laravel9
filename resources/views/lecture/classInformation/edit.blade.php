<x-admin>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Dosen') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="container-fluid">
        <a href="{{ url()->previous() }}" class="btn btn-outline-dark rounded-pill mb-4"><i class="ti ti-arrow-left"></i> Back</a>
          <div class="card">
            <div class="card-body">
            <p class="fw-semibold mb-4"><span class="card-title mr-4">Edit Asisten</span></p>
            <form method="POST" action="{{ route('lecture.class-information.update', ['idClassroom' => $classroom, 'class_information' => $class_information->id]) }}">
                @csrf
                @method('PATCH')

                <!-- Title -->
                <div class="mb-3">
                    <x-input-label for="title" :value="__('Judul')" />
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="$class_information->title" required autofocus autocomplete="title" />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <x-input-label for="description" :value="__('Deskripsi')" />
                    <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="$class_information->description" required autofocus autocomplete="description" />
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('Edit Informasi Kelas') }}
                    </x-primary-button>
                </div>
            </form>
            </div>
          </div>
        </div>
    </div>
</x-admin>
