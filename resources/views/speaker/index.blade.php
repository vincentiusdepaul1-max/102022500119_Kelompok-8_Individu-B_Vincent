<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Speakers</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 30px; background: #f8fafc; color: #334155; }
        .container { max-width: 1200px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        h1, h2 { color: #1e293b; }
        .alert { padding: 12px; background: #dcfce7; color: #166534; border-radius: 6px; margin-bottom: 20px; }
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group.full { grid-column: span 2; }
        label { font-weight: 600; margin-bottom: 5px; font-size: 14px; }
        input, select, textarea { padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; }
        button { padding: 10px 20px; background: #2563eb; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; }
        button:hover { background: #1d4ed8; }
        .btn-danger { background: #dc2626; }
        .btn-danger:hover { background: #b91c1c; }
        .btn-warning { background: #d97706; color: white; text-decoration: none; display: inline-block; padding: 6px 12px; border-radius: 4px; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 14px; }
        th, td { padding: 10px 12px; border: 1px solid #e2e8f0; text-align: left; }
        th { background-color: #f1f5f9; color: #475569; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; }
        .badge-verified { background: #dcfce7; color: #166534; }
        .badge-pending { background: #fef9c3; color: #854d0e; }
        .badge-leave { background: #fee2e2; color: #991b1b; }
        
        /* Styling Navbar Header */
        .navbar-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .btn-logout {
            background: #ef4444;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
        }
        .btn-logout:hover {
            background: #dc2626;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Navbar Header dengan Tombol Logout -->
        <div class="navbar-top">
            <div>
                <h1>Manajemen Speakers</h1>
                <p style="margin: 0; color: #64748b;">Aplikasi CRUD sederhana menggunakan pola MVC Laravel.</p>
            </div>
            <div class="user-info">
                <span>Halo, <strong>{{ Auth::user()->name ?? 'Admin' }}</strong> (<em>{{ Auth::user()->role ?? 'admin' }}</em>)</span>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Tambah / Edit Data -->
        <div style="background: #f8fafc; padding: 20px; border-radius: 8px; margin-bottom: 30px; border: 1px solid #e2e8f0;">
            <h2>{{ isset($speakerToEdit) ? 'Edit Speaker: ' . $speakerToEdit->name : 'Tambah Speaker Baru' }}</h2>
            
            <form action="{{ isset($speakerToEdit) ? route('speakers.update', $speakerToEdit->id) : route('speakers.store') }}" method="POST">
                @csrf
                @if(isset($speakerToEdit))
                    @method('PUT')
                @endif

                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $speakerToEdit->name ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $speakerToEdit->email ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label>No. Telepon / WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone', $speakerToEdit->phone ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" required>
                            @foreach(['Keynote Speaker', 'Workshop Facilitator', 'Panelist', 'Guest Lecturer'] as $role)
                                <option value="{{ $role }}" {{ (old('role', $speakerToEdit->role ?? '') == $role) ? 'selected' : '' }}>{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" required>
                            @foreach(['Verified', 'Pending Review', 'On Leave'] as $status)
                                <option value="{{ $status }}" {{ (old('status', $speakerToEdit->status ?? '') == $status) ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Institusi Saat Ini</label>
                        <input type="text" name="current_institution" value="{{ old('current_institution', $speakerToEdit->current_institution ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Primary Domain (Keahlian Utama)</label>
                        <input type="text" name="primary_domain" value="{{ old('primary_domain', $speakerToEdit->primary_domain ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label>URL Portfolio</label>
                        <input type="url" name="portfolio_url" value="{{ old('portfolio_url', $speakerToEdit->portfolio_url ?? '') }}">
                    </div>

                    <div class="form-group full">
                        <label>Skills (Pisahkan dengan koma)</label>
                        <textarea name="skills" rows="2">{{ old('skills', $speakerToEdit->skills ?? '') }}</textarea>
                    </div>

                    <div class="form-group full">
                        <label>Bio Singkat</label>
                        <textarea name="bio" rows="3">{{ old('bio', $speakerToEdit->bio ?? '') }}</textarea>
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit">{{ isset($speakerToEdit) ? 'Perbarui Data' : 'Simpan Speaker' }}</button>
                    @if(isset($speakerToEdit))
                        <a href="{{ route('speakers.index') }}" style="padding: 10px 20px; background: #64748b; color: white; text-decoration: none; border-radius: 6px; font-weight: 600; display: inline-flex; align-items: center;">Batal</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabel Daftar Data -->
        <h2>Daftar Speakers</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama & Kontak</th>
                    <th>Role & Status</th>
                    <th>Institusi / Domain</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($speaker as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $item->name }}</strong><br>
                            <small>{{ $item->email }} | {{ $item->phone }}</small>
                        </td>
                        <td>
                            {{ $item->role }}<br>
                            <span class="badge {{ $item->status == 'Verified' ? 'badge-verified' : ($item->status == 'Pending Review' ? 'badge-pending' : 'badge-leave') }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td>
                            {{ $item->current_institution }}<br>
                            <small>Dom: {{ $item->primary_domain }}</small>
                        </td>
                        <td>
                            <!-- Tombol Edit (Bisa diakses Admin & Staff) -->
                            <a href="{{ route('speakers.index', ['edit' => $item->id]) }}" class="btn-warning">Edit</a>
                            
                            <!-- Tombol Hapus HANYA MUNCUL JIKA USER ADALAH ADMIN -->
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <form action="{{ route('speakers.destroy', $item->id) }}" method="POST" style="display:inline-block; margin-left: 5px;" onsubmit="return confirm('Yakin ingin menghapus speaker ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger" style="padding: 6px 12px; font-size: 13px;">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #64748b;">Belum ada data speaker.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>