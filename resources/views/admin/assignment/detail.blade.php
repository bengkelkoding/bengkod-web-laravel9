<x-admin>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <a href="{{ url('admin/assignment') }}" class="btn btn-outline-dark rounded-pill mb-4"><i
                class="ti ti-arrow-left"></i>
            Back</a>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <p class="fw-semibold mb-4"><span class="card-title mr-4">Tabel Detail Penugasan :
                                    {{ $assignment->judul }} </span></p>
                        </div>
                        <div class="col">
                            <div class="flex justify-end">
                                <a href="{{ route('admin.download-tugas', $assignment->id) }}" class="btn btn-primary bg-blue-500">Download Semua Tugas</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <form>
                                <div class="flex">
                                    <label>
                                        Show
                                        <select class="rounded-md" name="per_page" id="per_page"
                                            onchange="this.form.submit()">
                                            <option value="10" {{ request()->per_page == 10 ? 'selected' : '' }}>10
                                            </option>
                                            <option value="25" {{ request()->per_page == 25 ? 'selected' : '' }}>25
                                            </option>
                                            <option value="50" {{ request()->per_page == 50 ? 'selected' : '' }}>50
                                            </option>
                                            <option value="100" {{ request()->per_page == 100 ? 'selected' : '' }}>
                                                100
                                            </option>
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
                                    <input type="text" id="simple-search"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                        placeholder="Search" name="search">
                                </div>
                                <button type="submit"
                                    class="p-2.5 ml-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                    <span class="sr-only">Search</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-hover max-md:min-w-[250vw]">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIM</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Status</th>
                                    <th>File Tugas</th>
                                    <th>Nilai Tersimpan</th>
                                    <th>Tanggal Submit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($student as $key => $m)
                                    <tr>
                                        <td>{{ $student->firstItem() + $key }}</td>
                                        <td>{{ $m->code }}</td>
                                        <td>{{ $m->name }}</td>
                                        <td>
                                            @if (!isset($m->task))
                                                {{ __('Belum input tugas') }}
                                            @else
                                                @if ($m->task->status === 0)
                                                    {{ __('Tugas belum disubmit') }}
                                                @elseif ($m->task->status === 1)
                                                    {{ __('Tugas telah disubmit') }}
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @isset($m->task)
                                                @if ($assignment->deadline < now('Asia/Jakarta') && $m->task->status === 0)
                                                    <form action="{{ route('admin.force-submit', $m->task->id) }}"
                                                        method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <input type="hidden" name="status" value="1">
                                                        <button type="submit" class="btn btn-primary bg-blue-400">
                                                            <i class="ti ti-download"></i> Force Submit</button>
                                                    </form>
                                                @elseif ($m->task->status === 0)
                                                    <button class="btn btn-primary" disabled><i class="ti ti-download"></i>
                                                        Download</button>
                                                @else
                                                    @if ($m->task->task_file == '-')
                                                    <div class="alert alert-danger py-2 px-3 mb-0" role="alert">
                                                        {{ __('Tidak ada file tugas') }}
                                                    </div>
                                                    @else
                                                    <a class="btn btn-primary"
                                                        href="{{ asset('storage/task/' . $m->task->task_file) }}"><i
                                                            class="ti ti-download"></i> Download</a>
                                                    @endif
                                                @endif
                                            @else
                                                <div class="alert alert-danger py-2 px-3 mb-0" role="alert">
                                                    {{ __('Belum ada file tugas') }}
                                                </div>
                                            @endisset
                                        </td>
                                        <td>
                                            @isset($m->task)
                                                @isset($m->task->final_score)
                                                    {{ $m->task->final_score }}
                                                @else
                                                    {{ __('-') }}
                                                @endisset
                                            @else
                                                {{ __('-') }}
                                            @endisset
                                        </td>
                                        <td>
                                            @isset($m->task)
                                                {{ \Carbon\Carbon::parse($m->task->created_at)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('l, d F Y, h:i') }}
                                            @else
                                                {{ __('-') }}
                                            @endisset
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Data Kosong</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $student->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin>
