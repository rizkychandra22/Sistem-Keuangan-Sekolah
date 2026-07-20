<div class="col-md-6">
    <div class="form-group">
        <strong>Nama Guru:</strong>
        <input type="text" name="name" value="{{ old('name', $user->guru->nama ?? $user->name) }}" class="form-control" placeholder="Nama Guru">
    </div>
    <div class="form-group">
        <strong>NIP:</strong>
        <input type="text" name="nip" value="{{ old('nip', $user->guru->nip ?? '') }}" class="form-control" placeholder="NIP">
    </div>
    <div class="form-group">
        <strong>Jabatan:</strong>
        <input type="text" name="jabatan" value="{{ old('jabatan', $user->guru->jabatan ?? '') }}" class="form-control" placeholder="Jabatan">
    </div>
    <div class="form-group">
        <strong>Kontak:</strong>
        <input type="text" name="kontak" value="{{ old('kontak', $user->guru->kontak ?? '') }}" class="form-control" placeholder="Kontak (No HP/Telp)">
    </div>
    <div class="form-group">
        <strong>Email:</strong>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" placeholder="Email Login">
    </div>
</div>