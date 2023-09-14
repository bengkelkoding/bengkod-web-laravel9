<x-app-layout>
    <x-slot name="header">
        Bengkel Koding
    </x-slot>
    <div class="box-content h-[210px] w-100% p-4 bg-gradient-to-l from-cyan-500 to-blue-500 ">
        <div class="box-content h-auto ml-[190px] mb-[40px]">
            <h1 class="text-white font-bold text-[32px] mt-7">Selamat pagi, {{ auth()->user()->name }}!</h1>
            <p class="text-white mt-2 text-[16px] w-[427px]">Jika kamu tidak sanggup menahan lelahnya belajar, Maka bersiaplah menahan perihnya kebodohan.</p>
            <p class="text-white">~ Imam Syafi’i</p>
        </div>
    </div>

    @if($user->kursus)
        <div class="box-border h-40 w-[700px] p-1 border ml-[190px] mt-12">
            <h3 class="text-black font-bold ml-2 mb-2 text-[14px]">Kursus Anda</h3>
            <div class="box-border h-auto w-[662px] shadow-lg ml-2 flex justify-between items-center">
                <div class="mr-5 p-2 flex">
                    <img src="{{ $user->kursus->image }}" alt="" width="90px" height="90px" class="rounded">
                    <div class="w-[170px] h-auto pl-5">
                        <h1 class="text-black font-bold text-[20px]">{{ $user->kursus->judul }}</h1>
                        <p class="text-[#828282] text-[12px]">
                            <img src="assets\admin\icons\users-solid.png" alt="" class="inline mr-2">
                            10 Mahasiswa Terdaftar</p>
                        <p class="text-[#828282] text-[12px]">
                            <img src="assets\admin\icons\calendar-days-solid.png" alt="" class="inline mr-2">
                            {{ $user->kursus->hari }}</p>
                        <p class="text-[#828282] text-[12px]">
                            <img src="assets\admin\icons\clock-solid.png" alt="" class="inline mr-2">
                            {{ $user->kursus->jam }}
                        </p>
                    </div>
                </div>
                <div>
                    <x-tombol-universal href="{{ $user->kursus->url }}" class="w-[180px] h-auto mr-5 mb-5"><span class="text-[14px]">Belajar Sekarang</span></x-tombol-universal>
                </div>
            </div>
        </div>
    @else
        <li>Anda belum mendaftar ke kursus manapun.</li>
    @endif

    {{-- <h2>Kursus Anda:</h2>
        <ul>
            @if($user->kursus)
                <img src="{{$user->kursus->image}}">
                <li>{{ $user->kursus->id }}</li>
                <li>{{ $user->kursus->judul }}</li>
                <li>{{ $user->kursus->author }}</li>
                <li>{{ $user->kursus->hari }}</li>
                <li>{{ $user->kursus->jam }}</li>
                <li>{{ $user->kursus->url }}</li>
            @else
                <li>Anda belum mendaftar ke kursus manapun.</li>
            @endif
        </ul> --}}
</x-app-layout>
