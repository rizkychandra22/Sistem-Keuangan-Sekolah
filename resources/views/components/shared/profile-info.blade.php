<tr>
    <th style="width: 15%;">Nama Guru</th>
    <td>{{ $user->guru->nama ?? $user->name }}</td>
</tr>
<tr>
    <th style="width: 15%;">NIP</th>
    <td>{{ $user->guru->nip ?? '-' }}</td>
</tr>
<tr>
    <th style="width: 15%;">Jabatan</th>
    <td>{{ $user->guru->jabatan ?? '-' }}</td>
</tr>
<tr>
    <th style="width: 15%;">Kontak</th>
    <td>{{ $user->guru->kontak ?? '-' }}</td>
</tr>
<tr>
    <th style="width: 15%;">Motivasi</th>
    <td>{{ $user->guru->motivasi ?? '-' }}</td>
</tr>
<tr>
    <th style="width: 15%;">Username (Login)</th>
    <td>{{ $user->username }}</td>
</tr>
<tr>
    <th style="width: 15%;">Email</th>
    <td>{{ $user->email }}</td>
</tr>