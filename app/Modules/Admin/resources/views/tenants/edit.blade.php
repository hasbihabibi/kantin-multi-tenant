<x-layouts.admin title="{{ $tenant->display_name }}">
    @if (session('status'))
        <div class="mb-4 rounded-lg bg-green-100 px-4 py-2 text-sm text-green-800 dark:bg-green-900/40 dark:text-green-300">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-100 px-4 py-2 text-sm text-red-800 dark:bg-red-900/40 dark:text-red-300">
            <ul class="list-disc ps-4">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif
    <div class="flex items-center gap-3">
        <h1 class="text-xl font-semibold">{{ $tenant->display_name }}</h1>
        <x-status-badge :status="$tenant->status">{{ $tenant->status }}</x-status-badge>
    </div>
    
    <section class="mt-6">
        <h2 class="font-semibold">Skema Komisi (effective-dated)</h2>
        <ul class="mt-2 space-y-1 text-sm">
            @foreach ($commissions as $c)
                <li>{{ number_format((float) $c->commission_rate * 100, 2) }}% — {{ $c->valid_from }} s/d {{ $c->valid_to ?? 'sekarang' }}</li>
            @endforeach
        </ul>
        <form method="POST" action="{{ route('admin.tenants.commissions.store', $tenant) }}" class="mt-4 flex flex-wrap items-end gap-2">
            @csrf
            <x-input name="commission_rate" label="Tarif Baru (%)" type="number" step="0.01" required />
            <x-button type="submit" variant="secondary">Ubah Komisi</x-button>
        </form>
    </section>

    <section class="mt-8">
        <h2 class="font-semibold">Operator / Role</h2>
        <ul class="mt-2 space-y-1 text-sm">
            @foreach ($members as $m)
                <li>{{ $m->user?->email }} — {{ $m->role }}</li>
            @endforeach
        </ul>
        <form method="POST" action="{{ route('admin.tenants.roles.store', $tenant) }}" class="mt-3 flex flex-wrap items-end gap-2">
            @csrf
            <x-input name="email" label="Email user" type="email" required />
            <x-input name="role" label="Role (owner/operator/cashier)" required />
            <x-button type="submit">Tugaskan</x-button>
        </form>
    </section>
    <section class="mt-8">
        <h2 class="font-semibold">Rekening Pencairan Dana</h2>
        <div class="mt-3 overflow-x-auto rounded-xl border border-zinc-200 dark:border-zinc-800">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                    <tr><th class="px-4 py-2">Bank</th><th class="px-4 py-2">No. Rekening</th><th class="px-4 py-2">Atas Nama</th><th class="px-4 py-2">Status</th></tr>
                </thead>
                <tbody>
                    @forelse ($banks as $b)
                        <tr class="border-t border-zinc-200 dark:border-zinc-800">
                            <td class="px-4 py-3">{{ $b->bank_code }}</td>
                            <td class="px-4 py-3 font-mono">****{{ $b->account_last4 }}</td>
                            <td class="px-4 py-3">{{ $b->account_holder }}</td>
                            <td class="px-4 py-3"><x-status-badge :status="$b->status === 'verified' ? 'active' : 'pending'">{{ $b->status }}</x-status-badge></td>
                        </tr>
                    @empty
                        <tr><td class="px-4 py-3" colspan="4">Belum ada rekening pencairan yang didaftarkan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <form method="POST" action="{{ route('admin.tenants.banks.store', $tenant) }}" class="mt-4 flex flex-wrap items-end gap-2">
            @csrf
            <x-input name="bank_code" label="Kode Bank (cth: BCA)" required />
            <x-input name="account_number" label="Nomor Rekening (minimal 4 digit)" type="number" required />
            <x-input name="account_holder" label="Atas Nama" required />
            <x-button type="submit">Tambah Rekening</x-button>
        </form>
    </section>
</x-layouts.admin>