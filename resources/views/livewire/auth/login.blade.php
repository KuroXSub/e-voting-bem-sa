<div class="auth-container dark:auth-dark">
    <div class="auth-card dark:auth-dark">
        <div class="auth-text-center mb-8">
            <h2 class="auth-title dark:auth-dark">Masuk ke Akun Anda</h2>
            <p class="auth-subtitle dark:auth-dark">Silakan isi email dan password Anda</p>
        </div>

        <form wire:submit="login" class="auth-form">
            <!-- Email -->
            <div class="auth-form-group">
                <label for="email" class="auth-label dark:auth-dark">Email</label>
                <input wire:model="email" type="email" id="email" required autocomplete="email"
                    placeholder="you@example.com"
                    class="auth-input dark:auth-dark" />
                @error('email') <span class="auth-error">{{ $message }}</span> @enderror
            </div>

            <!-- Password -->
            <div class="auth-form-group">
                <div class="flex items-center justify-between mb-1">
                    <label for="password" class="auth-label dark:auth-dark">Password</label>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        wire:navigate
                        class="auth-link dark:auth-dark">
                        Lupa password?
                    </a>
                    @endif
                </div>
                <input wire:model="password" type="password" id="password" required autocomplete="current-password"
                    placeholder="••••••••"
                    class="auth-input dark:auth-dark" />
                @error('password') <span class="auth-error">{{ $message }}</span> @enderror
            </div>

            <!-- Remember Me -->
            <div class="auth-checkbox">
                <input id="remember" type="checkbox" wire:model="remember"
                       class="auth-checkbox-input" />
                <label for="remember" class="auth-checkbox-label dark:auth-dark">Ingat saya</label>
            </div>

            <!-- Login Button -->
            <button type="submit"
                class="auth-btn auth-btn-primary">
                Masuk
            </button>
        </form>

        <!-- Register Link -->
        @if (Route::has('register'))
            <p class="auth-text-sm auth-text-gray dark:auth-dark auth-text-center mt-6">
                Belum punya akun?
                <a href="{{ route('register') }}"
                wire:navigate
                class="auth-link dark:auth-dark">
                    Daftar
                </a>
            </p>
        @endif
    </div>
</div>