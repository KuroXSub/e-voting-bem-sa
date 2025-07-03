<div class="auth-container dark:auth-dark">
    <div class="auth-card dark:auth-dark">
        <div class="auth-text-center mb-8">
            <h2 class="auth-title dark:auth-dark">Buat Akun Baru</h2>
            <p class="auth-subtitle dark:auth-dark">Masukkan data Anda untuk mendaftar</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="auth-status dark:auth-dark">
                {{ session('status') }}
            </div>
        @endif

        <form wire:submit="register" class="auth-form">
            <!-- Nama -->
            <div class="auth-form-group">
                <label for="name" class="auth-label dark:auth-dark">Nama Lengkap</label>
                <input wire:model="name" type="text" id="name" autocomplete="name" required
                       placeholder="Nama lengkap"
                       class="auth-input dark:auth-dark" />
                @error('name') <span class="auth-error">{{ $message }}</span> @enderror
            </div>

            <!-- Email -->
            <div class="auth-form-group">
                <label for="email" class="auth-label dark:auth-dark">Email</label>
                <input wire:model="email" type="email" id="email" autocomplete="email" required
                       placeholder="email@example.com"
                       class="auth-input dark:auth-dark" />
                @error('email') <span class="auth-error">{{ $message }}</span> @enderror
            </div>

            <!-- Password -->
            <div class="auth-form-group">
                <label for="password" class="auth-label dark:auth-dark">Password</label>
                <input wire:model="password" type="password" id="password" autocomplete="new-password" required
                       placeholder="••••••••"
                       class="auth-input dark:auth-dark" />
                @error('password') <span class="auth-error">{{ $message }}</span> @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="auth-form-group">
                <label for="password_confirmation" class="auth-label dark:auth-dark">Konfirmasi Password</label>
                <input wire:model="password_confirmation" type="password" id="password_confirmation" autocomplete="new-password" required
                       placeholder="Ulangi password"
                       class="auth-input dark:auth-dark" />
            </div>

            <!-- Tombol Daftar -->
            <button type="submit"
                    class="auth-btn auth-btn-primary">
                Daftar
            </button>
        </form>

        <!-- Link Login -->
        <p class="auth-text-sm auth-text-gray dark:auth-dark auth-text-center mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" wire:navigate
               class="auth-link dark:auth-dark">
                Masuk di sini
            </a>
        </p>
    </div>
</div>