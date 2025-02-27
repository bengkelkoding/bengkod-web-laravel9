<x-admin>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Dosen') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <p class="fw-semibold mb-4"><span class="card-title mr-4">Mahasiswa {{ $classroom->name . ' ' . $classroom->day . ' ' . $classroom->time}}</span></p>
                    <div class="row">
                        <div class="col">
                            <form>
                                <div class="flex">
                                    <label>
                                        Show
                                        <select class="rounded-md" name="per_page" id="per_page" onchange="this.form.submit()">
                                            <option value="10" {{ request()->per_page == 10 ? 'selected' : '' }}>10</option>
                                            <option value="25" {{ request()->per_page == 25 ? 'selected' : '' }}>25</option>
                                            <option value="50" {{ request()->per_page == 50 ? 'selected' : '' }}>50</option>
                                            <option value="100" {{ request()->per_page == 100 ? 'selected' : '' }}>100</option>
                                        </select>
                                        entries
                                    </label>
                                </div>
                            </form>
                        </div>
                        <div class="col">
                            <form class="flex items-center">
                                <label for="simple-search" class="sr-only">Search</label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="ti ti-certificate"></i>
                                    </div>
                                    <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Search" name="search">
                                </div>
                                <button type="submit" class="p-2.5 ml-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                    <span class="sr-only">Search</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped max-md:min-w-[250vw]" >
                            <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Email</th>
                                <th scope="col">Nilai Akhir</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($students as $key => $student)
                                @php
                                    $final_score = 0;
                                @endphp
                                <tr>
                                    <th scope="row">{{ $students->firstItem() + $key }}</th>
                                    <td>{{ $student->code }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    @if($student->taskScore->whereNotNull('final_score') !== null)
                                        @php
                                            foreach ($student->taskScore as $key => $tugas) {
                                                if ($tugas->final_score !== null) {
                                                    $final_score += $tugas->final_score;
                                                }
                                            }

                                            $jumlah = $student->taskScore->whereNotNull('final_score')->count();
                                            if ($jumlah !== 0) {
                                                $final_score = round($final_score / $jumlah);
                                            }
                                        @endphp
                                        @if ($final_score == 0)
                                            <td class="success">Belum ada nilai</td>
                                        @elseif ($final_score > 0)
                                            <td class="success">{{ $final_score }}</td>
                                        @endif
                                    @else
                                        <td>Belum ada tugas yang dikumpulkan</td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="5">Data Kosong</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $students->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin>
