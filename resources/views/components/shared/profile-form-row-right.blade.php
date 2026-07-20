<div class="col-md-6">
    <div class="form-group">
        <strong>Motivasi:</strong>
        <textarea name="motivasi" class="form-control" rows="4" placeholder="Kata-kata Motivasi">{{ old('motivasi', $user->guru->motivasi ?? '') }}</textarea>
    </div>
    <div class="form-group">
        <strong>Username (Login):</strong>
        <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control" placeholder="Username Login">
    </div>
    <div class="form-group">
        <strong>Password Login Baru:</strong>
        <input type="password" name="password" class="form-control" placeholder="Isi jika ingin mengubah password">
    </div>
    <div class="form-group">
        <strong>Konfirmasi Password Baru:</strong>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password Baru">
    </div>
</div>