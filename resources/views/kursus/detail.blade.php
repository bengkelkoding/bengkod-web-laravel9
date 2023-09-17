<x-universal-layout>
    <div class="pb-3 box-border w-full flex justify-center items-center max-md:justify-center flex-wrap">
        <div class="mr-5 p-2 flex flex-wrap max-md:justify-center max-md:mr-0  my-10">
            <img src="{{ asset($kursus->image) }}" alt="Gambar Kursus" width="200px" height="200px" class="rounded">
            <div class=" h-auto ml-[40px]">
                <h1 class="text-black font-semibold text-[40px] max-md:text-center">{{ $kursus->judul }}</h1>
                <p class="text-[#828282] text-[14px]">
                    <img src="assets\admin\icons\users-solid.png" alt="" class="inline mr-2">
                    {{ $kursus->users_count }} Mahasiswa Terdaftar</p>
                <p class="text-[#828282] text-[14px]">
                    <img src="assets\admin\icons\calendar-days-solid.png" alt="" class="inline mr-2">
                    {{ $kursus->hari }}
                </p>
                <p class="text-[#828282] text-[14px]">
                    <img src="assets\admin\icons\clock-solid.png" alt="" class="inline mr-2">
                    {{ $kursus->jam }}
                </p>
                <div>
                @auth
                    @if (!is_null(auth()->user()->id_kursus))
                        @if (auth()->user()->id_kursus == $kursus->id)
                            <x-tombol-universal href="{{ env('APP_URL_QUARTO').$kursus->url }}" class="px-6 h-auto mr-6 max-md:mr-0 mb-5">Belajar Sekarang</x-tombol-universal>
                        @else
                            <div class="alert alert-warning my-5 ml-3 bg-[#ff0000] inline-block p-2 rounded-md bg-opacity-50">
                                Anda sudah terdaftar pada kursus lain!
                            </div>
                        @endif
                    @else
                        <form action="{{ route('update.kursus') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mendaftar ke kursus ini?')">
                            @csrf
                            <input type="hidden" name="kursus_id" value="{{ $kursus->id }}">
                            <x-tombol-universal type="submit" class="px-6 h-auto mr-6 max-md:mr-0 mb-5">Daftar Kursus</x-tombol-universal>
                        </form>
                    @endif
                @else
                    <x-tombol-universal href="{{ url('login') }}" class="px-6 h-auto mr-6 max-md:mr-0 mb-5">Daftar Kursus</x-tombol-universal>
                @endauth
                </div>
            </div>
        </div>
    </div>

    <div class="w-screen px-4 flex justify-center mx-auto border-y ">
        <div class="justify-start w-[50%] pb-10 pt-4 px-8 border-r ">
            <h1 class="text-[28px] font-medium text-center mb-2 ml-2 mt-3">Deskripsi</h1>
            <p class="text-[14px] text-justify ml-2">{{ $kursus->description }}</p>
        </div>

        <div class="box-border ml-3 w-[30%] pb-10 pt-4 px-8">
            <h1 class="text-[28px] font-medium text-center mb-2 ml-2 mt-3">Tools</h1>
            <ol class="list-disc ml-5">
                <li >VS Code</li>
                <li >Browser</li>
                <li >Web Server</li>
            </ol>
        </div>
    </div>
</x-universal-layout>