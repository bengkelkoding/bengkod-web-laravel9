<x-admin>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <p class="fw-semibold mb-4"><span class="card-title mr-4">Tabel Kontak Asisten </span><a
                            href="{{ route('admin.contact-assistant.create') }}"
                            class="btn btn-outline-dark rounded-pill"><i class="ti ti-plus"></i> Tambah Data</a>
                    </p>
                    <div class="flex max-md:flex-col">
                        <div class="col">
                            <form>
                                <div class="flex inline">
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

                    <div class="table-responsive">
                        <table class="table table-striped max-md:min-w-[250vw]">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Nomor Telepon</th>
                                    <th scope="col">Kursus</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contactAssistant as $key => $ca)
                                    <tr>
                                        <th scope="row">{{ $contactAssistant->firstItem() + $key }}</th>
                                        <td>{{ $ca->name }}</td>
                                        <td>{{ $ca->phone_number }}</td>
                                        <td>
                                            @if(isset($ca->course->judul))
                                                {{ $ca->course->judul }}
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-dark dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('admin.contact-assistant.edit', $ca->id) }}"><i
                                                                class="ti ti-edit"></i> Edit</a></li>
                                                    <form
                                                        action="{{ route('admin.contact-assistant.destroy', $ca->id) }}"
                                                        method="post">
                                                        <li><button type="submit" class="dropdown-item"><i
                                                                    class="ti ti-trash"></i> Hapus</button></li>
                                                        @method('delete')
                                                        @csrf
                                                    </form>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="6">Data kosong</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $contactAssistant->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin>
