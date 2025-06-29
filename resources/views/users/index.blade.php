@extends('layouts.app')
@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Akun</h1>
            <p class="text-gray-500 text-sm mt-1">Total user: <span class="font-semibold">{{ $users->total() }}</span></p>
        </div>
        <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl shadow-lg font-semibold text-base transition-all duration-200">
            <i class="fas fa-user-plus text-lg"></i> Tambah User
        </a>
    </div>
    <!-- Tutorial/Info Singkat -->
    <div class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-400 rounded-xl flex items-start gap-3">
        <i class="fas fa-info-circle text-blue-500 text-2xl mt-1"></i>
        <div>
            <div class="font-semibold text-blue-800 mb-1">Tentang Kelola Akun</div>
            <ul class="list-disc pl-5 text-sm text-blue-900 space-y-1">
                <li>Menu ini digunakan untuk <b>mengelola data akun pengguna</b> aplikasi (admin, dokter, staff).</li>
                <li>Anda dapat <b>menambah, mengedit, dan menghapus</b> user sesuai kebutuhan.</li>
                <li>Gunakan fitur <b>pencarian</b> untuk menemukan user dengan cepat berdasarkan nama atau email.</li>
                <li>Pastikan email dan role user diisi dengan benar untuk akses yang sesuai.</li>
                <li>Hanya admin yang dapat mengakses dan mengelola data akun di menu ini.</li>
            </ul>
        </div>
    </div>
    @if(session('success'))
        <div class="mb-4 p-3 flex items-center bg-green-50 border border-green-200 rounded-lg">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            <span class="text-green-700">{{ session('success') }}</span>
        </div>
    @endif
    <form method="GET" class="mb-4 flex flex-col md:flex-row gap-2 md:gap-4 items-center w-full">
        <div class="relative w-full md:w-72">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-search"></i></span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email..." class="w-full pl-10 pr-3 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 text-sm shadow-sm transition-all" />
        </div>
        <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg shadow font-semibold text-sm transition-all">
            <i class="fas fa-search"></i> Cari
        </button>
    </form>

    <!-- MOBILE: Card/List View -->
    <div class="md:hidden space-y-3">
      @forelse($users as $user)
        <div class="bg-white rounded-lg shadow p-3 flex flex-col space-y-1 border">
          <div class="flex items-center gap-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=6366f1&color=fff" alt="avatar" class="w-10 h-10 rounded-full ring-2 ring-blue-200">
            <div>
              <div class="font-semibold text-gray-900">{{ $user->name }}</div>
              <div class="text-xs text-gray-500">{{ $user->status ?? 'Aktif' }}</div>
              <span class="px-2 py-0.5 rounded-full text-xs font-medium
                @if($user->role=='admin') bg-blue-100 text-blue-800
                @elseif($user->role=='doctor') bg-green-100 text-green-800
                @elseif($user->role=='staff') bg-purple-100 text-purple-800
                @else bg-gray-100 text-gray-800 @endif">
                {{ $user->role }}
              </span>
            </div>
          </div>
          <div class="text-xs text-gray-600 mt-1">{{ $user->email }}</div>
          <div class="flex space-x-2 mt-2">
            <a href="{{ route('users.edit', $user) }}" class="flex-1 flex items-center justify-center py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-600 rounded-lg" title="Edit User"><i class="fas fa-edit mr-1"></i>Edit</a>
            <form action="{{ route('users.destroy', $user) }}" method="POST" class="flex-1 flex items-center justify-center" onsubmit="return confirm('Yakin hapus user ini?')">
              @csrf @method('DELETE')
              <button type="submit" class="w-full py-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg" title="Hapus User"><i class="fas fa-trash mr-1"></i>Hapus</button>
            </form>
          </div>
        </div>
      @empty
        <div class="text-center text-gray-400 py-8">Belum ada data user</div>
      @endforelse
      <div class="mt-4">{{ $users->links() }}</div>
    </div>

    <!-- DESKTOP: Table View -->
    <div class="hidden md:block bg-white rounded-xl shadow border border-gray-100 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-blue-600 uppercase tracking-wider">User</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-blue-600 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-blue-600 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-blue-600 uppercase tracking-wider">Dibuat</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-blue-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-3 flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=6366f1&color=fff" alt="avatar" class="w-9 h-9 rounded-full ring-2 ring-blue-200">
                        <div>
                            <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $user->status ?? 'Aktif' }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-3">{{ $user->email }}</td>
                    <td class="px-6 py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            @if($user->role=='admin') bg-blue-100 text-blue-800
                            @elseif($user->role=='doctor') bg-green-100 text-green-800
                            @elseif($user->role=='staff') bg-purple-100 text-purple-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-500">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</td>
                    <td class="px-6 py-3 text-center">
                        <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center justify-center w-8 h-8 bg-yellow-100 hover:bg-yellow-200 text-yellow-600 rounded-lg mr-1" title="Edit User" data-tooltip="Edit User">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus user ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg" title="Hapus User" data-tooltip="Hapus User">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <div class="text-gray-500 font-medium">Belum ada data user</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $users->links() }}</div>
    </div>
</div>
@endsection
